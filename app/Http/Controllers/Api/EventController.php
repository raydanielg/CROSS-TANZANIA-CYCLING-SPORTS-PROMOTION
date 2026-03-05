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

        $registrations = Registration::with('event')
            ->where('participant_id', $participant->id)
            ->get()
            ->pluck('event');

        return response()->json($registrations);
    }
}
