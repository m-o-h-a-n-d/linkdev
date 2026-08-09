<?php

namespace App\Http\Controllers\Viewer\Auth;

use App\Data\User\Auth\ResendEmailVerificationData;
use App\Data\User\Auth\VerifyEmailOtpData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ResendEmailVerificationRequest;
use App\Http\Requests\User\Auth\VerifyEmailOtpRequest;
use App\Services\User\EmailVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function __construct(
        protected readonly EmailVerificationService $emailVerificationService
    ) {}

    public function show(Request $request): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->route('account.index');
        }

        $email = $user ? $user->email : ($request->session()->get('verify_email') ?? $request->query('email'));

        if (! $email) {
            return redirect()->route('login');
        }

        return view('frontend.auth.verify-email-otp', compact('email'));
    }

    public function verify(VerifyEmailOtpRequest $request): RedirectResponse
    {
        $dto = VerifyEmailOtpData::from($request);

        $success = $this->emailVerificationService->verifyEmailOtp($dto);

        if (! $success) {
            return back()
                ->withInput(['email' => $dto->email])
                ->withErrors(['otp' => __('The verification code is invalid or has expired.')]);
        }

        return redirect()->route('account.index')
            ->with('status', __('Your email address has been successfully verified!'));
    }

    public function resend(ResendEmailVerificationRequest $request): RedirectResponse
    {
        $dto = ResendEmailVerificationData::from($request);

        $this->emailVerificationService->resendVerificationOtp($dto->email);

        $request->session()->put('verify_email', $dto->email);

        return back()->with('status', __('A new verification OTP has been sent to your email address.'));
    }
}
