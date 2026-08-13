<?php

namespace App\Services\Match;

use App\Models\CompetitionGroup;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FixtureGeneratorService
{
    public function __construct(
        protected MatchRepositoryInterface $matchRepository
    ) {}

    /**
     * Generate round-robin match fixtures for a group of teams in a competition.
     */
    public function generateGroupFixtures(CompetitionGroup $group, ?Carbon $startDate = null): Collection
    {
        $teams = $group->teams;

        if ($teams->count() < 2) {
            return collect();
        }

        $startDate = $startDate ?? Carbon::now()->addDays(1)->setHour(17)->setMinute(0);
        $teamIds = $teams->pluck('id')->toArray();
        $isOdd = count($teamIds) % 2 !== 0;

        if ($isOdd) {
            $teamIds[] = null; // Dummy bye team
        }

        $numTeams = count($teamIds);
        $numRounds = $numTeams - 1;
        $halfSize = $numTeams / 2;

        $createdMatches = collect();
        $matchDate = $startDate->copy();

        for ($round = 0; $round < $numRounds; $round++) {
            for ($i = 0; $i < $halfSize; $i++) {
                $home = $teamIds[$i];
                $away = $teamIds[$numTeams - 1 - $i];

                if ($home !== null && $away !== null) {
                    $match = $this->matchRepository->create([
                        'competition_id' => $group->competition_id,
                        'group_id' => $group->id,
                        'home_team_id' => $home,
                        'away_team_id' => $away,
                        'scheduled_at' => $matchDate->copy()->addHours($i * 2),
                        'status' => 'scheduled',
                        'home_score' => 0,
                        'away_score' => 0,
                        'round_number' => $round + 1,
                        'notes' => 'Group Stage Fixture - Round ' . ($round + 1),
                    ]);

                    $createdMatches->push($match);
                }
            }

            // Rotate team array for round robin (keep first element fixed)
            $last = array_pop($teamIds);
            array_splice($teamIds, 1, 0, [$last]);

            $matchDate->addDays(2);
        }

        return $createdMatches;
    }
}
