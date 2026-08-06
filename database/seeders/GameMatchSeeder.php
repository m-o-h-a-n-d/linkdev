<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use App\Models\GameMatch;

use Illuminate\Database\Seeder;

class GameMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competitions = Competition::all();

        foreach ($competitions as $competition) {
            $groups = CompetitionGroup::where('competition_id', $competition->id)->get();

            foreach ($groups as $group) {
                $teams = $group->teams;
                if ($teams->count() >= 2) {
                    GameMatch::factory()->create([
                        'competition_id' => $competition->id,
                        'group_id' => $group->id,
                        'home_team_id' => $teams[0]->id,
                        'away_team_id' => $teams[1]->id,
                        'status' => 'finished',
                        'home_score' => 2,
                        'away_score' => 1,
                        'winner_team_id' => $teams[0]->id,
                    ]);

                    if ($teams->count() >= 4) {
                        GameMatch::factory()->create([
                            'competition_id' => $competition->id,
                            'group_id' => $group->id,
                            'home_team_id' => $teams[2]->id,
                            'away_team_id' => $teams[3]->id,
                            'status' => 'scheduled',
                        ]);
                    }
                }
            }
        }
    }
}
