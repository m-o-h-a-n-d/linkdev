<?php

namespace App\Services\Match;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use App\Models\GameMatch;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use App\Repositories\Contracts\Standing\GroupStandingRepositoryInterface;
use App\Repositories\Contracts\Standing\TeamStatisticRepositoryInterface;
use Illuminate\Support\Facades\DB;

class MatchStandingsService
{
    public function __construct(
        protected MatchRepositoryInterface $matchRepository,
        protected GroupStandingRepositoryInterface $groupStandingRepository,
        protected TeamStatisticRepositoryInterface $teamStatisticRepository
    ) {}

    /**
     * Recalculate group standings for a given group based on finished matches.
     */
    public function recalculateGroupStandings(CompetitionGroup $group): void
    {
        // Fetch all teams assigned to this group
        $teams = $group->teams;

        if ($teams->isEmpty()) {
            return;
        }

        // Fetch finished matches for this group via repository
        $finishedMatches = $this->matchRepository->getFinishedMatchesByGroup($group->id);

        $stats = [];

        foreach ($teams as $team) {
            $stats[$team->id] = [
                'group_id' => $group->id,
                'team_id' => $team->id,
                'played' => 0,
                'won' => 0,
                'draw' => 0,
                'lost' => 0,
                'goals_for' => 0,
                'goals_against' => 0,
                'goal_difference' => 0,
                'points' => 0,
            ];
        }

        foreach ($finishedMatches as $match) {
            $homeId = $match->home_team_id;
            $awayId = $match->away_team_id;

            if (! isset($stats[$homeId])) {
                $stats[$homeId] = [
                    'group_id' => $group->id,
                    'team_id' => $homeId,
                    'played' => 0,
                    'won' => 0,
                    'draw' => 0,
                    'lost' => 0,
                    'goals_for' => 0,
                    'goals_against' => 0,
                    'goal_difference' => 0,
                    'points' => 0,
                ];
            }

            if (! isset($stats[$awayId])) {
                $stats[$awayId] = [
                    'group_id' => $group->id,
                    'team_id' => $awayId,
                    'played' => 0,
                    'won' => 0,
                    'draw' => 0,
                    'lost' => 0,
                    'goals_for' => 0,
                    'goals_against' => 0,
                    'goal_difference' => 0,
                    'points' => 0,
                ];
            }

            // Home Stats
            $stats[$homeId]['played'] += 1;
            $stats[$homeId]['goals_for'] += $match->home_score;
            $stats[$homeId]['goals_against'] += $match->away_score;

            // Away Stats
            $stats[$awayId]['played'] += 1;
            $stats[$awayId]['goals_for'] += $match->away_score;
            $stats[$awayId]['goals_against'] += $match->home_score;

            // Outcome (Handball: Win = 2 pts, Draw = 1 pt, Loss = 0 pts)
            if ($match->home_score > $match->away_score) {
                $stats[$homeId]['won'] += 1;
                $stats[$homeId]['points'] += 2;

                $stats[$awayId]['lost'] += 1;
            } elseif ($match->away_score > $match->home_score) {
                $stats[$awayId]['won'] += 1;
                $stats[$awayId]['points'] += 2;

                $stats[$homeId]['lost'] += 1;
            } else {
                $stats[$homeId]['draw'] += 1;
                $stats[$homeId]['points'] += 1;

                $stats[$awayId]['draw'] += 1;
                $stats[$awayId]['points'] += 1;
            }
        }

        // Calculate Goal Difference & Sort Teams
        foreach ($stats as $teamId => &$data) {
            $data['goal_difference'] = $data['goals_for'] - $data['goals_against'];
        }
        unset($data);

        // Sort by Points DESC, Goal Difference DESC, Goals For DESC
        uasort($stats, function ($a, $b) {
            if ($a['points'] !== $b['points']) {
                return ($b['points'] > $a['points']) ? 1 : -1;
            }
            if ($a['goal_difference'] !== $b['goal_difference']) {
                return ($b['goal_difference'] > $a['goal_difference']) ? 1 : -1;
            }
            if ($a['goals_for'] !== $b['goals_for']) {
                return ($b['goals_for'] > $a['goals_for']) ? 1 : -1;
            }
            return 0;
        });

        // Save / Update Group Standings with Rank via repository
        DB::transaction(function () use ($group, $stats) {
            $rank = 1;
            foreach ($stats as $teamId => $data) {
                $this->groupStandingRepository->updateOrCreate(
                    [
                        'group_id' => $group->id,
                        'team_id' => $teamId,
                    ],
                    [
                        'played' => $data['played'],
                        'won' => $data['won'],
                        'draw' => $data['draw'],
                        'lost' => $data['lost'],
                        'goals_for' => $data['goals_for'],
                        'goals_against' => $data['goals_against'],
                        'goal_difference' => $data['goal_difference'],
                        'points' => $data['points'],
                        'position_rank' => $rank++,
                    ]
                );
            }
        });
    }

