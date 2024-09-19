<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    // Registration method
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

        // Handle profile picture upload if present
        $profilePicturePath = '';
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create new account
        $account = Account::create([
            'account_full_name' => $request->account_full_name,
            'account_email_address' => $request->account_email_address,
            'account_password' => Hash::make($request->account_password),
            'account_role' => $request->account_role,
            'account_contact_number' => $request->account_contact_number,
            'account_membership_status' => '2', // default status
            'account_membership_expiry' => now()->addYear(), // example expiration date
            'account_profile_picture_path' => $profilePicturePath, // Store the uploaded picture path or empty string
        ]);

        // Generate the zero-padded membership ID based on account_id
        $membership_id = str_pad($account->account_id, 6, '0', STR_PAD_LEFT);

        // Insert into membership table
        DB::table('membership')->insert([
            'membership_id' => $membership_id,
            'account_id' => $account->account_id,
            'membership_expiry' => now()->addYear(),
            'membership_status' => 1, // 1-active, 2-inactive
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('account.login')->with('success', 'Registration successful! Please log in.');
    }

    // Login method
    public function login(Request $request) {
        // Validate login request
        $request->validate([
            'account_email_address' => 'required|email',
            'account_password' => 'required',
        ]);

        // Find account by email
        $account = Account::where('account_email_address', $request->account_email_address)->first();

        // Handle invalid email
        if (!$account) {
            return back()->withErrors([
                'account_email_address' => 'We could not find an account with that email. Please try again or <a href="' . route('register') . '">register an account</a>.',
            ])->withInput();
        }

        // Handle invalid password
        if (!Hash::check($request->account_password, $account->account_password)) {
            return back()->withErrors([
                'account_password' => 'The password you entered was incorrect. Please try again.',
            ])->withInput();
        }

        // Log in the user
        Auth::login($account);
        Log::info('User after login: ', [Auth::user()]);
        Log::info('SESSION ID BEFORE REGENERATION ----> ' . $request->session()->getId());
        $request->session()->regenerate();
        Log::info('SESSION ID AFTER REGENERATION ----> ' . $request->session()->getId());

        // Redirect based on user role
        switch (Auth::user()->account_role) {
            case 1: // Archer
                return redirect()->route('archer.dashboard');
            case 2: // Coach
                return redirect()->route('coach.dashboard');
            case 3: // Committee Member
                return redirect()->route('committee.dashboard');
            default:
                return redirect()->route('account.login');
        }
    }

    // Logout method
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Log::info('SESSION ID AFTER FLUSH ----> ' . $request->session()->getId());

        return redirect('/login'); // Redirect to login after logout
    }

    // Display profile method for Archer
    public function profile()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Retrieve membership details based on account_id, if it exists
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();
        
        // Check if the membership exists
        $membership_id = $membership ? $membership->membership_id : 'N/A'; // If membership is null, fallback to 'N/A'
        $membership_status = $membership ? $membership->membership_status : 'N/A'; // Retrieve membership status
        $membership_expiry = $membership ? $membership->membership_expiry : 'N/A'; // Retrieve membership expiry

        // Pass the user and membership data to the view
        return view('archer.profile', [
            'user' => $user,
            'membership_id' => $membership_id,
            'membership_status' => $membership_status, // Pass membership_status
            'membership_expiry' => $membership_expiry, // Pass membership_expiry
        ]);
    }

    // Display profile method for Coach
    public function coachProfile()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Retrieve membership details based on account_id, if it exists
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();
    
        // Check if the membership exists
        $membership_id = $membership ? $membership->membership_id : 'N/A'; // If membership is null, fallback to 'N/A'
        $membership_status = $membership ? $membership->membership_status : 'N/A'; // Retrieve membership status
        $membership_expiry = $membership ? $membership->membership_expiry : 'N/A'; // Retrieve membership expiry

        // Pass the user and membership data to the view
        return view('coach.profile', [
            'user' => $user,
            'membership_id' => $membership_id,
            'membership_status' => $membership_status, // Pass membership_status
            'membership_expiry' => $membership_expiry, // Pass membership_expiry
        ]);
    }

    // Display profile method for Committee
    public function committeeProfile()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Retrieve membership details based on account_id, if it exists
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        // Check if the membership exists
        $membership_id = $membership ? $membership->membership_id : 'N/A'; // If membership is null, fallback to 'N/A'
        $membership_status = $membership ? $membership->membership_status : 'N/A'; // Retrieve membership status
        $membership_expiry = $membership ? $membership->membership_expiry : 'N/A'; // Retrieve membership expiry

        // Pass the user and membership data to the view
        return view('committee.profile', [
            'user' => $user,
            'membership_id' => $membership_id,
            'membership_status' => $membership_status, // Pass membership_status
            'membership_expiry' => $membership_expiry, // Pass membership_expiry
        ]);
    }

    // Edit profile method for Archer
    public function editProfile()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Retrieve membership details based on account_id
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();
    
        // Check if the membership exists
        $membership_id = $membership ? $membership->membership_id : 'N/A'; // Fallback to 'N/A' if null

        return view('archer.editProfile', ['user' => $user, 'membership_id' => $membership_id]);
    }

    // Edit profile method for Coach
    public function coachEditProfile()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Retrieve membership details based on account_id
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();
    
        // Check if the membership exists
        $membership_id = $membership ? $membership->membership_id : 'N/A'; // Fallback to 'N/A' if null

        return view('coach.editProfile', ['user' => $user, 'membership_id' => $membership_id]);
    }

    // Edit profile method for Committee
    public function committeeEditProfile()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Retrieve membership details based on account_id
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();
    
        // Check if the membership exists
        $membership_id = $membership ? $membership->membership_id : 'N/A'; // Fallback to 'N/A' if null

        return view('committee.editProfile', ['user' => $user, 'membership_id' => $membership_id]);
    }

    // Update profile method for Archer
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Validate profile update data
        $request->validate([
            'account_full_name' => 'required|string|max:255',
            'account_email_address' => 'required|string|email|max:255|unique:account,account_email_address,' . $user->account_id . ',account_id', // Exclude current user
            'account_contact_number' => 'required|string|max:15',
        ]);

        // Update user profile
        $user->update([
            'account_full_name' => $request->account_full_name,
            'account_email_address' => $request->account_email_address,
            'account_contact_number' => $request->account_contact_number,
        ]);

        return redirect()->route('archer.profile')->with('success', 'Profile updated successfully.');
    }

    // Update profile method for Coach
    public function updateCoachProfile(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Validate profile update data
        $request->validate([
            'account_full_name' => 'required|string|max:255',
            'account_email_address' => 'required|string|email|max:255|unique:account,account_email_address,' . $user->account_id . ',account_id', // Exclude current user
            'account_contact_number' => 'required|string|max:15',
        ]);

        // Update user profile
        $user->update([
            'account_full_name' => $request->account_full_name,
            'account_email_address' => $request->account_email_address,
            'account_contact_number' => $request->account_contact_number,
        ]);

        return redirect()->route('coach.profile')->with('success', 'Profile updated successfully.');
    }

    // Update profile method for Committee
    public function updateCommitteeProfile(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Validate profile update data
        $request->validate([
            'account_full_name' => 'required|string|max:255',
            'account_email_address' => 'required|string|email|max:255|unique:account,account_email_address,' . $user->account_id . ',account_id', // Exclude current user
            'account_contact_number' => 'required|string|max:15',
        ]);

        // Update user profile
        $user->update([
            'account_full_name' => $request->account_full_name,
            'account_email_address' => $request->account_email_address,
            'account_contact_number' => $request->account_contact_number,
        ]);

        return redirect()->route('committee.profile')->with('success', 'Profile updated successfully.');
    }

    // Update profile picture method for Archer
    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();

        // Validate the uploaded profile picture
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB limit
        ]);

        if ($request->hasFile('profile_picture')) {
            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Delete old profile picture if it exists
            if ($user->account_profile_picture_path) {
                Storage::disk('public')->delete($user->account_profile_picture_path);
            }

            // Update user's profile picture path
            $user->update(['account_profile_picture_path' => $path]);
        }

        return back()->with('success', 'Profile picture updated successfully.');
    }

    // Update profile picture method for Coach
    public function updateCoachProfilePicture(Request $request)
    {
        $user = Auth::user();

        // Validate the uploaded profile picture
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB limit
        ]);

        if ($request->hasFile('profile_picture')) {
            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Delete old profile picture if it exists
            if ($user->account_profile_picture_path) {
                Storage::disk('public')->delete($user->account_profile_picture_path);
            }

            // Update user's profile picture path
            $user->update(['account_profile_picture_path' => $path]);
        }

        return back()->with('success', 'Profile picture updated successfully.');
    }

    // Update profile picture method for Committee
    public function updateCommitteeProfilePicture(Request $request)
    {
        $user = Auth::user();

        // Validate the uploaded profile picture
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB limit
        ]);

        if ($request->hasFile('profile_picture')) {
            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Delete old profile picture if it exists
            if ($user->account_profile_picture_path) {
                Storage::disk('public')->delete($user->account_profile_picture_path);
            }

            // Update user's profile picture path
            $user->update(['account_profile_picture_path' => $path]);
        }

        return back()->with('success', 'Profile picture updated successfully.');
    }

    public function manageMember()
    {
        $members = DB::table('account') // Join the 'account' and 'membership' tables
                    ->join('membership', 'account.account_id', '=', 'membership.account_id')
                    ->select('account.*', 'membership.membership_id', 'membership.membership_status') // Fetch 'membership_status'
                    ->get();

        return view('committee.member', ['members' => $members]);
    }

    // Update and delete member profile
    public function viewProfile($id)
    {
        $member = Account::findOrFail($id);
        return view('committee.viewProfile', compact('member'));
    }

    public function deleteProfile($id)
    {
        $member = Account::findOrFail($id);
        $member->delete();
        return redirect()->route('committee.member')->with('success', 'Member deleted successfully');
    }
}
