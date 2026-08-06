<?php

namespace Database\Seeders;

use App\Models\CompetitionGroup;
use App\Models\GroupStanding;
use Illuminate\Database\Seeder;

class GroupStandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = CompetitionGroup::all();

        foreach ($groups as $group) {
            foreach ($group->teams as $index => $team) {
                GroupStanding::factory()->create([
                    'group_id' => $group->id,
                    'team_id' => $team->id,
                    'position_rank' => $index + 1,
                ]);
            }
        }
    }
}
