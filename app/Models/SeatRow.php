<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatRow extends Model
{
    protected $fillable = ['room_id', 'row_label', 'type', 'total_seats'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'row_id');
    }

    /**
     * Kiểm tra hàng có phải VIP không
     */
    public function isVip()
    {
        return $this->type === 'vip';
    }

    /**
     * Lấy loại hàng (standard/vip)
     */
    public function getRowType()
    {
        return $this->type;
    }
} 