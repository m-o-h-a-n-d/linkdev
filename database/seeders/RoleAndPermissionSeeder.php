<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'admin';
        $superAdminRoleName = 'super-admin';

        /*
        |--------------------------------------------------------------------------
        | Reset Permission Cache
        |--------------------------------------------------------------------------
        */

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Get All Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = collect(config('permissions.modules'))
            ->flatMap(
                fn (array $module) => $module['permissions'] ?? []
            )
            ->unique()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Create / Update Permissions
        |--------------------------------------------------------------------------
        */

        Permission::upsert(
            $permissions
                ->map(fn (string $permission) => [
                    'name' => $permission,
                    'guard_name' => $guard,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
                ->toArray(),
            ['name', 'guard_name'],
            ['updated_at']
        );

        /*
        |--------------------------------------------------------------------------
        | Remove Any Existing Default Role
        |--------------------------------------------------------------------------
        */

        $defaultRole = Role::query()
            ->where('name', 'default')
            ->where('guard_name', $guard)
            ->first();

        if ($defaultRole) {
            $defaultRole->users()->get()->each(function (User $user) use ($defaultRole): void {
                $user->removeRole($defaultRole);
            });

            $defaultRole->delete();
        }

        $superAdmin = Role::firstOrCreate([
            'name' => $superAdminRoleName,
            'guard_name' => $guard,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Sync All Permissions
        |--------------------------------------------------------------------------
        */

        $superAdmin->syncPermissions(
            $permissions->all()
        );


        /*
        |--------------------------------------------------------------------------
        | Assign Super Admin Role to Existing Admins
        |--------------------------------------------------------------------------
        */

        $adminUsers = User::query()
            ->whereHas('admin')
            ->get();

        foreach ($adminUsers as $adminUser) {
            $adminUser->assignRole($superAdmin);
        }

        /*
        |--------------------------------------------------------------------------
        | Clear Cache Again
        |--------------------------------------------------------------------------
        */

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
