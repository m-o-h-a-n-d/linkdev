<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'favicon'       => null,
                'icon'          => null,
                'session'       => 'Season 2025/26',
                'header'        => 'Every throw, every save, every point.',
                'description'   => 'The public portal for handball competitions — follow live matches, group standings, and team form as the season unfolds.',
                'matches_image' => 'frontend/images/ihf-bracket.png',
            ]
        );
    }
}
