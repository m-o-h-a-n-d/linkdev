<?php

namespace Database\Seeders;

use App\Models\CompetitionGroup;
use App\Services\Match\MatchStandingsService;
use Illuminate\Database\Seeder;

class GroupStandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $standingsService = app(MatchStandingsService::class);
        $groups = CompetitionGroup::all();

        foreach ($groups as $group) {
            $standingsService->recalculateGroupStandings($group);
        }
    }
}
