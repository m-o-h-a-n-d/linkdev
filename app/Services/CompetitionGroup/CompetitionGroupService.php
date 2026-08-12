<?php

namespace App\Services\CompetitionGroup;

use App\Data\CompetitionGroup\CreateCompetitionGroupData;
use App\Data\CompetitionGroup\UpdateCompetitionGroupData;
use App\Models\CompetitionGroup;
use App\Repositories\Contracts\CompetitionGroup\CompetitionGroupRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompetitionGroupService
{
    public function __construct(
        protected CompetitionGroupRepositoryInterface $competitionGroupRepository
    ) {}

    public function all(): Collection
    {
        return $this->competitionGroupRepository->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->competitionGroupRepository->paginate($perPage);
    }

    public function findOrFail(int $id): CompetitionGroup
    {
        $group = $this->competitionGroupRepository->find($id);

        if (! $group) {
            throw new ModelNotFoundException('Competition group not found.');
        }

        return $group;
    }

    public function store(CreateCompetitionGroupData $data): CompetitionGroup
    {
        return $this->competitionGroupRepository->create($data);
    }

    public function update(int $id, UpdateCompetitionGroupData $data): CompetitionGroup
    {
        $group = $this->findOrFail($id);

        return $this->competitionGroupRepository->update($group, $data);
    }

    public function destroy(int $id): bool
    {
        $group = $this->findOrFail($id);

        return $this->competitionGroupRepository->delete($group);
    }

    public function attachTeam(int $groupId, int $teamId): void
    {
        $group = $this->findOrFail($groupId);

        $this->competitionGroupRepository->attachTeam($group, $teamId);
    }

    public function detachTeam(int $groupId, int $teamId): void
    {
        $group = $this->findOrFail($groupId);

        $this->competitionGroupRepository->detachTeam($group, $teamId);
    }
}