    /**
     * Recalculate overall team statistics for a competition.
     */
    public function recalculateTeamStatistics(Competition $competition): void
    {
        // Fetch finished matches for this competition via repository
        $finishedMatches = $this->matchRepository->getFinishedMatchesByCompetition($competition->id);

        $stats = [];

        foreach ($competition->teams as $team) {
            $stats[$team->id] = [
                'team_id' => $team->id,
                'competition_id' => $competition->id,
                'matches_played' => 0,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'goals_for' => 0,
                'goals_against' => 0,
                'goal_difference' => 0,
                'points' => 0,
            ];
        }

        foreach ($finishedMatches as $match) {
            $homeId = $match->home_team_id;
            $awayId = $match->away_team_id;

            foreach ([$homeId, $awayId] as $id) {
                if (! isset($stats[$id])) {
                    $stats[$id] = [
                        'team_id' => $id,
                        'competition_id' => $competition->id,
                        'matches_played' => 0,
                        'wins' => 0,
                        'draws' => 0,
                        'losses' => 0,
                        'goals_for' => 0,
                        'goals_against' => 0,
                        'goal_difference' => 0,
                        'points' => 0,
                    ];
                }
            }

            $stats[$homeId]['matches_played'] += 1;
            $stats[$homeId]['goals_for'] += $match->home_score;
            $stats[$homeId]['goals_against'] += $match->away_score;

            $stats[$awayId]['matches_played'] += 1;
            $stats[$awayId]['goals_for'] += $match->away_score;
            $stats[$awayId]['goals_against'] += $match->home_score;

            if ($match->home_score > $match->away_score) {
                $stats[$homeId]['wins'] += 1;
                $stats[$homeId]['points'] += 2;
                $stats[$awayId]['losses'] += 1;
            } elseif ($match->away_score > $match->home_score) {
                $stats[$awayId]['wins'] += 1;
                $stats[$awayId]['points'] += 2;
                $stats[$homeId]['losses'] += 1;
            } else {
                $stats[$homeId]['draws'] += 1;
                $stats[$homeId]['points'] += 1;
                $stats[$awayId]['draws'] += 1;
                $stats[$awayId]['points'] += 1;
            }
        }

        foreach ($stats as $teamId => &$data) {
            $data['goal_difference'] = $data['goals_for'] - $data['goals_against'];
        }
        unset($data);

        // Update / create team statistics via repository
        DB::transaction(function () use ($competition, $stats) {
            foreach ($stats as $teamId => $data) {
                $this->teamStatisticRepository->updateOrCreate(
                    [
                        'team_id' => $teamId,
                        'competition_id' => $competition->id,
                    ],
                    $data
                );
            }
        });
    }

    /**
     * Advance winning team in knockout round matches (e.g. from Semi-Finals to Final).
     */
    public function advanceKnockoutWinner(GameMatch $match): void
    {
        if ($match->status !== 'finished' || ! $match->winner_team_id || $match->group_id !== null) {
            return;
        }

        $competition = $match->competition ?? Competition::find($match->competition_id);
        if (! $competition) {
            return;
        }

        // Get all knockout matches in this current round
        $currentRoundMatches = GameMatch::where('competition_id', $match->competition_id)
            ->whereNull('group_id')
            ->where('round_number', $match->round_number)
            ->get();

        // Check if there are 2 semi-final matches in this round and both finished
        if ($currentRoundMatches->count() === 2) {
            $finishedCount = $currentRoundMatches->where('status', 'finished')->count();

            if ($finishedCount === 2) {
                $finalRoundNumber = $match->round_number + 1;
                $existingFinal = GameMatch::where('competition_id', $match->competition_id)
                    ->whereNull('group_id')
                    ->where('round_number', $finalRoundNumber)
                    ->first();

                if (! $existingFinal) {
                    $winner1 = $currentRoundMatches[0]->winner_team_id;
                    $winner2 = $currentRoundMatches[1]->winner_team_id;

                    if ($winner1 && $winner2) {
                        $lastMatchDate = $currentRoundMatches->max('scheduled_at') ?? \Carbon\Carbon::now();
                        $finalDate = \Carbon\Carbon::parse($lastMatchDate)->addDays(3)->setHour(19)->setMinute(0);

                        $this->matchRepository->create([
                            'competition_id' => $competition->id,
                            'group_id' => null,
                            'home_team_id' => $winner1,
                            'away_team_id' => $winner2,
                            'scheduled_at' => $finalDate,
                            'status' => 'scheduled',
                            'home_score' => 0,
                            'away_score' => 0,
                            'round_number' => $finalRoundNumber,
                            'notes' => 'المباراة النهائية لحسم لقب البطولة 🏆',
                        ]);

                        $this->syncCompetitionDatesAndStatus($competition);
                    }
                }
            }
        }

        // If the match that just finished was the Final match (single match in round)
        if ($currentRoundMatches->count() === 1) {
            $competition->update([
                'winner_team_id' => $match->winner_team_id,
                'status' => 'completed',
            ]);
        }
    }

