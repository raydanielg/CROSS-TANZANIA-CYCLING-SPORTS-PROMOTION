<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'role',
        'category',
        'content',
        'image',
        'rating',
        'is_active',
        'role_sw',
        'content_sw',
    ];
}
