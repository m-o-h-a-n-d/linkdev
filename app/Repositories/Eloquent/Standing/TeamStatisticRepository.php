<?php

namespace App\Repositories\Eloquent\Standing;

use App\Models\TeamStatistic;
use App\Repositories\Contracts\Standing\TeamStatisticRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TeamStatisticRepository implements TeamStatisticRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values = []): TeamStatistic
    {
        return TeamStatistic::updateOrCreate($attributes, $values);
    }

    public function getByCompetitionId(?int $competitionId = null): Collection
    {
        return TeamStatistic::with('team')
            ->when($competitionId, function ($query) use ($competitionId) {
                $query->where('competition_id', $competitionId);
            })
            ->orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->orderBy('goals_for', 'desc')
            ->get();
    }
}

