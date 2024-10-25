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
    // Validate all 36 scores as strings to accommodate 'X' and 'M'
    $request->validate([
        'distance' => 'required|integer|min:1',
        'date' => 'required|date',
        'set1_score1' => 'required|string|max:2',
        'set1_score2' => 'required|string|max:2',
        'set1_score3' => 'required|string|max:2',
        'set1_score4' => 'required|string|max:2',
        'set1_score5' => 'required|string|max:2',
        'set1_score6' => 'required|string|max:2',
        'set2_score1' => 'required|string|max:2',
        'set2_score2' => 'required|string|max:2',
        'set2_score3' => 'required|string|max:2',
        'set2_score4' => 'required|string|max:2',
        'set2_score5' => 'required|string|max:2',
        'set2_score6' => 'required|string|max:2',
        'set3_score1' => 'required|string|max:2',
        'set3_score2' => 'required|string|max:2',
        'set3_score3' => 'required|string|max:2',
        'set3_score4' => 'required|string|max:2',
        'set3_score5' => 'required|string|max:2',
        'set3_score6' => 'required|string|max:2',
        'set4_score1' => 'required|string|max:2',
        'set4_score2' => 'required|string|max:2',
        'set4_score3' => 'required|string|max:2',
        'set4_score4' => 'required|string|max:2',
        'set4_score5' => 'required|string|max:2',
        'set4_score6' => 'required|string|max:2',
        'set5_score1' => 'required|string|max:2',
        'set5_score2' => 'required|string|max:2',
        'set5_score3' => 'required|string|max:2',
        'set5_score4' => 'required|string|max:2',
        'set5_score5' => 'required|string|max:2',
        'set5_score6' => 'required|string|max:2',
        'set6_score1' => 'required|string|max:2',
        'set6_score2' => 'required|string|max:2',
        'set6_score3' => 'required|string|max:2',
        'set6_score4' => 'required|string|max:2',
        'set6_score5' => 'required|string|max:2',
        'set6_score6' => 'required|string|max:2',
        'notes' => 'nullable|string',
        'canvas_image' => 'required|string',
    ]);

    // Extract and decode the Base64 image data
    $imageData = $request->input('canvas_image');
    $imageName = 'score_' . time() . '.png';
    $imagePath = public_path('images/scoring/' . $imageName);

    if (!file_exists(public_path('images/scoring'))) {
        mkdir(public_path('images/scoring'), 0777, true);
    }

    list(, $imageData) = explode(',', $imageData);
    $imageData = base64_decode($imageData);

    if (file_put_contents($imagePath, $imageData) === false) {
        return back()->withErrors('Failed to save the canvas image.');
    }

    // Initialize totals and counters
    $overallTotal = 0;
    $xCount = 0;
    $tenCount = 0;

    // Array to store each set's total
    $setTotals = [];

    // Loop through all sets to calculate totals and counters
    for ($set = 1; $set <= 6; $set++) {
        $setTotal = 0;
    
        for ($score = 1; $score <= 6; $score++) {
            $currentScore = $request->input("set{$set}_score{$score}");
    
            // Check if the score is 'X'
            if ($currentScore === 'X') {
                $setTotal += 10;  // Treat 'X' as 10 points for calculations
                $xCount++;
                $tenCount++;  // 'X' also counts as 10
            } elseif ($currentScore === 'M') {
                $setTotal += 0;  // 'M' is a miss
            } else {
                $numericScore = intval($currentScore);  // Convert string to integer
                $setTotal += $numericScore;
    
                if ($numericScore === 10) {
                    $tenCount++;
                }
            }
        }
    
        $overallTotal += $setTotal;
        $setTotals["set{$set}_total"] = $setTotal;
    }

    // Retrieve the membership ID for the current user
    $membership = DB::table('membership')->where('account_id', Auth::id())->first();

    if (!$membership) {
        return back()->withErrors('Membership not found.');
    }

    // Create a new score entry with set totals
    Score::create(array_merge([
        'membership_id' => $membership->membership_id,
        'distance' => $request->distance,
        'date' => $request->date,
        'canvas_image' => $imageName,
        'set1_score1' => $request->set1_score1,
        'set1_score2' => $request->set1_score2,
        'set1_score3' => $request->set1_score3,
        'set1_score4' => $request->set1_score4,
        'set1_score5' => $request->set1_score5,
        'set1_score6' => $request->set1_score6,
        'set2_score1' => $request->set2_score1,
        'set2_score2' => $request->set2_score2,
        'set2_score3' => $request->set2_score3,
        'set2_score4' => $request->set2_score4,
        'set2_score5' => $request->set2_score5,
        'set2_score6' => $request->set2_score6,
        'set3_score1' => $request->set3_score1,
        'set3_score2' => $request->set3_score2,
        'set3_score3' => $request->set3_score3,
        'set3_score4' => $request->set3_score4,
        'set3_score5' => $request->set3_score5,
        'set3_score6' => $request->set3_score6,
        'set4_score1' => $request->set4_score1,
        'set4_score2' => $request->set4_score2,
        'set4_score3' => $request->set4_score3,
        'set4_score4' => $request->set4_score4,
        'set4_score5' => $request->set4_score5,
        'set4_score6' => $request->set4_score6,
        'set5_score1' => $request->set5_score1,
        'set5_score2' => $request->set5_score2,
        'set5_score3' => $request->set5_score3,
        'set5_score4' => $request->set5_score4,
        'set5_score5' => $request->set5_score5,
        'set5_score6' => $request->set5_score6,
        'set6_score1' => $request->set6_score1,
        'set6_score2' => $request->set6_score2,
        'set6_score3' => $request->set6_score3,
        'set6_score4' => $request->set6_score4,
        'set6_score5' => $request->set6_score5,
        'set6_score6' => $request->set6_score6,
        'overall_total' => $overallTotal,
        'x_count' => $xCount,
        'ten_count' => $tenCount,
        'x_and_ten_count' => $xCount + $tenCount,
        'notes' => $request->notes,
    ], $setTotals));

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
        $query = Score::where('membership_id', $membership_id)
        ->select('id', 'date', 'distance', 'overall_total', 'x_count', 'ten_count');

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

        // Retrieve the user's full name using a join on membership and account tables
        $user = DB::table('membership')
            ->join('account', 'membership.account_id', '=', 'account.account_id')
            ->where('membership.membership_id', $score->membership_id)
            ->select('account.account_full_name')
            ->first();

        // Check if the user exists, otherwise set a default name
        $fullName = $user ? $user->account_full_name : 'Unknown User';

        // Pass the score and the user's full name to the view
        return view('archer.scoringDetails', compact('score', 'fullName'));
    }

    // Update an existing score for archer
    public function updateScore(Request $request, $id)
    {
        // Validate the score data
        $request->validate([
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

    public function showCoachArcherScoringDetails($id, $referrer = null)
    {
        // Find the score record by ID
        $score = Score::findOrFail($id);

        // Retrieve the archer's full name
        $archer = DB::table('membership')
            ->join('account', 'membership.account_id', '=', 'account.account_id')
            ->where('membership.membership_id', $score->membership_id)
            ->select('account.account_full_name')
            ->first();

        $fullName = $archer->account_full_name ?? 'Unknown Archer';

        // Pass the score, archer name, and referrer to the view
        return view('coach.scoringDetails', compact('score', 'fullName', 'referrer'));
    }

    // Method for committee to view scoring history for all archers
    public function showCommitteeScoringHistory(Request $request)
    {
        // Base query for scoring history with join on membership and account to fetch archer names
        $query = Score::join('membership', 'scores.membership_id', '=', 'membership.membership_id')
            ->join('account', 'membership.account_id', '=', 'account.account_id')
            ->select('scores.*', 'account.account_full_name as archer_name');

        // Apply filters based on the 'filter' request input
        if ($request->filled('filter')) {
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
                    // Do not apply any time filter if 'all' or invalid filter is provided
                    break;
            }
        }

        // Apply custom date range filter if both start-date and end-date are provided
        if ($request->filled('start-date') && $request->filled('end-date')) {
            $query->whereBetween('scores.date', [
                $request->input('start-date'),
                $request->input('end-date')
            ]);
        }

        // Paginate the results, ordered by date in descending order, 10 per page
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
