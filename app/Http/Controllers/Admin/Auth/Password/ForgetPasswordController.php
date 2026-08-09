<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Data\User\Auth\ForgotPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ForgotPasswordRequest;
use App\Services\User\OtpService;

class ForgetPasswordController extends Controller
{
    public function __construct(
        private OtpService $otpService
    ) {}

    public function showForgetPasswordForm()
    {
        return view('backend.auth.forgot-password');

    }

    public function sendOtp(ForgotPasswordRequest $request)
    {
        $request->validated();

        $dto = ForgotPasswordData::from($request);

        $result = $this->otpService->sendOtp($dto->email);

        $request->session()->put('reset_email', $dto->email);

        if (! $result) {
            return back()
                ->withInput(['email' => $dto->email])
                ->withErrors(['email' => __('Failed to send OTP. Please ensure the email is Admin and has access to the dashboard.')]);
        }

        return redirect()->route('admin.auth.verify-otp')
            ->with('status', __('A 6-digit verification code (OTP) has been sent to your email address.'));

    }
}
