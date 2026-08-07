<?php

namespace App\Services;

use App\Notifications\SendOtpNotify;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Password;

class OtpService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function sendOtp(string $email): bool
    {
        $user = $this->userRepository->findByEmail($email);
        if (! $user) {
            return false;
        }

        // Delete previous OTPs using Spatie HasOneTimePasswords trait
        $user->deleteAllOneTimePasswords();

        // Create Spatie OneTimePassword (10 minutes expiry)
        $otp = $user->createOneTimePassword(10);

        // Send notification via SendOtpNotify
        try {
            $user->notify(new SendOtpNotify($otp->password));
        } catch (\Throwable $e) {
            logger()->error('Failed to send OTP notification: ' . $e->getMessage());
        }

        return true;
    }

    public function verifyOtp(string $email, string $otp): ?string
    {
        $user = $this->userRepository->findByEmail($email);
        if (! $user) {
            return null;
        }

        // Consume OTP using Spatie HasOneTimePasswords trait method
        $result = $user->consumeOneTimePassword($otp);

        if (! $result->isOk()) {
            return null;
        }

        // Create standard Laravel password reset token
        return Password::createToken($user);
    }

    public function resendOtp(string $email): bool
    {
        return $this->sendOtp($email);
    }
}
