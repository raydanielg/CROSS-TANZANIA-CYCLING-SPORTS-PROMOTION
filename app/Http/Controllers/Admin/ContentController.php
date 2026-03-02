<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function pages()
    {
        return view('admin.content.pages');
    }

    public function media()
    {
        return view('admin.content.media');
    }

    public function testimonials()
    {
        return view('admin.content.testimonials');
    }

    public function faqs()
    {
        return view('admin.content.faqs');
    }
}
