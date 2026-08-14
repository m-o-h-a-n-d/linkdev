<?php

namespace App\Repositories\Contracts\Standing;

use App\Models\TeamStatistic;
use Illuminate\Database\Eloquent\Collection;

interface TeamStatisticRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values = []): TeamStatistic;

    public function getByCompetitionId(?int $competitionId = null): Collection;
}

