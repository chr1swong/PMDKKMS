<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoringController extends Controller
{
    // Store the scoring data
    public function storeScore(Request $request)
    {
        // Validate the score data
        $request->validate([
            'set' => 'required|integer|min:1',
            'category' => 'required|string',
            'distance' => 'required|integer|min:1',
            'date' => 'required|date',
            'score1' => 'required|integer|min:0|max:60',
            'score2' => 'required|integer|min:0|max:60',
            'score3' => 'required|integer|min:0|max:60',
            'score4' => 'required|integer|min:0|max:60',
            'score5' => 'required|integer|min:0|max:60',
            'score6' => 'required|integer|min:0|max:60',
            'notes' => 'nullable|string',
        ]);

        // Calculate total score
        $total = $request->score1 + $request->score2 + $request->score3 + $request->score4 + $request->score5 + $request->score6;

        // Retrieve the membership ID for the current user
        $membership = DB::table('membership')->where('account_id', Auth::id())->first();
        
        // Create a new score entry
        Score::create([
            'membership_id' => $membership->membership_id, // Link the score to membership ID
            'set' => $request->set,
            'category' => $request->category,
            'distance' => $request->distance,
            'date' => $request->date,
            'score1' => $request->score1,
            'score2' => $request->score2,
            'score3' => $request->score3,
            'score4' => $request->score4,
            'score5' => $request->score5,
            'score6' => $request->score6,
            'total' => $total,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Score recorded successfully.');
    }

    public function scoring()
    {
        $membership = DB::table('membership')->where('account_id', Auth::id())->first();
        
        // Pass the membership_id to the view
        return view('archer.scoring', ['membership_id' => $membership->membership_id]);
    }
}
