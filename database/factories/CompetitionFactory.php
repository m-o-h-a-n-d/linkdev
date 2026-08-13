<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Competition>
 */
class CompetitionFactory extends Factory
{
    protected $model = Competition::class;

    public function definition(): array
    {
        $name = fake()->words(3, true) . ' Tournament';
        $startDate = fake()->dateTimeBetween('-1 month', '+1 month');
        $endDate = (clone $startDate)->modify('+2 months');

        return [
            'name' => ucfirst($name),
            'description' => fake()->paragraph(),
            'season' => '2025/2026',
            'status' => fake()->randomElement(['draft', 'upcoming', 'ongoing', 'completed', 'cancelled']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'winner_team_id' => null,
            'created_by_user_id' => User::factory(),
        ];
    }
}
