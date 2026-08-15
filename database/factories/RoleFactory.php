<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->slug(2),
            'guard_name' => 'admin',
        ];
    }

    /**
     * Attach and sync permissions for this role.
     */
    public function withPermissions(array|string $permissions): static
    {
        return $this->afterCreating(function (Role $role) use ($permissions) {
            $permissionNames = (array) $permissions;
            $guard = $role->guard_name ?? 'admin';

            foreach ($permissionNames as $perm) {
                Permission::firstOrCreate([
                    'name' => $perm,
                    'guard_name' => $guard,
                ]);
            }

            $role->syncPermissions($permissionNames);
        });
    }

    /**
     * Functional State: Super Admin
     */
    public function superAdmin(): static
    {
        return $this->state([
            'name' => 'super-admin',
            'guard_name' => 'admin',
        ])->afterCreating(function (Role $role) {
            $permissions = collect(config('permissions.modules'))
                ->flatMap(fn (array $module) => $module['permissions'] ?? [])
                ->unique()
                ->values();

            foreach ($permissions as $perm) {
                Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'admin']);
            }

            $role->syncPermissions($permissions->all());
        });
    }

    /**
     * Functional State: Competition & Tournament Manager
     */
    public function competitionManager(): static
    {
        return $this->state([
            'name' => 'competition-manager',
            'guard_name' => 'admin',
        ])->withPermissions([
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
    public function matchCommissioner(): static
    {
        return $this->state([
            'name' => 'match-commissioner',
            'guard_name' => 'admin',
        ])->withPermissions([
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
    public function teamsOfficer(): static
    {
        return $this->state([
            'name' => 'teams-officer',
            'guard_name' => 'admin',
        ])->withPermissions([
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
    public function statisticsAnalyst(): static
    {
        return $this->state([
            'name' => 'statistics-analyst',
            'guard_name' => 'admin',
        ])->withPermissions([
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
    public function systemAuditor(): static
    {
        return $this->state([
            'name' => 'system-auditor',
            'guard_name' => 'admin',
        ])->withPermissions([
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
}
