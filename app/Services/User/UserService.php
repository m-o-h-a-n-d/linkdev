<?php

namespace App\Services\User;

use App\Data\User\CreateUserData;
use App\Data\User\LoginData;
use App\Data\User\UpdateUserData;
use App\Models\User;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Services\Admin\AdminServices;
use App\Utility\ActivityLogger;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected AdminServices $adminServices,
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

    public function toggleAdminRole(int $id): bool
    {
        $user = $this->findOrFail($id);
        $defaultAdminRole = Role::find(2)
            ?? Role::where('name', 'admin')->where('guard_name', 'admin')->first()
            ?? Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);

        return DB::transaction(function () use ($user, $defaultAdminRole) {
            $hasAdminRole = $user->roles()->where('guard_name', 'admin')->exists() || $user->admin()->exists();

            if ($hasAdminRole) {
                $user->roles()->detach();
                $this->adminServices->deleteAdminProfile($user);

                ActivityLogger::log(
                    action: 'STATUS_CHANGE',
                    entityType: 'User',
                    entityId: $user->id,
                    description: "Removed admin role privileges from user '{$user->name}' ({$user->email})."
                );

                return false;
            }

            $user->assignRole($defaultAdminRole);

            $user->admin()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $user->admin?->phone ?? '0000000000',
                    'national_id' => $user->admin?->national_id ?? 0,
                    'address' => $user->admin?->address ?? 'Not provided',
                    'gender' => $user->admin?->gender ?? 'Male',
                    'status' => $user->admin?->status ?? 'active',
                    'image' => $user->admin?->image ?? 'defaults/avatar.png',
                ]
            );

            ActivityLogger::log(
                action: 'STATUS_CHANGE',
                entityType: 'User',
                entityId: $user->id,
                description: "Assigned default admin role '{$defaultAdminRole->name}' to user '{$user->name}' ({$user->email})."
            );

            return true;
        });
    }

    public function destroy(int $id): bool
    {
        $user = $this->findOrFail($id);
        $userName = $user->name;
        $userEmail = $user->email;
        $userId = $user->id;

        return DB::transaction(function () use ($user, $userName, $userEmail, $userId) {
            $user->roles()->detach();

            $this->adminServices->deleteAdminProfile($user);

            $deleted = $this->userRepository->forceDelete($user);

            if ($deleted) {
                ActivityLogger::log(
                    action: 'DELETED',
                    entityType: 'User',
                    entityId: $userId,
                    description: "Permanently deleted user account '{$userName}' ({$userEmail})."
                );
            }

            return $deleted;
        });
    }

    public function login(LoginData $data, string $guard = 'web', bool $remember = false): bool
    {
        return Auth::guard($guard)->attempt(
            [
                'email' => $data->email,
                'password' => $data->password,
            ],
            $remember
        );
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
