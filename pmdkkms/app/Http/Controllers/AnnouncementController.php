<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Fetch all announcements
        $announcements = Announcement::all();
        return view('committee.dashboard', compact('announcements'));
    }

    public function store(Request $request)
    {
        // Validate and create a new announcement
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Announcement added successfully!');
    }

    public function update(Request $request, $id)
    {
        // Validate and update the announcement
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Announcement updated successfully!');
    }

    public function destroy($id)
    {
        // Find and delete the announcement
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully!');
    }
}
