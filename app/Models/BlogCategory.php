<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlogPost;

class BlogCategory extends Model
{
    //
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function blogSubCategories()
    {
        return $this->hasMany(BlogSubCategory::class);
    }
}
