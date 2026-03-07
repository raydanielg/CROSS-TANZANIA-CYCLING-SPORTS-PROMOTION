<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Event;
use App\Models\User;
use App\Models\Participant;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function new()
    {
        $registrations = Registration::with(['event', 'participant.user'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
        $events = Event::where('status', 'upcoming')->get();
        return view('admin.registrations.new', compact('registrations', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'gender' => 'required|in:Male,Female',
            'license_no' => 'nullable|string',
            'skip_payment' => 'nullable|boolean',
            'payment_method' => 'nullable|string',
            'payment_phone' => 'nullable|string',
        ]);

        // 1. Create or Find User
        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            ['name' => $validated['name'], 'password' => Hash::make('password')]
        );

        // 2. Auto-generate License No if not provided
        $license_no = $validated['license_no'];
        if (empty($license_no)) {
            $prefix = 'CT';
            $year = date('y');
            $random = rand(1000, 9999);
            $license_no = "{$prefix}-{$year}-{$random}";
        }

        // 3. Create or Update Participant
        $participant = Participant::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'license_no' => $license_no,
                'status' => 'active'
            ]
        );

        // 4. Create Registration
        $status = $request->has('skip_payment') ? 'pending' : 'confirmed';
        $registration = Registration::create([
            'event_id' => $validated['event_id'],
            'participant_id' => $participant->id,
            'status' => $status,
            'bib_number' => 'BIB-' . rand(1000, 9999),
            'confirmed_at' => $status === 'confirmed' ? now() : null,
        ]);

        // 5. Handle Payment
        if (!$request->has('skip_payment')) {
            Payment::create([
                'registration_id' => $registration->id,
                'amount' => Event::find($validated['event_id'])->registration_fee,
                'method' => $validated['payment_method'],
                'reference' => 'REG-' . strtoupper(Str::random(8)),
                'payment_phone' => $validated['payment_phone'],
                'status' => 'completed',
                'paid_at' => now(),
            ]);
        }

        // --- Simulated Activity Log ---
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "Registered rider {$validated['name']} for event " . Event::find($validated['event_id'])->name . " (" . ($status) . ")",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration created successfully. ' . ($status === 'pending' ? 'Moved to pending list.' : 'Confirmed and moved to confirmed list.'),
            'registration' => $registration,
            'license_no' => $license_no
        ]);
    }

    public function confirmPayment(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        if (!$registration->event_license_no) {
            $prefix = 'CT';
            $year = date('y');
            do {
                $candidate = $prefix . '-' . $year . '-' . strtoupper(Str::random(6));
                $exists = Registration::where('event_id', $registration->event_id)
                    ->where('event_license_no', $candidate)
                    ->exists();
            } while ($exists);
            $registration->event_license_no = $candidate;
        }

        $registration->status = 'paid';
        $registration->confirmed_at = now();
        $registration->save();

        Payment::create([
            'registration_id' => $registration->id,
            'amount' => $registration->event->registration_fee,
            'method' => $request->payment_method ?? 'Manual',
            'reference' => 'REG-' . strtoupper(Str::random(8)),
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Payment confirmed and registration activated.']);
    }

    public function confirmed()
    {
        $registrations = Registration::with(['event', 'participant.user', 'payment'])->where('status', 'confirmed')->latest()->paginate(10);
        return view('admin.registrations.confirmed', compact('registrations'));
    }

    public function pending()
    {
        $registrations = Registration::with(['event', 'participant.user', 'payment'])->where('status', 'pending')->latest()->paginate(10);
        return view('admin.registrations.pending', compact('registrations'));
    }

    public function cancelled()
    {
        $registrations = Registration::with(['event', 'participant.user', 'payment'])->where('status', 'cancelled')->latest()->paginate(10);
        return view('admin.registrations.cancelled', compact('registrations'));
    }

    public function checkin()
    {
        $registrations = Registration::with(['event', 'participant.user', 'payment'])->where('status', 'confirmed')->latest()->paginate(10);
        return view('admin.registrations.check-in', compact('registrations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status updated to ' . $request->status]);
    }

    public function toggleCheckin($id)
    {
        $registration = Registration::findOrFail($id);
        $status = !$registration->checked_in;
        
        $registration->update([
            'checked_in' => $status,
            'checked_in_at' => $status ? now() : null
        ]);

        return response()->json([
            'success' => true, 
            'message' => $status ? 'Rider checked-in successfully.' : 'Check-in reverted.',
            'checked_in' => $status
        ]);
    }
}
