<?php

namespace App\Repositories\Eloquent\Standing;

use App\Models\TeamStatistic;
use App\Repositories\Contracts\Standing\TeamStatisticRepositoryInterface;

class TeamStatisticRepository implements TeamStatisticRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values = []): TeamStatistic
    {
        return TeamStatistic::updateOrCreate($attributes, $values);
    }
}
