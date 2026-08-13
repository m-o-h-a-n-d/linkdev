<?php

namespace App\Repositories\Contracts\Standing;

use App\Models\TeamStatistic;

interface TeamStatisticRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values = []): TeamStatistic;
}
