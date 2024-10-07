<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoringController extends Controller
{
    // Store the scoring data for an archer
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

    // Show scoring input page for archer
    public function scoring()
    {
        $membership = DB::table('membership')->where('account_id', Auth::id())->first();
        
        // Pass the membership_id to the view
        return view('archer.scoring', ['membership_id' => $membership->membership_id]);
    }

    // Show scoring history for an archer
    public function showScoringHistoryArcher(Request $request)
    {
        // Get the authenticated user's membership ID
        $membership_id = Auth::user()->membership->membership_id;

        // Base query for scoring data
        $query = Score::where('membership_id', $membership_id);

        // Apply filters based on the request
        switch ($request->input('filter')) {
            case 'last1day':
                $query->where('date', '>=', now()->subDay());
                break;
            case 'last3days':
                $query->where('date', '>=', now()->subDays(3));
                break;
            case 'last7days':
                $query->where('date', '>=', now()->subDays(7));
                break;
            case 'last30days':
                $query->where('date', '>=', now()->subDays(30));
                break;
            case 'all':
            default:
                // Do not filter, show all records
                break;
        }

        // Custom date range filter
        if ($request->filled('start-date') && $request->filled('end-date')) {
            $query->whereBetween('date', [$request->input('start-date'), $request->input('end-date')]);
        }

        // Paginate the results with 10 per page
        $scoringData = $query->orderBy('date', 'desc')->paginate(10);

        // Return the view with filtered data
        return view('archer.scoringHistory', compact('scoringData', 'membership_id'));
    }

    // Show scoring details for an archer
    public function showScoreDetails($id)
    {
        // Find the score record by ID
        $score = Score::findOrFail($id);

        // Pass the score data to the view
        return view('archer.scoringDetails', compact('score'));
    }

    // Update an existing score for archer
    public function updateScore(Request $request, $id)
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

        // Find the existing score entry and update it
        $score = Score::findOrFail($id);
        $score->update([
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

        return redirect()->route('archer.scoringHistory')->with('success', 'Score updated successfully.');
    }

    // Delete a score entry
    public function deleteScore($id)
    {
        $score = Score::findOrFail($id);
        $score->delete();

        return redirect()->route('archer.scoringHistory')->with('success', 'Score deleted successfully.');
    }

    // Method for coaches to view the scoring history of their enrolled archers
    public function showCoachArcherScoringHistory(Request $request, $membership_id)
    {
        // Base query to get scoring data for the specified archer by membership_id
        $query = Score::where('membership_id', $membership_id);

        // Apply filters based on the request
        switch ($request->input('filter')) {
            case 'last1day':
                $query->where('date', '>=', now()->subDay());
                break;
            case 'last3days':
                $query->where('date', '>=', now()->subDays(3));
                break;
            case 'last7days':
                $query->where('date', '>=', now()->subDays(7));
                break;
            case 'last30days':
                $query->where('date', '>=', now()->subDays(30));
                break;
            case 'all':
            default:
                // Do not filter, show all records
                break;
        }

        // Custom date range filter
        if ($request->filled('start-date') && $request->filled('end-date')) {
            $query->whereBetween('date', [$request->input('start-date'), $request->input('end-date')]);
        }

        // Retrieve the archer's full name from the account table based on membership
        $archer = DB::table('membership')
            ->join('account', 'membership.account_id', '=', 'account.account_id')
            ->where('membership.membership_id', $membership_id)
            ->select('account.account_full_name') // Select the archer's full name
            ->first();

        // If no archer is found, set a default name
        $archerName = $archer->account_full_name ?? 'Unknown Archer';

        // Paginate the results with 10 per page
        $scoringData = $query->orderBy('date', 'desc')->paginate(10);

        // Return the view with filtered data, passing the archerName
        return view('coach.scoringHistory', compact('scoringData', 'membership_id', 'archerName'));
    }

    // Show scoring details for coach's view of archer
    public function showCoachArcherScoringDetails($id)
    {
        // Find the score record by ID
        $score = Score::findOrFail($id);

        // Retrieve the archer's full name from the account table based on membership ID
        $archer = DB::table('membership')
            ->join('account', 'membership.account_id', '=', 'account.account_id')
            ->where('membership.membership_id', $score->membership_id)
            ->select('account.account_full_name') // Select the archer's full name
            ->first();

        // If no archer is found, set a default name
        $archerName = $archer->account_full_name ?? 'Unknown Archer';

        // Pass the score and archer name to the view
        return view('coach.scoringDetails', compact('score', 'archerName'));
    }

    // Method for committee to view scoring history for all archers
    public function showCommitteeScoringHistory(Request $request)
    {
        // Correct the table name from 'score' to 'scores'
        $query = Score::join('membership', 'scores.membership_id', '=', 'membership.membership_id')
                ->join('account', 'membership.account_id', '=', 'account.account_id')
                ->select('scores.*', 'account.account_full_name as archer_name');

        // Apply filters based on the request if any
        switch ($request->input('filter')) {
            case 'last1day':
                $query->where('scores.date', '>=', now()->subDay());
                break;
            case 'last3days':
                $query->where('scores.date', '>=', now()->subDays(3));
                break;
            case 'last7days':
                $query->where('scores.date', '>=', now()->subDays(7));
                break;
            case 'last30days':
                $query->where('scores.date', '>=', now()->subDays(30));
                break;
            case 'all':
            default:
                // Do not filter, show all records
                break;
        }

        // Custom date range filter
        if ($request->filled('start-date') && $request->filled('end-date')) {
            $query->whereBetween('scores.date', [$request->input('start-date'), $request->input('end-date')]);
        }

        // Paginate the results with 10 per page
        $scoringData = $query->orderBy('scores.date', 'desc')->paginate(10);

        // Return the view with filtered data
        return view('committee.scoringHistory', compact('scoringData'));
    }

    // Show scoring details for committee's view
    public function showCommitteeScoringDetails($id)
    {
        // Find the score record by ID
        $score = Score::findOrFail($id);

        // Retrieve the archer's full name based on membership_id
        $archer = DB::table('membership')
                    ->join('account', 'membership.account_id', '=', 'account.account_id')
                    ->where('membership.membership_id', $score->membership_id)
                    ->select('account.account_full_name')
                    ->first();

        // If no archer is found, set a default name
        $archerName = $archer->account_full_name ?? 'Unknown Archer';

        // Pass the score and archer name to the view
        return view('committee.scoringDetails', compact('score', 'archerName'));
    }

    public function showAllEnrolledArcherScoringHistory(Request $request)
    {
        $user = Auth::user(); // Get the current coach

        // Get the membership IDs of archers enrolled with this coach
        $enrolledArcherIds = DB::table('coach_archer')
            ->where('coach_id', $user->account_id)
            ->pluck('archer_id');

        // Get the scoring data for enrolled archers
        $query = Score::whereIn('scores.membership_id', $enrolledArcherIds);

        // Apply filters based on the request (similar to committee history)
        if ($request->filled('start-date') && $request->filled('end-date')) {
            $query->whereBetween('scores.date', [$request->input('start-date'), $request->input('end-date')]);
        }

        // Fetch archer names
        $scoringData = $query->join('membership', 'scores.membership_id', '=', 'membership.membership_id')
            ->join('account', 'membership.account_id', '=', 'account.account_id')
            ->select('scores.*', 'account.account_full_name as archer_name')
            ->orderBy('scores.date', 'desc')
            ->paginate(10);

        return view('coach.scoringList', compact('scoringData'));
    }
}
