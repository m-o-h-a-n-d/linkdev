<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StaffProfileSeeder::class,
            TeamSeeder::class,
            CompetitionSeeder::class,
            CompetitionSettingSeeder::class,
            CompetitionGroupSeeder::class,
            GameMatchSeeder::class,
            GroupStandingSeeder::class,
            TeamStatisticSeeder::class,
            ActivityLogSeeder::class,
        ]);
    }
}
