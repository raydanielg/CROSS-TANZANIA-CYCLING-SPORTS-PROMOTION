<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'blog_sub_category_id' => 'nullable|exists:blog_sub_categories,id',
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'summary_sw' => 'nullable|string',
            'content' => 'required|string',
            'content_sw' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|boolean',
        ]);

        $path = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $stored = $file->storeAs('uploads/blog', $filename, 'public');
            $path = '/storage/' . $stored;
        }

        $slug = Str::slug($validated['title']);
        $slug = $slug . '-' . time();

        \App\Models\BlogPost::create([
            'user_id' => Auth::id(),
            'blog_category_id' => $validated['blog_category_id'],
            'blog_sub_category_id' => $validated['blog_sub_category_id'] ?? null,
            'title' => $validated['title'],
            'title_sw' => $validated['title_sw'] ?? null,
            'slug' => $slug,
            'summary' => $validated['summary'] ?? null,
            'summary_sw' => $validated['summary_sw'] ?? null,
            'content' => $validated['content'],
            'content_sw' => $validated['content_sw'] ?? null,
            'featured_image' => $path,
            'status' => $validated['status'],
            'is_featured' => (bool)($validated['is_featured'] ?? false),
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.blog.posts.index')->with('success', 'Blog post created successfully.');
    }

    public function categories()
    {
        $categories = \App\Models\BlogCategory::withCount('blogPosts')->get();
        return view('admin.blog.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_sw' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        $validated['is_active'] = (bool)($validated['is_active'] ?? true);

        \App\Models\BlogCategory::create($validated);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, \App\Models\BlogCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_sw' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = (bool)($validated['is_active'] ?? false);
        $category->update($validated);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(\App\Models\BlogCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
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
            'name_sw' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']) . '-' . time();

        $validated['is_active'] = (bool)($validated['is_active'] ?? true);

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
