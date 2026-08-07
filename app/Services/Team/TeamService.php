<?php

namespace App\Services\Team;

use App\Data\Team\CreateTeamData;
use App\Data\Team\UpdateTeamData;
use App\Models\Team;
use App\Repositories\Contracts\Team\TeamRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TeamService
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository
    ) {}

    public function all(): Collection
    {
        return $this->teamRepository->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->teamRepository->paginate($perPage);
    }

    public function findOrFail(int $id): Team
    {
        $team = $this->teamRepository->find($id);

        if (! $team) {
            throw new ModelNotFoundException('Team not found.');
        }

        return $team;
    }

    public function store(CreateTeamData $data): Team
    {
        return $this->teamRepository->create($data);
    }

    public function update(int $id, UpdateTeamData $data): Team
    {
        $team = $this->findOrFail($id);

        return $this->teamRepository->update($team, $data);
    }

    public function destroy(int $id): bool
    {
        $team = $this->findOrFail($id);

        return $this->teamRepository->delete($team);
    }
}
