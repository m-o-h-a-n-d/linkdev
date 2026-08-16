<?php

namespace App\Services\Match;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use App\Models\GameMatch;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use App\Repositories\Contracts\Standing\GroupStandingRepositoryInterface;
use App\Repositories\Contracts\Standing\TeamStatisticRepositoryInterface;
use Carbon\Carbon;
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
     * Idempotent: completely reconstructs standings from finished matches.
     */
    public function recalculateGroupStandings(CompetitionGroup $group): void
    {
        $group->loadMissing('competition.settings', 'teams');
        $teams = $group->teams;

        if ($teams->isEmpty()) {
            return;
        }

        $competition = $group->competition ?? Competition::with('settings')->find($group->competition_id);
        $settings = $competition?->settings;

        $ptsWin = $settings && isset($settings->points_win) ? (int) $settings->points_win : 3;
        $ptsDraw = $settings && isset($settings->points_draw) ? (int) $settings->points_draw : 1;
        $ptsLoss = $settings && isset($settings->points_loss) ? (int) $settings->points_loss : 0;

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

            // Outcome with dynamic points
            if ($match->home_score > $match->away_score) {
                $stats[$homeId]['won'] += 1;
                $stats[$homeId]['points'] += $ptsWin;

                $stats[$awayId]['lost'] += 1;
                $stats[$awayId]['points'] += $ptsLoss;
            } elseif ($match->away_score > $match->home_score) {
                $stats[$awayId]['won'] += 1;
                $stats[$awayId]['points'] += $ptsWin;

                $stats[$homeId]['lost'] += 1;
                $stats[$homeId]['points'] += $ptsLoss;
            } else {
                $stats[$homeId]['draw'] += 1;
                $stats[$homeId]['points'] += $ptsDraw;

                $stats[$awayId]['draw'] += 1;
                $stats[$awayId]['points'] += $ptsDraw;
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

        // Save / Update Group Standings with Rank via repository in transaction
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
     * Idempotent: completely reconstructs stats from finished matches.
     */
    public function recalculateTeamStatistics(Competition $competition): void
    {
        $competition->loadMissing('settings', 'teams');
        $settings = $competition->settings;

        $ptsWin = $settings && isset($settings->points_win) ? (int) $settings->points_win : 3;
        $ptsDraw = $settings && isset($settings->points_draw) ? (int) $settings->points_draw : 1;
        $ptsLoss = $settings && isset($settings->points_loss) ? (int) $settings->points_loss : 0;

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
                $stats[$homeId]['points'] += $ptsWin;
                $stats[$awayId]['losses'] += 1;
                $stats[$awayId]['points'] += $ptsLoss;
            } elseif ($match->away_score > $match->home_score) {
                $stats[$awayId]['wins'] += 1;
                $stats[$awayId]['points'] += $ptsWin;
                $stats[$homeId]['losses'] += 1;
                $stats[$homeId]['points'] += $ptsLoss;
            } else {
                $stats[$homeId]['draws'] += 1;
                $stats[$homeId]['points'] += $ptsDraw;
                $stats[$awayId]['draws'] += 1;
                $stats[$awayId]['points'] += $ptsDraw;
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
     * Advance winning team in knockout round matches (e.g. from Quarter-Finals to Semi-Finals to Final).
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
            ->orderBy('id', 'asc')
            ->get();

        $totalInRound = $currentRoundMatches->count();
        $finishedMatches = $currentRoundMatches->where('status', 'finished');

        // Check if all matches in this round are completed with a designated winner
        if ($finishedMatches->count() === $totalInRound && $totalInRound > 0) {
            if ($totalInRound === 1) {
                // Final match completed: assign competition winner and complete competition
                $competition->update([
                    'winner_team_id' => $match->winner_team_id,
                    'status' => 'completed',
                ]);

                return;
            }

            // If multiple matches (e.g. 4 QF or 2 SF), advance winners to the next round
            $nextRoundNumber = $match->round_number + 1;
            $existingNextRound = GameMatch::where('competition_id', $match->competition_id)
                ->whereNull('group_id')
                ->where('round_number', $nextRoundNumber)
                ->first();

            if (! $existingNextRound) {
                $winners = $finishedMatches->pluck('winner_team_id')->filter()->values();

                if ($winners->count() === $totalInRound && $winners->count() % 2 === 0) {
                    $lastMatchDate = $currentRoundMatches->max('scheduled_at') ?? Carbon::now();
                    $nextRoundDate = Carbon::parse($lastMatchDate)->addDays(3)->setHour(17)->setMinute(0);

                    $numNextMatches = (int) ($winners->count() / 2);
                    for ($i = 0; $i < $numNextMatches; $i++) {
                        $homeWinner = $winners[$i * 2];
                        $awayWinner = $winners[$i * 2 + 1];

                        $note = match ($numNextMatches) {
                            1 => 'المباراة النهائية لحسم لقب البطولة 🏆',
                            2 => 'نصف النهائي ' . ($i + 1) . ' 🏆',
                            default => 'الدور الإقصائي التالي - مباراة ' . ($i + 1) . ' 🏆',
                        };

                        $this->matchRepository->create([
                            'competition_id' => $competition->id,
                            'group_id' => null,
                            'home_team_id' => $homeWinner,
                            'away_team_id' => $awayWinner,
                            'scheduled_at' => $nextRoundDate->copy()->addHours($i * 3),
                            'status' => 'scheduled',
                            'home_score' => 0,
                            'away_score' => 0,
                            'round_number' => $nextRoundNumber,
                            'notes' => $note,
                        ]);
                    }

                    $this->syncCompetitionDatesAndStatus($competition);
                }
            }
        }
    }

    /**
     * Check if all group stage matches are finished, and auto-generate the knockout stage.
     * Supports 1, 2, 4, or more groups.
     */
    public function checkAndGenerateKnockoutFromGroups(Competition $competition): void
    {
        $groups = $competition->groups()->with('standings')->orderBy('id', 'asc')->get();

        if ($groups->isEmpty()) {
            return;
        }

        // Check if there are group matches and all of them are finished
        $groupMatches = $competition->matches()->whereNotNull('group_id')->get();

        if ($groupMatches->isEmpty()) {
            return;
        }

        $unfinishedGroupMatches = $groupMatches->where('status', '!=', 'finished');
        if ($unfinishedGroupMatches->isNotEmpty()) {
            return; // Group stage still in progress
        }

        // Check if knockout matches already exist
        $existingKnockoutMatches = $competition->matches()->whereNull('group_id')->exists();
        if ($existingKnockoutMatches) {
            return; // Knockout already generated
        }

        $lastGroupDate = $groupMatches->max('scheduled_at') ?? Carbon::now();
        $knockoutDate = Carbon::parse($lastGroupDate)->addDays(2)->setHour(17)->setMinute(0);
        $knockoutRoundNumber = ($groupMatches->max('round_number') ?? 1) + 1;

        $numGroups = $groups->count();

        if ($numGroups === 1) {
            // Single group: Top 4 qualify for Semi-Finals, or Top 2 for Final
            $group = $groups->first();
            $rank1 = $group->standings()->where('position_rank', 1)->first()?->team_id;
            $rank2 = $group->standings()->where('position_rank', 2)->first()?->team_id;
            $rank3 = $group->standings()->where('position_rank', 3)->first()?->team_id;
            $rank4 = $group->standings()->where('position_rank', 4)->first()?->team_id;

            if ($rank1 && $rank2 && $rank3 && $rank4) {
                // Semi-Final 1: 1st vs 4th
                $this->matchRepository->create([
                    'competition_id' => $competition->id,
                    'group_id' => null,
                    'home_team_id' => $rank1,
                    'away_team_id' => $rank4,
                    'scheduled_at' => $knockoutDate->copy(),
                    'status' => 'scheduled',
                    'home_score' => 0,
                    'away_score' => 0,
                    'round_number' => $knockoutRoundNumber,
                    'notes' => 'نصف النهائي 1: الأول ضد الرابع 🏆',
                ]);

                // Semi-Final 2: 2nd vs 3rd
                $this->matchRepository->create([
                    'competition_id' => $competition->id,
                    'group_id' => null,
                    'home_team_id' => $rank2,
                    'away_team_id' => $rank3,
                    'scheduled_at' => $knockoutDate->copy()->addHours(3),
                    'status' => 'scheduled',
                    'home_score' => 0,
                    'away_score' => 0,
                    'round_number' => $knockoutRoundNumber,
                    'notes' => 'نصف النهائي 2: الثاني ضد الثالث 🏆',
                ]);
            } elseif ($rank1 && $rank2) {
                // Direct Final: 1st vs 2nd
                $this->matchRepository->create([
                    'competition_id' => $competition->id,
                    'group_id' => null,
                    'home_team_id' => $rank1,
                    'away_team_id' => $rank2,
                    'scheduled_at' => $knockoutDate->copy(),
                    'status' => 'scheduled',
                    'home_score' => 0,
                    'away_score' => 0,
                    'round_number' => $knockoutRoundNumber,
                    'notes' => 'المباراة النهائية لحسم لقب البطولة 🏆',
                ]);
            }
        } elseif ($numGroups === 2) {
            // Standard 2 Groups: 1st Group A vs 2nd Group B, 1st Group B vs 2nd Group A
            $groupA = $groups[0];
            $groupB = $groups[1];

            $teamA1 = $groupA->standings()->where('position_rank', 1)->first()?->team_id;
            $teamA2 = $groupA->standings()->where('position_rank', 2)->first()?->team_id;

            $teamB1 = $groupB->standings()->where('position_rank', 1)->first()?->team_id;
            $teamB2 = $groupB->standings()->where('position_rank', 2)->first()?->team_id;

            if (! $teamA1 || ! $teamA2 || ! $teamB1 || ! $teamB2) {
                return;
            }

            // Semi-Final 1: 1A vs 2B
            $this->matchRepository->create([
                'competition_id' => $competition->id,
                'group_id' => null,
                'home_team_id' => $teamA1,
                'away_team_id' => $teamB2,
                'scheduled_at' => $knockoutDate->copy(),
                'status' => 'scheduled',
                'home_score' => 0,
                'away_score' => 0,
                'round_number' => $knockoutRoundNumber,
                'notes' => "نصف النهائي 1: متصدر {$groupA->name} ضد وصيف {$groupB->name} 🏆",
            ]);

            // Semi-Final 2: 1B vs 2A
            $this->matchRepository->create([
                'competition_id' => $competition->id,
                'group_id' => null,
                'home_team_id' => $teamB1,
                'away_team_id' => $teamA2,
                'scheduled_at' => $knockoutDate->copy()->addHours(3),
                'status' => 'scheduled',
                'home_score' => 0,
                'away_score' => 0,
                'round_number' => $knockoutRoundNumber,
                'notes' => "نصف النهائي 2: متصدر {$groupB->name} ضد وصيف {$groupA->name} 🏆",
            ]);
        } elseif ($numGroups === 4) {
            // 4 Groups: Quarter Finals
            // QF1: 1A vs 2B, QF2: 1C vs 2D, QF3: 1B vs 2A, QF4: 1D vs 2C
            $gA = $groups[0];
            $gB = $groups[1];
            $gC = $groups[2];
            $gD = $groups[3];

            $pairs = [
                [$gA, 1, $gB, 2, 'ربع النهائي 1'],
                [$gC, 1, $gD, 2, 'ربع النهائي 2'],
                [$gB, 1, $gA, 2, 'ربع النهائي 3'],
                [$gD, 1, $gC, 2, 'ربع النهائي 4'],
            ];

            $hourOffset = 0;
            foreach ($pairs as [$gHome, $rankHome, $gAway, $rankAway, $label]) {
                $homeId = $gHome->standings()->where('position_rank', $rankHome)->first()?->team_id;
                $awayId = $gAway->standings()->where('position_rank', $rankAway)->first()?->team_id;

                if ($homeId && $awayId) {
                    $this->matchRepository->create([
                        'competition_id' => $competition->id,
                        'group_id' => null,
                        'home_team_id' => $homeId,
                        'away_team_id' => $awayId,
                        'scheduled_at' => $knockoutDate->copy()->addHours($hourOffset),
                        'status' => 'scheduled',
                        'home_score' => 0,
                        'away_score' => 0,
                        'round_number' => $knockoutRoundNumber,
                        'notes' => "{$label}: متصدر {$gHome->name} ضد وصيف {$gAway->name} 🏆",
                    ]);
                    $hourOffset += 2;
                }
            }
        } else {
            // Generic even number of groups: Cross-group pairing
            for ($i = 0; $i < $numGroups; $i += 2) {
                if (! isset($groups[$i + 1])) {
                    break;
                }
                $g1 = $groups[$i];
                $g2 = $groups[$i + 1];

                $t1_1 = $g1->standings()->where('position_rank', 1)->first()?->team_id;
                $t1_2 = $g1->standings()->where('position_rank', 2)->first()?->team_id;
                $t2_1 = $g2->standings()->where('position_rank', 1)->first()?->team_id;
                $t2_2 = $g2->standings()->where('position_rank', 2)->first()?->team_id;

                if ($t1_1 && $t2_2) {
                    $this->matchRepository->create([
                        'competition_id' => $competition->id,
                        'group_id' => null,
                        'home_team_id' => $t1_1,
                        'away_team_id' => $t2_2,
                        'scheduled_at' => $knockoutDate->copy()->addHours($i * 2),
                        'status' => 'scheduled',
                        'home_score' => 0,
                        'away_score' => 0,
                        'round_number' => $knockoutRoundNumber,
                        'notes' => "مباراة إقصائية: متصدر {$g1->name} ضد وصيف {$g2->name} 🏆",
                    ]);
                }

                if ($t2_1 && $t1_2) {
                    $this->matchRepository->create([
                        'competition_id' => $competition->id,
                        'group_id' => null,
                        'home_team_id' => $t2_1,
                        'away_team_id' => $t1_2,
                        'scheduled_at' => $knockoutDate->copy()->addHours(($i + 1) * 2),
                        'status' => 'scheduled',
                        'home_score' => 0,
                        'away_score' => 0,
                        'round_number' => $knockoutRoundNumber,
                        'notes' => "مباراة إقصائية: متصدر {$g2->name} ضد وصيف {$g1->name} 🏆",
                    ]);
                }
            }
        }

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
            $updates['start_date'] = Carbon::parse($minDate)->toDateString();
        }

        if ($maxDate) {
            $updates['end_date'] = Carbon::parse($maxDate)->toDateString();
        }

        $totalMatches = $matches->count();
        $finishedMatches = $matches->where('status', 'finished')->count();
        $liveMatches = $matches->where('status', 'live')->count();

        if ($finishedMatches === $totalMatches && $totalMatches > 0) {
            $updates['status'] = 'completed';

            // Auto-assign competition winner if not set
            if (! $competition->winner_team_id) {
                // If there is a final knockout match, its winner is the champion
                $finalKnockout = $matches->whereNull('group_id')->sortByDesc('round_number')->first();
                if ($finalKnockout && $finalKnockout->winner_team_id) {
                    $updates['winner_team_id'] = $finalKnockout->winner_team_id;
                } else {
                    $topStatistic = $competition->statistics()->orderBy('points', 'desc')->orderBy('goal_difference', 'desc')->first();
                    if ($topStatistic) {
                        $updates['winner_team_id'] = $topStatistic->team_id;
                    }
                }
            }
        } elseif ($liveMatches > 0 || $finishedMatches > 0) {
            $updates['status'] = 'ongoing';
        } elseif ($competition->status !== 'cancelled') {
            $now = Carbon::now();
            if ($minDate && Carbon::parse($minDate)->isPast() && $maxDate && Carbon::parse($maxDate)->isFuture()) {
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
