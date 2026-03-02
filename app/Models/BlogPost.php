<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function blogSubCategory()
    {
        return $this->belongsTo(BlogSubCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
}
