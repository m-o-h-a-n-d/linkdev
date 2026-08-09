<?php

namespace App\Http\Controllers\Viewer\Auth;

use App\Data\User\LoginData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        protected readonly UserService $userService,
    ) {}

    public function show(): View
    {
        return view('frontend.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $dto = LoginData::from($request);

        if (! $this->userService->login($dto, 'web', $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('account.index'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
