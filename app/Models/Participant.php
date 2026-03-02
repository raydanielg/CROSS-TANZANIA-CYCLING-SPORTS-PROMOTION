<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'date_of_birth',
        'license_no',
        'emergency_contact_name',
        'emergency_contact_phone',
        'bio',
        'status',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
