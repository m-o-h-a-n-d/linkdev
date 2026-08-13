<?php

namespace App\Services\Match;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use App\Models\GameMatch;
use App\Models\GroupStanding;
use App\Models\TeamStatistic;
use Illuminate\Support\Facades\DB;

class MatchStandingsService
{
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

        // Fetch finished matches for this group
        $finishedMatches = GameMatch::where('group_id', $group->id)
            ->where('status', 'finished')
            ->get();

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

        // Save / Update Group Standings with Rank
        DB::transaction(function () use ($group, $stats) {
            $rank = 1;
            foreach ($stats as $teamId => $data) {
                GroupStanding::updateOrCreate(
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
        $finishedMatches = GameMatch::where('competition_id', $competition->id)
            ->where('status', 'finished')
            ->get();

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

        DB::transaction(function () use ($competition, $stats) {
            foreach ($stats as $teamId => $data) {
                TeamStatistic::updateOrCreate(
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
     * Advance winning team in knockout round matches.
     */
    public function advanceKnockoutWinner(GameMatch $match): void
    {
        if ($match->status !== 'finished' || ! $match->winner_team_id) {
            return;
        }

        // Check if there is a next round match in the competition
        $nextRoundNumber = $match->round_number + 1;

        $nextMatch = GameMatch::where('competition_id', $match->competition_id)
            ->where('round_number', $nextRoundNumber)
            ->whereNull('group_id') // Knockout matches have no group_id
            ->first();

        if (! $nextMatch) {
            return;
        }

        // Fill home_team_id if empty, else away_team_id
        if (! $nextMatch->home_team_id || $nextMatch->home_team_id == $match->winner_team_id) {
            $nextMatch->update(['home_team_id' => $match->winner_team_id]);
        } elseif (! $nextMatch->away_team_id || $nextMatch->away_team_id == $match->winner_team_id) {
            $nextMatch->update(['away_team_id' => $match->winner_team_id]);
        }
    }
}
