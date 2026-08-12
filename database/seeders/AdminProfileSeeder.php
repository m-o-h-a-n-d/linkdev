<?php

namespace Database\Seeders;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@example.test')->first();

        if ($adminUser) {
            AdminProfile::updateOrCreate(
                ['user_id' => $adminUser->id],
                [
                    'phone' => '01000000000',
                    'image' => 'defaults/admin-avatar.png',
                    'status' => 'active',
                    'national_id' => 12345678901234,
                    'address' => 'Cairo, Egypt',
                    'gender' => 'Male',
                ]
            );
        }
    }
}
