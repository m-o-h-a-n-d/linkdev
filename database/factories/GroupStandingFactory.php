<?php

namespace Database\Factories;

use App\Models\CompetitionGroup;
use App\Models\GroupStanding;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GroupStanding>
 */
class GroupStandingFactory extends Factory
{
    protected $model = GroupStanding::class;

    public function definition(): array
    {
        $won = fake()->numberBetween(0, 5);
        $draw = fake()->numberBetween(0, 3);
        $lost = fake()->numberBetween(0, 5);
        $played = $won + $draw + $lost;
        $goalsFor = fake()->numberBetween($played, $played * 3);
        $goalsAgainst = fake()->numberBetween($played, $played * 3);

        return [
            'group_id' => CompetitionGroup::factory(),
            'team_id' => Team::factory(),
            'played' => $played,
            'won' => $won,
            'draw' => $draw,
            'lost' => $lost,
            'goals_for' => $goalsFor,
            'goals_against' => $goalsAgainst,
            'goal_difference' => $goalsFor - $goalsAgainst,
            'points' => ($won * 3) + $draw,
            'position_rank' => fake()->numberBetween(1, 4),
        ];
    }
}
