<?php

namespace App\Repositories\Contracts;

use App\DTOs\User\CreateUserData;
use App\DTOs\User\UpdateUserData;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function all(): Collection;

    public function find(int $id): ?User;

    public function create(CreateUserData $data): User;

    public function update(User $user, UpdateUserData $data): User;

    public function delete(User $user): bool;
}
