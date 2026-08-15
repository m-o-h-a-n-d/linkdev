<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Utility\Enums\TeamStatus;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'الأهلي (Al Ahly SC)',
                'short_name' => 'AHL',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@alahlyegypt.com',
                'phone' => '+20227355555',
                'manager_name' => 'ستيفان مادسن (Stefan Madsen)',
                'arena' => 'صالة الأمير عبد الله الفيصل بالجزيرة',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/ar/8/8c/Al_Ahly_SC_logo.png',
            ],
            [
                'name' => 'الزمالك (Zamalek SC)',
                'short_name' => 'ZAM',
                'city' => 'الجيزة',
                'country' => 'مصر',
                'email' => 'handball@zamalek.org',
                'phone' => '+20233470000',
                'manager_name' => 'فرناندو باربيتو (Fernando Barbeito)',
                'arena' => 'صالة عبد الرحمن فوزي بميت عقبة',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/ar/4/4c/%D8%B4%D8%B9%D8%A7%D8%B1_%D9%86%D8%A7%D8%AF%D9%8A_%D8%A7%D9%84%D8%B2%D9%85%D8%A7%D9%84%D9%83_%D8%A7%D9%84%D9%85%D8%B5%D8%B1%D9%8A.png',
            ],
            [
                'name' => 'سبورتنج (Sporting Club)',
                'short_name' => 'SPO',
                'city' => 'الإسكندرية',
                'country' => 'مصر',
                'email' => 'handball@sportingclub.eg',
                'phone' => '+2035432100',
                'manager_name' => 'أشرف عواض',
                'arena' => 'صالة نادي سبورتنج بالإسكندرية',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://alexsportingclub.com/wp-content/uploads/2024/03/Group-11191.svg',
            ],
            [
                'name' => 'سموحة (Smouha SC)',
                'short_name' => 'SMO',
                'city' => 'الإسكندرية',
                'country' => 'مصر',
                'email' => 'handball@smouhaclub.com',
                'phone' => '+2034255555',
                'manager_name' => 'محمد عبد السلام',
                'arena' => 'صالة نادي سموحة الكبرى',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/ar/2/2e/Smouha-Club.png',
            ],
            [
                'name' => 'طلائع الجيش (Tala\'ea El Gaish)',
                'short_name' => 'TGS',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@elgaish.org',
                'phone' => '+20222610000',
                'manager_name' => 'طارق محروس',
                'arena' => 'صالة جهاز الرياضة العسكري بكوبري القبة',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/ar/3/34/%D8%B4%D8%B9%D8%A7%D8%B1_%D9%86%D8%A7%D8%AF%D9%8A_%D8%B7%D9%84%D8%A7%D8%A6%D8%B9_%D8%A7%D9%84%D8%AC%D9%8A%D8%B4.png',
            ],
            [
                'name' => 'البنك الأهلي (National Bank of Egypt)',
                'short_name' => 'NBE',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@nbeclub.com',
                'phone' => '+20223900000',
                'manager_name' => 'عمرو الجيوشي',
                'arena' => 'صالة اتحاد الشرطة بالدراسة',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/en/d/da/National_Bank_of_Egypt_SC_logo.png',
            ],
            [
                'name' => 'هليوبوليس (Heliopolis SC)',
                'short_name' => 'HEL',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@heliopolisclub.com',
                'phone' => '+20224150000',
                'manager_name' => 'أحمد دعبس',
                'arena' => 'صالة نادي هليوبوليس بالشروق',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/en/2/29/Heliopolis_Sporting_Club_%28crest%29.jpg',
            ],
            [
                'name' => 'الأولمبي (Olympic Club)',
                'short_name' => 'OLY',
                'city' => 'الإسكندرية',
                'country' => 'مصر',
                'email' => 'handball@olympic-club.eg',
                'phone' => '+2034950000',
                'manager_name' => 'حسام غريب',
                'arena' => 'صالة النادي الأولمبي بوابل المياه',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/en/9/9a/Olympic_Club_%28Egypt%29_logo.png',
            ],
            [
                'name' => 'الطيران (Aviation Club)',
                'short_name' => 'TAY',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@aviationclub.org',
                'phone' => '+20222670000',
                'manager_name' => 'محمد يحيى',
                'arena' => 'صالة نادي الطيران بمدينة نصر',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://koraapedia.com/wp-content/uploads/2021/02/%D8%B4%D8%B9%D8%A7%D8%B1-%D9%86%D8%A7%D8%AF%D9%8A-%D8%A7%D9%84%D8%B7%D9%8A%D8%B1%D8%A7%D9%86.jpg',
            ],
            [
                'name' => 'الجزيرة (Gezira SC)',
                'short_name' => 'GEZ',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@geziraclub.com',
                'phone' => '+20227360000',
                'manager_name' => 'خالد فتحي',
                'arena' => 'صالة نادي الجزيرة بالزمالك',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/ar/c/cd/Jazira_Egypt_sc.jpg',
            ],
            [
                'name' => 'الزهور (El Zohour SC)',
                'short_name' => 'ZOH',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@zohourclub.com',
                'phone' => '+20222600000',
                'manager_name' => 'علاء حسن',
                'arena' => 'صالة نادي الزهور بمدينة نصر',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://zohourclub.net/images/logo.png',
            ],
            [
                'name' => 'المعادي (Maadi SC)',
                'short_name' => 'MAA',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@maadiclub.org',
                'phone' => '+20223580000',
                'manager_name' => 'مصطفى حسين',
                'arena' => 'صالة نادي المعادي واليخت',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://1921.tel/e-hotline.info/files/logo/1921.png',
            ],
            [
                'name' => 'الترسانة (Tersana SC)',
                'short_name' => 'TER',
                'city' => 'الجيزة',
                'country' => 'مصر',
                'email' => 'handball@tersanaclub.com',
                'phone' => '+20233030000',
                'manager_name' => 'أشرف عبده',
                'arena' => 'صالة حسن الشاذلي بميت عقبة',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/ar/d/d9/Tersana_sc.png',
            ],
            [
                'name' => 'القناة (Al Qanah SC)',
                'short_name' => 'QAN',
                'city' => 'الإسماعيلية',
                'country' => 'مصر',
                'email' => 'handball@qanahclub.com',
                'phone' => '+20643320000',
                'manager_name' => 'مدحت عبد العال',
                'arena' => 'صالة هيئة قناة السويس بالإسماعيلية',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f6/El_Qanah_FC_logo.svg/500px-El_Qanah_FC_logo.svg.png',
            ],
            [
                'name' => 'أصحاب الجياد (Ashhab El Giyad)',
                'short_name' => 'GYD',
                'city' => 'الإسكندرية',
                'country' => 'مصر',
                'email' => 'handball@giyadclub.com',
                'phone' => '+2034280000',
                'manager_name' => 'إيهاب العاصي',
                'arena' => 'صالة نادي أصحاب الجياد بسموحة',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/ar/6/63/%D9%86%D8%A7%D8%AF%D9%8A_%D8%A3%D8%B5%D8%AD%D8%A7%D8%A8_%D8%A7%D9%84%D8%AC%D9%8A%D8%A7%D8%AF.png',
            ],
            [
                'name' => 'الشمس (Al Shams SC)',
                'short_name' => 'SHM',
                'city' => 'القاهرة',
                'country' => 'مصر',
                'email' => 'handball@shamsclub.com',
                'phone' => '+20221800000',
                'manager_name' => 'صابر حسين',
                'arena' => 'صالة نادي الشمس بمصر الجديدة',
                'status' => TeamStatus::ACCEPTED,
                'logo' => 'https://upload.wikimedia.org/wikipedia/en/e/e2/El_Shams_SC.jpg',
            ],
        ];

        foreach ($teams as $teamData) {
            $logoUrl = $teamData['logo'];
            $shortName = strtolower($teamData['short_name']);

            // Attempt to download and store logo locally for reliable offline serving
            if (filter_var($logoUrl, FILTER_VALIDATE_URL)) {
                try {
                    $ext = pathinfo(parse_url($logoUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
                    $localPath = "uploads/teams/{$shortName}.{$ext}";
                    $fullStoragePath = storage_path("app/public/{$localPath}");

                    if (! file_exists(dirname($fullStoragePath))) {
                        mkdir(dirname($fullStoragePath), 0755, true);
                    }

                    if (! file_exists($fullStoragePath)) {
                        $response = \Illuminate\Support\Facades\Http::withHeaders([
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                            'Accept' => 'image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
                        ])->timeout(10)->get($logoUrl);

                        if ($response->successful() && strlen($response->body()) > 100) {
                            file_put_contents($fullStoragePath, $response->body());
                            $teamData['logo'] = $localPath;
                        }
                    } else {
                        $teamData['logo'] = $localPath;
                    }
                } catch (\Throwable $e) {
                    // Fallback to remote URL
                }
            }

            Team::updateOrCreate(
                ['name' => $teamData['name']],
                $teamData
            );
        }
    }
}
