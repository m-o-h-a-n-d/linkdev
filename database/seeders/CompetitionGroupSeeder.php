<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use Illuminate\Database\Seeder;

class CompetitionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competitions = Competition::all();

        if ($competitions->isEmpty()) {
            $competitions = Competition::factory(2)->create();
        }

        foreach ($competitions as $competition) {
            $compTeams = $competition->teams;

            $groupA = CompetitionGroup::factory()->create([
                'competition_id' => $competition->id,
                'name' => 'Group A - ' . $competition->name,
            ]);

            $groupB = CompetitionGroup::factory()->create([
                'competition_id' => $competition->id,
                'name' => 'Group B - ' . $competition->name,
            ]);

            if ($compTeams->count() >= 8) {
                $groupA->teams()->attach($compTeams->slice(0, 4)->pluck('id'));
                $groupB->teams()->attach($compTeams->slice(4, 4)->pluck('id'));
            }
        }
    }
}
