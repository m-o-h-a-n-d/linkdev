<?php

namespace App\Repositories\Eloquent\Standing;

use App\Models\GroupStanding;
use App\Repositories\Contracts\Standing\GroupStandingRepositoryInterface;

class GroupStandingRepository implements GroupStandingRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values = []): GroupStanding
    {
        return GroupStanding::updateOrCreate($attributes, $values);
    }
}
