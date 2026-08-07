<?php

namespace App\Data\StaffProfile;

use Spatie\LaravelData\Data;

class UpdateStaffProfileData extends Data
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
