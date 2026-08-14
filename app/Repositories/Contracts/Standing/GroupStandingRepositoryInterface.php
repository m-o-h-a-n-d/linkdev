<?php

namespace App\Repositories\Contracts\Standing;

use App\Models\GroupStanding;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

interface GroupStandingRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values = []): GroupStanding;

    public function getByCompetitionId(?int $competitionId = null): Collection;

    public function getByGroupId(int $groupId): EloquentCollection;
}

