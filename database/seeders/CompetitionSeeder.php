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
        $creator = User::first() ?? User::factory()->create([
            'email' => 'admin@example.test',
            'name' => 'Super Admin',
        ]);

        $allTeams = Team::all();

        $competitionsData = [
            [
                'name' => 'دوري المحترفين المصري لكرة اليد 2026/2027',
                'description' => 'البطولة الرسمية الأولى لكرة اليد في مصر بمشاركة نخبة أندية الدوري الممتاز بنظام المجموعات والمرحلة النهائية لحسم اللقب.',
                'season' => '2026/2027',
                'status' => 'upcoming',
                'start_date' => now()->addDays(2)->toDateString(),
                'end_date' => now()->addMonths(4)->toDateString(),
                'created_by_user_id' => $creator->id,
            ],
            [
                'name' => 'كأس مصر لكرة اليد 2026',
                'description' => 'بطولة كأس مصر السنوية لكرة اليد بمشاركة جميع أندية المحترفين والممتاز للمنافسة على الكأس الفضية.',
                'season' => '2025/2026',
                'status' => 'upcoming',
                'start_date' => now()->addDays(5)->toDateString(),
                'end_date' => now()->addMonths(2)->toDateString(),
                'created_by_user_id' => $creator->id,
            ],
        ];

        foreach ($competitionsData as $data) {
            $competition = Competition::updateOrCreate(
                ['name' => $data['name']],
                $data
            );

            // Attach all active teams to the main league
            if ($allTeams->isNotEmpty()) {
                $competition->teams()->sync($allTeams->pluck('id'));
            }
        }
    }
}
