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

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function all(): Collection;

    public function find(int $id): ?GameMatch;

    public function findWithRelations(int $id, array $relations = []): ?GameMatch;

    public function create(CreateMatchData|array $data): GameMatch;

    public function update(GameMatch $match, UpdateMatchData|array $data): GameMatch;

    public function delete(GameMatch $match): bool;

    public function getUpcomingMatches(int $limit): Collection;

    public function getLiveMatches(): Collection;

    public function getLiveAndScheduledMatches(): Collection;

    public function getScheduledMatchesToLive(?\Carbon\Carbon $now = null): Collection;

    public function getFinishedMatchesByGroup(int $groupId): Collection;

    public function getFinishedMatchesByCompetition(int $competitionId): Collection;

    public function getNextKnockoutMatch(int $competitionId, int $nextRoundNumber): ?GameMatch;

    public function incrementScore(GameMatch $match, string $field): GameMatch;

    public function decrementScore(GameMatch $match, string $field): GameMatch;
}
