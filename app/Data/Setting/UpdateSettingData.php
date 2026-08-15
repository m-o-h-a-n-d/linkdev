<?php

namespace App\Data\Setting;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateSettingData extends Data
{
    public function __construct(
        public ?string $session = null,
        public ?string $header = null,
        public ?string $description = null,
        #[Rule(['nullable'])]
        public UploadedFile|string|null $favicon = null,
        #[Rule(['nullable'])]
        public UploadedFile|string|null $icon = null,
        #[Rule(['nullable'])]
        public UploadedFile|string|null $matches_image = null,
    ) {}

    public static function rules(): array
    {
        return [
            'session'       => ['nullable', 'string', 'max:255'],
            'header'        => ['nullable', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'favicon'       => ['nullable'],
            'icon'          => ['nullable'],
            'matches_image' => ['nullable'],
        ];
    }
}
