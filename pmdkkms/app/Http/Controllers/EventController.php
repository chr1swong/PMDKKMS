<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events for the calendar.
     */
    public function index()
    {
        // Prepare the events array to pass to the view
        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->event_date->toDateString(),
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'location' => $event->location,
                'color' => $event->color   // Pass the color to FullCalendar
            ];
        });

        return view('committee.events', compact('events'));
    }

    /**
     * Store a newly created event in the database.
     */
    public function store(Request $request)
    {
        // Validate the event details including the color
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'color' => 'required|string'  // Validate the color input
        ]);

        // Store the new event in the database
        Event::create($request->all());

        return response()->json(['status' => 'Event added successfully!']);
    }

    /**
     * Delete the specified event from the database.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['status' => 'Event deleted successfully!']);
    }

    /**
     * Update the event date when dragged on the calendar.
     */
    public function updateDate($id, Request $request)
    {
        $event = Event::findOrFail($id);
        $event->event_date = $request->event_date;
        $event->save();

        return response()->json(['status' => 'Event date updated successfully!']);
    }

    /**
     * Update the event duration when resized on the calendar.
     */
    public function updateDuration($id, Request $request)
    {
        $event = Event::findOrFail($id);
        $event->end_time = $request->end_time;
        $event->save();

        return response()->json(['status' => 'Event duration updated successfully!']);
    }

    /**
     * Update the specified event in the database.
     */
    public function update($id, Request $request)
    {
        $event = Event::findOrFail($id);

        // Validate the updated event details
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'color' => 'required|string'
        ]);

        // Update the event in the database
        $event->update($request->all());

        return response()->json(['status' => 'Event updated successfully!']);
    }
}
