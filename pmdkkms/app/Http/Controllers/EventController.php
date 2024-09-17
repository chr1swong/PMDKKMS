<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Prepare the events array to pass to the view
        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->event_date->toDateString(), // Converts date to string
            ];
        });

        // Pass the events array to the view
        return view('committee.events', compact('events'));
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
        ]);

        // Store the new event
        Event::create($request->all());

        return response()->json(['status' => 'Event added successfully!']);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['status' => 'Event deleted successfully!']);
    }
}

