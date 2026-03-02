<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket;
use App\Models\SupportFaq;
use App\Models\User;

class SupportController extends Controller
{
    public function help() 
    { 
        $faqs = SupportFaq::where('is_active', true)->orderBy('order')->get();
        $tickets = Ticket::with('user')->latest()->take(5)->get();
        return view('admin.support.help', compact('faqs', 'tickets')); 
    }

    public function tickets()
    {
        $tickets = Ticket::with('user')->latest()->paginate(15);
        return view('admin.support.tickets', compact('tickets'));
    }

    public function faqs()
    {
        $faqs = SupportFaq::orderBy('category')->orderBy('order')->get();
        return view('admin.support.faqs', compact('faqs'));
    }

    public function docs() { return view('admin.support.docs'); }
    public function contact() { return view('admin.support.contact'); }
    public function feedback() { return view('admin.support.feedback'); }
}
