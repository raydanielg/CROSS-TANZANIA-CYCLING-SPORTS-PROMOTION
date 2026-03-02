<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportFaq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category',
        'is_active',
        'order'
    ];
}
