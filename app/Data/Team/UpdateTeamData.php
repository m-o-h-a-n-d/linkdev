<?php

namespace App\Data\Team;

use Spatie\LaravelData\Data;

class UpdateTeamData extends Data
{
    public function __construct(
        public ?string $name = null,
        public ?string $short_name = null,
        public ?string $logo = null,
        public ?string $city = null,
        public ?string $country = null,
    ) {}
}
