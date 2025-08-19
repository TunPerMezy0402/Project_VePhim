<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = ['cinema_id', 'name', 'total_seats', 'capacity', 'type'];
    
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function seatRows()
    {
        return $this->hasMany(SeatRow::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
