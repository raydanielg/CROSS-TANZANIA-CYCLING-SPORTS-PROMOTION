<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'user_id',
        'blog_category_id',
        'blog_sub_category_id',
        'title',
        'title_sw',
        'slug',
        'summary',
        'summary_sw',
        'content',
        'content_sw',
        'featured_image',
        'status',
        'views',
        'is_featured',
        'published_at',
    ];

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
