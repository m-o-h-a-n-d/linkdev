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
        // System Admin / Super Admin
        User::updateOrCreate(
            ['email' => 'admin@example.test'],
            [
                'name' => 'Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('123456789'),
                'email_verified_at' => now(),
            ]
        );

        // Regular Users
        User::factory(5)->create();
    }
}
