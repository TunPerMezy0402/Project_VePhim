<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all rooms that have seats but no seat rows
        $roomsWithSeats = DB::table('seats')
            ->select('room_id')
            ->whereNull('row_id')
            ->distinct()
            ->get();

        foreach ($roomsWithSeats as $roomData) {
            $roomId = $roomData->room_id;
            
            // Get all seats for this room
            $seats = DB::table('seats')
                ->where('room_id', $roomId)
                ->whereNull('row_id')
                ->orderBy('seat_number')
                ->get();

            // Group seats by row (first character of seat_number)
            $seatsByRow = $seats->groupBy(function($seat) {
                return substr($seat->seat_number, 0, 1);
            });

            // Create seat rows and update seats
            foreach ($seatsByRow as $rowLabel => $rowSeats) {
                // Create seat row
                $seatRowId = DB::table('seat_rows')->insertGetId([
                    'room_id' => $roomId,
                    'row_label' => $rowLabel,
                    'type' => 'standard', // Default to standard, can be updated later
                    'total_seats' => $rowSeats->count(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update all seats in this row
                $seatIds = $rowSeats->pluck('id')->toArray();
                DB::table('seats')
                    ->whereIn('id', $seatIds)
                    ->update([
                        'row_id' => $seatRowId,
                        'updated_at' => now(),
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove row_id from all seats
        DB::table('seats')->update(['row_id' => null]);
        
        // Delete all seat rows
        DB::table('seat_rows')->truncate();
    }
};
