<?php

namespace App\Data\CompetitionGroup;

use Spatie\LaravelData\Data;

class UpdateCompetitionGroupData extends Data
{
    public function __construct(
        public ?int $competition_id = null,
        public ?string $name = null,
        public ?int $display_order = null,
    ) {}
}
