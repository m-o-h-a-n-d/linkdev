<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1. Super Admin (Full Control)
        $permissions = collect(config('permissions.modules'))
            ->flatMap(fn (array $module) => $module['permissions'] ?? [])
            ->unique()
            ->values();

        foreach ($permissions as $permissionName) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'admin',
            ]);
        }

        $superAdmin = User::where('email', 'admin@example.test')->first();
        if (! $superAdmin) {
            User::factory()->asSuperAdmin()->create();
        } else {
            $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);
            $role->syncPermissions($permissions->all());
            $superAdmin->assignRole($role);
        }

        // 2. Competition & Tournament Manager
        if (! User::where('email', 'competition.manager@example.test')->exists()) {
            User::factory()->asCompetitionManager()->create();
        }

        // 3. Match Commissioner / Referee
        if (! User::where('email', 'match.referee@example.test')->exists()) {
            User::factory()->asMatchCommissioner()->create();
        }

        // 4. Teams Officer
        if (! User::where('email', 'teams.officer@example.test')->exists()) {
            User::factory()->asTeamsOfficer()->create();
        }

        // 5. Statistics & Standings Analyst
        if (! User::where('email', 'analyst@example.test')->exists()) {
            User::factory()->asStatisticsAnalyst()->create();
        }

        // 6. System Auditor
        if (! User::where('email', 'auditor@example.test')->exists()) {
            User::factory()->asSystemAuditor()->create();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
