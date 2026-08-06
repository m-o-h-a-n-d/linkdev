<?php

namespace App\Services;

use App\DTOs\User\CreateUserData;
use App\DTOs\User\UpdateUserData;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->paginate($perPage);
    }

    public function all(): Collection
    {
        return $this->userRepository->all();
    }

    public function findOrFail(int $id): User
    {
        $user = $this->userRepository->find($id);

        if (! $user) {
            throw new ModelNotFoundException('User not found.');
        }

        return $user;
    }

    public function store(CreateUserData $data): User
    {
        return $this->userRepository->create($data);
    }

    public function update(int $id, UpdateUserData $data): User
    {
        $user = $this->findOrFail($id);

        return $this->userRepository->update($user, $data);
    }

    public function destroy(int $id): bool
    {
        $user = $this->findOrFail($id);

        return $this->userRepository->delete($user);
    }
}
