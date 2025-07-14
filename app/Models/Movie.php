<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'name',
        'description',
        'duration',
        'country_id',
        'director_id',
        'image',
        'is_active',
        'release_date',
        'trailer_url',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actor');
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function cinemas()
    {
        return $this->belongsToMany(Cinema::class, 'cinema_movie');
    }
}
