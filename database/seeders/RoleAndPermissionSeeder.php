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
        $guards = ['admin', 'web'];
        $allPermissionNames = [];

        // 1. Create All Permissions for both 'admin' and 'web' guards
        foreach ($modules as $moduleKey => $moduleData) {
            $permissions = $moduleData['permissions'] ?? [];
            foreach ($permissions as $permissionName) {
                foreach ($guards as $guard) {
                    Permission::firstOrCreate([
                        'name' => $permissionName,
                        'guard_name' => $guard,
                    ]);
                }
                $allPermissionNames[] = $permissionName;
            }
        }

        // 2. Create Super Admin Roles for both 'admin' and 'web' guards
        foreach ($guards as $guard) {
            $superAdminRole = Role::firstOrCreate([
                'name' => 'super-admin',
                'guard_name' => $guard,
            ]);
            $superAdminRole->syncPermissions($allPermissionNames);
        }

        // 3. Assign Super Admin Roles to System Admins (Users with AdminProfile)
        $admins = User::whereHas('admin')->get();
        if ($admins->isEmpty()) {
            $admins = User::limit(5)->get();
        }

        foreach ($admins as $adminUser) {
            foreach ($guards as $guard) {
                $role = Role::where('name', 'super-admin')->where('guard_name', $guard)->first();
                if ($role && ! $adminUser->hasRole('super-admin', $guard)) {
                    $adminUser->assignRole($role);
                }
            }
        }
    }
}
