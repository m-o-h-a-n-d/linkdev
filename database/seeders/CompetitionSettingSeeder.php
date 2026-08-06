<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\CompetitionSetting;
use Illuminate\Database\Seeder;

class CompetitionSettingSeeder extends Seeder
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
            CompetitionSetting::factory()->create([
                'competition_id' => $competition->id,
            ]);
        }
    }
}
