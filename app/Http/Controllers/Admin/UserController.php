<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Participant;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile($id = null)
    {
        $user = $id ? User::with('participant')->findOrFail($id) : auth()->user();
        return view('admin.users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female',
            'bio' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $validated['profile_photo_path'] = $path;
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'profile_photo_path' => $validated['profile_photo_path'] ?? $user->profile_photo_path,
        ]);

        if ($user->participant) {
            $user->participant->update([
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'bio' => $validated['bio'],
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function admins()
    {
        // For now, simple email-based or just list (can add roles later)
        $users = User::latest()->paginate(10);
        return view('admin.users.admins', compact('users'));
    }

    public function staff()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.staff', compact('users'));
    }

    public function participants()
    {
        $users = User::has('participant')->latest()->paginate(10);
        return view('admin.users.participants', compact('users'));
    }

    public function showRider($id)
    {
        $participant = Participant::with(['user', 'registrations.event', 'registrations.payment'])->findOrFail($id);
        
        $stats = [
            'total_events' => $participant->registrations->count(),
            'total_distance' => $participant->registrations->sum(fn($reg) => $reg->event->distance_km ?? 0),
            'total_paid' => $participant->registrations->sum(fn($reg) => $reg->payment && $reg->payment->status === 'completed' ? $reg->payment->amount : 0),
            'completed_events' => $participant->registrations->where('event.status', 'past')->count()
        ];

        return view('admin.participants.profile', compact('participant', 'stats'));
    }

    public function searchRider(Request $request)
    {
        $query = $request->input('query');
        
        // Search by License No, Name, or Email
        $participant = Participant::where('license_no', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->first();

        if ($participant) {
            return redirect()->route('admin.participants.profile', $participant->id);
        }

        return back()->with('error', 'Rider not found with that ID or name.');
    }

    public function roles()
    {
        return view('admin.users.roles');
    }
}
