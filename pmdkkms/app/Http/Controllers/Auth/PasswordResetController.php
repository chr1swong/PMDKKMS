<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    // Step 1: Send password reset link
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['account_email_address' => 'required|email']);

        // Check if the email exists in the account table
        $account = Account::where('account_email_address', $request->account_email_address)->first();

        if (!$account) {
            return back()->withErrors(['account_email_address' => 'E-mail address not found.']);
        }

        // Send the password reset link
        $status = Password::broker('accounts')->sendResetLink(
            ['account_email_address' => $request->account_email_address]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['account_email_address' => __($status)]);
    }

    // Step 2: Show the reset form
    public function showResetForm(Request $request, $token = null) {
        return view('auth.reset-password')->with(
            ['token' => $token, 'account_email_address' => $request->account_email_address]
        );
    }

    // Step 3: Handle the password reset
    public function reset(Request $request) {
        // Custom validation messages
        $messages = [
            'new_account_password.confirmed' => 'The password and confirm password fields do not match. Please try again.',
        ];

        $request->validate([
            'token' => 'required',
            'account_email_address' => 'required|string|email',
            'new_account_password' => 'required|string|min:8|confirmed',
        ], $messages);

        // Map the validated data to the format expected by the PasswordBroker
        $credentials = [
            'account_email_address' => $request->account_email_address,
            'password' => $request->new_account_password,
            'password_confirmation' => $request->new_account_password_confirmation,
            'token' => $request->token,
        ];

        $status = Password::broker('accounts')->reset(
            $credentials,
            function ($user, $password) {
                $user->forceFill([
                    'account_password' => Hash::make($password),
                ])->save();

                $user->setRememberToken(Str::random(60));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Account password reset successfully!')
            : back()->withErrors(['account_email_address' => [__($status)]]);
    }

    // Step 4: Change password for logged-in users
public function changePassword(Request $request) {
    // Custom validation messages
    $messages = [
        'new_account_password.confirmed' => 'The password and confirm password fields do not match. Please try again.',
    ];

    // Validate current and new password
    $request->validate([
        'current_password' => 'required|string',
        'new_account_password' => 'required|string|min:8|confirmed',
    ], $messages);

    // Get the currently authenticated user
    $account = Auth::user();

    // Check if the provided current password matches the one in the database
    if (!Hash::check($request->current_password, $account->account_password)) {
        return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect. Please try again.'])->withInput();
    }

    // Check if the new password is the same as the existing one
    if (Hash::check($request->new_account_password, $account->account_password)) {
        return redirect()->back()->withErrors(['new_account_password' => 'The new password cannot be the same as the current password. Please choose a different password.'])->withInput();
    }

    // Update the user's password
    $account->account_password = Hash::make($request->new_account_password);
    $status = $account->save();

    // Determine the user's role and redirect accordingly
    if ($status) {
        switch ($account->account_role) {
            case 1: // Archer
                return redirect()->route('archer.editProfile')->with('success', 'Account password changed successfully!');
            case 2: // Coach
                return redirect()->route('coach.editProfile')->with('success', 'Account password changed successfully!');
            case 3: // Committee Member
                return redirect()->route('committee.editProfile')->with('success', 'Account password changed successfully!');
            default:
                return redirect()->route('login')->with('error', 'Role not recognized. Please log in again.');
        }
    }

    // If the password change fails
    return back()->withErrors(['new_account_password' => 'Unable to change the password, please try again.']);
}

}
