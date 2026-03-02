<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function email()
    {
        $events = Event::where('status', 'upcoming')->get();
        return view('admin.notifications.email', compact('events'));
    }

    public function sms()
    {
        $events = Event::where('status', 'upcoming')->get();
        return view('admin.notifications.sms', compact('events'));
    }

    public function templates()
    {
        return view('admin.notifications.templates');
    }

    public function broadcast()
    {
        $events = Event::where('status', 'upcoming')->get();
        $recent_broadcasts = Notification::where('type', 'broadcast')->latest()->take(5)->get();
        return view('admin.notifications.broadcast', compact('events', 'recent_broadcasts'));
    }

    public function history()
    {
        $notifications = Notification::with(['event', 'user'])->latest()->paginate(15);
        return view('admin.notifications.history', compact('notifications'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:email,sms,broadcast',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'recipient_type' => 'required|in:all,event_participants,individual',
            'event_id' => 'required_if:recipient_type,event_participants',
            'user_id' => 'required_if:recipient_type,individual',
        ]);

        $notification = Notification::create([
            'type' => $validated['type'],
            'subject' => $validated['subject'] ?? ($validated['type'] === 'sms' ? 'SMS Alert' : 'System Broadcast'),
            'message' => $validated['message'],
            'recipient_type' => $validated['recipient_type'],
            'event_id' => $validated['event_id'] ?? null,
            'user_id' => $validated['user_id'] ?? null,
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // Simulated Activity Log
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "Sent " . strtoupper($validated['type']) . " to " . str_replace('_', ' ', $validated['recipient_type']),
        ]);

        return redirect()->route('admin.notifications.history')->with('success', ucfirst($validated['type']) . ' sent successfully.');
    }
}
