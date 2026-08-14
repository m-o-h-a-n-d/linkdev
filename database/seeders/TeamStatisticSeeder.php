<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Services\Match\MatchStandingsService;
use Illuminate\Database\Seeder;

class TeamStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $standingsService = app(MatchStandingsService::class);
        $competitions = Competition::all();

        foreach ($competitions as $competition) {
            $standingsService->recalculateTeamStatistics($competition);
        }
    }
}
