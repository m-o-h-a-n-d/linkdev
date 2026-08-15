<?php

namespace Database\Factories;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Attach an admin profile to the user.
     */
    public function withAdminProfile(array $attributes = []): static
    {
        return $this->afterCreating(function (User $user) use ($attributes) {
            AdminProfile::updateOrCreate(
                ['user_id' => $user->id],
                array_merge([
                    'phone' => fake()->unique()->numerify('01#########'),
                    'image' => 'defaults/admin-avatar.png',
                    'status' => 'active',
                    'national_id' => fake()->numerify('##############'),
                    'address' => fake()->address(),
                    'gender' => fake()->randomElement(['Male', 'Female']),
                ], $attributes)
            );
        });
    }

    /**
     * Assign a Spatie role with optional custom permissions.
     */
    public function withRole(string $roleName, array $permissions = [], string $guard = 'admin'): static
    {
        return $this->afterCreating(function (User $user) use ($roleName, $permissions, $guard) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $guard,
            ]);

            if (!empty($permissions)) {
                foreach ($permissions as $perm) {
                    Permission::firstOrCreate([
                        'name' => $perm,
                        'guard_name' => $guard,
                    ]);
                }
                $role->syncPermissions($permissions);
            }

            $user->assignRole($role);
        });
    }

    /**
     * Functional State: Super Admin
     */
    public function asSuperAdmin(array $userAttributes = [], array $profileAttributes = []): static
    {
        return $this->state(array_merge([
            'name' => 'Super Admin',
            'email' => 'admin@example.test',
            'password' => Hash::make('123456789'),
        ], $userAttributes))
        ->withAdminProfile(array_merge([
            'phone' => '01000000001',
            'address' => 'Cairo, Egypt',
            'gender' => 'Male',
        ], $profileAttributes))
        ->afterCreating(function (User $user) {
            $allPermissions = collect(config('permissions.modules'))
                ->flatMap(fn (array $module) => $module['permissions'] ?? [])
                ->unique()
                ->values();

            foreach ($allPermissions as $perm) {
                Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'admin']);
            }

            $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);
            $role->syncPermissions($allPermissions->all());
            $user->assignRole($role);
        });
    }

    /**
     * Functional State: Competition & Tournament Manager
     */
    public function asCompetitionManager(array $userAttributes = [], array $profileAttributes = []): static
    {
        return $this->state(array_merge([
            'name' => 'Competition Manager',
            'email' => 'competition.manager@example.test',
            'password' => Hash::make('123456789'),
        ], $userAttributes))
        ->withAdminProfile(array_merge([
            'phone' => '01000000002',
            'address' => 'Alexandria, Egypt',
            'gender' => 'Male',
        ], $profileAttributes))
        ->withRole('competition-manager', [
            'dashboard.access',
            'competitions.view',
            'competitions.create',
            'competitions.edit',
            'competitions.delete',
            'competition-settings.view',
            'competition-settings.manage',
            'groups.view',
            'groups.create',
            'groups.edit',
            'groups.delete',
            'matches.view',
            'matches.create',
            'matches.edit',
            'matches.delete',
            'matches.live-center',
            'standings.view',
            'standings.manage',
            'statistics.view',
            'statistics.manage',
            'teams.view',
        ]);
    }

    /**
     * Functional State: Match Commissioner / Referee
     */
    public function asMatchCommissioner(array $userAttributes = [], array $profileAttributes = []): static
    {
        return $this->state(array_merge([
            'name' => 'Match Commissioner',
            'email' => 'match.referee@example.test',
            'password' => Hash::make('123456789'),
        ], $userAttributes))
        ->withAdminProfile(array_merge([
            'phone' => '01000000003',
            'address' => 'Giza, Egypt',
            'gender' => 'Male',
        ], $profileAttributes))
        ->withRole('match-commissioner', [
            'dashboard.access',
            'matches.view',
            'matches.live-center',
            'competitions.view',
            'groups.view',
            'teams.view',
            'standings.view',
            'statistics.view',
        ]);
    }

    /**
     * Functional State: Teams Officer
     */
    public function asTeamsOfficer(array $userAttributes = [], array $profileAttributes = []): static
    {
        return $this->state(array_merge([
            'name' => 'Teams Officer',
            'email' => 'teams.officer@example.test',
            'password' => Hash::make('123456789'),
        ], $userAttributes))
        ->withAdminProfile(array_merge([
            'phone' => '01000000004',
            'address' => 'Mansoura, Egypt',
            'gender' => 'Female',
        ], $profileAttributes))
        ->withRole('teams-officer', [
            'dashboard.access',
            'teams.view',
            'teams.create',
            'teams.edit',
            'teams.delete',
            'competitions.view',
            'groups.view',
        ]);
    }

    /**
     * Functional State: Statistics & Standings Analyst
     */
    public function asStatisticsAnalyst(array $userAttributes = [], array $profileAttributes = []): static
    {
        return $this->state(array_merge([
            'name' => 'Statistics Analyst',
            'email' => 'analyst@example.test',
            'password' => Hash::make('123456789'),
        ], $userAttributes))
        ->withAdminProfile(array_merge([
            'phone' => '01000000005',
            'address' => 'Tanta, Egypt',
            'gender' => 'Male',
        ], $profileAttributes))
        ->withRole('statistics-analyst', [
            'dashboard.access',
            'statistics.view',
            'statistics.manage',
            'standings.view',
            'standings.manage',
            'matches.view',
            'competitions.view',
            'groups.view',
            'teams.view',
        ]);
    }

    /**
     * Functional State: System Auditor
     */
    public function asSystemAuditor(array $userAttributes = [], array $profileAttributes = []): static
    {
        return $this->state(array_merge([
            'name' => 'System Auditor',
            'email' => 'auditor@example.test',
            'password' => Hash::make('123456789'),
        ], $userAttributes))
        ->withAdminProfile(array_merge([
            'phone' => '01000000006',
            'address' => 'Aswan, Egypt',
            'gender' => 'Female',
        ], $profileAttributes))
        ->withRole('system-auditor', [
            'dashboard.access',
            'activity-logs.view',
            'users.view',
            'admins.view',
            'roles.view',
            'competitions.view',
            'matches.view',
            'teams.view',
            'standings.view',
            'statistics.view',
        ]);
    }

    /**
     * Functional State: Default Admin Role (ID 2 with dashboard.access)
     */
    public function asAdmin(array $userAttributes = [], array $profileAttributes = []): static
    {
        return $this->state(array_merge([
            'name' => 'Default Admin',
            'email' => 'default.admin@example.test',
            'password' => Hash::make('123456789'),
        ], $userAttributes))
        ->withAdminProfile(array_merge([
            'phone' => fake()->unique()->numerify('01#########'),
            'address' => 'Cairo, Egypt',
            'gender' => 'Male',
        ], $profileAttributes))
        ->withRole('admin', ['dashboard.access']);
    }
}
