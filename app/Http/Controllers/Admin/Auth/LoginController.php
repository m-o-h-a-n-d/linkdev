<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Data\User\LoginData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
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
        return view('backend.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $dto = LoginData::from($request);

        if (! $this->userService->login($dto, 'admin', $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => __('auth.failed'),
                ])
                ->onlyInput('email');
        }

        $user = Auth::guard('admin')->user();

        if (
            ! $user ||
            ! $user->admin()->exists() ||
            ! $user->can('dashboard.access')
        ) {
            Auth::guard('admin')->logout();

            return back()
                ->withErrors([
                    'email' => __('Access denied. You do not have permission to access the admin panel.'),
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(
            route('admin.dashboard')
        );
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.auth.login')
            ->with('success', 'Logged out successfully!');
    }
}
