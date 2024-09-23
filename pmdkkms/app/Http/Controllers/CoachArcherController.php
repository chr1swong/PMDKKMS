<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoachArcherController extends Controller
{
    // Method to display the list of enrolled and unenrolled archers for the coach
    public function showMyArchers()
    {
        $user = Auth::user(); // Get current coach
    
        // Fetch enrolled archers (those with a coach)
        $enrolledArchers = DB::table('coach_archer')
            ->join('account', 'coach_archer.archer_id', '=', 'account.account_id')
            ->join('membership', 'account.account_id', '=', 'membership.account_id')
            ->select('account.account_id', 'account.account_full_name', 'membership.membership_id', 'membership.membership_status')
            ->where('coach_archer.coach_id', $user->account_id)
            ->get();
    
        // Fetch unenrolled archers (those without a coach)
        $unenrolledArchers = DB::table('account')
            ->leftJoin('membership', 'account.account_id', '=', 'membership.account_id')
            ->where('account_role', 1) // Only archers
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('coach_archer')
                    ->whereColumn('account.account_id', 'coach_archer.archer_id');
            })
            ->select('account.account_id', 'account.account_full_name', 'membership.membership_id', 'membership.membership_status')
            ->get();
    
        // Pass the enrolled and unenrolled archers to the view
        return view('coach.myArcher', compact('enrolledArchers', 'unenrolledArchers'));
    }

    // Method to enroll an archer
    public function enrollArcher(Request $request, $archerId)
    {
        $coach = Auth::user(); // Get current coach

        // Insert new relationship between coach and archer
        DB::table('coach_archer')->insert([
            'coach_id' => $coach->account_id,
            'archer_id' => $archerId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add flash message to the session
        return redirect()->route('coach.myArcher')->with('popupMessage', 'Archer enrolled successfully.');
    }

    // Method to unenroll an archer
    public function unenrollArcher(Request $request, $archerId)
    {
        $coach = Auth::user(); // Get current coach

        // Delete the coach-archer relationship
        DB::table('coach_archer')->where([
            ['coach_id', $coach->account_id],
            ['archer_id', $archerId]
        ])->delete();

        // Add flash message to the session
        return redirect()->route('coach.myArcher')->with('popupMessage', 'Archer unenrolled successfully.');
    }

    public function manageMember()
    {
        // Get members and link the coach for archers
        $members = DB::table('account')
            ->leftJoin('membership', 'account.account_id', '=', 'membership.account_id')
            ->leftJoin('coach_archer', 'account.account_id', '=', 'coach_archer.archer_id') // Join with coach_archer table
            ->leftJoin('account as coach', 'coach_archer.coach_id', '=', 'coach.account_id') // Join again to get coach details
            ->select('account.*', 'membership.membership_id', 'membership.membership_status', 'coach.account_full_name as coach_name')
            ->get();

        return view('committee.member', ['members' => $members]);
    }

    
}
