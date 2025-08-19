<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    // app/Models/Seat.php
    protected $fillable = ['room_id', 'row_id', 'seat_number', 'seat_chair', 'price', 'is_available'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function seatRow()
    {
        return $this->belongsTo(SeatRow::class, 'row_id');
    }

    /**
     * Kiểm tra ghế có phải VIP không
     */
    public function isVip()
    {
        // Check if seatRow relationship is loaded
        if ($this->relationLoaded('seatRow')) {
            return $this->seatRow && $this->seatRow->type === 'vip';
        }
        
        // If relationship is not loaded, check the row_id directly
        if ($this->row_id) {
            try {
                $seatRow = SeatRow::find($this->row_id);
                return $seatRow && $seatRow->type === 'vip';
            } catch (\Exception $e) {
                return false;
            }
        }
        
        return false;
    }

    /**
     * Lấy loại ghế (single/couple)
     */
    public function getSeatType()
    {
        return $this->seat_chair;
    }

    /**
     * Lấy loại ghế đầy đủ (single, couple, single_vip, couple_vip)
     */
    public function getFullSeatType()
    {
        $type = $this->seat_chair;
        if ($this->isVip()) {
            $type .= '_vip';
        }
        return $type;
    }

    /**
     * Tính thống kê ghế theo loại cho một collection seats
     */
    public static function getSeatStats($seats)
    {
        $stats = [
            'single' => 0,
            'couple' => 0,
            'single_vip' => 0,
            'couple_vip' => 0,
        ];

        foreach ($seats as $seat) {
            $type = $seat->getFullSeatType();
            if (isset($stats[$type])) {
                $stats[$type]++;
            }
        }

        return $stats;
    }

    /**
     * Nhóm ghế theo hàng và tính thống kê
     */
    public static function getSeatRowsStats($seats)
    {
        // Group seats by their actual row_id relationship
        $groupedSeats = $seats->groupBy('row_id');

        $rowStats = [];
        foreach ($groupedSeats as $rowId => $rowSeats) {
            // Get the row label from the first seat's relationship
            $firstSeat = $rowSeats->first();
            $rowLabel = 'Unknown';
            
            if ($firstSeat) {
                // Check if seatRow relationship is loaded
                if ($firstSeat->relationLoaded('seatRow') && $firstSeat->seatRow) {
                    $rowLabel = $firstSeat->seatRow->row_label;
                } else if ($firstSeat->row_id) {
                    // Load the seat row if not already loaded
                    try {
                        $seatRow = SeatRow::find($firstSeat->row_id);
                        if ($seatRow) {
                            $rowLabel = $seatRow->row_label;
                        }
                    } catch (\Exception $e) {
                        $rowLabel = 'Unknown';
                    }
                }
            }
            
            $rowStats[$rowLabel] = self::getSeatStats($rowSeats);
        }

        return $rowStats;
    }
}
