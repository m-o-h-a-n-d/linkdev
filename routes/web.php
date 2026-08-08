<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\User\Auth\EmailVerificationController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\User\Auth\Password\OtpVerificationController;
use App\Http\Controllers\User\Auth\Password\ResetPasswordController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\Viewer\AccountController;
use App\Http\Controllers\Viewer\TeamController;
use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', function () {
    return view('frontend.index');
})->name('home');

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
Route::get('/competitions', function () {
    return view('frontend.pages.competitions');
})->name('competitions.index');

Route::get('/matches', function () {
    return view('frontend.pages.matches');
})->name('matches.index');

Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{id}', [TeamController::class, 'show'])->name('teams.show');

// Public Team Registration Form Link for Coaches
Route::get('/team-registration', function () {
    return view('frontend.team-registration');
})->name('team-registration.public');

/*
|--------------------------------------------------------------------------
| Admin / Backend Direct View Routes (Dedicated Subfolder per Sidebar Item)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'show'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        Route::get('/forgot-password', function () {
            return view('backend.auth.forgot-password');
        })->name('forgot-password');

        Route::get('/verify-otp', function () {
            return view('backend.auth.verify-otp');
        })->name('verify-otp');

        Route::get('/reset-password', function () {
            return view('backend.auth.reset-password');
        })->name('reset-password');
    });
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
        Route::get('/', function () {
            return view('backend.competitions.index');
        })->name('index');

        Route::get('/create', function () {
            return view('backend.competitions.create');
        })->name('create');

        Route::get('/edit', function () {
            return view('backend.competitions.edit');
        })->name('edit');

        Route::get('/show', function () {
            return view('backend.competitions.show');
        })->name('show');
    });

    // 3. Groups
    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/', function () {
            return view('backend.groups.index');
        })->name('index');

        Route::get('/create', function () {
            return view('backend.groups.create');
        })->name('create');

        Route::get('/edit', function () {
            return view('backend.groups.edit');
        })->name('edit');

        Route::get('/show', function () {
            return view('backend.groups.show');
        })->name('show');
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
    Route::prefix('teams')->name('teams.')->group(function () {
        Route::get('/', function () {
            return view('backend.teams.index');
        })->name('index');

        Route::get('/create', function () {
            return view('backend.teams.create');
        })->name('create');

        Route::get('/edit', function () {
            return view('backend.teams.edit');
        })->name('edit');

        Route::get('/show', function () {
            return view('backend.teams.show');
        })->name('show');
    });

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

    // Roles & Permissions Management
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', function () {
            return view('backend.roles.index');
        })->name('index');

        Route::get('/create', function () {
            return view('backend.roles.create');
        })->name('create');

        Route::get('/edit', function () {
            return view('backend.roles.edit');
        })->name('edit');

        Route::get('/show', function () {
            return view('backend.roles.show');
        })->name('show');
    });

    // 9. Admin Management
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', function () {
            return view('backend.admins.index');
        })->name('index');

        Route::get('/create', function () {
            return view('backend.admins.create');
        })->name('create');

        Route::get('/edit', function () {
            return view('backend.admins.edit');
        })->name('edit');

        Route::get('/show', function () {
            return view('backend.admins.show');
        })->name('show');
    });

    // Profile Settings Route (Topbar Profile Direct Link)
    Route::get('/profile', function () {
        return view('backend.admins.edit');
    })->name('profile');

    // 10. Activity Logs
    Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
        Route::get('/', function () {
            return view('backend.activity-logs.index');
        })->name('index');
    });

    // Auth Pages

});
