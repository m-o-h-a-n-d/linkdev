<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        $teamName = fake()->unique()->company() . ' FC';
        return [
            'name' => $teamName,
            'short_name' => strtoupper(substr(str_replace(' ', '', $teamName), 0, 3)),
            'logo' => fake()->imageUrl(200, 200, 'sports'),
            'city' => fake()->city(),
            'country' => fake()->country(),
        ];
    }
}
