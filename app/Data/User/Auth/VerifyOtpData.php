<?php

namespace App\Data\User\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class VerifyOtpData extends Data
{
    public function __construct(
        #[Required, Email]
        public string $email,

        #[Required, Regex('/^[0-9]{6}$/')]
        public string $otp,
    ) {}
}
