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

        // Extract the dates for the score-related data
        $scoreDates = $scores->pluck('date')->map(function ($date) {
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

        // Performance Consistency Chart
        $performanceConsistency = collect(range(1, 6))->map(function ($setIndex) use ($scores) {
            $setScores = $scores->map(function ($score) use ($setIndex) {
                $set = "set{$setIndex}_total";
                return $score->$set;
            })->filter();

            // Calculate standard deviation
            $average = $setScores->avg();
            $variance = $setScores->map(function ($score) use ($average) {
                return pow($score - $average, 2);
            })->avg();

            return round(sqrt($variance), 2); // Standard deviation
        })->toArray();

        // Set Performance Comparison Chart
        $setPerformanceComparison = collect(range(1, 6))->map(function ($setIndex) use ($scores) {
            $setScores = $scores->map(function ($score) use ($setIndex) {
                $set = "set{$setIndex}_total";
                return $score->$set;
            })->filter();

            return round($setScores->avg(), 2); // Average score per set
        })->toArray();

        // Hit Zone Percentage
        $hitZones = [
            'X' => 0, '10' => 0, '9' => 0, '8' => 0, '7' => 0,
            '6' => 0, '5' => 0, '4' => 0, '3' => 0, '2' => 0, '1' => 0, 'Miss' => 0
        ];

        $totalShots = 0;
        foreach ($scores as $score) {
            $allScores = [
                $score->set1_score1, $score->set1_score2, $score->set1_score3, $score->set1_score4, $score->set1_score5, $score->set1_score6,
                $score->set2_score1, $score->set2_score2, $score->set2_score3, $score->set2_score4, $score->set2_score5, $score->set2_score6,
                $score->set3_score1, $score->set3_score2, $score->set3_score3, $score->set3_score4, $score->set3_score5, $score->set3_score6,
                $score->set4_score1, $score->set4_score2, $score->set4_score3, $score->set4_score4, $score->set4_score5, $score->set4_score6,
                $score->set5_score1, $score->set5_score2, $score->set5_score3, $score->set5_score4, $score->set5_score5, $score->set5_score6,
                $score->set6_score1, $score->set6_score2, $score->set6_score3, $score->set6_score4, $score->set6_score5, $score->set6_score6
            ];

            foreach ($allScores as $shot) {
                if ($shot === 'X') {
                    $hitZones['X']++;
                } elseif (is_numeric($shot) && isset($hitZones[$shot])) {
                    $hitZones[$shot]++;
                } else {
                    $hitZones['Miss']++;
                }
                $totalShots++;
            }
        }

        // Calculate the percentage for each hit zone
        $hitZonePercentages = array_map(function ($count) use ($totalShots) {
            return $totalShots > 0 ? round(($count / $totalShots) * 100, 2) : 0;
        }, $hitZones);

        // Convert hit zones to arrays for Chart.js
        $hitZoneLabels = array_keys($hitZonePercentages);
        $hitZoneValues = array_values($hitZonePercentages);

        // Attendance data for each day of the current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalDaysInMonth = Carbon::now()->daysInMonth;

        // Generate all dates in the current month
        $daysInMonth = CarbonPeriod::create("$currentYear-$currentMonth-01", "$currentYear-$currentMonth-$totalDaysInMonth");
        $dailyAttendance = [];

        // Initialize daily attendance with zeros (absent)
        foreach ($daysInMonth as $day) {
            $dailyAttendance[$day->format('Y-m-d')] = 0;
        }

        // Fetch attendance records for the current month
        $attendances = Attendance::where('membership_id', $membership->membership_id)
            ->whereMonth('attendance_date', $currentMonth)
            ->whereYear('attendance_date', $currentYear)
            ->get();

        // Mark the days as present
        foreach ($attendances as $attendance) {
            $date = Carbon::parse($attendance->attendance_date)->format('Y-m-d');
            if ($attendance->attendance_status === 'present' && array_key_exists($date, $dailyAttendance)) {
                $dailyAttendance[$date] = 1; // Mark as present
            }
        }

        // Prepare data for the attendance graph
        $attendanceDates = array_keys($dailyAttendance);
        $attendanceValues = array_values($dailyAttendance);

        return view('archer.analytics', compact(
            'scoreDates', 'totalScores', 'xCounts', 'tenCounts', 'averageScores',
            'attendanceDates', 'attendanceValues', 'membership', 'performanceConsistency',
            'setPerformanceComparison', 'hitZoneLabels', 'hitZoneValues'
        ));
    }

    public function viewArcherAnalytics($archerId)
    {
        // Fetch the membership details for the given archer ID
        $membership = DB::table('membership')->where('account_id', $archerId)->first();

        if (!$membership) {
            return redirect()->back()->with('error', 'Membership not found for the selected archer.');
        }

        // Retrieve the archer's full name
        $archer = DB::table('membership')
            ->join('account', 'membership.account_id', '=', 'account.account_id')
            ->where('membership.membership_id', $membership->membership_id)
            ->select('account.account_full_name')
            ->first();

        $fullName = $archer->account_full_name ?? 'Unknown Archer';

        // Fetch the latest 15 scores for the archer, ordered by date in descending order
        $scores = Score::where('membership_id', $membership->membership_id)
            ->orderBy('date', 'desc')
            ->take(15)
            ->get()
            ->sortBy('date')
            ->values();

        // Extract the dates for the score-related data
        $scoreDates = $scores->pluck('date')->map(function ($date) {
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

        // Performance Consistency Chart
        $performanceConsistency = collect(range(1, 6))->map(function ($setIndex) use ($scores) {
            $setScores = $scores->map(function ($score) use ($setIndex) {
                $set = "set{$setIndex}_total";
                return $score->$set;
            })->filter();

            $average = $setScores->avg();
            $variance = $setScores->map(function ($score) use ($average) {
                return pow($score - $average, 2);
            })->avg();

            return round(sqrt($variance), 2); // Standard deviation
        })->toArray();

        // Set Performance Comparison Chart
        $setPerformanceComparison = collect(range(1, 6))->map(function ($setIndex) use ($scores) {
            $setScores = $scores->map(function ($score) use ($setIndex) {
                $set = "set{$setIndex}_total";
                return $score->$set;
            })->filter();

            return round($setScores->avg(), 2); // Average score per set
        })->toArray();

        // Hit Zone Percentage
        $hitZones = [
            'X' => 0, '10' => 0, '9' => 0, '8' => 0, '7' => 0,
            '6' => 0, '5' => 0, '4' => 0, '3' => 0, '2' => 0, '1' => 0, 'Miss' => 0
        ];

        $totalShots = 0;
        foreach ($scores as $score) {
            $allScores = [
                $score->set1_score1, $score->set1_score2, $score->set1_score3, $score->set1_score4, $score->set1_score5, $score->set1_score6,
                $score->set2_score1, $score->set2_score2, $score->set2_score3, $score->set2_score4, $score->set2_score5, $score->set2_score6,
                $score->set3_score1, $score->set3_score2, $score->set3_score3, $score->set3_score4, $score->set3_score5, $score->set3_score6,
                $score->set4_score1, $score->set4_score2, $score->set4_score3, $score->set4_score4, $score->set4_score5, $score->set4_score6,
                $score->set5_score1, $score->set5_score2, $score->set5_score3, $score->set5_score4, $score->set5_score5, $score->set5_score6,
                $score->set6_score1, $score->set6_score2, $score->set6_score3, $score->set6_score4, $score->set6_score5, $score->set6_score6
            ];

            foreach ($allScores as $shot) {
                if ($shot === 'X') {
                    $hitZones['X']++;
                } elseif (is_numeric($shot) && isset($hitZones[$shot])) {
                    $hitZones[$shot]++;
                } else {
                    $hitZones['Miss']++;
                }
                $totalShots++;
            }
        }

        $hitZonePercentages = array_map(function ($count) use ($totalShots) {
            return $totalShots > 0 ? round(($count / $totalShots) * 100, 2) : 0;
        }, $hitZones);

        $hitZoneLabels = array_keys($hitZonePercentages);
        $hitZoneValues = array_values($hitZonePercentages);

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalDaysInMonth = Carbon::now()->daysInMonth;

        $daysInMonth = CarbonPeriod::create("$currentYear-$currentMonth-01", "$currentYear-$currentMonth-$totalDaysInMonth");
        $dailyAttendance = [];

        foreach ($daysInMonth as $day) {
            $dailyAttendance[$day->format('Y-m-d')] = 0;
        }

        $attendances = Attendance::where('membership_id', $membership->membership_id)
            ->whereMonth('attendance_date', $currentMonth)
            ->whereYear('attendance_date', $currentYear)
            ->get();

        foreach ($attendances as $attendance) {
            $date = Carbon::parse($attendance->attendance_date)->format('Y-m-d');
            if ($attendance->attendance_status === 'present' && array_key_exists($date, $dailyAttendance)) {
                $dailyAttendance[$date] = 1;
            }
        }

        $attendanceDates = array_keys($dailyAttendance);
        $attendanceValues = array_values($dailyAttendance);

        return view('coach.analytics', compact(
            'scoreDates', 'totalScores', 'xCounts', 'tenCounts', 'averageScores',
            'attendanceDates', 'attendanceValues', 'membership', 'performanceConsistency',
            'setPerformanceComparison', 'hitZoneLabels', 'hitZoneValues', 'fullName'
        ));
    }
}
