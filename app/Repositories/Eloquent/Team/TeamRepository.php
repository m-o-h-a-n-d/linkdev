<?php

namespace App\Repositories\Eloquent\Team;

use App\Data\Team\CreateTeamData;
use App\Data\Team\UpdateTeamData;
use App\Models\Team;
use App\Repositories\Contracts\Team\TeamRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository implements TeamRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Team::paginate($perPage);
    }

    public function all(): Collection
    {
        return Team::get();
    }

    public function find(int $id): ?Team
    {
        return Team::find($id);
    }

    public function create(CreateTeamData $data): Team
    {
        return Team::create($data->toArray());
    }

    public function update(Team $team, UpdateTeamData $data): Team
    {
        $team->update($data->toArray());
        return $team;
    }

    public function delete(Team $team): bool
    {
        return $team->delete();
    }
}
