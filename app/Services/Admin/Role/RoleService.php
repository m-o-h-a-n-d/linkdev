<?php

namespace App\Services\Admin\Role;

use App\Data\Admin\Role\RoleData;
use App\Services\Admin\AdminServices;
use App\Repositories\Contracts\Role\RoleRepositoryInterface;
use App\Utility\ActivityLogger;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class RoleService
{
    private const SUPER_ADMIN_ROLE = 'super-admin';

    public function __construct(
        protected RoleRepositoryInterface $roleRepository,
        protected AdminServices $adminServices
    ) {}

    public function getAllRoles(): Collection
    {
        return $this->roleRepository->getAll();
    }

    public function getRoleById(int $id): Role
    {
        return $this->roleRepository->findById($id);
    }

    public function getProtectedRoleNames(): array
    {
        return [self::SUPER_ADMIN_ROLE];
    }

    public function isProtectedRole(Role $role): bool
    {
        return in_array($role->name, $this->getProtectedRoleNames(), true) || $role->id === 1;
    }

    public function isDeletableRole(Role $role): bool
    {
        return $role->id !== 1 && $role->id !== 2 && ! in_array($role->name, [self::SUPER_ADMIN_ROLE, 'admin'], true);
    }

    private function ensureRoleNameIsAllowed(string $name): void
    {
        if (in_array($name, $this->getProtectedRoleNames(), true)) {
            throw ValidationException::withMessages([
                'name' => 'This role name is reserved and cannot be used.',
            ]);
        }
    }

    private function ensureRoleIsMutable(Role $role): void
    {
        if ($this->isProtectedRole($role)) {
            throw ValidationException::withMessages([
                'name' => 'This role is protected and cannot be modified.',
            ]);
        }
    }

    public function createRole(RoleData $data): Role
    {
        $this->ensureRoleNameIsAllowed($data->name);

        $role = $this->roleRepository->create([
            'name' => $data->name,
            'guard_name' => 'admin',
        ]);

        if (! empty($data->permissions)) {
            $this->roleRepository->syncPermissions($role, $data->permissions);
        }

        ActivityLogger::log(
            action: 'CREATED',
            entityType: 'Role',
            entityId: $role->id,
            description: "Created new role '{$role->name}' with " . count($data->permissions) . " permissions."
        );

        return $role;
    }

    public function updateRole(int $id, RoleData $data): Role
    {
        $role = $this->roleRepository->findById($id);
        $this->ensureRoleIsMutable($role);
        $this->ensureRoleNameIsAllowed($data->name);

        $role = $this->roleRepository->update($role, [
            'name' => $data->name,
        ]);

        $this->roleRepository->syncPermissions($role, $data->permissions);

        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'Role',
            entityId: $role->id,
            description: "Updated role '{$role->name}' with " . count($data->permissions) . " assigned permissions."
        );

        return $role;
    }

    public function deleteRole(int $id): bool
    {
        $role = $this->roleRepository->findById($id);

        if (! $this->isDeletableRole($role)) {
            throw ValidationException::withMessages([
                'name' => 'This role is protected and cannot be deleted.',
            ]);
        }

        $roleName = $role->name;
        $roleId = $role->id;

        return DB::transaction(function () use ($role, $roleName, $roleId) {
            $users = $role->users()->with('admin')->get();

            foreach ($users as $user) {
                $this->adminServices->deleteAdminProfile($user);
            }

            $deleted = $this->roleRepository->delete($role);

            if ($deleted) {
                ActivityLogger::log(
                    action: 'DELETED',
                    entityType: 'Role',
                    entityId: $roleId,
                    description: "Deleted role '{$roleName}' and unassigned associated admin profiles."
                );
            }

            return $deleted;
        });
    }
}
