<?php

namespace App\Data\User;

use Spatie\LaravelData\Data;

class UpdateUserData extends Data
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
    ) {}
}
