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

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = GameMatch::with(['competition', 'group', 'homeTeam', 'awayTeam']);

        if (! empty($filters['competition_id'])) {
            $query->where('competition_id', $filters['competition_id']);
        }

        if (! empty($filters['group_id'])) {
            $query->where('group_id', $filters['group_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('scheduled_at', 'asc')->paginate($perPage);
    }

    public function all(): Collection
    {
        return GameMatch::with(['group', 'homeTeam', 'awayTeam', 'competition', 'winnerTeam'])
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    public function find(int $id): ?GameMatch
    {
        return GameMatch::find($id);
    }

    public function findWithRelations(int $id, array $relations = []): ?GameMatch
    {
        $query = GameMatch::query();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->find($id);
    }

    public function create(CreateMatchData|array $data): GameMatch
    {
        $payload = $data instanceof CreateMatchData ? $data->toArray() : $data;

        return GameMatch::create($payload);
    }

    public function update(GameMatch $match, UpdateMatchData|array $data): GameMatch
    {
        $attributes = $data instanceof UpdateMatchData ? array_filter($data->toArray(), fn ($v) => $v !== null) : $data;

        $match->update($attributes);

        return $match;
    }

    public function delete(GameMatch $match): bool
    {
        return $match->delete();
    }

    public function getUpcomingMatches(int $limit): Collection
    {
        return GameMatch::where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getLiveMatches(): Collection
    {
        return GameMatch::with(['group', 'homeTeam', 'awayTeam'])
            ->where('status', 'live')
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    public function getLiveAndScheduledMatches(): Collection
    {
        return GameMatch::with(['homeTeam', 'awayTeam', 'group', 'competition'])
            ->whereIn('status', ['live', 'scheduled'])
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    public function getScheduledMatchesToLive(?\Carbon\Carbon $now = null): Collection
    {
        $now = $now ?? \Carbon\Carbon::now();

        return GameMatch::where('status', 'scheduled')
            ->where('scheduled_at', '<=', $now)
            ->get();
    }

    public function getFinishedMatchesByGroup(int $groupId): Collection
    {
        return GameMatch::where('group_id', $groupId)
            ->where('status', 'finished')
            ->get();
    }

    public function getFinishedMatchesByCompetition(int $competitionId): Collection
    {
        return GameMatch::where('competition_id', $competitionId)
            ->where('status', 'finished')
            ->get();
    }

    public function getNextKnockoutMatch(int $competitionId, int $nextRoundNumber): ?GameMatch
    {
        return GameMatch::where('competition_id', $competitionId)
            ->where('round_number', $nextRoundNumber)
            ->whereNull('group_id')
            ->first();
    }

    public function incrementScore(GameMatch $match, string $field): GameMatch
    {
        $match->increment($field);

        return $match;
    }

    public function decrementScore(GameMatch $match, string $field): GameMatch
    {
        $match->decrement($field);

        return $match;
    }
}
