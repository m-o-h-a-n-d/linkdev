<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\GameMatch;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GameMatch>
 */
class GameMatchFactory extends Factory
{
    protected $model = GameMatch::class;

    public function definition(): array
    {
        $status = fake()->randomElement(['scheduled', 'live', 'finished', 'postponed', 'cancelled']);
        $homeScore = $status === 'finished' ? fake()->numberBetween(0, 5) : 0;
        $awayScore = $status === 'finished' ? fake()->numberBetween(0, 5) : 0;

        return [
            'competition_id' => Competition::factory(),
            'group_id' => null,
            'home_team_id' => Team::factory(),
            'away_team_id' => Team::factory(),
            'winner_team_id' => null,
            'scheduled_at' => fake()->dateTimeBetween('now', '+1 month'),
            'started_at' => $status === 'finished' ? fake()->dateTimeBetween('-2 hours', '-1 hour') : null,
            'ended_at' => $status === 'finished' ? fake()->dateTime('now') : null,
            'status' => $status,
            'home_score' => $homeScore,
            'away_score' => $awayScore,
            'round_number' => fake()->numberBetween(1, 10),
            'notes' => fake()->sentence(),
        ];
    }
}
