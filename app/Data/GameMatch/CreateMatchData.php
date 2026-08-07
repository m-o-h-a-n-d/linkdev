<?php

namespace App\Data\GameMatch;

use Spatie\LaravelData\Data;

class CreateMatchData extends Data
{
    public function __construct(
        public int $competition_id,
        public int $home_team_id,
        public int $away_team_id,
        public string $scheduled_at,
        public int $round_number,
        public ?int $group_id = null,
        public ?string $status = 'scheduled',
        public ?string $notes = null,
    ) {}
}
