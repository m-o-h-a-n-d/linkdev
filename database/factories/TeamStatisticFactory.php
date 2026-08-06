<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\Team;
use App\Models\TeamStatistic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamStatistic>
 */
class TeamStatisticFactory extends Factory
{
    protected $model = TeamStatistic::class;

    public function definition(): array
    {
        $wins = fake()->numberBetween(0, 10);
        $draws = fake()->numberBetween(0, 5);
        $losses = fake()->numberBetween(0, 10);
        $played = $wins + $draws + $losses;
        $goalsFor = fake()->numberBetween($played, $played * 3);
        $goalsAgainst = fake()->numberBetween($played, $played * 3);

        return [
            'team_id' => Team::factory(),
            'competition_id' => Competition::factory(),
            'matches_played' => $played,
            'wins' => $wins,
            'draws' => $draws,
            'losses' => $losses,
            'goals_for' => $goalsFor,
            'goals_against' => $goalsAgainst,
            'goal_difference' => $goalsFor - $goalsAgainst,
            'points' => ($wins * 3) + $draws,
        ];
    }
}
