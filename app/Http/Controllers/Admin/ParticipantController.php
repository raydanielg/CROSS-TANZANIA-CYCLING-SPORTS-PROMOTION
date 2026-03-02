<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::with('user')->latest()->paginate(10);
        return view('admin.participants.index', compact('participants'));
    }

    public function registered()
    {
        $participants = Participant::with('user')->where('status', 'active')->latest()->paginate(10);
        return view('admin.participants.index', compact('participants'));
    }

    public function pending()
    {
        $participants = Participant::with('user')->where('status', 'pending')->latest()->paginate(10);
        return view('admin.participants.index', compact('participants'));
    }

    public function blacklist()
    {
        $participants = Participant::with('user')->where('status', 'blacklisted')->latest()->paginate(10);
        return view('admin.participants.index', compact('participants'));
    }

    public function profile($id)
    {
        $participant = Participant::with(['user', 'registrations.event', 'registrations.payment'])
            ->findOrFail($id);

        $stats = [
            'total_events' => $participant->registrations->count(),
            'total_distance' => $participant->registrations->sum(fn($reg) => $reg->event->distance_km ?? 0),
            'total_paid' => $participant->registrations->sum(fn($reg) => $reg->payment && $reg->payment->status === 'completed' ? $reg->payment->amount : 0),
            'completed_events' => $participant->registrations->where('event.status', 'past')->count()
        ];

        return view('admin.participants.profile', compact('participant', 'stats'));
    }

    public function blacklistRider($id)
    {
        $participant = Participant::findOrFail($id);
        $participant->update(['status' => 'blacklisted']);

        return response()->json(['success' => true, 'message' => 'Rider has been moved to blacklist.']);
    }

    public function restoreRider($id)
    {
        $participant = Participant::findOrFail($id);
        $participant->update(['status' => 'active']);

        return response()->json(['success' => true, 'message' => 'Rider has been restored from blacklist.']);
    }

    public function getHistory($id)
    {
        $participant = Participant::with('registrations.event')->findOrFail($id);
        return response()->json([
            'name' => $participant->user->name,
            'history' => $participant->registrations->map(function($reg) {
                return [
                    'event' => $reg->event->name,
                    'date' => \Carbon\Carbon::parse($reg->event->event_date)->format('M d, Y'),
                    'status' => ucfirst($reg->status),
                    'bib' => $reg->bib_number ?? 'TBA'
                ];
            })
        ]);
    }
}
