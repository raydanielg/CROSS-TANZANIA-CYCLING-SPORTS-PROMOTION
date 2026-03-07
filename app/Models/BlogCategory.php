<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlogPost;

class BlogCategory extends Model
{
    protected $fillable = [
        'name',
        'name_sw',
        'slug',
        'description',
        'is_active',
    ];

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function blogSubCategories()
    {
        return $this->hasMany(BlogSubCategory::class);
    }
}
