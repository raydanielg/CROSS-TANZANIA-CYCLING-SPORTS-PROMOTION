<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\BlogSubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = BlogCategory::query()
            ->where('is_active', true)
            ->withCount([
                'blogPosts as posts_count' => function ($q) {
                    $q->where('status', 'published');
                },
            ])
            ->orderBy('name')
            ->get(['id', 'name', 'name_sw', 'slug', 'description']);

        return response()->json($categories);
    }

    public function subCategories(Request $request): JsonResponse
    {
        $query = BlogSubCategory::query()
            ->where('is_active', true)
            ->with(['blogCategory:id,name,slug']);

        if ($request->filled('category')) {
            $slug = $request->get('category');
            $query->whereHas('blogCategory', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        $subs = $query
            ->orderBy('name')
            ->get(['id', 'blog_category_id', 'name', 'name_sw', 'slug', 'description']);

        return response()->json($subs);
    }

    public function posts(Request $request): JsonResponse
    {
        $query = BlogPost::query()
            ->with(['user:id,name', 'blogCategory:id,name,slug'])
            ->withCount([
                'comments as comments_count' => function ($q) {
                    $q->where('is_approved', true);
                },
            ])
            ->where('status', 'published')
            ->orderByDesc('published_at');

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $slug = $request->get('category');
            $query->whereHas('blogCategory', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        if ($request->filled('sub_category')) {
            $slug = $request->get('sub_category');
            $query->whereHas('blogSubCategory', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        $posts = $query->paginate(10);

        $posts->getCollection()->transform(function (BlogPost $post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'title_sw' => $post->title_sw,
                'slug' => $post->slug,
                'summary' => $post->summary,
                'summary_sw' => $post->summary_sw,
                'featured_image' => $post->featured_image ? asset($post->featured_image) : null,
                'is_featured' => (bool)$post->is_featured,
                'published_at' => optional($post->published_at)->toISOString(),
                'author' => $post->user ? [
                    'name' => $post->user->name,
                ] : null,
                'category' => $post->blogCategory ? [
                    'name' => $post->blogCategory->name,
                    'name_sw' => $post->blogCategory->name_sw,
                    'slug' => $post->blogCategory->slug,
                ] : null,
                'comments_count' => (int)($post->comments_count ?? 0),
            ];
        });

        return response()->json($posts);
    }

    public function post(string $slug): JsonResponse
    {
        $post = BlogPost::query()
            ->with(['user:id,name', 'blogCategory:id,name,slug'])
            ->withCount([
                'comments as comments_count' => function ($q) {
                    $q->where('is_approved', true);
                },
            ])
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views');

        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'title_sw' => $post->title_sw,
            'slug' => $post->slug,
            'summary' => $post->summary,
            'summary_sw' => $post->summary_sw,
            'content' => $post->content,
            'content_sw' => $post->content_sw,
            'featured_image' => $post->featured_image ? asset($post->featured_image) : null,
            'published_at' => optional($post->published_at)->toISOString(),
            'views' => $post->views,
            'author' => $post->user ? [
                'name' => $post->user->name,
            ] : null,
            'category' => $post->blogCategory ? [
                'name' => $post->blogCategory->name,
                'name_sw' => $post->blogCategory->name_sw,
                'slug' => $post->blogCategory->slug,
            ] : null,
            'comments_count' => (int)($post->comments_count ?? 0),
        ]);
    }

    public function comments(string $slug): JsonResponse
    {
        $post = BlogPost::query()
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail(['id']);

        $comments = BlogComment::query()
            ->where('blog_post_id', $post->id)
            ->where('is_approved', true)
            ->with('user:id,name')
            ->latest()
            ->get();

        return response()->json($comments->map(function (BlogComment $comment) {
            return [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'created_at' => optional($comment->created_at)->toISOString(),
                'author' => $comment->user ? [
                    'name' => $comment->user->name,
                ] : [
                    'name' => $comment->name,
                ],
            ];
        }));
    }

    public function storeComment(Request $request, string $slug): JsonResponse
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'min:2'],
        ]);

        $post = BlogPost::query()
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail(['id']);

        $comment = BlogComment::create([
            'blog_post_id' => $post->id,
            'user_id' => $request->user()->id,
            'comment' => $validated['comment'],
            'is_approved' => false,
        ]);

        $comment->load('user:id,name');

        return response()->json([
            'message' => 'Comment submitted for review.',
            'comment' => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'created_at' => optional($comment->created_at)->toISOString(),
                'author' => $comment->user ? [
                    'name' => $comment->user->name,
                ] : null,
            ],
        ], 201);
    }
}
