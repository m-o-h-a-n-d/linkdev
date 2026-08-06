<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\CompetitionSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompetitionSetting>
 */
class CompetitionSettingFactory extends Factory
{
    protected $model = CompetitionSetting::class;

    public function definition(): array
    {
        return [
            'competition_id' => Competition::factory(),
            'competition_type' => fake()->randomElement(['league', 'knockout', 'mixed']),
            'max_teams' => fake()->randomElement([8, 16, 32]),
            'points_win' => 3,
            'points_draw' => 1,
            'points_loss' => 0,
        ];
    }
}
