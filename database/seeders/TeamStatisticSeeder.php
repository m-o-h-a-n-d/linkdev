<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\TeamStatistic;
use Illuminate\Database\Seeder;

class TeamStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competitions = Competition::all();

        foreach ($competitions as $competition) {
            foreach ($competition->teams as $team) {
                TeamStatistic::factory()->create([
                    'team_id' => $team->id,
                    'competition_id' => $competition->id,
                ]);
            }
        }
    }
}
