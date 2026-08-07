<?php

namespace App\Http\Controllers\User\Auth\Password;

use App\Data\User\Auth\ResetPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ResetPasswordRequest;
use App\Services\User\PasswordResetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function __construct(
        protected readonly PasswordResetService $passwordResetService
    ) {}

    public function showResetForm(Request $request, string $token): View
    {
        $email = $request->query('email');

        return view('frontend.auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $dto = ResetPasswordData::from($request);

        $success = $this->passwordResetService->resetPassword($dto);

        if (! $success) {
            return back()
                ->withInput(['email' => $dto->email])
                ->withErrors(['email' => __('Invalid token or email verification request.')]);
        }

        return redirect()->route('login')
            ->with('status', __('Your password has been successfully reset! You can now log in.'));
    }
}
