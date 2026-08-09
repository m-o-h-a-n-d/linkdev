<?php

namespace App\Repositories\Eloquent\Role;

use App\Repositories\Contracts\Role\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll(): Collection
    {
        return Role::with('permissions')->get();
    }

    public function findById(int $id): Role
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function create(array $data): Role
    {
        return Role::create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'admin',
        ]);
    }

    public function update(Role|int $role, array $data): Role
    {
        if (is_int($role)) {
            $role = $this->findById($role);
        }

        $role->update([
            'name' => $data['name'],
        ]);

        return $role;
    }

    public function delete(Role|int $role): bool
    {
        if (is_int($role)) {
            $role = $this->findById($role);
        }

        return (bool) $role->delete();
    }

    public function syncPermissions(Role $role, array $permissions): void
    {
        $role->syncPermissions($permissions);
    }
}
