<?php

namespace App\Data\GameMatch;

use Spatie\LaravelData\Data;

class UpdateMatchData extends Data
{
    public function __construct(
        public ?string $status = null,
        public ?string $started_at = null,
        public ?string $ended_at = null,
        public ?int $home_score = null,
        public ?int $away_score = null,
        public ?int $winner_team_id = null,
        public ?string $notes = null,
    ) {}
}
