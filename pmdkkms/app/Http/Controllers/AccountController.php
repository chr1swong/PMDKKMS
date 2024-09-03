<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_full_name' => 'required|string|max:255',
            'account_email_address' => 'required|string|email|max:255|unique:account,account_email_address',
            'account_password' => 'required|string|min:8|confirmed',
            'account_role' => 'required|in:1,2,3',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $account = Account::create([
            'account_full_name' => $request->account_full_name,
            'account_email_address' => $request->account_email_address,
            'account_password' => Hash::make($request->account_password),
            'account_role' => $request->account_role,
            'account_contact_number' => $request->account_contact_number,
            'account_membership_status' => 'active', // default status
            'account_membership_expiry' => now()->addYear(), // example expiration date
            'account_profile_picture_path' => $request->file('profile_picture')->store('profile_pictures', 'public'), // assuming you handle file uploads
        ]);

        Auth::login($account);

        return redirect()->route('profile');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'account_role' => 'required',
            'account_email_address' => 'required_if:account_role,2,3',
            'account_password' => 'required',
        ]);

        $field = $request->account_role == "1" ?: 'account_email_address';

        $account = Account::where($field, $request->$field)
            ->where('account_role', $request->account_role)
            ->first();

        if (!$account) {
            return back()->withErrors([
                $field => 'We could not find an account with those credentials. Please try again or <a href="' . route('register') . '">register an account</a>.',
            ]);
        }

        if (!Hash::check($request->account_password, $account->account_password)) {
            return back()->withErrors([
                'account_password' => 'The password you entered was incorrect. Please try again.',
            ])->withInput();
        }

        Auth::login($account);
        $request->session()->regenerate();

        return redirect()->intended('profile');
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
