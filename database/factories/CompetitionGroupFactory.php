<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompetitionGroup>
 */
class CompetitionGroupFactory extends Factory
{
    protected $model = CompetitionGroup::class;

    public function definition(): array
    {
        return [
            'competition_id' => Competition::factory(),
            'name' => 'Group ' . fake()->randomElement(['A', 'B', 'C', 'D', 'E', 'F']),
            'display_order' => fake()->numberBetween(1, 6),
        ];
    }
}
