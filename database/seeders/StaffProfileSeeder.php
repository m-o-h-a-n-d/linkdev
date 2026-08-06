<?php

namespace Database\Seeders;

use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        foreach ($users->take(4) as $user) {
            StaffProfile::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
