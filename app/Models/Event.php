<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'event_date',
        'location',
        'start_location',
        'end_location',
        'distance_km',
        'registration_fee',
        'max_participants',
        'category',
        'status',
        'image'
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
