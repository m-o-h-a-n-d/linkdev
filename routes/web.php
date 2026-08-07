<?php

use App\Http\Controllers\Viewer\AccountController;
use App\Http\Controllers\Viewer\TeamController;
use App\Http\Controllers\User\Auth\EmailVerificationController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\User\Auth\Password\OtpVerificationController;
use App\Http\Controllers\User\Auth\Password\ResetPasswordController;
use App\Http\Controllers\User\Auth\RegisterController;
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
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

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

