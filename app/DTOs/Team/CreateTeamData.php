<?php

namespace App\DTOs\Team;

use Illuminate\Http\Request;

readonly class CreateTeamData
{
    public function __construct(
        public string $name,
        public string $short_name,
        public string $logo,
        public string $city,
        public string $country,
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
            name: $data['name'],
            short_name: $data['short_name'],
            logo: $data['logo'],
            city: $data['city'],
            country: $data['country'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'short_name' => $this->short_name,
            'logo' => $this->logo,
            'city' => $this->city,
            'country' => $this->country,
        ];
    }
}
