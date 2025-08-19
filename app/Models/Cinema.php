<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'address'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'cinema_movie');
    }

    public function scheduleTimes()
    {
        return $this->hasMany(ScheduleTime::class);
    }
}
