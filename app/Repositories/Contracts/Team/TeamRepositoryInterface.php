<?php

namespace App\Repositories\Contracts\Team;

use App\Data\Team\CreateTeamData;
use App\Data\Team\UpdateTeamData;
use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TeamRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function all(): Collection;

    public function find(int $id): ?Team;

    public function create(CreateTeamData $data, ?string $logoPath = null): Team;

    public function update(Team $team, UpdateTeamData $data, ?string $logoPath = null): Team;

    public function updateStatus(Team $team, string $status, ?string $reason = null): Team;

    public function getPendingTeams(): Collection;

    public function delete(Team $team): bool;
}
