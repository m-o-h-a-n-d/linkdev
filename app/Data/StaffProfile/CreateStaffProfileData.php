<?php

namespace App\Data\StaffProfile;

use Spatie\LaravelData\Data;

class CreateStaffProfileData extends Data
{
    public function __construct(
        public int $user_id,
        public string $phone,
        public string $image,
        public string $status,
        public int $national_id,
        public string $address,
        public string $gender,
    ) {}
}
