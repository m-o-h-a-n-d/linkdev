<?php

namespace App\Repositories\Eloquent\Admin;

use App\Data\Admin\CreateAdminData;
use App\Data\Admin\UpdateAdminData;
use App\Models\User;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AdminRepository implements AdminRepositoryInterface
{
    /**
     * Get paginated admins.
     */
    public function paginate(int $perPage = 12): LengthAwarePaginator
    {
        $currentUserId = auth('admin')->id() ?? auth()->id();

        return User::query()
            ->whereHas('admin')
            ->when(
                $currentUserId,
                fn ($query) => $query->where('id', '!=', $currentUserId)
            )
            ->with(['admin', 'roles'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get all admins.
     */
    public function all(): Collection
    {
        $currentUserId = auth('admin')->id() ?? auth()->id();

        return User::query()
            ->whereHas('admin')
            ->when(
                $currentUserId,
                fn ($query) => $query->where('id', '!=', $currentUserId)
            )
            ->with(['admin', 'roles'])
            ->latest()
            ->get();
    }

    /**
     * Find admin by User ID.
     */
    public function find(int $id): ?User
    {
        return User::query()
            ->whereHas('admin')
            ->with(['admin', 'roles'])
            ->find($id);
    }

    /**
     * Create User + Admin Profile atomically.
     */
    public function create(
        CreateAdminData $data,
        ?string $imagePath = null
    ): User {
        return DB::transaction(function () use ($data, $imagePath) {

            $user = User::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => $data->password,
                'email_verified_at' => now(),
            ]);

            $user->admin()->create([
                'phone' => $data->phone,
                'national_id' => $data->national_id,
                'address' => $data->address,
                'gender' => $data->gender,
                'status' => $data->status ?? 'active',
                'image' => $imagePath,
            ]);

            return $user->load(['admin', 'roles']);
        });
    }

    /**
     * Update User + Admin Profile atomically.
     */
    public function update(
        User $user,
        UpdateAdminData $data,
        ?string $imagePath = null
    ): User {
        return DB::transaction(function () use ($user, $data, $imagePath) {

            $user->update([
                'name' => $data->name,
                'email' => $data->email,
                'password' => $data->password,
            ]);

            $profilePayload = [
                'phone' => $data->phone,
                'status' => $data->status ?? 'active',
                'national_id' => $data->national_id,
                'address' => $data->address,
                'gender' => $data->gender,
            ];

            if ($imagePath !== null) {
                $profilePayload['image'] = $imagePath;
            }

            $user->admin()->updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                $profilePayload
            );

            return $user->load(['admin', 'roles']);
        });
    }

    /**
     * Delete User + Admin Profile atomically.
     */
    public function delete(User $user): bool
    {
        return DB::transaction(function () use ($user) {

            $user->admin()->delete();

            return $user->delete();
        });
    }
}
