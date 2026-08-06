<?php

namespace App\DTOs\Team;

use Illuminate\Http\Request;

readonly class UpdateTeamData
{
    public function __construct(
        public ?string $name = null,
        public ?string $short_name = null,
        public ?string $logo = null,
        public ?string $city = null,
        public ?string $country = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name'),
            short_name: $request->validated('short_name'),
            logo: $request->validated('logo'),
            city: $request->validated('city'),
            country: $request->validated('country'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            short_name: $data['short_name'] ?? null,
            logo: $data['logo'] ?? null,
            city: $data['city'] ?? null,
            country: $data['country'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'logo' => $this->logo,
            'city' => $this->city,
            'country' => $this->country,
        ], fn ($value) => $value !== null);
    }
}
