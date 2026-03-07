<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = GalleryCategory::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'name_sw', 'slug']);

        return response()->json($categories);
    }

    public function images(Request $request): JsonResponse
    {
        $query = GalleryImage::query()
            ->with(['category:id,name,name_sw,slug'])
            ->where('is_active', true);

        if ($request->filled('category') && $request->category !== 'all') {
            $slug = $request->category;
            $query->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        $images = $query
            ->latest()
            ->paginate(48);

        $images->getCollection()->transform(function (GalleryImage $img) {
            return [
                'id' => $img->id,
                'title' => $img->title,
                'title_sw' => $img->title_sw,
                'url' => asset($img->file_path),
                'category' => $img->category ? [
                    'id' => $img->category->id,
                    'name' => $img->category->name,
                    'name_sw' => $img->category->name_sw,
                    'slug' => $img->category->slug,
                ] : null,
                'created_at' => optional($img->created_at)->toISOString(),
            ];
        });

        return response()->json($images);
    }
}
