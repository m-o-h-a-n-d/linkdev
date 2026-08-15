<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 2. Collect and create all permissions defined in config/permissions.php
        $allPermissions = collect(config('permissions.modules'))
            ->flatMap(fn (array $module) => $module['permissions'] ?? [])
            ->unique()
            ->values();

        foreach ($allPermissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'admin',
            ]);
        }

        // 3. Protected Role (ID 1): Super Admin (Full Access to all modules)
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'admin',
        ]);
        $superAdminRole->syncPermissions($allPermissions->all());

        $superAdminUser = User::where('email', 'admin@example.test')->first();
        if ($superAdminUser) {
            $superAdminUser->assignRole($superAdminRole);
        } else {
            User::factory()->asSuperAdmin()->create();
        }

        // 4. Default Role (ID 2): Default Admin Role
        // Protected from deletion, customizable, default for any user promoted to admin
        $defaultAdminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'admin',
        ]);
        $defaultAdminRole->syncPermissions(['dashboard.access']);

        // 5. Functional Specialized Roles
        // Competition & Tournament Manager
        if (! User::where('email', 'competition.manager@example.test')->exists()) {
            User::factory()->asCompetitionManager()->create();
        }

        // Match Commissioner / Referee
        if (! User::where('email', 'match.referee@example.test')->exists()) {
            User::factory()->asMatchCommissioner()->create();
        }

        // Teams Officer
        if (! User::where('email', 'teams.officer@example.test')->exists()) {
            User::factory()->asTeamsOfficer()->create();
        }

        // Statistics & Standings Analyst
        if (! User::where('email', 'analyst@example.test')->exists()) {
            User::factory()->asStatisticsAnalyst()->create();
        }

        // System Auditor
        if (! User::where('email', 'auditor@example.test')->exists()) {
            User::factory()->asSystemAuditor()->create();
        }

        // 6. Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
