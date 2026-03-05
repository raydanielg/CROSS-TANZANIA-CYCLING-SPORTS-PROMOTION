<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPage extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'content',
        'sections',
        'meta_title',
        'meta_description',
        'is_active',
        'title_sw',
        'subtitle_sw',
        'content_sw',
        'sections_sw',
    ];

    protected $casts = [
        'sections' => 'array',
        'is_active' => 'boolean',
    ];
}
