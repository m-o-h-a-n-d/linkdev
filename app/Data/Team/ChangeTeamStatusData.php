<?php

namespace App\Data\Team;

use Spatie\LaravelData\Data;

class ChangeTeamStatusData extends Data
{
    public function __construct(
        public string $status,
        public ?string $rejection_reason = null,
    ) {}
}
