<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Middleware\PreventAuthenticatedAccess;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CoachArcherController;
use App\Http\Controllers\ScoringController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AnalyticsController;

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

    // Route for showing the success message after attendance is recorded
    Route::get('/attendance/success', function () {
        return view('attendance.success');
    })->name('attendance.success');

    Route::get('/attendance/scan', [AttendanceController::class, 'recordAttendanceFromQr'])
    ->name('attendance.scan')
    ->withoutMiddleware(['auth']); // Allow access without logins
});

// Routes for all levels of auth'd user
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');

    Route::get('/payment/return', [PaymentController::class, 'paymentReturn'])->name('payment.return');
    Route::post('/payment/notify', [PaymentController::class, 'paymentNotify'])->name('payment.notify');
});

// Routes accessible to archer only
Route::middleware(['auth', RoleAccessMiddleware::class . ':1'])->group(function () {

    // Archer Dashboard
    Route::get('/archer/dashboard', [EventController::class, 'showArcherDashboard'])->name('archer.dashboard');

    // Archer Profile
    Route::get('/archer/profile', [AccountController::class, 'profile'])->name('archer.profile');
    Route::get('/archer/editProfile', [AccountController::class, 'editProfile'])->name('archer.editProfile');
    Route::post('/archer/updateProfile', [AccountController::class, 'updateProfile'])->name('archer.updateProfile');
    Route::post('/archer/changePassword', [PasswordResetController::class, 'changePassword'])->name('archer.changePassword');
    Route::put('/archer/updateProfilePicture', [AccountController::class, 'updateProfilePicture'])->name('archer.updateProfilePicture');

    // Archer Attendance
    Route::get('/archer/attendance', [AttendanceController::class, 'showAttendanceForm'])->name('archer.attendance');
    Route::post('/archer/attendance', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');
    Route::get('/archer/attendance/view', [AttendanceController::class, 'viewAttendance'])->name('attendance.view');
    Route::get('/archer/attendance/{membership_id}/more', [AttendanceController::class, 'viewMoreAttendanceArcher'])->name('archer.attendanceMore');

    // Events
    Route::get('/archer/events', [EventController::class, 'viewEvents'])->name('archer.events');

    // Scoring Routes
    Route::get('/archer/scoring', [ScoringController::class, 'scoring'])->name('archer.scoring');
    Route::post('/archer/scoring', [ScoringController::class, 'storeScore'])->name('scoring.store');  // Updated route name here
    Route::get('/archer/scoring-history', [ScoringController::class, 'showScoringHistoryArcher'])->name('archer.scoringHistory');
    Route::get('/archer/scoring-details/{id}', [ScoringController::class, 'showScoreDetails'])->name('scoring.details');
    Route::put('/archer/scoring/{id}', [ScoringController::class, 'updateScore'])->name('scoring.update');
    Route::delete('/archer/scoring/{id}', [ScoringController::class, 'deleteScore'])->name('scoring.delete');

    // Interactive Scoring
    Route::get('/archer/scoringInteractive', function () {
        return view('archer.scoringInteractive');
    })->name('archer.scoringInteractive');

    // Performance Analytics
    Route::get('/archer/performance-analytics', [AnalyticsController::class, 'showArcherAnalytics'])->name('archer.analytics');


    //Routes for payments
    Route::get('/archer/paymentForm', function () {
        return app(PaymentController::class)->paymentForm('archer');
    })->name('archer.paymentForm');
    Route::post('/archer/initiatePayment', function (Request $request) {
        return app(PaymentController::class)->initiatePayment($request, 'archer');
    })->name('archer.initiatePayment');
    Route::get('/archer/payment-return', [PaymentController::class, 'archerPaymentReturn'])->name('archer.payment.return');
    Route::post('/archer/payment-notify', [PaymentController::class, 'archerPaymentNotify'])->name('archer.payment.notify');
    // Route to access the payment history page
    Route::get('/archer/paymentHistory', [PaymentController::class, 'paymentHistoryArcher'])->name('archer.paymentHistory');

});

// Routes accessible to coach only
Route::middleware(['auth', RoleAccessMiddleware::class . ':2'])->group(function () {

    // Coach Dashboard
    Route::get('/coach/dashboard', [CoachArcherController::class, 'showCoachDashboard'])->name('coach.dashboard');

    // Coach Profile
    Route::get('/coach/profile', [AccountController::class, 'coachProfile'])->name('coach.profile');
    Route::get('/coach/editProfile', [AccountController::class, 'coachEditProfile'])->name('coach.editProfile');
    Route::post('/coach/updateProfile', [AccountController::class, 'updateCoachProfile'])->name('coach.updateProfile');
    Route::post('/coach/changePassword', [PasswordResetController::class, 'changeCoachPassword'])->name('coach.changePassword');
    Route::put('/coach/updateProfilePicture', [AccountController::class, 'updateCoachProfilePicture'])->name('coach.updateProfilePicture');

    // Events for Coach
    Route::get('/coach/events', [EventController::class, 'viewEvents'])->name('coach.events');

    // Coach-Archer Relationship Routes
    Route::get('/coach/myArcher', [CoachArcherController::class, 'showMyArchers'])->name('coach.myArcher');
    Route::post('/coach/enroll-archer/{archer}', [CoachArcherController::class, 'enrollArcher'])->name('coach.enrollArcher');
    Route::post('/coach/unenroll-archer/{archer}', [CoachArcherController::class, 'unenrollArcher'])->name('coach.unenrollArcher');
    Route::get('/coach/archer/profile/{membership_id}', [CoachArcherController::class, 'viewCoachArcherProfile'])->name('coach.viewProfile');

    // Attendance Routes for Coach
    Route::get('/coach/attendance/{membership_id}', [AttendanceController::class, 'viewCoachArcherAttendance'])->name('coach.attendanceView');
    Route::post('/coach/attendance/{membership_id}/update', [AttendanceController::class, 'updateCoachArcherAttendance'])->name('coach.updateAttendance');
    Route::get('/coach/attendance-list', [AttendanceController::class, 'viewAllAttendanceForCoach'])->name('coach.attendanceList');
    Route::get('/coach/attendance/{membership_id}/more', [AttendanceController::class, 'viewMoreAttendanceCoach'])->name('coach.attendanceMore');

    // QR Code Routes
    Route::get('/coach/qr/{membership_id}', [AttendanceController::class, 'generateArcherQrCode'])->name('coach.archerQrCode');
    Route::post('/attendance/record', [AttendanceController::class, 'recordAttendance'])->name('attendance.record');

    // Scoring Routes for Coach
    Route::get('/coach/scoring-list', [ScoringController::class, 'showAllEnrolledArcherScoringHistory'])->name('coach.scoringList');
    Route::get('/coach/scoring-history/{membership_id}', [ScoringController::class, 'showCoachArcherScoringHistory'])->name('coach.scoringHistoryArcher');
    Route::get('/coach/scoring-details/{id}/{referrer?}', [ScoringController::class, 'showCoachArcherScoringDetails'])->name('coach.scoringDetails');

    // Coach Performance Analytics
    Route::get('/coach/analytics/{archerId}', [AnalyticsController::class, 'viewArcherAnalytics'])->name('coach.analytics');

    //Routes for payments
    Route::get('/coach/paymentForm', function () {
        return app(PaymentController::class)->paymentForm('coach');
    })->name('coach.paymentForm');
    // Coach payment initiation
    Route::post('/coach/initiatePayment', function (Request $request) {
        return app(PaymentController::class)->initiatePayment($request, 'coach');
    })->name('coach.initiatePayment');
    Route::get('/coach/payment-return', [PaymentController::class, 'coachPaymentReturn'])->name('coach.payment.return');
    Route::post('/coach/payment-notify', [PaymentController::class, 'coachPaymentNotify'])->name('coach.payment.notify');
    // Route to access the payment history page
    Route::get('/coach/paymentHistory', [PaymentController::class, 'paymentHistoryCoach'])->name('coach.paymentHistory');
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
    Route::match(['get', 'post'], '/committee/editMemberProfile/{membership_id}', [AccountController::class, 'committeeEditMemberProfile'])->name('committee.editMemberProfile');

    //Route for Attendance
    Route::get('/committee/attendanceList', [AttendanceController::class, 'viewAllAttendance'])->name('committee.attendanceList'); // Updated route
    Route::get('/committee/attendance/{membership_id}', [AttendanceController::class, 'viewArcherAttendance'])->name('committee.attendanceView');
    Route::post('/committee/attendance/update/{membership_id}', [AttendanceController::class, 'updateCommitteeArcherAttendance'])->name('committee.updateCommitteeArcherAttendance');
    Route::get('/committee/attendance/{membership_id}/more', [AttendanceController::class, 'viewMoreAttendanceCommittee'])->name('committee.attendanceMore');

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
    Route::put('/committee/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update'); // Update existing announcement (Edit announcement)
    Route::delete('/committee/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy'); // Delete announcement

    //Route for Analytics
    Route::get('/committee/analyticsList', [AccountController::class, 'viewAnalyticsList'])->name('committee.analyticsList');
    Route::get('/committee/analytics/{archerId}', [AnalyticsController::class, 'viewArcherAnalytics'])->name('committee.analytics');
    
    //Routes for payments
    Route::get('/committee/paymentForm', function () {
        return app(PaymentController::class)->paymentForm('committee');
    })->name('committee.paymentForm');

    Route::post('/committee/initiatePayment', [PaymentController::class, 'initiatePayment'])->name('committee.initiatePayment');
    Route::get('/committee/payment-return', [PaymentController::class, 'committeePaymentReturn'])->name('committee.payment.return');
    Route::post('/committee/payment-notify', [PaymentController::class, 'committeePaymentNotify'])->name('committee.payment.notify');

    // Route to access the payment history page
    Route::get('/committee/paymentHistory', [PaymentController::class, 'paymentHistoryCommittee'])->name('committee.paymentHistory');

});
