<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    protected $fillable = [
        'name',
        'name_sw',
        'slug',
        'is_active',
    ];

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
