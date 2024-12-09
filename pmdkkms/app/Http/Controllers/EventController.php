<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of events for the calendar.
     * Committee has full access, others have view-only access.
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
     * Display events in a view-only mode for archers and coaches.
     */
    public function viewEvents()
    {
        // Prepare the events array to pass to the view
        $events = Event::all()->map(function ($event) {
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

        // Check user role and return the appropriate view (archer or coach)
        if (auth()->user()->account_role == 1) {
            return view('archer.events', compact('events'));
        } elseif (auth()->user()->account_role == 2) {
            return view('coach.events', compact('events'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Store a newly created event in the database.
     * Only for committee members.
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
     * Only for committee members.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['status' => 'Event deleted successfully!']);
    }

    /**
     * Update the event date when dragged on the calendar.
     * Only for committee members.
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
     * Only for committee members.
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
     * Only for committee members.
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

    /**
     * Show the homepage with upcoming events.
     */
    public function showHomePage()
    {
        // Fetch upcoming events from the database
        $upcomingEvents = Event::where('event_date', '>=', now())
                            ->orderBy('event_date', 'asc')
                            ->take(5) // Limit to the next 5 upcoming events
                            ->get();

        return view('home', compact('upcomingEvents'));
    }

    /**
     * Show the committee dashboard with upcoming events.
     */
    public function showDashboard()
    {
        // Fetch upcoming events from the database
        $upcomingEvents = Event::where('event_date', '>=', now())
                            ->orderBy('event_date', 'asc')
                            ->orderBy('start_time', 'asc')
                            ->take(5)
                            ->get();

        // Pass the events to the view
        return view('committee.dashboard', compact('upcomingEvents'));
    }


    /**
     * Show the archer dashboard with announcements and upcoming events.
     */
    public function showArcherDashboard()
    {
        // Fetch all announcements
        $announcements = DB::table('announcements')->get();

        // Fetch upcoming events
        $upcomingEvents = DB::table('events')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        return view('archer.dashboard', compact('announcements', 'upcomingEvents'));
    }

    /**
     * Show the coach dashboard with upcoming events.
     */
    public function showCoachDashboard()
    {
        // Fetch upcoming events for coaches (view-only)
        $upcomingEvents = Event::where('event_date', '>=', now())
                            ->orderBy('event_date', 'asc')
                            ->take(5) // Adjust the limit as needed
                            ->get();

        return view('coach.dashboard', compact('upcomingEvents'));
    }

    /**
     * Fetch upcoming events for AJAX requests.
     */
    public function fetchUpcomingEvents()
    {
        $upcomingEvents = Event::where('event_date', '>=', now())
                            ->orderBy('event_date', 'asc')
                            ->take(5)
                            ->get();

        return response()->json($upcomingEvents);
    }
}
