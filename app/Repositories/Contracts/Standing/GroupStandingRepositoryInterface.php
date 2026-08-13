<?php

namespace App\Repositories\Contracts\Standing;

use App\Models\GroupStanding;

interface GroupStandingRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values = []): GroupStanding;
}
