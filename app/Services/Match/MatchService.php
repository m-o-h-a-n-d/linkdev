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
use Illuminate\Support\Facades\DB;

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

    // All matches
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

    // Get form data for matches
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
        $match = DB::transaction(function () use ($data) {
            $created = $this->matchRepository->create($data);

            if ($created->competition) {
                $this->standingsService->syncCompetitionDatesAndStatus($created->competition);
            }

            return $created;
        });

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
    public function generateFixtures(int $groupId, ?\Carbon\Carbon $startDate = null): Collection
    {
        $group = $this->groupRepository->find($groupId);

        if (! $group) {
            throw new ModelNotFoundException('Group not found.');
        }

        $createdMatches = DB::transaction(function () use ($group, $startDate) {
            $existingMatches = $group->matches;

            if ($existingMatches->isNotEmpty()) {
                $hasActiveOrFinished = $existingMatches->contains(function ($match) {
                    return in_array($match->status, ['live', 'finished']);
                });

                if ($hasActiveOrFinished) {
                    throw new \DomainException('لا يمكن إعادة توليد جدول المباريات: توجد مباريات بدأت بالفعل أو انتهت في هذه المجموعة.');
                }

                // Delete previous unplayed scheduled fixtures before regenerating to avoid duplicates
                foreach ($existingMatches as $match) {
                    $this->matchRepository->delete($match);
                }
            }

            $matches = $this->fixtureGeneratorService->generateGroupFixtures($group, $startDate);

            if ($group->competition) {
                $this->standingsService->syncCompetitionDatesAndStatus($group->competition);
            }

            return $matches;
        });

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

        $isKnockout = $match->group_id === null;

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
                    // Score is tied
                    if ($isKnockout) {
                        $winnerId = $updatePayload['winner_team_id'] ?? $match->winner_team_id;
                        if (! $winnerId) {
                            throw new \DomainException('مباريات الأدوار الإقصائية لا يمكن أن تنتهي بالتعادل. يرجى تحديد الفريق الفائز (بركلات الترجيح / الأشواط الإضافية).');
                        }
                        $updatePayload['winner_team_id'] = $winnerId;
                    } else {
                        $updatePayload['winner_team_id'] = null;
                    }
                }
                $updatePayload['ended_at'] = now()->toDateTimeString();
            }
        }

        $updatedMatch = DB::transaction(function () use ($match, $updatePayload) {
            $updated = $this->matchRepository->update($match, $updatePayload);

            if ($updated->group) {
                $this->standingsService->recalculateGroupStandings($updated->group);
            }
            if ($updated->competition) {
                $this->standingsService->recalculateTeamStatistics($updated->competition);
                if ($updated->status === 'finished') {
                    $this->standingsService->checkAndGenerateKnockoutFromGroups($updated->competition);
                    $this->standingsService->advanceKnockoutWinner($updated);
                }
                $this->standingsService->syncCompetitionDatesAndStatus($updated->competition);
            }

            return $updated;
        });

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

        $deleted = DB::transaction(function () use ($match, $group, $competition) {
            $del = $this->matchRepository->delete($match);

            if ($group) {
                $this->standingsService->recalculateGroupStandings($group);
            }
            if ($competition) {
                $this->standingsService->recalculateTeamStatistics($competition);
                $this->standingsService->syncCompetitionDatesAndStatus($competition);
            }

            return $del;
        });

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
    public function updateScore(int $id, string $action, ?int $designatedWinnerId = null): GameMatch
    {
        $match = $this->findOrFail($id);

        if ($action === 'start_live') {
            $now = now();
            DB::transaction(function () use ($match, $now) {
                $this->matchRepository->update($match, [
                    'status' => 'live',
                    'scheduled_at' => $now,
                    'started_at' => $now,
                ]);
                if ($match->competition) {
                    $this->standingsService->syncCompetitionDatesAndStatus($match->competition);
                }
            });

            $freshMatch = $match->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
            $this->liveStatusService->sendLiveNotification($freshMatch);

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
            $isKnockout = $match->group_id === null;
            $winnerId = null;

            if ($match->home_score > $match->away_score) {
                $winnerId = $match->home_team_id;
            } elseif ($match->away_score > $match->home_score) {
                $winnerId = $match->away_team_id;
            } else {
                if ($isKnockout) {
                    $winnerId = $designatedWinnerId ?? $match->winner_team_id;
                    if (! $winnerId) {
                        throw new \DomainException('لا يمكن إنهاء مباراة في الأدوار الإقصائية بنتيجة تعادل (' . $match->home_score . ' - ' . $match->away_score . '). مباريات خروج المغلوب تتطلب فائزاً لحسم التأهل.');
                    }
                }
            }

            $startedAt = $match->started_at ?? $match->scheduled_at ?? now();

            $updated = DB::transaction(function () use ($match, $winnerId, $startedAt) {
                $updatedMatch = $this->matchRepository->update($match, [
                    'status' => 'finished',
                    'winner_team_id' => $winnerId,
                    'started_at' => $startedAt,
                    'ended_at' => now(),
                ]);

                if ($updatedMatch->group) {
                    $this->standingsService->recalculateGroupStandings($updatedMatch->group);
                }
                if ($updatedMatch->competition) {
                    $this->standingsService->recalculateTeamStatistics($updatedMatch->competition);
                    $this->standingsService->checkAndGenerateKnockoutFromGroups($updatedMatch->competition);
                    $this->standingsService->advanceKnockoutWinner($updatedMatch);
                    $this->syncAndCheckCompetition($updatedMatch->competition);
                }

                return $updatedMatch;
            });

            $freshMatch = $updated->fresh(['homeTeam', 'awayTeam', 'competition', 'group']);
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

    protected function syncAndCheckCompetition($competition): void
    {
        $this->standingsService->syncCompetitionDatesAndStatus($competition);
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
