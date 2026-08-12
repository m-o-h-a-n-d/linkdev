<?php

namespace App\Repositories\Contracts\Role;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): Role;

    public function findByName(string $name, string $guardName = 'admin'): Role;

    public function create(array $data): Role;

    public function update(Role|int $role, array $data): Role;

    public function delete(Role|int $role): bool;

    public function syncPermissions(Role $role, array $permissions): void;
}
