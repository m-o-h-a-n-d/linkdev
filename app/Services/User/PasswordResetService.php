<?php

namespace App\Services\User;

use App\Data\User\Auth\ResetPasswordData;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function resetPassword(ResetPasswordData $data): bool
    {
        $user = $this->userRepository->findByEmail($data->email);

        if (! $user) {
            return false;
        }

        if (! Password::tokenExists($user, $data->token)) {
            return false;
        }

        $user->forceFill([
            'password' => $data->password,
            'remember_token' => Str::random(60),
        ])->save();

        Password::deleteToken($user);

        event(new PasswordReset($user));

        return true;
    }
}
