<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Score;
use App\Models\Membership;  // Include the Membership model
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    // Method to show performance analytics
    public function performanceAnalytics()
    {
        $user = Auth::user();
        $membership = Membership::where('account_id', $user->account_id)->first(); // Fetch the membership details
        
        if (!$membership) {
            return redirect()->back()->with('error', 'Membership not found for this user.');
        }
        
        // Fetch archer's full name from the linked Account model
        $archerName = $user->account_full_name; // Assuming the name is stored in 'account_full_name'

        // Get attendance records for this archer
        $attendances = Attendance::where('membership_id', $membership->membership_id)->get();

        // Get scoring records for this archer
        $scores = Score::where('membership_id', $membership->membership_id)->get();

        // Calculate total attendance and attendance percentage
        $totalAttendanceDays = $attendances->count();
        $presentDays = $attendances->where('attendance_status', 'present')->count();
        $attendancePercentage = $totalAttendanceDays > 0 ? ($presentDays / $totalAttendanceDays) * 100 : 0;

        // Prepare data for visualizing scores over time
        $scoreData = $scores->map(function ($score) {
            return [
                'date' => Carbon::parse($score->date)->format('Y-m-d'), // Ensure proper date formatting
                'total' => $score->total,
            ];
        });

        // Prepare attendance data for chart
        $attendanceData = $attendances->map(function ($attendance) {
            return [
                'date' => Carbon::parse($attendance->attendance_date)->format('Y-m-d'), // Ensure proper date formatting
                'status' => $attendance->attendance_status,
            ];
        });

        // Calculate average score
        $averageScore = $scores->avg('total');

        // Pass the data to the view, including the archer's name
        return view('archer.analytics', compact(
            'totalAttendanceDays',
            'presentDays',
            'attendancePercentage',
            'scoreData',
            'attendanceData',
            'averageScore',
            'archerName' // Pass archer's name to the view
        ));
    }
}
