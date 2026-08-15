<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        $realLogos = [
            'https://upload.wikimedia.org/wikipedia/ar/8/8c/Al_Ahly_SC_logo.png',
            'https://upload.wikimedia.org/wikipedia/ar/4/4c/%D8%B4%D8%B9%D8%A7%D8%B1_%D9%86%D8%A7%D8%AF%D9%8A_%D8%A7%D9%84%D8%B2%D9%85%D8%A7%D9%84%D9%83_%D8%A7%D9%84%D9%85%D8%B5%D8%B1%D9%8A.png',
            'https://alexsportingclub.com/wp-content/uploads/2024/03/Group-11191.svg',
            'https://upload.wikimedia.org/wikipedia/ar/2/2e/Smouha-Club.png',
            'https://upload.wikimedia.org/wikipedia/ar/3/34/%D8%B4%D8%B9%D8%A7%D8%B1_%D9%86%D8%A7%D8%AF%D9%8A_%D8%B7%D9%84%D8%A7%D8%A6%D8%B9_%D8%A7%D9%84%D8%AC%D9%8A%D8%B4.png',
            'https://upload.wikimedia.org/wikipedia/en/d/da/National_Bank_of_Egypt_SC_logo.png',
            'https://upload.wikimedia.org/wikipedia/en/2/29/Heliopolis_Sporting_Club_%28crest%29.jpg',
            'https://upload.wikimedia.org/wikipedia/en/9/9a/Olympic_Club_%28Egypt%29_logo.png',
            'https://koraapedia.com/wp-content/uploads/2021/02/%D8%B4%D8%B9%D8%A7%D8%B1-%D9%86%D8%A7%D8%AF%D9%8A-%D8%A7%D9%84%D8%B7%D9%8A%D8%B1%D8%A7%D9%86.jpg',
            'https://upload.wikimedia.org/wikipedia/ar/c/cd/Jazira_Egypt_sc.jpg',
            'https://zohourclub.net/images/logo.png',
            'https://1921.tel/e-hotline.info/files/logo/1921.png',
            'https://upload.wikimedia.org/wikipedia/ar/d/d9/Tersana_sc.png',
            'https://upload.wikimedia.org/wikipedia/en/thumb/f/f6/El_Qanah_FC_logo.svg/500px-El_Qanah_FC_logo.svg.png',
            'https://upload.wikimedia.org/wikipedia/ar/6/63/%D9%86%D8%A7%D8%AF%D9%8A_%D8%A3%D8%B5%D8%AD%D8%A7%D8%A8_%D8%A7%D9%84%D8%AC%D9%8A%D8%A7%D8%AF.png',
            'https://upload.wikimedia.org/wikipedia/en/e/e2/El_Shams_SC.jpg',
        ];

        $teamName = fake()->unique()->company() . ' HC';
        return [
            'name' => $teamName,
            'short_name' => strtoupper(substr(str_replace(' ', '', $teamName), 0, 3)),
            'logo' => fake()->randomElement($realLogos),
            'city' => fake()->city(),
            'country' => 'مصر',
        ];
    }
}
