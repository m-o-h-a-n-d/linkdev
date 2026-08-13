<?php

namespace App\Services\Match;

use App\Data\Match\CreateMatchData;
use App\Data\Match\UpdateMatchData;
use App\Models\GameMatch;
use App\Repositories\Contracts\Competition\CompetitionRepositoryInterface;
use App\Repositories\Contracts\CompetitionGroup\CompetitionGroupRepositoryInterface;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use App\Repositories\Contracts\Team\TeamRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MatchService
{
    public function __construct(
        protected MatchRepositoryInterface $matchRepository,
        protected MatchLiveStatusService $liveStatusService,
        protected MatchStandingsService $standingsService,
        protected FixtureGeneratorService $fixtureGeneratorService,
        protected CompetitionRepositoryInterface $competitionRepository,
        protected CompetitionGroupRepositoryInterface $groupRepository,
        protected TeamRepositoryInterface $teamRepository
    ) {}

    public function all(): Collection
    {
        return $this->matchRepository->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->matchRepository->paginate($perPage);
    }

    public function getPaginatedMatches(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $this->liveStatusService->checkAndUpdateLiveStatuses();

        return $this->matchRepository->paginateWithFilters($filters, $perPage);
    }

    public function findOrFail(int $id): GameMatch
    {
        $match = $this->matchRepository->find($id);

        if (! $match) {
            throw new ModelNotFoundException('Match not found.');
        }

        return $match;
    }

    public function findWithRelations(int $id, array $relations = []): GameMatch
    {
        $match = $this->matchRepository->findWithRelations($id, $relations);

        if (! $match) {
            throw new ModelNotFoundException('Match not found.');
        }

        return $match;
    }

    public function getFormData(): array
    {
        return [
            'competitions' => $this->competitionRepository->allWithRelations(['groups', 'teams']),
            'groups' => $this->groupRepository->allWithRelations(['teams']),
            'teams' => $this->teamRepository->all(),
        ];
    }

    public function getFilterData(): array
    {
        return [
            'competitions' => $this->competitionRepository->all(),
            'groups' => $this->groupRepository->all(),
        ];
    }

    public function getShowDetails(int $id): array
    {
        $match = $this->findWithRelations($id, ['competition', 'group', 'homeTeam', 'awayTeam', 'winnerTeam']);
        $elapsedMinutes = $this->liveStatusService->getElapsedMinutes($match);

        return compact('match', 'elapsedMinutes');
    }

    public function store(CreateMatchData $data): GameMatch
    {
        return $this->matchRepository->create($data);
    }

    public function generateFixtures(int $groupId): Collection
    {
        $group = $this->groupRepository->find($groupId);

        if (! $group) {
            throw new ModelNotFoundException('Group not found.');
        }

        return $this->fixtureGeneratorService->generateGroupFixtures($group);
    }

    public function updateMatch(int $id, UpdateMatchData $data): GameMatch
    {
        $match = $this->findOrFail($id);
        $updatePayload = array_filter($data->toArray(), fn ($value) => $value !== null);

        if (isset($updatePayload['status'])) {
            if ($updatePayload['status'] === 'live' && $match->status !== 'live') {
                $now = now()->toDateTimeString();
                $updatePayload['scheduled_at'] = $now;
                $updatePayload['started_at'] = $now;
            }

            if ($updatePayload['status'] === 'finished') {
                $homeScore = $updatePayload['home_score'] ?? $match->home_score;
                $awayScore = $updatePayload['away_score'] ?? $match->away_score;

                if ($homeScore > $awayScore) {
                    $updatePayload['winner_team_id'] = $match->home_team_id;
                } elseif ($awayScore > $homeScore) {
                    $updatePayload['winner_team_id'] = $match->away_team_id;
                } else {
                    $updatePayload['winner_team_id'] = null;
                }
                $updatePayload['ended_at'] = now()->toDateTimeString();
            }
        }

        $updatedMatch = $this->matchRepository->update($match, $updatePayload);

        if ($updatedMatch->group) {
            $this->standingsService->recalculateGroupStandings($updatedMatch->group);
        }
        if ($updatedMatch->competition) {
            $this->standingsService->recalculateTeamStatistics($updatedMatch->competition);
        }

        if ($updatedMatch->status === 'finished') {
            $this->standingsService->advanceKnockoutWinner($updatedMatch);
        }

        return $updatedMatch;
    }

    public function destroyMatch(int $id): bool
    {
        $match = $this->findOrFail($id);
        $group = $match->group;
        $competition = $match->competition;

        $deleted = $this->matchRepository->delete($match);

        if ($group) {
            $this->standingsService->recalculateGroupStandings($group);
        }
        if ($competition) {
            $this->standingsService->recalculateTeamStatistics($competition);
        }

        return $deleted;
    }

    public function getLiveCenterMatches(): Collection
    {
        $this->liveStatusService->checkAndUpdateLiveStatuses();

        return $this->matchRepository->getLiveAndScheduledMatches();
    }

    public function updateScore(int $id, string $action): GameMatch
    {
        $match = $this->findOrFail($id);

        if ($action === 'start_live') {
            $now = now();
            $this->matchRepository->update($match, [
                'status' => 'live',
                'scheduled_at' => $now,
                'started_at' => $now,
            ]);
            $this->liveStatusService->sendLiveNotification($match);
        } elseif ($action === 'increment_home') {
            $this->matchRepository->incrementScore($match, 'home_score');
        } elseif ($action === 'decrement_home' && $match->home_score > 0) {
            $this->matchRepository->decrementScore($match, 'home_score');
        } elseif ($action === 'increment_away') {
            $this->matchRepository->incrementScore($match, 'away_score');
        } elseif ($action === 'decrement_away' && $match->away_score > 0) {
            $match = $this->matchRepository->decrementScore($match, 'away_score');
        } elseif ($action === 'finish_match') {
            $winnerId = null;
            if ($match->home_score > $match->away_score) {
                $winnerId = $match->home_team_id;
            } elseif ($match->away_score > $match->home_score) {
                $winnerId = $match->away_team_id;
            }

            $startedAt = $match->started_at ?? $match->scheduled_at ?? now();

            $this->matchRepository->update($match, [
                'status' => 'finished',
                'winner_team_id' => $winnerId,
                'started_at' => $startedAt,
                'ended_at' => now(),
            ]);

            if ($match->group) {
                $this->standingsService->recalculateGroupStandings($match->group);
            }
            if ($match->competition) {
                $this->standingsService->recalculateTeamStatistics($match->competition);
            }

            $this->standingsService->advanceKnockoutWinner($match);
        }

        return $match->fresh();
    }
}
