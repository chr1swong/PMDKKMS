<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScoringController extends Controller
{
    // Show the scoring form for archers
    public function scoring()
    {
        // Return the scoring view (assuming the view is 'archer/scoring.blade.php')
        return view('archer.scoring');
    }

    // Store the scoring data (this is optional, if you want to handle score submissions)
    public function storeScore(Request $request)
    {
        // Validate the score data
        $request->validate([
            'round1' => 'required|integer|min:0|max:60',
            'round2' => 'required|integer|min:0|max:60',
            // Add other rounds as necessary
        ]);

        // Save or process the scores (You would insert into a database here)

        return back()->with('success', 'Score recorded successfully.');
    }
}
