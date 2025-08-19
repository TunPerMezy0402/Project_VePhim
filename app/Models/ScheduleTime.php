<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleTime extends Model
{
    use SoftDeletes;
    protected $table = 'schedule_times';
    protected $fillable = [
        'cinema_id',
        'label',
        'start_time',
    ];
    
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
