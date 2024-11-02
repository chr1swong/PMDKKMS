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
    public function paymentForm($view = 'committee')
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Retrieve membership details for the user
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        // Check if the membership exists and assign appropriate values
        $membership_id = $membership ? $membership->membership_id : 'N/A';
        $membership_status = $membership && $membership->membership_status == 1 ? 'Active' : 'Inactive';
        $membership_expiry = $membership && $membership->membership_expiry ? Carbon::parse($membership->membership_expiry)->toFormattedDateString() : 'N/A';

        // Choose the view path based on the $view parameter
        $viewPath = match ($view) {
            'archer' => 'archer.paymentForm',
            'coach' => 'coach.paymentForm',
            default => 'committee.paymentForm',
        };

        // Pass the user, membership details, and new variables to the view
        return view($viewPath, [
            'user' => $user,
            'membership_id' => $membership_id,
            'membership_status' => $membership_status,
            'membership_expiry' => $membership_expiry,
        ]);
    }

    // Initiate the payment
    public function initiatePayment(Request $request, $role = 'committee')
    {
        // Validate duration
        $request->validate([
            'duration' => 'required|in:1,3,6,12',
        ]);

        $user = Auth::user();
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        // Calculate amount based on duration
        $duration = $request->duration;
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

        // Set return URLs based on role
        $returnRoute = match ($role) {
            'archer' => 'archer.payment.return',
            'coach' => 'coach.payment.return',
            default => 'committee.payment.return',
        };
        $callbackRoute = match ($role) {
            'archer' => 'archer.payment.notify',
            'coach' => 'coach.payment.notify',
            default => 'committee.payment.notify',
        };

        // Prepare data for ToyyibPay API
        $billData = [
            'userSecretKey' => $userSecretKey,
            'categoryCode' => $categoryCode,
            'billName' => 'Membership Extension',
            'billDescription' => 'Extend membership for ' . $user->account_full_name,
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $amount * 100, // amount in cents
            'billReturnUrl' => route($returnRoute),
            'billCallbackUrl' => route($callbackRoute),
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

    // Committee payment return function
    public function committeePaymentReturn(Request $request)
    {
        return $this->handlePaymentReturn($request, 'committee');
    }

    // Archer payment return function
    public function archerPaymentReturn(Request $request)
    {
        return $this->handlePaymentReturn($request, 'archer');
    }

    // Coach payment return function
    public function coachPaymentReturn(Request $request)
    {
        return $this->handlePaymentReturn($request, 'coach');
    }

    // Common logic for handling payment return
    private function handlePaymentReturn(Request $request, $role)
    {
        // Retrieve BillCode and Status
        $billcode = $request->billcode;
        $status_id = $request->status_id;

        // Find the payment record
        $payment = Payment::where('toyyibpay_billcode', $billcode)->first();

        if (!$payment) {
            return redirect()->route("{$role}.paymentForm")->with('error', 'Payment not found.');
        }

        if ($status_id == 1) {
            $payment->update(['payment_status' => 'Completed']);

            $membership = DB::table('membership')->where('membership_id', $payment->membership_id)->first();

            if ($membership) {
                $currentExpiryDate = Carbon::parse($membership->membership_expiry);
                $newExpiryDate = $currentExpiryDate->addMonths($payment->duration);

                DB::table('membership')->where('membership_id', $payment->membership_id)->update([
                    'membership_expiry' => $newExpiryDate,
                ]);
            }

            return redirect()->route("{$role}.profile")->with('success', 'Payment successful. Membership extended.');
        } else {
            $payment->update(['payment_status' => 'Failed']);
            return redirect()->route("{$role}.paymentForm")->with('error', 'Payment failed or canceled. Please try again.');
        }
    }

    // Handle payment notification (ToyyibPay calls this URL to notify payment status)
    public function committeePaymentNotify(Request $request)
    {
        return $this->handlePaymentNotify($request, 'committee');
    }

    public function archerPaymentNotify(Request $request)
    {
        return $this->handlePaymentNotify($request, 'archer');
    }

    public function coachPaymentNotify(Request $request)
    {
        return $this->handlePaymentNotify($request, 'coach');
    }

    // Common logic for handling payment notification
    private function handlePaymentNotify(Request $request, $role)
    {
        Log::info("{$role} ToyyibPay Payment Notification:", $request->all());

        $billcode = $request->billcode;
        $status_id = $request->status_id;

        $payment = Payment::where('toyyibpay_billcode', $billcode)->first();

        if ($payment) {
            if ($status_id == 1) {
                $payment->update(['payment_status' => 'Completed']);

                $membership = DB::table('membership')->where('membership_id', $payment->membership_id)->first();

                if ($membership) {
                    $currentExpiryDate = Carbon::parse($membership->membership_expiry);
                    $newExpiryDate = $currentExpiryDate->addMonths($payment->duration);

                    DB::table('membership')->where('membership_id', $payment->membership_id)->update([
                        'membership_expiry' => $newExpiryDate,
                    ]);
                }
            } else {
                $payment->update(['payment_status' => 'Failed']);
            }
        }
    }

    public function paymentHistoryCommittee(Request $request)
    {
        // Fetch the start and end dates from the request
        $startDate = $request->query('start-date');
        $endDate = $request->query('end-date');

        // Fetch the payment records, applying date filter if provided
        $payments = Payment::with('account')
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->paginate(10); // Adjust pagination as needed

        // Pass the payments data and selected dates to the view
        return view('committee.paymentHistory', compact('payments', 'startDate', 'endDate'));
    }
}
