<?php

namespace App\Services;

use App\Data\User\CreateUserData;
use App\Data\User\LoginData;
use App\Data\User\UpdateUserData;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

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

    public function login(LoginData $data): bool
    {
        return Auth::attempt($data->toArray());
    }

     public function sendResetLink(string $email): string
    {
        return Password::sendResetLink([
            'email' => $email,
        ]);
    }

    public function reset(array $credentials, callable $callback): string
    {
        return Password::reset($credentials, $callback);
    }
}
