<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Data\User\Auth\ForgotPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ForgotPasswordRequest;
use App\Http\Requests\User\Auth\VerifyOtpRequest;
use App\Services\User\OtpService;
use Illuminate\Http\RedirectResponse;

class OtpVerificationController extends Controller
{
    public function __construct(
        private OtpService $otpService
    ) {}

    public function showOtpVerificationForm()
    {
        $email = session('reset_email');
        if (! $email) {
            return redirect()->route('admin.auth.forgot-password')->with('error', 'Please enter your email to request a password reset.');
        }

        return view('backend.auth.verify-otp', compact('email'));
    }

    public function verifyOtp(VerifyOtpRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $email = $validated['email'] ?? session('reset_email');
        $otp = $validated['otp'];

        if (! $email) {
            return redirect()->route('admin.auth.forgot-password')->with('error', 'Email not found in session.');
        }

        // Verify the OTP using OtpService - returns the valid Laravel password reset token
        $token = $this->otpService->verifyOtp($email, $otp);

        if ($token) {
            return redirect()->route('admin.auth.reset-password', [
                'token' => $token,
                'email' => $email,
            ]);
        }

        return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP code. Please try again.']);
    }

    public function resendOtp(ForgotPasswordRequest $request): RedirectResponse
    {
        $dto = ForgotPasswordData::from($request);

        $success = $this->otpService->resendOtp($dto->email);

        if (! $success) {
            return back()->withErrors(['email' => 'Failed to send OTP notification. Please make sure the email is a valid admin.']);
        }

        $request->session()->put('reset_email', $dto->email);

        return back()->with('status', 'A new 6-digit verification code (OTP) has been sent to your email address.');
    }
}
