<?php

namespace App\Repositories\Eloquent\CompetitionGroup;

use App\Data\CompetitionGroup\CreateCompetitionGroupData;
use App\Data\CompetitionGroup\UpdateCompetitionGroupData;
use App\Models\CompetitionGroup;
use App\Repositories\Contracts\CompetitionGroup\CompetitionGroupRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CompetitionGroupRepository implements CompetitionGroupRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return CompetitionGroup::with(['competition', 'teams'])
            ->orderBy('competition_id')
            ->orderBy('display_order')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function all(): Collection
    {
        return CompetitionGroup::with(['competition', 'teams'])
            ->orderBy('competition_id')
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();
    }

    public function find(int $id): ?CompetitionGroup
    {
        return CompetitionGroup::with(['competition', 'teams'])->find($id);
    }

    public function create(CreateCompetitionGroupData $data): CompetitionGroup
    {
        return CompetitionGroup::create($data->toArray());
    }

    public function update(CompetitionGroup $group, UpdateCompetitionGroupData $data): CompetitionGroup
    {
        $group->update($data->toArray());

        return $group->fresh();
    }

    public function delete(CompetitionGroup $group): bool
    {
        return $group->delete();
    }

    public function attachTeam(CompetitionGroup $group, int $teamId): void
    {
        $group->teams()->syncWithoutDetaching([$teamId]);
    }

    public function detachTeam(CompetitionGroup $group, int $teamId): void
    {
        $group->teams()->detach($teamId);
    }
}
