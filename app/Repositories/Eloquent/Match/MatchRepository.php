<?php

namespace App\Repositories\Eloquent\Match;

use App\Data\Match\CreateMatchData;
use App\Data\Match\UpdateMatchData;
use App\Models\GameMatch;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MatchRepository implements MatchRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return GameMatch::paginate($perPage);
    }

    public function all(): Collection
    {
        return GameMatch::all();
    }

    public function find(int $id): ?GameMatch
    {
        return GameMatch::findOrFail($id);
    }

    public function create(CreateMatchData $data): GameMatch
    {
        return GameMatch::create($data->toArray());
    }

    public function update(GameMatch $match, UpdateMatchData $data): GameMatch
    {
        $match->update($data->toArray());
        return $match;
    }

    public function delete(GameMatch $match): bool
    {
        return $match->delete();
    }
}
