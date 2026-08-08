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
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = config('permissions.modules', []);

        // 1. Create All Permissions from config
        $allPermissionNames = [];
        foreach ($modules as $moduleKey => $moduleData) {
            $permissions = $moduleData['permissions'] ?? [];
            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
                $allPermissionNames[] = $permissionName;
            }
        }

        // 2. Create Super Admin Role with All Permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions($allPermissionNames);

        // Assign Super Admin Role to Main System Admin
        $systemAdmin = User::where('email', 'admin@linkdev.com')->first();
        if ($systemAdmin) {
            $systemAdmin->assignRole($superAdminRole);
        }
    }
}
