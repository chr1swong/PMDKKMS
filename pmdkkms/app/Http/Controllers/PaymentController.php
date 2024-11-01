<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Display the payment form
    public function paymentForm()
    {
        // Get user and membership info
        $user = Auth::user();

        // Retrieve membership details
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        // Check if the membership exists
        $membership_id = $membership ? $membership->membership_id : 'N/A';

        // Pass the user and membership data to the view
        return view('committee.paymentForm', [
            'user' => $user,
            'membership_id' => $membership_id,
        ]);
    }

    // Initiate the payment
    public function initiatePayment(Request $request)
    {
        // Validate duration
        $request->validate([
            'duration' => 'required|in:1,3,6,12',
        ]);

        $user = Auth::user();
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        // Calculate amount based on duration
        $duration = $request->duration; // in months
        // Prices: 1 Month (RM30), 3 Months (RM90), 6 Months (RM180), 12 Months (RM360)
        switch ($duration) {
            case '1':
                $amount = 30;
                break;
            case '3':
                $amount = 90;
                break;
            case '6':
                $amount = 180;
                break;
            case '12':
                $amount = 360;
                break;
            default:
                return back()->with('error', 'Invalid duration selected.');
        }

        // Retrieve ToyyibPay credentials
        $userSecretKey = config('services.toyyibpay.secret_key');
        $categoryCode = config('services.toyyibpay.category_code');
        $url = config('services.toyyibpay.url');

        // Log credentials (ensure to remove this in production)
        Log::info('ToyyibPay Credentials:', [
            'userSecretKey' => $userSecretKey,
            'categoryCode' => $categoryCode,
        ]);

        // Prepare data for ToyyibPay API
        $billData = [
            'userSecretKey' => $userSecretKey,
            'categoryCode' => $categoryCode,
            'billName' => 'Membership Extension',
            'billDescription' => 'Extend membership for ' . $user->account_full_name,
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $amount * 100, // amount in cents
            'billReturnUrl' => route('payment.return'),
            'billCallbackUrl' => route('payment.notify'),
            'billExternalReferenceNo' => 'MEMBERSHIP_' . $membership->membership_id,
            'billTo' => $user->account_full_name,
            'billEmail' => $user->account_email_address,
            'billPhone' => $user->account_contact_number,
            'billContentEmail' => 'Thank you for extending your membership.',
            'billExpiryDate' => '', // Optional
            'billChargeToCustomer' => 1,
        ];

        // Send POST request to ToyyibPay API to create a bill
        $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/createBill', $billData);

        if ($response->successful() && isset($response->json()[0]['BillCode'])) {
            $billCode = $response->json()[0]['BillCode'];

            // Save payment record in database
            Payment::create([
                'account_id' => $user->account_id,
                'membership_id' => $membership->membership_id,
                'amount' => $amount,
                'payment_status' => 'Pending', // Mark as pending until confirmation
                'toyyibpay_billcode' => $billCode,
                'duration' => $duration, // Save the duration for reference
            ]);

            // Redirect user to ToyyibPay payment page
            return redirect('https://dev.toyyibpay.com/' . $billCode);
        } else {
            // Save failed payment record in database
            Payment::create([
                'account_id' => $user->account_id,
                'membership_id' => $membership->membership_id,
                'amount' => $amount,
                'payment_status' => 'Failed', // Mark payment as failed
                'toyyibpay_billcode' => null, // No bill code since creation failed
                'duration' => $duration, // Save duration for tracking failed attempt
            ]);

            // Log error for debugging purposes
            Log::error('ToyyibPay API Error:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            // Return with error message to the previous page
            return back()->with('error', 'Failed to initiate payment. Please try again later.');
        }
    }

    public function paymentReturn(Request $request)
    {
        // Retrieve BillCode and Status
        $billcode = $request->billcode;
        $status_id = $request->status_id;

        // Find the payment record
        $payment = Payment::where('toyyibpay_billcode', $billcode)->first();

        if (!$payment) {
            return redirect()->route('committee.paymentForm')->with('error', 'Payment not found.');
        }

        if ($status_id == 1) {
            // Payment successful
            $payment->update(['payment_status' => 'Completed']);

            // Extend membership expiry date
            $membership = DB::table('membership')->where('membership_id', $payment->membership_id)->first();

            if ($membership) {
                // Update membership_expiry based on duration
                $currentExpiryDate = Carbon::parse($membership->membership_expiry);
                $newExpiryDate = $currentExpiryDate->addMonths($payment->duration);

                DB::table('membership')->where('membership_id', $payment->membership_id)->update([
                    'membership_expiry' => $newExpiryDate,
                ]);
            }

            return redirect()->route('committee.profile')->with('success', 'Payment successful. Membership extended.');
        } else {
            // Payment failed or canceled
            $payment->update(['payment_status' => 'Failed']);
            
            // Redirect back to payment form with an error message
            return redirect()->route('committee.paymentForm')->with('error', 'Payment failed or canceled. Please try again.');
        }
    }


    // Handle payment notification (ToyyibPay calls this URL to notify payment status)
    public function paymentNotify(Request $request)
    {
        // Log the request for debugging
        Log::info('ToyyibPay Payment Notification:', $request->all());

        $billcode = $request->billcode;
        $status_id = $request->status_id;

        // Find the payment record
        $payment = Payment::where('toyyibpay_billcode', $billcode)->first();

        if ($payment) {
            if ($status_id == 1) {
                // Payment successful
                $payment->update(['payment_status' => 'Completed']);

                // Extend membership expiry date
                $membership = DB::table('membership')->where('membership_id', $payment->membership_id)->first();

                if ($membership) {
                    // Update membership_expiry based on duration
                    $currentExpiryDate = Carbon::parse($membership->membership_expiry);
                    $newExpiryDate = $currentExpiryDate->addMonths($payment->duration);

                    DB::table('membership')->where('membership_id', $payment->membership_id)->update([
                        'membership_expiry' => $newExpiryDate,
                    ]);
                }
            } else {
                // Payment failed or canceled
                $payment->update(['payment_status' => 'Failed']);
            }
        }
    }
}
