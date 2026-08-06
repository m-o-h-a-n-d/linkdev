<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creator = User::first() ?? User::factory()->create();
        $teams = Team::all();

        if ($teams->isEmpty()) {
            $teams = Team::factory(16)->create();
        }

        $competitions = Competition::factory(2)->create([
            'created_by_user_id' => $creator->id,
        ]);

        foreach ($competitions as $competition) {
            $competition->teams()->attach($teams->random(8)->pluck('id'));
        }
    }
}
