<?php

namespace App\Repositories\Contracts\Admin;

use App\Data\Admin\CreateAdminData;
use App\Data\Admin\UpdateAdminData;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryInterface
{
    public function authAdmin(): ?User;

    public function paginate(int $perPage = 12): LengthAwarePaginator;

    public function all(): Collection;

    public function find(int $id): ?User;

    public function create(CreateAdminData $data, ?string $imagePath = null): User;

    public function update(User $user, UpdateAdminData $data, ?string $imagePath = null): User;

    public function delete(User $user): bool;
}
