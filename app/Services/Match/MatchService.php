<?php

namespace App\Services\Match;

use App\Data\Match\CreateMatchData;
use App\Data\Match\UpdateMatchData;
use App\Models\GameMatch;
use App\Repositories\Contracts\Competition\CompetitionRepositoryInterface;
use App\Repositories\Contracts\CompetitionGroup\CompetitionGroupRepositoryInterface;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use App\Repositories\Contracts\Team\TeamRepositoryInterface;
use App\Utility\ActivityLogger;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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


    //  All Of matches
    public function all(): Collection
    {
        return $this->matchRepository->all();
    }

    // Paginate matches with optional filters
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->matchRepository->paginate($perPage);
    }


    // Paginate matches with filters and update live statuses
    public function getPaginatedMatches(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $this->liveStatusService->checkAndUpdateLiveStatuses();

        return $this->matchRepository->paginateWithFilters($filters, $perPage);
    }


    // Get match by ID or throw exception if not found
    public function findOrFail(int $id): GameMatch
    {
        $match = $this->matchRepository->find($id);

        if (! $match) {
            throw new ModelNotFoundException('Match not found.');
        }

        return $match;
    }


    // Get match with relations by ID or throw exception if not found

    public function findWithRelations(int $id, array $relations = []): GameMatch
    {
        $match = $this->matchRepository->findWithRelations($id, $relations);

        if (! $match) {
            throw new ModelNotFoundException('Match not found.');
        }

        return $match;
    }

    // Get match details for show view

    public function getFormData(): array
    {
        return [
            'competitions' => $this->competitionRepository->allWithRelations(['groups', 'teams']),
            'groups' => $this->groupRepository->allWithRelations(['teams']),
            'teams' => $this->teamRepository->all(),
        ];
    }


    // Get filter data for matches
    public function getFilterData(): array
    {
        return [
            'competitions' => $this->competitionRepository->all(),
            'groups' => $this->groupRepository->all(),
        ];
    }


    // Get match details for show view
    public function getShowDetails(int $id): array
    {
        $match = $this->findWithRelations($id, ['competition', 'group', 'homeTeam', 'awayTeam', 'winnerTeam']);
        $elapsedMinutes = $this->liveStatusService->getElapsedMinutes($match);

        return compact('match', 'elapsedMinutes');
    }

    // Store a new match
    public function store(CreateMatchData $data): GameMatch
    {
        $match = $this->matchRepository->create($data);

        if ($match->competition) {
            $this->standingsService->syncCompetitionDatesAndStatus($match->competition);
        }

        if ($match->status === 'live') {
            $this->liveStatusService->sendLiveNotification($match);
        }

        $fresh = $match->load(['homeTeam', 'awayTeam']);
        ActivityLogger::log(
            action: 'CREATED',
            entityType: 'GameMatch',
            entityId: $match->id,
            description: "Scheduled fixture #{$match->id}: '{$fresh->homeTeam?->name}' vs '{$fresh->awayTeam?->name}'."
        );

        return $match;
    }

    // Generate fixtures for a group in a competition
    public function generateFixtures(int $groupId): Collection
    {
        $group = $this->groupRepository->find($groupId);

        if (! $group) {
            throw new ModelNotFoundException('Group not found.');
        }

        $createdMatches = $this->fixtureGeneratorService->generateGroupFixtures($group);

        if ($group->competition) {
            $this->standingsService->syncCompetitionDatesAndStatus($group->competition);
        }

        ActivityLogger::log(
            action: 'CREATED',
            entityType: 'GameMatch',
            entityId: $group->id,
            description: "Generated {$createdMatches->count()} fixtures for group '{$group->name}'."
        );

        return $createdMatches;
    }

    // Update an existing match and recalculate standings if necessary
    public function updateMatch(int $id, UpdateMatchData $data): GameMatch
    {
        $match = $this->findOrFail($id);
        $wasLive = $match->status === 'live';
        $updatePayload = array_filter($data->toArray(), fn ($value) => $value !== null);

        if (isset($updatePayload['status'])) {
            if ($updatePayload['status'] === 'live' && ! $wasLive) {
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
            if ($updatedMatch->status === 'finished') {
                $this->standingsService->checkAndGenerateKnockoutFromGroups($updatedMatch->competition);
                $this->standingsService->advanceKnockoutWinner($updatedMatch);
            }
            $this->standingsService->syncCompetitionDatesAndStatus($updatedMatch->competition);
        }

        if ($updatedMatch->status === 'live' && ! $wasLive) {
            $this->liveStatusService->sendLiveNotification($updatedMatch);
        } elseif ($updatedMatch->status === 'finished') {
            \App\Jobs\Match\BroadcastMatchStatusJob::dispatch($updatedMatch);
        } elseif ($updatedMatch->status === 'live') {
            \App\Jobs\Match\BroadcastMatchScoreUpdateJob::dispatch($updatedMatch, 'score_update');
        }

        $fresh = $updatedMatch->load(['homeTeam', 'awayTeam']);
        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'GameMatch',
            entityId: $updatedMatch->id,
            description: "Updated match #{$updatedMatch->id} ('{$fresh->homeTeam?->name}' vs '{$fresh->awayTeam?->name}') - Status: {$updatedMatch->status} ({$updatedMatch->home_score}-{$updatedMatch->away_score})."
        );

        return $updatedMatch;
    }

    // Delete a match and recalculate standings if necessary
    public function destroyMatch(int $id): bool
    {
        $match = $this->findOrFail($id);
        $group = $match->group;
        $competition = $match->competition;
        $matchId = $match->id;

        $deleted = $this->matchRepository->delete($match);

        if ($group) {
            $this->standingsService->recalculateGroupStandings($group);
        }
        if ($competition) {
            $this->standingsService->recalculateTeamStatistics($competition);
            $this->standingsService->syncCompetitionDatesAndStatus($competition);
        }

        if ($deleted) {
            ActivityLogger::log(
                action: 'DELETED',
                entityType: 'GameMatch',
                entityId: $matchId,
                description: "Deleted match #{$matchId}."
            );
        }

        return $deleted;
    }

    // Get live and scheduled matches for the live center view
    public function getLiveCenterMatches(): Collection
    {
        $this->liveStatusService->checkAndUpdateLiveStatuses();

        return $this->matchRepository->getLiveAndScheduledMatches();
    }

    // Update match score and handle live status changes
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
            $freshMatch = $match->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
            $this->liveStatusService->sendLiveNotification($freshMatch);
            if ($match->competition) {
                $this->standingsService->syncCompetitionDatesAndStatus($match->competition);
            }

            return $freshMatch;
        }

        if ($action === 'increment_home') {
            $this->matchRepository->incrementScore($match, 'home_score');
            $freshMatch = $match->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
            \App\Jobs\Match\BroadcastMatchScoreUpdateJob::dispatch($freshMatch, $action);

            return $freshMatch;
        }

        if ($action === 'decrement_home' && $match->home_score > 0) {
            $this->matchRepository->decrementScore($match, 'home_score');
            $freshMatch = $match->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
            \App\Jobs\Match\BroadcastMatchScoreUpdateJob::dispatch($freshMatch, $action);

            return $freshMatch;
        }

        if ($action === 'increment_away') {
            $this->matchRepository->incrementScore($match, 'away_score');
            $freshMatch = $match->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
            \App\Jobs\Match\BroadcastMatchScoreUpdateJob::dispatch($freshMatch, $action);

            return $freshMatch;
        }

        if ($action === 'decrement_away' && $match->away_score > 0) {
            $this->matchRepository->decrementScore($match, 'away_score');
            $freshMatch = $match->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
            \App\Jobs\Match\BroadcastMatchScoreUpdateJob::dispatch($freshMatch, $action);

            return $freshMatch;
        }

        if ($action === 'finish_match') {
            $winnerId = null;
            if ($match->home_score > $match->away_score) {
                $winnerId = $match->home_team_id;
            } elseif ($match->away_score > $match->home_score) {
                $winnerId = $match->away_team_id;
            }

            $startedAt = $match->started_at ?? $match->scheduled_at ?? now();

            $updated = $this->matchRepository->update($match, [
                'status' => 'finished',
                'winner_team_id' => $winnerId,
                'started_at' => $startedAt,
                'ended_at' => now(),
            ]);

            if ($updated->group) {
                $this->standingsService->recalculateGroupStandings($updated->group);
            }
            if ($updated->competition) {
                $this->standingsService->recalculateTeamStatistics($updated->competition);
                $this->standingsService->checkAndGenerateKnockoutFromGroups($updated->competition);
                $this->standingsService->advanceKnockoutWinner($updated);
                $this->standingsService->syncCompetitionDatesAndStatus($updated->competition);
            }

            $freshMatch = $match->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
            \App\Jobs\Match\BroadcastMatchStatusJob::dispatch($freshMatch);

            ActivityLogger::log(
                action: 'UPDATED',
                entityType: 'GameMatch',
                entityId: $freshMatch->id,
                description: "Finalized match #{$freshMatch->id}: '{$freshMatch->homeTeam?->name}' {$freshMatch->home_score} - {$freshMatch->away_score} '{$freshMatch->awayTeam?->name}'."
            );

            return $freshMatch;
        }

        return $match->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
    }


    // Get groups by competition ID

    public function getGroupsByCompetition(int $competitionId): Collection
    {
        return $this->groupRepository->getGroupsByCompetitionId($competitionId);
    }

    // Get teams by group ID

    public function getTeamsByGroup(int $groupId): Collection
    {
        return $this->groupRepository->getTeamsByGroupId($groupId);
    }

    // Get teams by competition ID

    public function getTeamsByCompetition(int $competitionId): Collection
    {
        return $this->competitionRepository->getTeamsByCompetitionId($competitionId);
    }
}

