<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogSubCategory extends Model
{
    protected $fillable = [
        'blog_category_id',
        'name',
        'name_sw',
        'slug',
        'description',
        'is_active',
    ];

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
