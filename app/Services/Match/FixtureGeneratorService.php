<?php

namespace App\Services\Match;

use App\Models\CompetitionGroup;
use App\Repositories\Contracts\Match\MatchRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class FixtureGeneratorService
{
    public function __construct(
        protected MatchRepositoryInterface $matchRepository
    ) {}

    /*
|--------------------------------------------------------------------------
| Round-Robin Fixture Generation
|--------------------------------------------------------------------------
|
| We use the Round-Robin (Circle Method) algorithm to generate fixtures.
|
| The main rule of Round-Robin:
| Every team must play against every other team exactly once
| in a Single Round-Robin tournament.
|
| Example with 4 teams:
|
|   Teams: A, B, C, D
|
|   Round 1: A vs D, B vs C
|   Round 2: A vs B, C vs D
|   Round 3: A vs C, D vs B
|
| Number of Rounds:
|   If N = number of teams:
|
|       Rounds = N - 1
|
| Number of Matches per Round:
|
|       Matches per Round = N / 2
|
| Total Number of Matches:
|
|       Total Matches = N * (N - 1) / 2
|
| Example:
|   6 teams:
|
|       Rounds        = 6 - 1 = 5
|       Matches/Round = 6 / 2 = 3
|       Total Matches = 6 * 5 / 2 = 15
|
|--------------------------------------------------------------------------
| Why do we add a NULL / Dummy Team?
|--------------------------------------------------------------------------
|
| The Circle Method requires an EVEN number of teams so that every team
| can be paired with another team in every round.
|
| If the number of teams is ODD, one team will have no opponent in each
| round (a "BYE").
|
| Example with 5 teams:
|
|   A, B, C, D, E
|
| We add a dummy team:
|
|   A, B, C, D, E, NULL
|
| Now we have 6 positions, so we can create 3 pairs per round.
|
| Example:
|
|   Round 1:
|       A vs NULL  -> A has a BYE (no match)
|       B vs E
|       C vs D
|
| The NULL does NOT represent a real team and must never be stored as
| an actual opponent/team in the fixture.
|
| When a fixture contains NULL, it means that the real team has a BYE
| and therefore does not play in that round.
|
|--------------------------------------------------------------------------
| Important:
|--------------------------------------------------------------------------
|
| For an ODD number of teams:
|
|   Actual teams = N
|   Dummy team   = 1
|   Algorithm size = N + 1
|
| Example:
|   5 teams -> 6 positions -> 5 rounds
|
| After adding NULL, the algorithm rotates the teams around a fixed
| position (Circle Method) to generate all unique pairings without
| repeating the same match.
|
| If this is a Double Round-Robin (Home & Away), every generated match
| is played twice with reversed home/away teams.
|
*/
    public function generateGroupFixtures(CompetitionGroup $group, ?Carbon $startDate = null): Collection
    {
        $group->loadMissing('competition', 'teams');
        $teams = $group->teams; //  All Teams Belong To Group

        if ($teams->count() < 2) {
            return new Collection; //  You can't generate fixtures for less than 2 teams return an empty collection
        }

        $competition = $group->competition;

        // Use competition start_date if not explicitly provided
        if (! $startDate && $competition && $competition->start_date) {
            $startDate = Carbon::parse($competition->start_date)->setHour(17)->setMinute(0);
        } else {
            $startDate = $startDate ?? Carbon::now()->addDays(1)->setHour(17)->setMinute(0);
        }

        $teamIds = $teams->pluck('id')->toArray(); // Get team IDs for fixture generation

        $isOdd = count($teamIds) % 2 !== 0; // Check if the number of teams is odd

        // If odd, add a dummy team (null) to make it even for round-robin scheduling
        if ($isOdd) {
            $teamIds[] = null; // Dummy bye team
        }

        $numTeams = count($teamIds);
        $numRounds = $numTeams - 1;
        $halfSize = $numTeams / 2;

        // Calculate days between rounds if competition has end_date
        $daysBetweenRounds = 2; // Default
        if ($competition && $competition->end_date && $numRounds > 1) {
            $compEndDate = Carbon::parse($competition->end_date)->setHour(17)->setMinute(0);
            $totalDays = $startDate->diffInDays($compEndDate, false);

            if ($totalDays >= ($numRounds - 1)) {
                $daysBetweenRounds = (int) floor($totalDays / ($numRounds - 1));
                if ($daysBetweenRounds < 1) {
                    $daysBetweenRounds = 1;
                }
            }
        }

        $createdMatches = new Collection;
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
                        'notes' => 'Group Stage Fixture - Round '.($round + 1),
                    ]);

                    $createdMatches->push($match);
                }
            }

            // Rotate team array for round robin (keep first element fixed)
            $last = array_pop($teamIds);
            array_splice($teamIds, 1, 0, [$last]);

            if ($round < $numRounds - 1) {
                $matchDate->addDays($daysBetweenRounds);
            }
        }

        return $createdMatches;
    }
}
