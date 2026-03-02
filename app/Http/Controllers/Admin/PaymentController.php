<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('registration.participant.user', 'registration.event')->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function pending()
    {
        $payments = Payment::with('registration.participant.user')->where('status', 'pending')->latest()->paginate(10);
        return view('admin.payments.pending', compact('payments'));
    }

    public function completed()
    {
        $payments = Payment::with('registration.participant.user')->where('status', 'completed')->latest()->paginate(10);
        return view('admin.payments.completed', compact('payments'));
    }

    public function failed()
    {
        $payments = Payment::with('registration.participant.user')->where('status', 'failed')->latest()->paginate(10);
        return view('admin.payments.failed', compact('payments'));
    }

    public function refunds()
    {
        $payments = Payment::with('registration.participant.user')->where('status', 'refunded')->latest()->paginate(10);
        return view('admin.payments.refunds', compact('payments'));
    }

    public function methods()
    {
        return view('admin.payments.methods');
    }

    public function methodDetails($method)
    {
        return view('admin.payments.method-details', compact('method'));
    }
}
