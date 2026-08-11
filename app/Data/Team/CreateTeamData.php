<?php

namespace App\Data\Team;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class CreateTeamData extends Data
{
    public function __construct(
        public string $name,
        public string $short_name,
        public string $city,
        public string $country,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $manager_name = null,
        public ?string $arena = null,
        #[Rule(['nullable'])]
        public UploadedFile|string|null $logo = null,
        public string $status = 'pending',
    ) {}

    public static function rules(): array
    {
        return [
            'logo' => ['nullable'],
        ];
    }
}
