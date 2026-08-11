<?php

namespace App\Data\Team;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateTeamData extends Data
{
    public function __construct(
        public ?string $name = null,
        public ?string $short_name = null,
        public ?string $city = null,
        public ?string $country = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $manager_name = null,
        public ?string $arena = null,
        #[Rule(['nullable'])]
        public UploadedFile|string|null $logo = null,
        public ?string $status = null,
        public ?string $rejection_reason = null,
    ) {}

    public static function rules(): array
    {
        return [
            'logo' => ['nullable'],
        ];
    }
}
