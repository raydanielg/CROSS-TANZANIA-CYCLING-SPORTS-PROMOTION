<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'description', 'image', 'original_price', 'deal_price', 'expiry_date', 'is_active',
        'title_sw', 'subtitle_sw', 'description_sw'
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'is_active' => 'boolean',
        'original_price' => 'decimal:2',
        'deal_price' => 'decimal:2',
    ];
}
