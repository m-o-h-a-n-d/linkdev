<?php

namespace App\Services\CompetitionGroup;

use App\Data\CompetitionGroup\CreateCompetitionGroupData;
use App\Data\CompetitionGroup\UpdateCompetitionGroupData;
use App\Models\CompetitionGroup;
use App\Repositories\Contracts\CompetitionGroup\CompetitionGroupRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Utility\ActivityLogger;

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
        $group = $this->competitionGroupRepository->create($data);

        ActivityLogger::log(
            action: 'CREATED',
            entityType: 'CompetitionGroup',
            entityId: $group->id,
            description: "Created group '{$group->name}' in competition #{$group->competition_id}."
        );

        return $group;
    }

    public function update(int $id, UpdateCompetitionGroupData $data): CompetitionGroup
    {
        $group = $this->findOrFail($id);

        $updated = $this->competitionGroupRepository->update($group, $data);

        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'CompetitionGroup',
            entityId: $updated->id,
            description: "Updated group '{$updated->name}'."
        );

        return $updated;
    }

    public function destroy(int $id): bool
    {
        $group = $this->findOrFail($id);
        $name = $group->name;
        $groupId = $group->id;

        $deleted = $this->competitionGroupRepository->delete($group);

        if ($deleted) {
            ActivityLogger::log(
                action: 'DELETED',
                entityType: 'CompetitionGroup',
                entityId: $groupId,
                description: "Deleted group '{$name}'."
            );
        }

        return $deleted;
    }

    public function attachTeam(int $groupId, int $teamId): void
    {
        $group = $this->findOrFail($groupId);
        $team = \App\Models\Team::findOrFail($teamId);
        //  يعني لو الفريق مش مقبول ما ينفعش يتضاف للجروب
        if (! $team->isAccepted()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'team_id' => 'Only accepted teams can be added to a group.',
            ]);
        }
        //  يعني لو الفريق موجود في جروب تاني في نفس الكومبيتيشن ما ينفعش يتضاف للجروب ده
        if ($this->competitionGroupRepository->isTeamInCompetitionGroup($group->competition_id, $teamId)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'team_id' => 'This team is already assigned to a group in this competition.',
            ]);
        }

        $this->competitionGroupRepository->attachTeam($group, $teamId);

        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'CompetitionGroup',
            entityId: $group->id,
            description: "Assigned team '{$team->name}' to group '{$group->name}'."
        );
    }

    public function detachTeam(int $groupId, int $teamId): void
    {
        $group = $this->findOrFail($groupId);
        $team = \App\Models\Team::find($teamId);

        $this->competitionGroupRepository->detachTeam($group, $teamId);

        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'CompetitionGroup',
            entityId: $group->id,
            description: "Removed team '" . ($team?->name ?? "#{$teamId}") . "' from group '{$group->name}'."
        );
    }

    public function getAvailableTeams(int $groupId): Collection
    {
        $group = $this->findOrFail($groupId);

        return $this->competitionGroupRepository->getAvailableTeamsForGroup($group);
    }
}
