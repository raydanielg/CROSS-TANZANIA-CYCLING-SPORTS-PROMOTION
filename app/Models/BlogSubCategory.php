<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogSubCategory extends Model
{
    //
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
