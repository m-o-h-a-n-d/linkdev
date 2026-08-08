<?php

namespace App\Data\AdminProfile;

use Spatie\LaravelData\Data;

class UpdateAdminProfileData extends Data
{
    public function __construct(
        public ?string $phone = null,
        public ?string $image = null,
        public ?string $status = null,
        public ?int $national_id = null,
        public ?string $address = null,
        public ?string $gender = null,
    ) {}
}
