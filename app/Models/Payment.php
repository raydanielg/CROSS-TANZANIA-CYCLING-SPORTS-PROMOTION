<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'registration_id',
        'amount',
        'currency',
        'description',
        'method',
        'reference',
        'phone_number',
        'status',
        'paid_at',
        'metadata',
        'checkout_url',
        'webhook_status',
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
