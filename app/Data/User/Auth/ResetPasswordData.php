<?php

namespace App\Data\User\Auth;

use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class ResetPasswordData extends Data
{
    public function __construct(
        #[Required, Email]
        public string $email,

        #[Required]
        public string $token,

        #[Required, Min(8), Confirmed]
        public string $password,

        public string $password_confirmation,
    ) {}
}
