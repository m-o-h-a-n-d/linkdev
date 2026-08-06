<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // System Admin / Main Test User
        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@linkdev.com',
        ]);

        // Regular Users
        User::factory(10)->create();
    }
}
