<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function pages()
    {
        $pages = \App\Models\ContentPage::all();
        return view('admin.content.pages.index', compact('pages'));
    }

    public function editPage($id)
    {
        $page = \App\Models\ContentPage::findOrFail($id);
        return view('admin.content.pages.edit', compact('page'));
    }

    public function updatePage(Request $request, $id)
    {
        $page = \App\Models\ContentPage::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'slug' => 'required|string|unique:content_pages,slug,' . $id,
            'content' => 'nullable|string',
            'content_sw' => 'nullable|string',
            'subtitle' => 'nullable|string|max:255',
            'subtitle_sw' => 'nullable|string|max:255',
        ]);

        $page->update($request->all());

        return redirect()->route('admin.content.pages')->with('success', 'Page updated successfully');
    }

    public function deals()
    {
        $deals = \App\Models\Deal::latest()->get();
        return view('admin.content.deals.index', compact('deals'));
    }

    public function createDeal()
    {
        return view('admin.content.deals.create');
    }

    public function storeDeal(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'deal_price' => 'required|numeric',
            'description' => 'required|string',
            'description_sw' => 'nullable|string',
        ]);

        \App\Models\Deal::create($request->all());

        return redirect()->route('admin.content.deals')->with('success', 'Deal created successfully');
    }

    public function editDeal($id)
    {
        $deal = \App\Models\Deal::findOrFail($id);
        return view('admin.content.deals.edit', compact('deal'));
    }

    public function updateDeal(Request $request, $id)
    {
        $deal = \App\Models\Deal::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'deal_price' => 'required|numeric',
            'description' => 'required|string',
            'description_sw' => 'nullable|string',
        ]);

        $deal->update($request->all());

        return redirect()->route('admin.content.deals')->with('success', 'Deal updated successfully');
    }

    public function destroyDeal($id)
    {
        $deal = \App\Models\Deal::findOrFail($id);
        $deal->delete();

        return redirect()->route('admin.content.deals')->with('success', 'Deal deleted successfully');
    }

    public function media()
    {
        $media = \App\Models\ContentMedia::latest()->paginate(24);
        return view('admin.content.media.index', compact('media'));
    }

    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/media', $filename, 'public');

            \App\Models\ContentMedia::create([
                'filename' => $filename,
                'file_path' => '/storage/' . $path,
                'file_type' => 'image',
                'file_size' => $file->getSize(),
                'alt_text' => $file->getClientOriginalName(),
            ]);

            return back()->with('success', 'File uploaded successfully');
        }

        return back()->with('error', 'File upload failed');
    }

    public function destroyMedia($id)
    {
        $media = \App\Models\ContentMedia::findOrFail($id);
        // Delete physical file if exists
        $filePath = str_replace('/storage/', '', $media->file_path);
        if (\Storage::disk('public')->exists($filePath)) {
            \Storage::disk('public')->delete($filePath);
        }
        $media->delete();

        return back()->with('success', 'Media deleted successfully');
    }

    public function testimonials()
    {
        $testimonials = \App\Models\Testimonial::latest()->get();
        return view('admin.content.testimonials.index', compact('testimonials'));
    }

    public function createTestimonial()
    {
        return view('admin.content.testimonials.create');
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'content_sw' => 'nullable|string',
            'role' => 'nullable|string|max:255',
            'role_sw' => 'nullable|string|max:255',
        ]);

        \App\Models\Testimonial::create($request->all());

        return redirect()->route('admin.content.testimonials')->with('success', 'Testimonial created successfully');
    }

    public function editTestimonial($id)
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);
        return view('admin.content.testimonials.edit', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'content_sw' => 'nullable|string',
            'role' => 'nullable|string|max:255',
            'role_sw' => 'nullable|string|max:255',
        ]);

        $testimonial->update($request->all());

        return redirect()->route('admin.content.testimonials')->with('success', 'Testimonial updated successfully');
    }

    public function destroyTestimonial($id)
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('admin.content.testimonials')->with('success', 'Testimonial deleted successfully');
    }

    public function faqs()
    {
        $faqs = \App\Models\SupportFaq::orderBy('category')->orderBy('order')->get();
        return view('admin.content.faqs.index', compact('faqs'));
    }

    public function createFaq()
    {
        return view('admin.content.faqs.create');
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'question_sw' => 'nullable|string',
            'answer' => 'required|string',
            'answer_sw' => 'nullable|string',
        ]);

        \App\Models\SupportFaq::create($request->all());

        return redirect()->route('admin.content.faqs')->with('success', 'FAQ created successfully');
    }

    public function editFaq($id)
    {
        $faq = \App\Models\SupportFaq::findOrFail($id);
        return view('admin.content.faqs.edit', compact('faq'));
    }

    public function updateFaq(Request $request, $id)
    {
        $faq = \App\Models\SupportFaq::findOrFail($id);
        $request->validate([
            'question' => 'required|string',
            'question_sw' => 'nullable|string',
            'answer' => 'required|string',
            'answer_sw' => 'nullable|string',
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.content.faqs')->with('success', 'FAQ updated successfully');
    }

    public function destroyFaq($id)
    {
        $faq = \App\Models\SupportFaq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.content.faqs')->with('success', 'FAQ deleted successfully');
    }
}
