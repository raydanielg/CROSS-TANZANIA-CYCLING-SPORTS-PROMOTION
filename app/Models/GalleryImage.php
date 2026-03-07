<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'gallery_category_id',
        'title',
        'title_sw',
        'file_path',
        'filename',
        'alt_text',
        'file_size',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }
}
