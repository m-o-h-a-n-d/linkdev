<?php

namespace App\Services\User;

use App\Data\User\Auth\VerifyEmailOtpData;
use App\Notifications\SendEmailVerificationOtpNotify;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Illuminate\Auth\Events\Verified;

class EmailVerificationService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function sendVerificationOtp(string $email): bool
    {
        $user = $this->userRepository->findByEmail($email);
        if (! $user) {
            return false;
        }

        if ($user->hasVerifiedEmail()) {
            return false;
        }

        // Delete previous OTPs using Spatie HasOneTimePasswords trait
        $user->deleteAllOneTimePasswords();

        // Create Spatie OneTimePassword (10 minutes expiry)
        $otp = $user->createOneTimePassword(10);

        // Send Email Verification Notification
        try {
            $user->notify(new SendEmailVerificationOtpNotify($otp->password));
        } catch (\Throwable $e) {
            logger()->error('Failed to send email verification OTP: ' . $e->getMessage());
        }

        return true;
    }

    public function verifyEmailOtp(VerifyEmailOtpData $data): bool
    {
        $user = $this->userRepository->findByEmail($data->email);
        if (! $user) {
            return false;
        }

        if ($user->hasVerifiedEmail()) {
            return true;
        }

        // Consume OTP using Spatie HasOneTimePasswords trait method
        $result = $user->consumeOneTimePassword($data->otp);

        if (! $result->isOk()) {
            return false;
        }

        // Mark Email as Verified & Save timestamp
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return true;
    }

    public function resendVerificationOtp(string $email): bool
    {
        return $this->sendVerificationOtp($email);
    }
}
