<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Middleware\PreventAuthenticatedAccess;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Controllers\EventController;

// Public routes (no authentication required)
Route::middleware([PreventAuthenticatedAccess::class])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

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
});

// Routes accessible to coach only
Route::middleware(['auth', RoleAccessMiddleware::class.':2'])->group(function () {
    Route::get('/coach/dashboard', function () {
        return view('coach.dashboard');
    })->name('coach.dashboard');

    // Coach Profile
    Route::get('/coach/profile', [AccountController::class, 'coachProfile'])->name('coach.profile');

    // Route for viewing the edit profile form (GET)
    Route::get('/coach/editProfile', [AccountController::class, 'coachEditProfile'])->name('coach.editProfile'); // Ensure this is present

    // Route for handling profile update (POST)
    Route::post('/coach/updateProfile', [AccountController::class, 'updateCoachProfile'])->name('coach.updateProfile');

    // Route for handling changing password
    Route::post('/coach/changePassword', [PasswordResetController::class, 'changePassword'])->name('coach.changePassword');

    // Route for updating profile picture
    Route::put('/coach/updateProfilePicture', [AccountController::class, 'updateCoachProfilePicture'])->name('coach.updateProfilePicture');

    // Route for viewing events
    Route::get('/coach/events', [EventController::class, 'viewEvents'])->name('coach.events');
});

// Routes accessible to committee member only
Route::middleware(['auth', RoleAccessMiddleware::class.':3'])->group(function () {
    Route::get('/committee/dashboard', function () {
        return view('committee.dashboard');
    })->name('committee.dashboard');

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

    //Route for Events
    Route::get('/committee/events', [EventController::class, 'index'])->name('events.index');  // Event listing
    Route::post('/committee/events', [EventController::class, 'store'])->name('events.store'); // Event creation
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy'); // Event deletion
    Route::post('/events/{id}/update-date', [EventController::class, 'updateDate'])->name('events.update-date'); // Update event date when dragged
    Route::post('/events/{id}/update-duration', [EventController::class, 'updateDuration'])->name('events.update-duration'); // Update event duration when resized
    Route::post('/events/{id}/update', [EventController::class, 'update'])->name('events.update'); // Update event details
});


