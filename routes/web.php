<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfile;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\Password\ForgetPasswordController as AdminForgetPasswordController;
use App\Http\Controllers\Admin\Auth\Password\OtpVerificationController as AdminOtpVerificationController;
use App\Http\Controllers\Admin\Auth\Password\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\CompetitionController as AdminCompetitionController;
use App\Http\Controllers\Admin\CompetitionGroupController as AdminCompetitionGroupController;
use App\Http\Controllers\Admin\MatchController as AdminMatchController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StandingController as AdminStandingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
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
use App\Services\Competition\CompetitionService;
use Illuminate\Support\Facades\Route;

Route::bind('competition', function (string $slug) {
    return app(CompetitionService::class)->findBySlugOrFail($slug);
});

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
Route::get('/competitions/{slug}', [ViewerCompetitionController::class, 'show'])->name('competitions.show');

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
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

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
            Route::post('/{id}/teams', [AdminCompetitionGroupController::class, 'attachTeam'])->name('attach-team');
            Route::delete('/{id}/teams/{teamId}', [AdminCompetitionGroupController::class, 'detachTeam'])->name('detach-team');
        });

        // 4. Matches
        Route::prefix('matches')->name('matches.')->group(function () {
            Route::get('/', [AdminMatchController::class, 'index'])->name('index');
            Route::get('/create', [AdminMatchController::class, 'create'])->name('create');
            Route::post('/', [AdminMatchController::class, 'store'])->name('store');
            Route::post('/generate-fixtures', [AdminMatchController::class, 'generateFixtures'])->name('generate-fixtures');
            Route::get('/live-center', [AdminMatchController::class, 'liveCenter'])->name('live-center');
            Route::post('/{id}/update-score', [AdminMatchController::class, 'updateScore'])->name('update-score');
            Route::get('/{id}', [AdminMatchController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminMatchController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminMatchController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminMatchController::class, 'destroy'])->name('destroy');
        });

        // Dynamic API Endpoints for Cascading Selects
        Route::get('/api/competitions/{id}/groups', [AdminMatchController::class, 'getGroupsByCompetition'])->name('api.competitions.groups');
        Route::get('/api/groups/{id}/teams', [AdminMatchController::class, 'getTeamsByGroup'])->name('api.groups.teams');
        Route::get('/api/competitions/{id}/teams', [AdminMatchController::class, 'getTeamsByCompetition'])->name('api.competitions.teams');


        // 5. Standings
        Route::prefix('standings')->name('standings.')->group(function () {
            Route::get('/', [AdminStandingController::class, 'index'])->name('index');
        });

        // 6. Teams
        Route::patch('teams/{team}/accept', [App\Http\Controllers\Admin\TeamController::class, 'accept'])->name('teams.accept');
        Route::patch('teams/{team}/reject', [App\Http\Controllers\Admin\TeamController::class, 'reject'])->name('teams.reject');
        Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);

        // 7. Team Statistics
        Route::prefix('statistics')->name('statistics.')->group(function () {
            Route::get('/', [AdminStandingController::class, 'statistics'])->name('index');
        });

        // 8. Users Directory
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::patch('/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('toggle-admin');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Dynamic Roles & Permissions Management
        Route::resource('roles', RoleController::class);

        // 9. Admin Management
        Route::resource('admins', AdminController::class);

        // Profile Settings Routes
        Route::get('/profile', [AdminProfile::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [AdminProfile::class, 'index'])->name('profile');
        Route::put('/profile', [AdminProfile::class, 'update'])->name('profile.update');

        // 10. Activity Logs
        Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
            Route::get('/', [ActivityLogController::class, 'index'])->name('index');
            Route::delete('/clear-all', [ActivityLogController::class, 'destroyAll'])->name('clear-all');
        });

        // 11. System Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'edit'])->middleware('permission:settings.view')->name('edit');
            Route::put('/', [SettingController::class, 'update'])->middleware('permission:settings.edit')->name('update');
        });
    });

    // Auth Pages

});
