<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\CompetitionGroup;
use App\Models\Team;
use Illuminate\Database\Seeder;

class CompetitionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $league = Competition::where('name', 'like', '%المحترفين%')->first() ?? Competition::first();

        if ($league) {
            $groupA = CompetitionGroup::updateOrCreate(
                [
                    'competition_id' => $league->id,
                    'name' => 'المجموعة الأولى (أندية بحري والقاهرة - Group A)',
                ]
            );

            $groupB = CompetitionGroup::updateOrCreate(
                [
                    'competition_id' => $league->id,
                    'name' => 'المجموعة الثانية (أندية الجيزة والقناة - Group B)',
                ]
            );

            // Group A Teams (الأهلي، سبورتنج، طلائع الجيش، هليوبوليس، الطيران، الزهور، الترسانة، أصحاب الجياد)
            $groupATeamNames = [
                'الأهلي (Al Ahly SC)',
                'سبورتنج (Sporting Club)',
                'طلائع الجيش (Tala\'ea El Gaish)',
                'هليوبوليس (Heliopolis SC)',
                'الطيران (Aviation Club)',
                'الزهور (El Zohour SC)',
                'الترسانة (Tersana SC)',
                'أصحاب الجياد (Ashhab El Giyad)',
            ];
            $groupATeamIds = Team::whereIn('name', $groupATeamNames)->pluck('id');
            if ($groupATeamIds->isNotEmpty()) {
                $groupA->teams()->sync($groupATeamIds);
            }

            // Group B Teams (الزمالك، سموحة، البنك الأهلي، الأولمبي، الجزيرة، المعادي، القناة، الشمس)
            $groupBTeamNames = [
                'الزمالك (Zamalek SC)',
                'سموحة (Smouha SC)',
                'البنك الأهلي (National Bank of Egypt)',
                'الأولمبي (Olympic Club)',
                'الجزيرة (Gezira SC)',
                'المعادي (Maadi SC)',
                'القناة (Al Qanah SC)',
                'الشمس (Al Shams SC)',
            ];
            $groupBTeamIds = Team::whereIn('name', $groupBTeamNames)->pluck('id');
            if ($groupBTeamIds->isNotEmpty()) {
                $groupB->teams()->sync($groupBTeamIds);
            }
        }

        // Cup Groups
        $cup = Competition::where('name', 'like', '%كأس مصر%')->first();
        if ($cup) {
            $cupGroup1 = CompetitionGroup::updateOrCreate([
                'competition_id' => $cup->id,
                'name' => 'المجموعة الأولى (تمهيدي الكأس)',
            ]);

            $cupGroup2 = CompetitionGroup::updateOrCreate([
                'competition_id' => $cup->id,
                'name' => 'المجموعة الثانية (تمهيدي الكأس)',
            ]);

            $allTeams = Team::all();
            if ($allTeams->count() >= 8) {
                $cupGroup1->teams()->sync($allTeams->slice(0, 4)->pluck('id'));
                $cupGroup2->teams()->sync($allTeams->slice(4, 4)->pluck('id'));
            }
        }
    }
}
