<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\Password\ForgetPasswordController as AdminForgetPasswordController;
use App\Http\Controllers\Admin\Auth\Password\OtpVerificationController as AdminOtpVerificationController;
use App\Http\Controllers\Admin\Auth\Password\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\CompetitionController as AdminCompetitionController;
use App\Http\Controllers\Admin\CompetitionGroupController as AdminCompetitionGroupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Viewer\AccountController;
use App\Http\Controllers\Viewer\Auth\EmailVerificationController;
use App\Http\Controllers\Viewer\Auth\LoginController;
use App\Http\Controllers\Viewer\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\Viewer\Auth\Password\OtpVerificationController;
use App\Http\Controllers\Viewer\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Viewer\Auth\RegisterController;
use App\Http\Controllers\Viewer\CompetitionController as ViewerCompetitionController;
use App\Http\Controllers\Viewer\HomeController;
use App\Http\Controllers\Viewer\MatchController;
use App\Http\Controllers\Viewer\PublicTeamRegistrationController;
use App\Http\Controllers\Viewer\TeamController;
use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Pages
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Email Verification OTP Routes
Route::get('/email/verify-otp', [EmailVerificationController::class, 'show'])->name('verification.notice');
Route::post('/email/verify-otp', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend-otp', [EmailVerificationController::class, 'resend'])->name('verification.resend');

// Password Reset & OTP Routes
Route::get('/forgot-password', [ForgetPasswordController::class, 'showForgetPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgetPasswordController::class, 'sendOtp'])->name('password.email');

Route::get('/verify-otp', [OtpVerificationController::class, 'showOtpForm'])->name('password.otp.show');
Route::post('/verify-otp', [OtpVerificationController::class, 'verifyOtp'])->name('password.otp.verify');
Route::post('/resend-otp', [OtpVerificationController::class, 'resendOtp'])->name('password.otp.resend');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

// Account Page (Protected by auth middleware)
Route::middleware('auth:web')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
});

// Public Pages
Route::get('/competitions', [ViewerCompetitionController::class, 'index'])->name('competitions.index');
Route::get('/competitions/{id}', [ViewerCompetitionController::class, 'show'])->name('competitions.show');

Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
Route::get('/matches/{id}', [MatchController::class, 'show'])->name('matches.show');

Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{id}', [TeamController::class, 'show'])->name('teams.show');

// Public Team Registration Form Link for Coaches
Route::get('/team-registration', [PublicTeamRegistrationController::class, 'show'])->name('team-registration.public');
Route::post('/team-registration', [PublicTeamRegistrationController::class, 'store'])->name('team-registration.store');

/*
|--------------------------------------------------------------------------
| Admin / Backend Direct View Routes (Dedicated Subfolder per Sidebar Item)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Authentication Routes

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'show'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Admin Password Reset & OTP Routes
        Route::get('/forgot-password', [AdminForgetPasswordController::class, 'showForgetPasswordForm'])->name('forgot-password');
        Route::post('/forgot-password', [AdminForgetPasswordController::class, 'sendOtp'])->name('forgot-password.send');

        Route::get('/verify-otp', [AdminOtpVerificationController::class, 'showOtpVerificationForm'])->name('verify-otp');
        Route::post('/verify-otp', [AdminOtpVerificationController::class, 'verifyOtp'])->name('verify-otp.submit');
        Route::post('/resend-otp', [AdminOtpVerificationController::class, 'resendOtp'])->name('verify-otp.resend');

        Route::get('/reset-password/{token?}', [AdminResetPasswordController::class, 'showResetForm'])->name('reset-password');
        Route::post('/reset-password', [AdminResetPasswordController::class, 'resetPassword'])->name('reset-password.submit');

    });
    // Protected Admin Dashboard Routes
    Route::middleware(['auth:admin', 'permission:dashboard.access'])->group(function () {
        // 1. Dashboard
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', function () {
                return view('backend.dashboard.index');
            })->name('index');
        });
        Route::get('/', function () {
            return view('backend.dashboard.index');
        })->name('dashboard');

        // 2. Competitions
        Route::prefix('competitions')->name('competitions.')->group(function () {
            Route::get('/', [AdminCompetitionController::class, 'index'])->name('index');

            Route::get('/create', [AdminCompetitionController::class, 'create'])->name('create');

            Route::get('/{id}/edit', [AdminCompetitionController::class, 'edit'])->name('edit');

            Route::get('/{id}', [AdminCompetitionController::class, 'show'])->name('show');

            Route::post('/', [AdminCompetitionController::class, 'store'])->name('store');

            Route::put('/{id}', [AdminCompetitionController::class, 'update'])->name('update');

            Route::delete('/{id}', [AdminCompetitionController::class, 'destroy'])->name('destroy');
        });

        // 3. Groups
        Route::prefix('groups')->name('groups.')->group(function () {
            Route::get('/', [AdminCompetitionGroupController::class, 'index'])->name('index');
            Route::get('/create', [AdminCompetitionGroupController::class, 'create'])->name('create');
            Route::post('/', [AdminCompetitionGroupController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminCompetitionGroupController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminCompetitionGroupController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminCompetitionGroupController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminCompetitionGroupController::class, 'destroy'])->name('destroy');
        });

        // 4. Matches
        Route::prefix('matches')->name('matches.')->group(function () {
            Route::get('/', function () {
                return view('backend.matches.index');
            })->name('index');

            Route::get('/create', function () {
                return view('backend.matches.create');
            })->name('create');

            Route::get('/edit', function () {
                return view('backend.matches.edit');
            })->name('edit');

            Route::get('/show', function () {
                return view('backend.matches.show');
            })->name('show');

            Route::get('/live-center', function () {
                return view('backend.matches.live-center');
            })->name('live-center');
        });

        // 5. Standings
        Route::prefix('standings')->name('standings.')->group(function () {
            Route::get('/', function () {
                return view('backend.standings.index');
            })->name('index');
        });

        // 6. Teams
        Route::patch('teams/{team}/accept', [App\Http\Controllers\Admin\TeamController::class, 'accept'])->name('teams.accept');
        Route::patch('teams/{team}/reject', [App\Http\Controllers\Admin\TeamController::class, 'reject'])->name('teams.reject');
        Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);

        // 7. Team Statistics
        Route::prefix('statistics')->name('statistics.')->group(function () {
            Route::get('/', function () {
                return view('backend.statistics.index');
            })->name('index');
        });

        // 8. Users Directory
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', function () {
                return view('backend.users.index');
            })->name('index');

            Route::get('/create', function () {
                return view('backend.users.create');
            })->name('create');

            Route::get('/edit', function () {
                return view('backend.users.edit');
            })->name('edit');
        });

        // Dynamic Roles & Permissions Management
        Route::resource('roles', RoleController::class);

        // 9. Admin Management
        Route::resource('admins', AdminController::class);

        // Profile Settings Routes
        Route::get('/profile', [App\Http\Controllers\Admin\AdminProfile::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [App\Http\Controllers\Admin\AdminProfile::class, 'index'])->name('profile');
        Route::put('/profile', [App\Http\Controllers\Admin\AdminProfile::class, 'update'])->name('profile.update');

        // 10. Activity Logs
        Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
            Route::get('/', function () {
                return view('backend.activity-logs.index');
            })->name('index');
        });
    });

    // Auth Pages

});
