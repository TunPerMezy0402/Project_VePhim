<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Seat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'room_id',
        'seat_number',
        'seat_type',
        'price',
        'is_available',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