    /**
     * Check if all group stage matches are finished, and auto-generate the semi-finals / knockout stage.
     */
    public function checkAndGenerateKnockoutFromGroups(Competition $competition): void
    {
        // 1. Check if the competition has at least 2 groups
        $groups = $competition->groups()->with('standings')->get();

        if ($groups->count() < 2) {
            return;
        }

        // 2. Check if there are group matches and all of them are finished
        $groupMatches = $competition->matches()->whereNotNull('group_id')->get();

        if ($groupMatches->isEmpty()) {
            return;
        }

        $unfinishedGroupMatches = $groupMatches->where('status', '!=', 'finished');
        if ($unfinishedGroupMatches->isNotEmpty()) {
            return; // Group stage still in progress
        }

        // 3. Check if knockout matches already exist
        $existingKnockoutMatches = $competition->matches()->whereNull('group_id')->get();
        if ($existingKnockoutMatches->isNotEmpty()) {
            return; // Knockout already generated
        }

        // 4. Get top 2 teams from each group
        $groupA = $groups[0];
        $groupB = $groups[1];

        $teamA1 = $groupA->standings()->where('position_rank', 1)->first()?->team_id;
        $teamA2 = $groupA->standings()->where('position_rank', 2)->first()?->team_id;

        $teamB1 = $groupB->standings()->where('position_rank', 1)->first()?->team_id;
        $teamB2 = $groupB->standings()->where('position_rank', 2)->first()?->team_id;

        if (! $teamA1 || ! $teamA2 || ! $teamB1 || ! $teamB2) {
            return;
        }

        $lastGroupDate = $groupMatches->max('scheduled_at') ?? \Carbon\Carbon::now();
        $semiDate = \Carbon\Carbon::parse($lastGroupDate)->addDays(2)->setHour(17)->setMinute(0);
        $semiRoundNumber = ($groupMatches->max('round_number') ?? 1) + 1;

        // Semi-Final 1: 1st Group A vs 2nd Group B
        $this->matchRepository->create([
            'competition_id' => $competition->id,
            'group_id' => null,
            'home_team_id' => $teamA1,
            'away_team_id' => $teamB2,
            'scheduled_at' => $semiDate->copy(),
            'status' => 'scheduled',
            'home_score' => 0,
            'away_score' => 0,
            'round_number' => $semiRoundNumber,
            'notes' => 'نصف النهائي 1: متصدر المجموعة A ضد وصيف المجموعة B',
        ]);

        // Semi-Final 2: 1st Group B vs 2nd Group A
        $this->matchRepository->create([
            'competition_id' => $competition->id,
            'group_id' => null,
            'home_team_id' => $teamB1,
            'away_team_id' => $teamA2,
            'scheduled_at' => $semiDate->copy()->addHours(3),
            'status' => 'scheduled',
            'home_score' => 0,
            'away_score' => 0,
            'round_number' => $semiRoundNumber,
            'notes' => 'نصف النهائي 2: متصدر المجموعة B ضد وصيف المجموعة A',
        ]);

        $this->syncCompetitionDatesAndStatus($competition);
    }

    /**
     * Synchronize competition start_date, end_date, and status based on its matches.
     */
    public function syncCompetitionDatesAndStatus(Competition $competition): void
    {
        $matches = $competition->matches()->get();

        if ($matches->isEmpty()) {
            return;
        }

        $minDate = $matches->min('scheduled_at');
        $maxDate = $matches->max('scheduled_at');

        $updates = [];

        if ($minDate) {
            $updates['start_date'] = \Carbon\Carbon::parse($minDate)->toDateString();
        }

        if ($maxDate) {
            $updates['end_date'] = \Carbon\Carbon::parse($maxDate)->toDateString();
        }

        $totalMatches = $matches->count();
        $finishedMatches = $matches->where('status', 'finished')->count();
        $liveMatches = $matches->where('status', 'live')->count();

        if ($finishedMatches === $totalMatches && $totalMatches > 0) {
            $updates['status'] = 'completed';

            // Auto-assign competition winner if not set
            if (! $competition->winner_team_id) {
                $topStatistic = $competition->statistics()->orderBy('points', 'desc')->orderBy('goal_difference', 'desc')->first();
                if ($topStatistic) {
                    $updates['winner_team_id'] = $topStatistic->team_id;
                }
            }
        } elseif ($liveMatches > 0 || $finishedMatches > 0) {
            $updates['status'] = 'ongoing';
        } elseif ($competition->status !== 'cancelled') {
            $now = \Carbon\Carbon::now();
            if ($minDate && \Carbon\Carbon::parse($minDate)->isPast() && $maxDate && \Carbon\Carbon::parse($maxDate)->isFuture()) {
                $updates['status'] = 'ongoing';
            } else {
                $updates['status'] = 'upcoming';
            }
        }

        if (! empty($updates)) {
            $competition->update($updates);
        }
    }
}
