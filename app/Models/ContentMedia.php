<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentMedia extends Model
{
    protected $fillable = [
        'filename',
        'file_path',
        'file_type',
        'file_size',
        'alt_text',
    ];
}
