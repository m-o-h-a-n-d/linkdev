<?php

namespace App\Repositories\Eloquent\User;

use App\Data\User\CreateUserData;
use App\Data\User\UpdateUserData;
use App\Models\User;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        $currentAdmin = Auth::guard('admin')->user() ?? Auth::user();
        $currentUserId = $currentAdmin?->id;

        return User::query()
            ->when($currentUserId, fn ($query) => $query->where('id', '!=', $currentUserId))
            ->with(['roles', 'admin'])
            ->latest()
            ->paginate($perPage);
    }

    public function all(): Collection
    {
        $currentAdmin = Auth::guard('admin')->user() ?? Auth::user();
        $currentUserId = $currentAdmin?->id;

        return User::query()
            ->when($currentUserId, fn ($query) => $query->where('id', '!=', $currentUserId))
            ->with(['roles', 'admin'])
            ->latest()
            ->get();
    }

    public function find(int $id): ?User
    {
        return User::query()
            ->with(['roles', 'admin'])
            ->find($id);
    }

    public function create(CreateUserData $data): User
    {
        return User::create($data->toArray());
    }

    public function update(User $user, UpdateUserData $data): User
    {
        $user->update(array_filter($data->toArray(), fn ($value) => $value !== null));

        return $user;
    }

    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }

    public function forceDelete(User $user): bool
    {
        return (bool) $user->forceDelete();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
