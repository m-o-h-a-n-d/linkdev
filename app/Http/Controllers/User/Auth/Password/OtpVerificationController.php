<?php

namespace App\Http\Controllers\User\Auth\Password;

use App\Data\User\Auth\ForgotPasswordData;
use App\Data\User\Auth\VerifyOtpData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ForgotPasswordRequest;
use App\Http\Requests\User\Auth\VerifyOtpRequest;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function __construct(
        protected readonly OtpService $otpService
    ) {}

    public function showOtpForm(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get('reset_email') ?? $request->query('email');

        if (! $email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => __('Please enter your email to receive an OTP verification code.')]);
        }

        return view('frontend.auth.verify-otp', compact('email'));
    }

    public function verifyOtp(VerifyOtpRequest $request): RedirectResponse
    {
        $dto = VerifyOtpData::from($request);

        $token = $this->otpService->verifyOtp($dto->email, $dto->otp);

        if (! $token) {
            return back()
                ->withInput(['email' => $dto->email])
                ->withErrors(['otp' => __('The verification code is invalid or has expired.')]);
        }

        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $dto->email,
        ])->with('status', __('OTP verified successfully! Please set your new password.'));
    }

    public function resendOtp(ForgotPasswordRequest $request): RedirectResponse
    {
        $dto = ForgotPasswordData::from($request);

        $this->otpService->resendOtp($dto->email);

        $request->session()->put('reset_email', $dto->email);

        return back()->with('status', __('A new OTP verification code has been sent to your email.'));
    }
}
