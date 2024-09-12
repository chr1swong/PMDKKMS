<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Middleware\PreventAuthenticatedAccess;
use App\Http\Middleware\RoleAccessMiddleware;

// Public routes (no authentication required)
// Apply middleware for preventing access to certain pages if already authenticated
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

    //Archer Profile
    Route::get('/archer/profile', function () {
        return view('archer.profile');
    })->name('archer.profile');

    Route::get('/archer/editProfile', function () {
        return view('archer.editProfile');
    })->name('archer.editProfile');
});
    
// Routes accessible to coach only
Route::middleware(['auth', RoleAccessMiddleware::class.':2'])->group(function () {
    Route::get('/coach/dashboard', function () {
        return view('coach.dashboard');
    })->name('coach.dashboard');
});

// Routes accessible to committee member only
Route::middleware(['auth', RoleAccessMiddleware::class.':3'])->group(function () {
    Route::get('/committee/dashboard', function () {
        return view('committee.dashboard');
    })->name('committee.dashboard');
});