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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_image_url'];

    /**
     * Get the full URL for the event image.
     *
     * @return string|null
     */
    public function getFullImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
