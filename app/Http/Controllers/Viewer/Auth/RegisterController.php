<?php

namespace App\Http\Controllers\Viewer\Auth;

use App\Data\User\CreateUserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Services\User\EmailVerificationService;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected EmailVerificationService $emailVerificationService
    ) {}

    /**
     * Display the registration view.
     */
    public function show(): View
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $userData = CreateUserData::from($request);
        $user = $this->userService->store($userData);

        Auth::login($user);

        $request->session()->regenerate();

        // Send Email Verification OTP
        $this->emailVerificationService->sendVerificationOtp($user->email);

        return redirect()->route('verification.notice')->with('status', 'Registration successful! Please verify your email address with the OTP code sent to your email.');
    }
}
