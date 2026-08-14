<?php

namespace App\Repositories\Eloquent\Standing;

use App\Models\GroupStanding;
use App\Repositories\Contracts\Standing\GroupStandingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class GroupStandingRepository implements GroupStandingRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values = []): GroupStanding
    {
        return GroupStanding::updateOrCreate($attributes, $values);
    }

    public function getByCompetitionId(?int $competitionId = null): Collection
    {
        return GroupStanding::with(['group', 'team'])
            ->when($competitionId, function ($query) use ($competitionId) {
                $query->whereHas('group', function ($q) use ($competitionId) {
                    $q->where('competition_id', $competitionId);
                });
            })
            ->orderBy('group_id')
            ->orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->orderBy('goals_for', 'desc')
            ->get()
            ->groupBy('group.name');
    }

    public function getByGroupId(int $groupId): EloquentCollection
    {
        return GroupStanding::with('team')
            ->where('group_id', $groupId)
            ->orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->orderBy('goals_for', 'desc')
            ->get();
    }
}

