<?php

namespace App\Repositories\Contracts\CompetitionGroup;

use App\Data\CompetitionGroup\CreateCompetitionGroupData;
use App\Data\CompetitionGroup\UpdateCompetitionGroupData;
use App\Models\CompetitionGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CompetitionGroupRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function all(): Collection;

    public function allWithRelations(array $relations = []): Collection;

    public function find(int $id): ?CompetitionGroup;

    public function create(CreateCompetitionGroupData $data): CompetitionGroup;

    public function update(CompetitionGroup $group, UpdateCompetitionGroupData $data): CompetitionGroup;

    public function delete(CompetitionGroup $group): bool;

    public function attachTeam(CompetitionGroup $group, int $teamId): void;

    public function detachTeam(CompetitionGroup $group, int $teamId): void;

    public function getAvailableTeamsForGroup(CompetitionGroup $group): Collection;

    public function isTeamInCompetitionGroup(int $competitionId, int $teamId): bool;

    public function getGroupsByCompetitionId(int $competitionId): Collection;

    public function getTeamsByGroupId(int $groupId): Collection;
}

