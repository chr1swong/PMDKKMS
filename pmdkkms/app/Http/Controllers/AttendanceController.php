<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    // Show attendance form for the logged-in archer
    public function showAttendanceForm()
    {
        $user = Auth::user(); // Get the logged-in user
        $membership = Membership::where('account_id', $user->account_id)->first(); // Get membership details for the logged-in archer

        // Fetch the attendance records for this member
        $attendances = Attendance::where('membership_id', $membership->membership_id)->get();

        // Format attendance data for FullCalendar
        $attendanceData = $attendances->map(function ($attendance) {
            return [
                'date' => $attendance->attendance_date,
                'status' => $attendance->attendance_status,
            ];
        });

        // Pass the membership and attendance data to the view
        return view('archer.attendance', [
            'membership' => $membership,
            'attendanceData' => $attendanceData,
            'readOnly' => true // Pass a flag to disable the form in the view
        ]);
    }

    // Store attendance record
    public function storeAttendance(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'membership_id' => 'required|exists:membership,membership_id',
            'attendance_date' => 'required|date',
            'attendance_status' => 'required|in:present,absent,excused',
            'check_in_time' => 'required|date_format:H:i',
        ]);

        // Format check_in_time to ensure no seconds are included
        $formattedCheckInTime = \Carbon\Carbon::parse($request->check_in_time)->format('H:i');

        // Create or update the attendance record
        Attendance::updateOrCreate(
            [
                'membership_id' => $request->membership_id,
                'attendance_date' => $request->attendance_date,
            ],
            [
                'attendance_status' => $request->attendance_status,
                'check_in_time' => $formattedCheckInTime,
            ]
        );

        // Redirect back with a success message
        return back()->with('success', 'Attendance recorded successfully.');
    }

    // View attendance records for the logged-in archer
    public function viewAttendance()
    {
        $user = Auth::user(); // Get the logged-in user
        $membership = Membership::where('account_id', $user->account_id)->first(); // Get membership details for the logged-in archer

        // Fetch attendance records for this membership
        $attendances = Attendance::where('membership_id', $membership->membership_id)->get();

        // Pass the attendance records to the view
        return view('archer.viewAttendance', [
            'membership' => $membership,
            'attendances' => $attendances
        ]);
    }

    public function viewMoreAttendanceArcher($membership_id)
    {
        // Get the archer's membership and related account details
        $archer = Membership::with('account') // Ensure the 'account' relationship is loaded
            ->where('membership_id', $membership_id)
            ->first();

        // Check if the archer's membership exists
        if (!$archer || !$archer->account) {
            return redirect()->back()->with('error', 'Archer or account not found.');
        }

        // Fetch attendance records for this specific archer's membership
        $attendanceRecords = Attendance::where('membership_id', $membership_id)
            ->orderBy('attendance_date', 'desc') // Sort by attendance date (descending)
            ->get();

        // Return the view with membership data and attendance records
        return view('archer.attendanceMore', [
            'archer' => $archer, // Pass the archer variable (with the 'account' relationship)
            'attendanceRecords' => $attendanceRecords, // Pass attendance records
        ]);
    }

    // View all attendance records for committee members
    public function viewAllAttendance(Request $request)
    {
        // Get the selected month and year from the request, default to the current month and year
        $filterMonth = $request->input('attendance-filter', date('F')); // Default to current month name (e.g., 'October')
        $filterYear = $request->input('year-filter', date('Y'));        // Default to current year (e.g., 2024)

        // Convert the month name to a number (January = 01, February = 02, etc.)
        $monthNumber = date('m', strtotime($filterMonth));

        // Get the total number of days in the selected month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $filterYear);

        // Query attendance records filtered by the selected month and year
        $attendances = Attendance::with(['membership', 'membership.account'])
            ->leftJoin('membership', 'attendance.membership_id', '=', 'membership.membership_id')
            ->leftJoin('account', 'membership.account_id', '=', 'account.account_id')
            ->leftJoin('coach_archer', 'account.account_id', '=', 'coach_archer.archer_id') // Join coach_archer to link archers with coaches
            ->leftJoin('account as coach', 'coach_archer.coach_id', '=', 'coach.account_id') // Get coach details
            ->whereMonth('attendance_date', $monthNumber)
            ->whereYear('attendance_date', $filterYear)
            ->select(
                'attendance.*',
                'account.account_full_name as archer_name',
                'membership.membership_id',
                'coach.account_full_name as coach_name'
            )
            ->get();

        // Group attendance records by membership_id and calculate attendance count for the month
        $attendanceSummary = $attendances->groupBy('membership_id')->map(function ($attendanceRecords) use ($daysInMonth) {
            $presentCount = $attendanceRecords->where('attendance_status', 'present')->count();
            return [
                'membership' => $attendanceRecords->first()->membership,
                'presentCount' => $presentCount,
                'daysInMonth' => $daysInMonth,
                'coach_name' => $attendanceRecords->first()->coach_name,
                'attendanceRecords' => $attendanceRecords // Include individual attendance records
            ];
        });

        // Pass the attendance summary and both month and year data to the view
        return view('committee.attendanceList', [
            'attendanceSummary' => $attendanceSummary,
            'filterMonth' => $filterMonth,
            'filterYear' => $filterYear
        ]);
    }

    // View a specific archer's attendance for committee members
    public function viewArcherAttendance($membership_id)
    {
        // Get the membership details of the selected archer
        $membership = Membership::where('membership_id', $membership_id)->firstOrFail();

        // Fetch attendance records for this membership
        $attendances = Attendance::where('membership_id', $membership->membership_id)->get();

        // Format attendance data for FullCalendar
        $attendanceData = $attendances->map(function ($attendance) {
            return [
                'date' => $attendance->attendance_date,
                'status' => $attendance->attendance_status,
            ];
        });

        // Pass the membership and attendance data to the view
        return view('committee.attendanceView', [
            'membership' => $membership,
            'attendanceData' => $attendanceData
        ]);
    }

    // **Committee Section**: Update a specific archer's attendance by the committee member
    public function updateCommitteeArcherAttendance(Request $request, $membership_id)
    {
        // Validate the request inputs
        $request->validate([
            'attendance_date' => 'required|date',
            'attendance_status' => 'required|in:present,absent',
            'check_in_time' => 'nullable|date_format:H:i',
        ]);

        // Format check_in_time to ensure no seconds are included
        $formattedCheckInTime = $request->has('check_in_time') ? \Carbon\Carbon::parse($request->check_in_time)->format('H:i') : null;

        // Get the archer's information (membership and account)
        $archer = Membership::with('account')->where('membership_id', $membership_id)->first();

        // Create or update the attendance record for the specific date
        Attendance::updateOrCreate(
            [
                'membership_id' => $membership_id,
                'attendance_date' => $request->attendance_date,
            ],
            [
                'attendance_status' => $request->attendance_status,
                'check_in_time' => $formattedCheckInTime,
            ]
        );

        // Return back with the updated data
        return back()->with([
            'archer' => $archer,  // Pass the archer data (membership and account)
            'attendance_status' => $request->attendance_status,
            'check_in_time' => $formattedCheckInTime,
            'attendance_date' => $request->attendance_date,
        ]);
    }

    public function viewMoreAttendanceCommittee($membership_id)
    {
        // Get the archer's membership and related account details
        $archer = Membership::with('account') // Ensure the 'account' relationship is loaded
            ->where('membership_id', $membership_id)
            ->first();

        // Check if the archer's membership exists
        if (!$archer || !$archer->account) {
            return redirect()->back()->with('error', 'Archer or account not found.');
        }

        // Fetch attendance records for this specific archer's membership
        $attendanceRecords = Attendance::where('membership_id', $membership_id)
            ->orderBy('attendance_date', 'desc') // Sort by attendance date (descending)
            ->get();

        // Return the view with membership data and attendance records
        return view('archer.attendanceMore', [
            'archer' => $archer, // Pass the archer variable (with the 'account' relationship)
            'attendanceRecords' => $attendanceRecords, // Pass attendance records
        ]);
    }

    // **Coach Section**: View attendance details of an archer for the coach
    public function viewCoachArcherAttendance($membership_id)
    {
        dd("you're not supposed to go here");

        // Fetch the membership and related archer details from the account table
        $membership = DB::table('membership')
            ->join('account', 'membership.account_id', '=', 'account.account_id')
            ->where('membership.membership_id', $membership_id)
            ->select('membership.membership_id', 'account.account_full_name')
            ->first();

        if (!$membership) {
            return redirect()->back()->with('error', 'Archer not found.');
        }

        // Fetch attendance records for this membership
        $attendances = Attendance::where('membership_id', $membership_id)->get();

        // Format attendance data for FullCalendar
        $attendanceData = $attendances->map(function ($attendance) {
            return [
                'date' => $attendance->attendance_date,
                'status' => $attendance->attendance_status,
            ];
        });

        // Pass the membership and attendance data to the view
        return view('coach.attendanceView', [
            'membership' => $membership, // This now contains the archer's full name as well
            'attendanceData' => $attendanceData,
        ]);
    }

    // **Coach Section**: Update a specific archer's attendance by the coach
    public function updateCoachArcherAttendance(Request $request, $membership_id)
    {
        // Validate the request inputs
        $request->validate([
            'attendance_date' => 'required|date',
            'attendance_status' => 'required|in:present,absent',
            'check_in_time' => 'nullable|date_format:H:i',
        ]);

        // Format check_in_time to ensure no seconds are included
        $formattedCheckInTime = $request->has('check_in_time') ? \Carbon\Carbon::parse($request->check_in_time)->format('H:i') : null;

        // Get the archer's information (membership and account)
        $archer = Membership::with('account')->where('membership_id', $membership_id)->first();

        // Create or update the attendance record for the specific date
        Attendance::updateOrCreate(
            [
                'membership_id' => $membership_id,
                'attendance_date' => $request->attendance_date,
            ],
            [
                'attendance_status' => $request->attendance_status,
                'check_in_time' => $formattedCheckInTime,
            ]
        );

        // Return back without the success message, but pass necessary data
        return back()->with([
            'archer' => $archer,  // Pass the archer data (membership and account)
            'attendance_status' => $request->attendance_status,
            'check_in_time' => $formattedCheckInTime,
            'attendance_date' => $request->attendance_date,
        ]);
    }

    public function viewAllAttendanceForCoach(Request $request)
    {
        // Get the current logged-in coach
        $coachId = Auth::user()->account_id;
        
        // Get the selected month and year from the request, or default to the current month and year
        $filterMonth = $request->input('attendance-filter', date('F')); // Default to current month
        $filterYear = $request->input('year-filter', date('Y'));        // Default to current year

        // Convert month name to number format (January -> 01, etc.)
        $monthNumber = date('m', strtotime($filterMonth));

        // Get the number of days in the selected month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $filterYear);

        // Ensure we are retrieving attendance for archers under this coach, filtered by the month and year
        $attendances = Attendance::with('membership.account')
            ->join('membership', 'attendance.membership_id', '=', 'membership.membership_id')
            ->join('coach_archer', 'membership.account_id', '=', 'coach_archer.archer_id')
            ->where('coach_archer.coach_id', $coachId) // Only fetch archers under this coach
            ->whereMonth('attendance_date', $monthNumber) // Filter by month
            ->whereYear('attendance_date', $filterYear)   // Filter by year
            ->select('attendance.*', 'membership.membership_id')
            ->get();

        // Group attendance records by membership_id
        $attendanceSummary = $attendances->groupBy('membership_id')->map(function ($attendanceRecords) use ($daysInMonth) {
            // Calculate number of 'present' days for each archer
            $presentCount = $attendanceRecords->where('attendance_status', 'present')->count();

            // Format check_in_time to show only hours and minutes (no seconds)
            $attendanceRecords->each(function ($attendance) {
                if ($attendance->check_in_time) {
                    // Format the check_in_time to HH:mm
                    $attendance->check_in_time = \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i');
                }
            });

            // Return structured data for the view
            return [
                'membership' => $attendanceRecords->first()->membership,
                'presentCount' => $presentCount,
                'daysInMonth' => $daysInMonth,
                'attendanceRecords' => $attendanceRecords, // Add attendance records for each archer
            ];
        });

        // Ensure we pass the correct month and year to the view, even when no records exist
        return view('coach.attendanceList', compact('attendanceSummary', 'filterMonth', 'filterYear'));
    }

    public function viewMoreAttendanceCoach($membership_id)
    {
        // Get the archer's information along with the associated account (including name)
        $archer = Membership::with('account') // Ensure the 'account' relationship is loaded
            ->where('membership_id', $membership_id)
            ->first();

        // Check if the archer's membership exists
        if (!$archer || !$archer->account) {
            return redirect()->back()->with('error', 'Archer or account not found.');
        }

        // Fetch attendance records for this specific archer's membership
        $attendanceRecords = Attendance::where('membership_id', $membership_id)
            ->orderBy('attendance_date', 'desc') // Sort by date (descending)
            ->get();

        // Return the view with membership data and attendance records
        return view('coach.attendanceMore', [
            'archer' => $archer, // Pass the $archer variable (with the 'account' relationship)
            'attendanceRecords' => $attendanceRecords, // Pass attendanceRecords variable
        ]);
    }

    public function generateArcherQrCode($membership_id)
    {
        $currentDate = now()->toDateString(); // Current date

        // Generate a QR code URL specific to the archer's attendance
        $qrUrl = route('attendance.scan', [
            'membership_id' => $membership_id,
            'date' => $currentDate,
        ]);

        // Generate the QR code
        $qrCode = QrCode::size(300)->generate($qrUrl);

        // Pass the generated QR code and date to the view
        return view('coach.attendanceQrCode', compact('qrCode', 'currentDate', 'membership_id'));
    }

    public function recordAttendanceFromQr(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'membership_id' => 'required|exists:membership,membership_id',
            'date' => 'required|date',
        ]);

        // Record attendance for the archer based on the QR scan
        Attendance::updateOrCreate(
            [
                'membership_id' => $request->membership_id,
                'attendance_date' => $request->date,
            ],
            [
                'attendance_status' => 'present',
                'check_in_time' => now()->format('H:i') // Add check-in time
            ]
        );

        // Fetch the archer's details
        $membership = Membership::where('membership_id', $request->membership_id)->first();
        $archerName = $membership->account->account_full_name ?? 'N/A';
        $membershipId = $membership->membership_id;
        $attendanceDate = $request->date;
        $checkInTime = now()->format('H:i'); // Get the current check-in time

        // Pass the details to the success view
        return view('attendanceSuccess', [
            'archerName' => $archerName,
            'membershipId' => $membershipId,
            'attendanceDate' => $attendanceDate,
            'checkInTime' => $checkInTime
        ]);
    }
}
