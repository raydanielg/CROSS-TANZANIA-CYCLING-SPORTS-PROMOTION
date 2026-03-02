<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'registration_id',
        'amount',
        'method',
        'reference',
        'phone_number',
        'status',
        'paid_at',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
