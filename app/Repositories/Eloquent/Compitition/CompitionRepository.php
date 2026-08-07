<?php

namespace App\Repositories\Eloquent\Compitition;

use App\Data\Competition\CreateCompetitionData;
use App\Data\Competition\UpdateCompetitionData;
use App\Models\Competition;
use App\Repositories\Contracts\Competition\CompititionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CompititionRepository implements CompititionRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Competition::paginate($perPage);
    }

    public function all(): Collection
    {
        return Competition::all();
    }

    public function find(int $id): ?Competition
    {
        return Competition::findOrFail($id);
    }

    public function create(CreateCompetitionData $data): Competition
    {
        return Competition::create($data->toArray());
    }

    public function update(Competition $competition, UpdateCompetitionData $data): Competition
    {
        $competition->update($data->toArray());
        return $competition;
    }

    public function delete(Competition $competition): bool
    {
        return $competition->delete();
    }
}
