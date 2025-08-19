<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'movie_id',
        'room_id',
        'day_time',
        'schedule_time_id',
        'end_time',
        'base_price',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function scheduleTime()
    {
        return $this->belongsTo(ScheduleTime::class, 'schedule_time_id');
    }
    
}
