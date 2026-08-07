<?php

namespace App\Data\Team;

use Spatie\LaravelData\Data;

class CreateTeamData extends Data
{
    public function __construct(
        public string $name,
        public string $short_name,
        public string $logo,
        public string $city,
        public string $country,
    ) {}
}
