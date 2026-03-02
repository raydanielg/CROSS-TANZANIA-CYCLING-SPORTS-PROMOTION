<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = \App\Models\BlogPost::with(['user', 'blogCategory'])->latest()->paginate(10);
        return view('admin.blog.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = \App\Models\BlogCategory::where('is_active', true)->get();
        return view('admin.blog.posts.create', compact('categories'));
    }

    public function categories()
    {
        $categories = \App\Models\BlogCategory::withCount('blogPosts')->get();
        return view('admin.blog.categories.index', compact('categories'));
    }

    public function subCategories()
    {
        $subCategories = \App\Models\BlogSubCategory::with('blogCategory')->get();
        return view('admin.blog.sub-categories.index', compact('subCategories'));
    }

    public function comments()
    {
        $comments = \App\Models\BlogComment::with('blogPost', 'user')->latest()->paginate(20);
        return view('admin.blog.comments.index', compact('comments'));
    }
}
