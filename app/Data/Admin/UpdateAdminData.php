<?php

namespace App\Data\Admin;

use Spatie\LaravelData\Data;

class UpdateAdminData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string|int $national_id,
        public string $address,
        public string $gender,
        public string $status = 'active',
        public ?string $role = null,
        public ?string $password = null,
        public mixed $image = null,
    ) {}
}
