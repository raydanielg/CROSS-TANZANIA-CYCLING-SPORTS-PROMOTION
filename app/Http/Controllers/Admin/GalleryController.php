<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function categories()
    {
        $categories = GalleryCategory::withCount('images')->orderBy('name')->get();
        return view('admin.gallery.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_sw' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        $validated['is_active'] = (bool)($validated['is_active'] ?? true);

        GalleryCategory::create($validated);

        return redirect()->back()->with('success', 'Gallery category created successfully.');
    }

    public function updateCategory(Request $request, GalleryCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_sw' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = (bool)($validated['is_active'] ?? false);
        $category->update($validated);

        return redirect()->back()->with('success', 'Gallery category updated successfully.');
    }

    public function destroyCategory(GalleryCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Gallery category deleted successfully.');
    }

    public function images(Request $request)
    {
        $categories = GalleryCategory::where('is_active', true)->orderBy('name')->get();

        $imagesQuery = GalleryImage::with('category')->latest();
        if ($request->filled('category_id')) {
            $imagesQuery->where('gallery_category_id', $request->category_id);
        }

        $images = $imagesQuery->paginate(24)->withQueryString();

        return view('admin.gallery.images.index', compact('categories', 'images'));
    }

    public function uploadImage(Request $request)
    {
        $validated = $request->validate([
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'title' => 'nullable|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/gallery', $filename, 'public');

        GalleryImage::create([
            'gallery_category_id' => $validated['gallery_category_id'],
            'title' => $validated['title'] ?? null,
            'title_sw' => $validated['title_sw'] ?? null,
            'filename' => $filename,
            'file_path' => '/storage/' . $path,
            'alt_text' => $validated['alt_text'] ?? $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Gallery image uploaded successfully.');
    }

    public function destroyImage(GalleryImage $image)
    {
        $filePath = str_replace('/storage/', '', $image->file_path);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $image->delete();

        return redirect()->back()->with('success', 'Gallery image deleted successfully.');
    }
}
