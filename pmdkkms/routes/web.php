<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Middleware\PreventAuthenticatedAccess;
use App\Http\Middleware\RoleAccessMiddleware;

// Apply middleware for preventing access to certain pages if already authenticated
Route::middleware([PreventAuthenticatedAccess::class])->group(function () {
    Route::get('/login', function() {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function() {
        return view('auth.register');
    })->name('register');
});

// Public routes (no authentication required)
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/member', function () {
    return view('member');
})->name('member');

// Register and login routes (form submissions)
Route::post('/register', [AccountController::class, 'register'])->name('account.register');
Route::post('/login', [AccountController::class, 'login'])->name('account.login');
Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');

// Forgot password form and action
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::post('/forgot-password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

// Protected routes: accessible only after authentication
// Route::middleware('auth')->group(function () {
//     // Archer dashboard
//     Route::get('/archer/dashboard', function () {
//         return view('archer.dashboard');
//     })->name('archer.dashboard');

//     // Coach dashboard
//     Route::get('/coach/dashboard', function () {
//         return view('coach.dashboard');
//     })->name('coach.dashboard');

//     // Committee member dashboard
//     Route::get('/committee/dashboard', function () {
//         return view('committee.dashboard');
//     })->name('committee.dashboard');
// });

//Routes accessible to archer (account_role=1)
// Route::middleware(['auth', RoleAccessMiddleware::class.':1'])->group(function () {
    Route::get('/archer/dashboard', function () {
        return view('archer.dashboard');
    })->name('archer.dashboard');
// });

// // Routes accessible to coach (account_role=2)
// Route::middleware(['auth', RoleAccessMiddleware::class.':2'])->group(function () {
    Route::get('/coach/dashboard', function () {
        return view('coach.dashboard');
    })->name('coach.dashboard');
// });

// Routes accessible to committee member (account_role=3)
// Route::middleware(['auth', RoleAccessMiddleware::class.':3'])->group(function () {
    Route::get('/committee/dashboard', function () {
        return view('committee.dashboard');
    })->name('committee.dashboard');
// });

;