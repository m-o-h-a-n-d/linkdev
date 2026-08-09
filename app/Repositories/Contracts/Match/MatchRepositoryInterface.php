<?php

namespace App\Repositories\Contracts\Match;

use App\Data\Match\CreateMatchData;
use App\Data\Match\UpdateMatchData;
use App\Models\GameMatch;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface MatchRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function all(): Collection;

    public function find(int $id): ?GameMatch;

    public function create(CreateMatchData $data): GameMatch;

    public function update(GameMatch $match, UpdateMatchData $data): GameMatch;

    public function delete(GameMatch $match): bool;
}
