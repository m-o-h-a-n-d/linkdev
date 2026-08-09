<?php

namespace App\Services\Admin\Role;

use App\Data\Admin\Role\RoleData;
use App\Repositories\Contracts\Role\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository
    ) {}

    public function getAllRoles(): Collection
    {
        return $this->roleRepository->getAll();
    }

    public function getRoleById(int $id): Role
    {
        return $this->roleRepository->findById($id);
    }

    public function createRole(RoleData $data): Role
    {
        $role = $this->roleRepository->create([
            'name' => $data->name,
            'guard_name' => 'admin',
        ]);

        if (! empty($data->permissions)) {
            $this->roleRepository->syncPermissions($role, $data->permissions);
        }

        return $role;
    }

    public function updateRole(int $id, RoleData $data): Role
    {
        $role = $this->roleRepository->update($id, [
            'name' => $data->name,
        ]);

        $this->roleRepository->syncPermissions($role, $data->permissions);

        return $role;
    }

    public function deleteRole(int $id): bool
    {
        $role = $this->roleRepository->findById($id);

        if ($role->name === 'super-admin') {
            return false;
        }

        return $this->roleRepository->delete($role);
    }
}
