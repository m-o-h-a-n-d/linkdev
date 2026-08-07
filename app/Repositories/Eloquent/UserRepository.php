<?php

namespace App\Repositories\Eloquent;

use App\Data\User\CreateUserData;
use App\Data\User\UpdateUserData;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::latest()->paginate($perPage);
    }

    public function all(): Collection
    {
        return User::latest()->get();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function create(CreateUserData $data): User
    {
        return User::create($data->toArray());
    }

    public function update(User $user, UpdateUserData $data): User
    {
        $user->update($data->toArray());

        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
