<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function pages()
    {
        $pages = \App\Models\ContentPage::latest()->get();
        return view('admin.content.pages', compact('pages'));
    }

    public function media()
    {
        $media = \App\Models\ContentMedia::latest()->paginate(24);
        return view('admin.content.media', compact('media'));
    }

    public function testimonials()
    {
        $testimonials = \App\Models\Testimonial::latest()->get();
        return view('admin.content.testimonials', compact('testimonials'));
    }

    public function faqs()
    {
        $faqs = \App\Models\SupportFaq::orderBy('category')->orderBy('order')->get();
        return view('admin.content.faqs', compact('faqs'));
    }
}
