<?php

namespace App\Http\Controllers\User\Auth\Password;

use App\Data\User\Auth\ForgotPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ForgotPasswordRequest;
use App\Services\User\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ForgetPasswordController extends Controller
{
    public function __construct(
        protected readonly OtpService $otpService
    ) {}

    public function showForgetPasswordForm(): View
    {
        return view('frontend.auth.forgot-password');
    }

    public function sendOtp(ForgotPasswordRequest $request): RedirectResponse
    {
        $dto = ForgotPasswordData::from($request);

        $this->otpService->sendOtp($dto->email);

        $request->session()->put('reset_email', $dto->email);

        return redirect()->route('password.otp.show')
            ->with('status', __('A 6-digit verification code (OTP) has been sent to your email address.'));
    }
}
