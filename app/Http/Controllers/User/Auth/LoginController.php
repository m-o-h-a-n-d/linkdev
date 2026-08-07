<?php

namespace App\Http\Controllers\User\Auth;

use App\Data\User\LoginData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{

    public function __construct(
        protected  readonly \App\Services\User\UserService $userService,
    ) {}
    public function show(): View
    {
        return view('frontend.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $dto = LoginData::from($request);

        if (! $this->userService->login($dto)) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('account.index'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Logged out successfully!');

    }
}
