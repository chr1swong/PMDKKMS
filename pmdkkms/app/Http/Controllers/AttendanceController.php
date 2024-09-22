<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;

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
            'attendanceData' => $attendanceData
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
        ]);

        // Create or update the attendance record
        Attendance::updateOrCreate(
            [
                'membership_id' => $request->membership_id,
                'attendance_date' => $request->attendance_date,
            ],
            [
                'attendance_status' => $request->attendance_status,
            ]
        );

        // Redirect back with a success message
        return back()->with('success', 'Attendance recorded successfully.');
    }

    // Optional: View attendance records for logged-in archer
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
}
