<?php

namespace Database\Factories;

use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StaffProfile>
 */
class StaffProfileFactory extends Factory
{
    protected $model = StaffProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => fake()->unique()->numerify('01#########'),
            'image' => fake()->imageUrl(250, 250, 'people'),
            'status' => fake()->randomElement(['active', 'inactive', 'banned']),
            'national_id' => fake()->numerify('##############'),
            'address' => fake()->address(),
            'gender' => fake()->randomElement(['Male', 'Female']),
        ];
    }
}
