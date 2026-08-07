<?php

namespace App\Data\Competition;

use Spatie\LaravelData\Data;

class UpdateCompetitionData extends Data
{
    public function __construct(
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?string $season = null,
        public ?string $status = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        public ?int $winner_team_id = null,
    ) {}
}
