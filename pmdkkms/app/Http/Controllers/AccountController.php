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
            'account_membership_status' => '2', // default status
            'account_membership_expiry' => now()->addYear(), // example expiration date
            'account_profile_picture_path' => $request->hasFile('profile_picture') 
                ? $request->file('profile_picture')->store('profile_pictures', 'public') 
                : '', // Assign empty string if no file uploaded
        ]);

        Auth::login($account);

        /*
            consider switch statement as
            switch (account_role)
        */

        return redirect()->route('login');
    }


        /*
        submit login form
        query db
        return account matches email
        read account->account_role
        switch(account_role):
            case 'archer': redirect()->route('....');
        */

        public function login(Request $request) {
            // Validate the request
            $credentials = $request->validate([
                'account_email_address' => 'required|email',
                'account_password' => 'required',
            ]);
        
            // Find the account based on the email address
            $account = Account::where('account_email_address', $request->account_email_address)->first();
        
            // Check if the account exists
            if (!$account) {
                return back()->withErrors([
                    'account_email_address' => 'We could not find an account with that email. Please try again or <a href="' . route('register') . '">register an account</a>.',
                ])->withInput();
            }
        
            // Check if the password is correct
            if (!Hash::check($request->account_password, $account->account_password)) {
                return back()->withErrors([
                    'account_password' => 'The password you entered was incorrect. Please try again.',
                ])->withInput();
            }
        
            // Log in the user
            Auth::login($account);
            $request->session()->regenerate();

            // dd(Auth::user()->account_role);
        
            // Redirect based on the role
            switch (Auth::user()->account_role) {
                case '1': // Archer
                    // return redirect()->route('archer.dashboard');
                    return view('archer.dashboard');
                case '2': // Coach
                    // return redirect()->intended('coach.dashboard');
                    return view('coach.dashboard');
                case '3': // Committee Member
                    // return redirect()->route('committee.dashboard');
                    return view('committee.dashboard');
                default:
                    return redirect()->route('login'); // Fallback if no role matches
            }
        }
        
        // public function logout(Request $request) {
        //     Auth::guard('web')->logout();
        //     $request->session()->invalidate();
        //     $request->session()->regenerateToken();
        
        //     return redirect('/');
        // }
        public function logout(Request $request)
        {
            dd('logout called');
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login'); // or wherever you want to redirect after logout
        }

    }