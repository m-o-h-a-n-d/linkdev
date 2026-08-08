<?php

namespace App\Services\Match;

use App\Data\Match\CreateMatchData;
use App\Data\Match\UpdateMatchData;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\GameMatch;

class MatchService
{
    public function __construct(
        protected MatchRepositoryInterface $matchRepository
    ) {}

    public function all(): Collection
    {
        return $this->matchRepository->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->matchRepository->paginate($perPage);
    }

    public function findOrFail(int $id): GameMatch
    {
        $match = $this->matchRepository->find($id);

        if (! $match) {
            throw new ModelNotFoundException('Match not found.');
        }

        return $match;
    }

    public function store(CreateMatchData $data): GameMatch
    {
        return $this->matchRepository->create($data);
    }

    public function update(int $id, UpdateMatchData $data): GameMatch
    {
        $match = $this->findOrFail($id);

        return $this->matchRepository->update($match, $data);
    }

    public function destroy(int $id): bool
    {
        $match = $this->findOrFail($id);

        return $this->matchRepository->delete($match);
    }
}
