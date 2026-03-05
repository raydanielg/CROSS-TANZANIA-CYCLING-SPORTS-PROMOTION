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
        $subCategories = \App\Models\BlogSubCategory::with('blogCategory')->latest()->get();
        $categories = \App\Models\BlogCategory::where('is_active', true)->get();
        return view('admin.blog.sub-categories.index', compact('subCategories', 'categories'));
    }

    public function storeSubCategory(Request $request)
    {
        $validated = $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']) . '-' . time();

        $sub = \App\Models\BlogSubCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sub Category created successfully.',
            'sub_category' => $sub
        ]);
    }

    public function comments()
    {
        $comments = \App\Models\BlogComment::with('blogPost', 'user')->latest()->paginate(20);
        return view('admin.blog.comments.index', compact('comments'));
    }
}
