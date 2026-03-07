<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $totalCollected = Payment::where('status', 'completed')->sum('amount');
        $pendingAmount = Payment::where('status', 'pending')->sum('amount');

        $payments = Payment::with(['registration.participant.user', 'registration.event', 'user'])
            ->latest()
            ->paginate(15);
        return view('admin.payments.index', compact('payments', 'totalCollected', 'pendingAmount'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['registration.participant.user', 'registration.event', 'user']);
        return view('admin.payments.show', compact('payment'));
    }

    public function webhookLogs()
    {
        // This could show recent webhook attempts if we logged them to a table
        $payments = Payment::whereNotNull('webhook_status')
            ->with(['registration.participant.user'])
            ->latest()
            ->paginate(15);
        return view('admin.payments.webhooks', compact('payments'));
    }

    public function pending()
    {
        $payments = Payment::with('registration.participant.user')->where('status', 'pending')->latest()->paginate(10);
        return view('admin.payments.pending', compact('payments'));
    }

    public function verify(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending payments can be verified.');
        }

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
                'webhook_status' => 'manual.verified',
            ]);

            if ($payment->registration) {
                $registration = $payment->registration;
                if (!$registration->event_license_no) {
                    $prefix = 'CT';
                    $year = date('y');
                    do {
                        $candidate = $prefix . '-' . $year . '-' . strtoupper(Str::random(6));
                        $exists = \App\Models\Registration::where('event_id', $registration->event_id)
                            ->where('event_license_no', $candidate)
                            ->exists();
                    } while ($exists);

                    $registration->event_license_no = $candidate;
                }

                $registration->status = 'paid';
                $registration->save();
            }
        });

        return redirect()->back()->with('success', 'Payment verified successfully.');
    }

    public function reject(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending payments can be rejected.');
        }

        $payment->update([
            'status' => 'failed',
            'webhook_status' => 'manual.rejected',
        ]);

        return redirect()->back()->with('success', 'Payment rejected.');
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
        $snippe_api_key = \App\Models\Setting::get('snippe_api_key', config('services.snippe.api_key'));
        $snippe_webhook_secret = \App\Models\Setting::get('snippe_webhook_secret', config('services.snippe.webhook_secret'));
        $snippe_base_url = \App\Models\Setting::get('snippe_base_url', config('services.snippe.base_url'));
        
        return view('admin.payments.methods', compact('snippe_api_key', 'snippe_webhook_secret', 'snippe_base_url'));
    }

    public function updateMethods(Request $request)
    {
        $request->validate([
            'snippe_api_key' => 'required|string',
            'snippe_base_url' => 'required|url',
            'snippe_webhook_secret' => 'nullable|string',
        ]);

        \App\Models\Setting::set('snippe_api_key', $request->snippe_api_key, 'payment');
        \App\Models\Setting::set('snippe_base_url', $request->snippe_base_url, 'payment');
        \App\Models\Setting::set('snippe_webhook_secret', $request->snippe_webhook_secret, 'payment');

        return redirect()->back()->with('success', 'Snippe Gateway settings updated successfully.');
    }

    public function methodDetails($method)
    {
        return view('admin.payments.method-details', compact('method'));
    }
}
