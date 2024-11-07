<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AnalyticsController extends Controller
{
    public function showArcherAnalytics()
    {
        $user = Auth::user();
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        if (!$membership) {
            return redirect()->back()->with('error', 'Membership not found.');
        }

        // Fetch the latest 15 scores for the archer, ordered by date in descending order
        $scores = Score::where('membership_id', $membership->membership_id)
            ->orderBy('date', 'desc')
            ->take(15)
            ->get()
            ->sortBy('date') // Sort in ascending order to display correctly on the chart
            ->values(); // Reset the collection keys to ensure proper mapping

        // Extract the dates
        $dates = $scores->pluck('date')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        })->toArray();

        // Calculate total scores for each record
        $totalScores = $scores->map(function ($score) {
            return $score->set1_total + $score->set2_total + $score->set3_total +
                   $score->set4_total + $score->set5_total + $score->set6_total;
        })->toArray();

        // Extract the x and ten counts
        $xCounts = $scores->pluck('x_count')->map(fn($count) => (int) $count)->toArray();
        $tenCounts = $scores->pluck('ten_count')->map(fn($count) => (int) $count)->toArray();

        // Calculate the average score per arrow for each set
        $averageScores = $scores->map(function ($score) {
            $sets = [
                [$score->set1_score1, $score->set1_score2, $score->set1_score3, $score->set1_score4, $score->set1_score5, $score->set1_score6],
                [$score->set2_score1, $score->set2_score2, $score->set2_score3, $score->set2_score4, $score->set2_score5, $score->set2_score6],
                [$score->set3_score1, $score->set3_score2, $score->set3_score3, $score->set3_score4, $score->set3_score5, $score->set3_score6],
                [$score->set4_score1, $score->set4_score2, $score->set4_score3, $score->set4_score4, $score->set4_score5, $score->set4_score6],
                [$score->set5_score1, $score->set5_score2, $score->set5_score3, $score->set5_score4, $score->set5_score5, $score->set5_score6],
                [$score->set6_score1, $score->set6_score2, $score->set6_score3, $score->set6_score4, $score->set6_score5, $score->set6_score6]
            ];

            // Calculate average for each set
            $setAverages = array_map(function ($set) {
                $numericScores = array_filter(array_map(function ($value) {
                    return $value === 'X' ? 10 : (is_numeric($value) ? (int) $value : null);
                }, $set));

                $arrowCount = count($numericScores);
                $totalScore = array_sum($numericScores);
                return $arrowCount > 0 ? round($totalScore / $arrowCount, 2) : 0;
            }, $sets);

            return $setAverages;
        })->toArray();

        // Attendance data for the current month only
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalDaysInMonth = Carbon::now()->daysInMonth;

        // Fetch attendance records for the current month
        $attendances = Attendance::where('membership_id', $membership->membership_id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();

        $presentCount = $attendances->where('attendance_status', 'present')->count();
        $absentCount = $attendances->where('attendance_status', 'absent')->count();

        // Calculate absent days for unmarked days in the current month
        $absentCount += $totalDaysInMonth - $attendances->count();

        // Prepare data for the attendance graph
        $attendanceRate = $totalDaysInMonth ? round(($presentCount / $totalDaysInMonth) * 100, 2) : 0;
        $attendanceData = [
            'present' => $presentCount,
            'absent' => $absentCount,
            'total' => $totalDaysInMonth
        ];

        return view('archer.analytics', compact('dates', 'totalScores', 'xCounts', 'tenCounts', 'averageScores', 'attendanceRate', 'attendanceData', 'membership'));
    }
}