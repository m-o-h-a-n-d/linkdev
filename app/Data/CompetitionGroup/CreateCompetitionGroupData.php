<?php

namespace App\Data\CompetitionGroup;

use Spatie\LaravelData\Data;

class CreateCompetitionGroupData extends Data
{
    public function __construct(
        public int $competition_id,
        public string $name,
        public int $display_order = 0,
    ) {}
}
