<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
    
        // Set membership expiry to the exact current date
        $currentDate = Carbon::now()->startOfDay();
    
        // Create new account
        $account = Account::create([
            'account_full_name' => $request->account_full_name,
            'account_email_address' => $request->account_email_address,
            'account_password' => Hash::make($request->account_password),
            'account_role' => $request->account_role,
            'account_contact_number' => $request->account_contact_number,
            'account_membership_status' => '2', // default status, 1-active, 2-inactive
            'account_membership_expiry' => $currentDate, // Set expiry date to the current date
            'account_profile_picture_path' => $profilePicturePath, // Store the uploaded picture path or empty string
        ]);
    
        // Generate the zero-padded membership ID based on account_id
        $membership_id = str_pad($account->account_id, 6, '0', STR_PAD_LEFT);
    
        // Insert into membership table
        DB::table('membership')->insert([
            'membership_id' => $membership_id,
            'account_id' => $account->account_id,
            'membership_expiry' => $currentDate, // Set expiry date to the current date
            'membership_status' => 2, // 1-active, 2-inactive
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('account.login')->with('success', 'Registration successful! Please log in.');
    }

    // Add this method to AccountController to check and update all membership statuses
    public function updateAllMembershipStatuses()
    {
        $memberships = DB::table('membership')->get();

        foreach ($memberships as $membership) {
            $newStatus = Carbon::now()->greaterThan(Carbon::parse($membership->membership_expiry)) ? 2 : 1;

            // Update the database only if the status has changed
            if ($membership->membership_status != $newStatus) {
                DB::table('membership')
                    ->where('membership_id', $membership->membership_id)
                    ->update(['membership_status' => $newStatus, 'updated_at' => now()]);
            }
        }
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

        // Check and update all membership statuses if the user is a committee member
        if (Auth::user()->account_role == 3) { // 3 represents Committee Member
            $this->updateAllMembershipStatuses();
        }

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
        $user = Auth::user();

        // Retrieve membership details based on account_id
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        if ($membership) {
            // Check if the membership has expired
            if (Carbon::now()->greaterThan($membership->membership_expiry)) {
                // If expired, update the membership_status to 'Inactive' (2)
                DB::table('membership')->where('account_id', $user->account_id)->update(['membership_status' => 2]);
                $membership_status = 'Inactive';
            } else {
                // If not expired, ensure membership_status is 'Active' (1)
                DB::table('membership')->where('account_id', $user->account_id)->update(['membership_status' => 1]);
                $membership_status = 'Active';
            }
        } else {
            $membership_status = 'N/A';
        }

        // Set other membership information
        $membership_id = $membership ? $membership->membership_id : 'N/A';
        $membership_expiry = $membership ? $membership->membership_expiry : 'N/A';

        // Pass the user and membership data to the view
        return view('archer.profile', [
            'user' => $user,
            'membership_id' => $membership_id,
            'membership_status' => $membership_status,
            'membership_expiry' => $membership_expiry,
        ]);
    }

    // Display profile method for Coach
    public function coachProfile()
    {
        $user = Auth::user();
    
        // Retrieve membership details based on account_id
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();
    
        if ($membership) {
            // Check if the membership has expired
            if (Carbon::now()->greaterThan($membership->membership_expiry)) {
                // If expired, update the membership_status to 'Inactive' (2)
                DB::table('membership')->where('account_id', $user->account_id)->update(['membership_status' => 2]);
                $membership_status = 'Inactive';
            } else {
                // If not expired, ensure membership_status is 'Active' (1)
                DB::table('membership')->where('account_id', $user->account_id)->update(['membership_status' => 1]);
                $membership_status = 'Active';
            }
        } else {
            $membership_status = 'N/A';
        }
    
        // Set other membership information
        $membership_id = $membership ? $membership->membership_id : 'N/A';
        $membership_expiry = $membership ? $membership->membership_expiry : 'N/A';
    
        // Pass the user and membership data to the view
        return view('coach.profile', [
            'user' => $user,
            'membership_id' => $membership_id,
            'membership_status' => $membership_status,
            'membership_expiry' => $membership_expiry,
        ]);
    }

    // Display profile method for Committee
    public function committeeProfile()
    {
        $user = Auth::user();

        // Retrieve membership details based on account_id
        $membership = DB::table('membership')->where('account_id', $user->account_id)->first();

        if ($membership) {
            // Check if the membership has expired and update the status accordingly
            $membership_status = Carbon::now()->greaterThan(Carbon::parse($membership->membership_expiry)) ? 'Inactive' : 'Active';

            // Update the database only if there's a mismatch
            $database_status = $membership->membership_status == 1 ? 'Active' : 'Inactive';
            if ($membership_status != $database_status) {
                DB::table('membership')
                    ->where('account_id', $user->account_id)
                    ->update(['membership_status' => $membership_status == 'Active' ? 1 : 2]);
            }
        } else {
            $membership_status = 'N/A'; // Handle the case where no membership exists
        }

        // Set other membership information
        $membership_id = $membership ? $membership->membership_id : 'N/A';
        $membership_expiry = $membership ? $membership->membership_expiry : 'N/A';

        // Pass the user and membership data to the view
        return view('committee.profile', [
            'user' => $user,
            'membership_id' => $membership_id,
            'membership_status' => $membership_status,
            'membership_expiry' => $membership_expiry,
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
        // Join the 'account' table with 'membership', 'coach_archer', and 'account' (for coach details)
        $members = DB::table('account')
            ->leftJoin('membership', 'account.account_id', '=', 'membership.account_id') // Join membership table
            ->leftJoin('coach_archer', 'account.account_id', '=', 'coach_archer.archer_id') // Join coach_archer table to link archers with their coaches
            ->leftJoin('account as coach', 'coach_archer.coach_id', '=', 'coach.account_id') // Join 'account' again to get coach details
            ->select(
                'account.*', // Select archer's account details
                'membership.membership_id', // Select membership details
                'membership.membership_status',
                'membership.membership_expiry',
                'coach.account_full_name as coach_name' // Select coach's name
            )
            ->paginate(10); // Add pagination (10 records per page)

        // Pass members data to the view
        return view('committee.member', ['members' => $members]);
    }

    public function viewProfile($membership_id)
    {
        $member = DB::table('account')
                    ->join('membership', 'account.account_id', '=', 'membership.account_id')
                    ->select('account.*', 'membership.membership_id', 'membership.membership_status', 'membership.membership_expiry')
                    ->where('membership.membership_id', $membership_id)
                    ->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Member not found');
        }

        return view('committee.viewProfile', ['member' => $member]);
    }

    public function deleteProfile($id)
    {
        $member = Account::findOrFail($id);
        $member->delete();
        return redirect()->route('committee.member')->with('success', 'Member deleted successfully');
    }

    public function viewArcherProfile($membership_id)
    {
        // Fetch archer details based on membership_id
        $member = DB::table('account')
                    ->join('membership', 'account.account_id', '=', 'membership.account_id')
                    ->where('membership.membership_id', $membership_id)
                    ->select('account.*', 'membership.membership_id', 'membership.membership_status', 'membership.membership_expiry')
                    ->first();

        if (!$member) {
            return redirect()->route('coach.myArcher')->with('popupMessage', 'Archer not found.');
        }

        // Pass archer data to the view
        return view('coach.viewProfile', compact('member'));
    }

    public function dashboard()
    {
        // Fetch the count of archers, coaches, and committee members from the 'account' table
        $archerCount = Account::where('account_role', 1)->count(); // 1 corresponds to 'Archer'
        $coachCount = Account::where('account_role', 2)->count();  // 2 corresponds to 'Coach'
        $committeeCount = Account::where('account_role', 3)->count();  // 3 corresponds to 'Committee Member'
        
        // Retrieve upcoming events
        $upcomingEvents = DB::table('events')->whereDate('event_date', '>=', now())->get();
        
        // Fetch announcements
        $announcements = Announcement::all(); // Make sure you have the Announcement model

        // Pass all these variables to the view
        return view('committee.dashboard', compact('archerCount', 'coachCount', 'committeeCount', 'upcomingEvents', 'announcements'));
    }
}
