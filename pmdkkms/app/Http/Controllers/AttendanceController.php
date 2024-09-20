<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // // Show attendance form
    // public function showAttendanceForm()
    // {
    //     $memberships = Membership::all(); // Get all members
    //     return view('archer.attendance', ['memberships' => $memberships]);
    // }

    // // Store attendance
    // public function storeAttendance(Request $request)
    // {
    //     $request->validate([
    //         'membership_id' => 'required|exists:membership,membership_id',
    //         'attendance_date' => 'required|date',
    //         'attendance_status' => 'required|in:present,absent,excused',
    //     ]);

    //     Attendance::create([
    //         'membership_id' => $request->membership_id,
    //         'attendance_date' => $request->attendance_date,
    //         'attendance_status' => $request->attendance_status,
    //     ]);

    //     return back()->with('success', 'Attendance recorded successfully.');
    // }

    // // View attendance records
    // public function viewAttendance()
    // {
    //     $attendances = Attendance::with('membership')->get();
    //     return view('archer.viewAttendance', ['attendances' => $attendances]);
    // }

    // Show attendance form for the logged-in archer
    public function showAttendanceForm()
    {
        $user = Auth::user(); // Get the logged-in user
        $membership = Membership::where('account_id', $user->account_id)->first(); // Get membership details for the logged-in archer

        return view('archer.attendance', ['membership' => $membership]);
    }
}


