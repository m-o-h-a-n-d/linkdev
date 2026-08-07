<?php

namespace App\Data\Competition;

use Spatie\LaravelData\Data;

class CreateCompetitionData extends Data
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $description,
        public string $season,
        public string $status,
        public string $start_date,
        public string $end_date,
        public int $created_by_user_id,
        public ?int $winner_team_id = null,
    ) {}
}
