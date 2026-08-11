<?php

namespace App\Data\Admin;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class CreateAdminData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $phone,
        public string|int $national_id,
        public string $address,
        public string $gender,
        public string $status = 'active',
        public ?string $role = null,
        public UploadedFile $image,
      public ?Carbon $email_verify_at = null,

    ) {}
}
