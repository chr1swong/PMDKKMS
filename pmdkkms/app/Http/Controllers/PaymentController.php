<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Show payment form for committee members
    public function showCommitteePaymentForm()
    {
        $user = auth()->user();
        return view('committee.paymentForm', ['user' => $user]);
    }

    // Process payment for membership extension for committee members
    public function processCommitteePayment(Request $request)
    {
        $request->validate([
            'duration' => 'required|in:1,3,6,12',
        ]);

        $user = auth()->user();
        $amount = 30 * $request->duration; // RM30 per month
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        if (!$membership) {
            return redirect()->back()->with('error', 'No membership found.');
        }

        // Extend the membership expiry date based on the selected duration
        $newExpiry = Carbon::parse($membership->membership_expiry)->addMonths($request->duration);

        // Update membership in the database
        DB::table('membership')
            ->where('account_id', $user->account_id)
            ->update([
                'membership_expiry' => $newExpiry,
                'updated_at' => now(),
            ]);

        return redirect()->route('committee.profile')->with('success', 'Membership extended successfully.');
    }
}
