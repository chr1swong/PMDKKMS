<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Middleware\PreventAuthenticatedAccess;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CoachArcherController;
use App\Http\Controllers\ScoringController;
use App\Http\Controllers\AnnouncementController;

// Public routes (no authentication required)
Route::middleware([PreventAuthenticatedAccess::class])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // Route to display the home page with events
    Route::get('/', [EventController::class, 'showHomePage'])->name('home');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
    
    Route::get('/member', function () {
        return view('member');
    })->name('member');

    Route::get('/login', function() {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AccountController::class, 'login'])->name('account.login');

    Route::get('/register', function() {
        return view('auth.register');
    })->name('register');

    // Register and login routes (form submissions)
    Route::post('/register', [AccountController::class, 'register'])->name('account.register');

    // Forgot password form and action
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('forgot-password');

    // Send the password reset link to the user's email address
    Route::post('/forgot-password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

    // Show the reset password form (user clicks the link in their email)
    Route::get('/forgot-password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

    // Handle the reset password form submission (user submits their new password)
    Route::post('/forgot-password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Routes for all levels of auth'd user
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
});

// Routes accessible to archer only
Route::middleware(['auth', RoleAccessMiddleware::class.':1'])->group(function () {
    Route::get('/archer/dashboard', function () {
        return view('archer.dashboard');
    })->name('archer.dashboard');

    // Archer Profile
    Route::get('/archer/profile', [AccountController::class, 'profile'])->name('archer.profile');

    // Route for archer attendance
    Route::get('/archer/attendance', [AttendanceController::class, 'showAttendanceForm'])->name('archer.attendance');
    Route::post('/archer/attendance', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');
    Route::get('/archer/attendance/view', [AttendanceController::class, 'viewAttendance'])->name('attendance.view');

    // Route for viewing the edit profile form (GET)
    Route::get('/archer/editProfile', [AccountController::class, 'editProfile'])->name('archer.editProfile');

    // Route for handling profile update (POST)
    Route::post('/archer/updateProfile', [AccountController::class, 'updateProfile'])->name('archer.updateProfile');

    // Route for handling changing password
    Route::post('/archer/changePassword', [PasswordResetController::class, 'changePassword'])->name('archer.changePassword'); // Changed route name here

    // Route for updating profile picture
    Route::put('/archer/updateProfilePicture', [AccountController::class, 'updateProfilePicture'])->name('archer.updateProfilePicture');

    //Route for viewing events
    Route::get('/archer/events', [EventController::class, 'viewEvents'])->name('archer.events');

    //Route for viewing events in dashboard
    Route::get('/archer/dashboard', [EventController::class, 'showArcherDashboard'])->name('archer.dashboard');

    // Route to display the scoring form (GET request)
    Route::get('/archer/scoring', [ScoringController::class, 'scoring'])->name('archer.scoring');

    // Route to store the score (POST request)
    Route::post('/archer/scoring', [ScoringController::class, 'storeScore'])->name('archer.storeScore');

    // Route for showing the scoring history page
    Route::get('/archer/scoring-history', [ScoringController::class, 'showScoringHistoryArcher'])->name('archer.scoringHistory');

    // Route for showing scoring details
    Route::get('/archer/scoring-details/{id}', [ScoringController::class, 'showScoreDetails'])->name('scoring.details');

    // Route for updating score
    Route::put('/archer/scoring/{id}', [ScoringController::class, 'updateScore'])->name('scoring.update');

    // Route for score deletion
    Route::delete('/archer/scoring/{id}', [ScoringController::class, 'deleteScore'])->name('scoring.delete');
});

// Routes accessible to coach only
Route::middleware(['auth', RoleAccessMiddleware::class.':2'])->group(function () {
    Route::get('/coach/dashboard', function () {
        return view('coach.dashboard');
    })->name('coach.dashboard');

    // Coach Profile
    Route::get('/coach/profile', [AccountController::class, 'coachProfile'])->name('coach.profile');

    // Route for viewing the edit profile form (GET)
    Route::get('/coach/editProfile', [AccountController::class, 'coachEditProfile'])->name('coach.editProfile'); 

    // Route for handling profile update (POST)
    Route::post('/coach/updateProfile', [AccountController::class, 'updateCoachProfile'])->name('coach.updateProfile');

    // Route for handling password change
    Route::post('/coach/changePassword', [PasswordResetController::class, 'changeCoachPassword'])->name('coach.changePassword');

    // Route for updating profile picture
    Route::put('/coach/updateProfilePicture', [AccountController::class, 'updateCoachProfilePicture'])->name('coach.updateProfilePicture');

    // Route for viewing events
    Route::get('/coach/events', [EventController::class, 'viewEvents'])->name('coach.events');

    //Route for viewing events in dashboard
    Route::get('/coach/dashboard', [EventController::class, 'showCoachDashboard'])->name('coach.dashboard');

    // Routes to CoachArcherController
    Route::get('/coach/myArcher', [CoachArcherController::class, 'showMyArchers'])->name('coach.myArcher');
    Route::post('/coach/enroll-archer/{archer}', [CoachArcherController::class, 'enrollArcher'])->name('coach.enrollArcher');
    Route::post('/coach/unenroll-archer/{archer}', [CoachArcherController::class, 'unenrollArcher'])->name('coach.unenrollArcher');

    Route::get('/coach/archer/profile/{membership_id}', [CoachArcherController::class, 'viewCoachArcherProfile'])->name('coach.viewProfile');

    // Route for coach to view a specific archer's attendance
    Route::get('/coach/attendance/{membership_id}', [AttendanceController::class, 'viewCoachArcherAttendance'])->name('coach.attendanceView');

    // Route for coach to update the archer's attendance
    Route::post('/coach/attendance/{membership_id}/update', [AttendanceController::class, 'updateCoachArcherAttendance'])->name('coach.updateAttendance');

    // Route for coach's scoring history view of a specific archer
    Route::get('/coach/scoring-history/{membership_id}', [ScoringController::class, 'showCoachArcherScoringHistory'])->name('coach.scoringHistoryArcher');

    // Route for coach to view scoring details of a specific archer
    Route::get('/coach/scoring-details/{id}', [ScoringController::class, 'showCoachArcherScoringDetails'])->name('coach.scoringDetails');

    // Route for viewing coach dashboard
    Route::get('/coach/dashboard', [CoachArcherController::class, 'showCoachDashboard'])->name('coach.dashboard');
});

// Routes accessible to committee member only
Route::middleware(['auth', RoleAccessMiddleware::class.':3'])->group(function () {
    Route::get('/committee/dashboard', function () {
        return view('committee.dashboard');
    })->name('committee.dashboard');

    //Route for Events
    Route::get('/committee/events', [EventController::class, 'index'])->name('events.index');  // Event listing
    Route::post('/committee/events', [EventController::class, 'store'])->name('events.store'); // Event creation
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy'); // Event deletion
    Route::post('/events/{id}/update-date', [EventController::class, 'updateDate'])->name('events.update-date'); // Update event date when dragged
    Route::post('/events/{id}/update-duration', [EventController::class, 'updateDuration'])->name('events.update-duration'); // Update event duration when resized
    Route::post('/events/{id}/update', [EventController::class, 'update'])->name('events.update'); // Update event details
    Route::get('/committee/dashboard', [EventController::class, 'showDashboard'])->name('committee.dashboard');
    Route::get('/committee/dashboard', [AccountController::class, 'dashboard'])->name('committee.dashboard');


    //Route for Member Management
    Route::get('/committee/member', [AccountController::class, 'manageMember'])->name('committee.member');
    Route::get('/committee/member/profile/{membership_id}', [AccountController::class, 'viewProfile'])->name('view.profile');
    Route::delete('/committee/member/{id}', [AccountController::class, 'deleteProfile'])->name('delete.profile');

    //Route for Attendance
    Route::get('/committee/attendanceList', [AttendanceController::class, 'viewAllAttendance'])->name('committee.attendanceList'); // Updated route
    // Route for committee to view a specific archer's attendance
    Route::get('/committee/attendance/{membership_id}', [AttendanceController::class, 'viewArcherAttendance'])->name('committee.attendanceView');

    // Committee Profile
    Route::get('/committee/profile', [AccountController::class, 'committeeProfile'])->name('committee.profile');

    // Route for viewing the edit profile form (GET)
    Route::get('/committee/editProfile', [AccountController::class, 'committeeEditProfile'])->name('committee.editProfile'); // Ensure this is present

    // Route for handling profile update (POST)
    Route::post('/committee/updateProfile', [AccountController::class, 'updateCommitteeProfile'])->name('committee.updateProfile');

    // Route for handling changing password
    Route::post('/committee/changePassword', [PasswordResetController::class, 'changePassword'])->name('committee.changePassword');

    // Route for updating profile picture
    Route::put('/committee/updateProfilePicture', [AccountController::class, 'updateCommitteeProfilePicture'])->name('committee.updateProfilePicture');

    // Route for committee to view scoring history of all archers
    Route::get('/committee/scoringHistory', [ScoringController::class, 'showCommitteeScoringHistory'])->name('committee.scoringHistory');

    // Route for committee to view specific scoring details
    Route::get('/committee/scoring-details/{id}', [ScoringController::class, 'showCommitteeScoringDetails'])->name('committee.scoringDetails');

    // Routes for Announcements
    Route::get('/committee/announcements', [AnnouncementController::class, 'index'])->name('committee.announcements'); // View announcements
    Route::post('/committee/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');    // Create new announcement
    Route::delete('/committee/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy'); // Delete announcement
});
