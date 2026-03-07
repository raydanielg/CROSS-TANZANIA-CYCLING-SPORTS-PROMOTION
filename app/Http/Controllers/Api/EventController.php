<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Display a listing of upcoming events.
     */
    public function index(): JsonResponse
    {
        $events = Event::withCount('registrations')
            ->where('status', 'upcoming')
            ->orderBy('event_date', 'asc')
            ->get();

        return response()->json($events);
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event): JsonResponse
    {
        return response()->json($event);
    }

    /**
     * Get user's registered events.
     */
    public function myEvents(Request $request): JsonResponse
    {
        $participant = $request->user()->participant;
        
        if (!$participant) {
            return response()->json([]);
        }

        $registrations = Registration::with(['event', 'payments'])
            ->where('participant_id', $participant->id)
            ->get();

        return response()->json($registrations);
    }

    /**
     * Register for an event
     */
    public function register(Request $request, Event $event): JsonResponse
    {
        $participant = $request->user()->participant;

        if (!$participant) {
            return response()->json(['message' => 'Participant profile not found'], 404);
        }

        // Check if already registered
        $existing = Registration::where('event_id', $event->id)
            ->where('participant_id', $participant->id)
            ->first();

        if ($existing) {
            return response()->json($existing);
        }

        $registration = Registration::create([
            'event_id' => $event->id,
            'participant_id' => $participant->id,
            'status' => 'pending',
        ]);

        return response()->json($registration, 201);
    }
}
