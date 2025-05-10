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

    // Quan hệ nhiều - nhiều với genres
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    // Quan hệ nhiều - nhiều với actors
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actor');
    }

    // Quan hệ 1 - nhiều (thuộc về 1 đạo diễn)
    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    // Quan hệ 1 - nhiều (thuộc về 1 quốc gia)
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
