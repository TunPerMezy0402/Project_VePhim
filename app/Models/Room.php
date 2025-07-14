<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'total_seats',
    ];

    public function cinema()
{
    return $this->belongsTo(Cinema::class);
}

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    
}
