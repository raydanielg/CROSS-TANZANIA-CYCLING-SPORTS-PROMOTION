<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('registrations')->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->loadCount('registrations');
        $event->load([
            'registrations' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'registrations.participant.user'
        ]);

        $remaining_slots = null;
        if (!is_null($event->max_participants)) {
            $remaining_slots = max(0, (int)$event->max_participants - (int)$event->registrations_count);
        }

        return view('admin.events.show', compact('event', 'remaining_slots'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'start_location' => 'nullable|string|max:255',
            'end_location' => 'nullable|string|max:255',
            'distance_km' => 'nullable|numeric|min:0',
            'category' => 'required|string',
            'registration_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:upcoming,past,ongoing,cancelled',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    public function participantsPdf(Event $event)
    {
        $event->loadCount('registrations');
        $event->load([
            'registrations' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'registrations.participant.user'
        ]);

        $remaining_slots = null;
        if (!is_null($event->max_participants)) {
            $remaining_slots = max(0, (int)$event->max_participants - (int)$event->registrations_count);
        }

        return view('admin.events.participants-pdf', compact('event', 'remaining_slots'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'start_location' => 'nullable|string|max:255',
            'end_location' => 'nullable|string|max:255',
            'distance_km' => 'nullable|numeric|min:0',
            'category' => 'required|string',
            'registration_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->name) . '-' . time();
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }
        
        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function upcoming()
    {
        $events = Event::where('status', 'upcoming')->latest()->paginate(10);
        return view('admin.events.upcoming', compact('events'));
    }

    public function past()
    {
        $events = Event::where('status', 'past')->latest()->paginate(10);
        return view('admin.events.past', compact('events'));
    }

    public function categories()
    {
        return view('admin.events.categories');
    }

    public function results()
    {
        return view('admin.events.results');
    }
}
