<?php

namespace App\Services\Admin;

use App\Data\Admin\CreateAdminData;
use App\Data\Admin\UpdateAdminData;
use App\Models\User;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Utility\ActivityLogger;
use App\Utility\ImageManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;

class AdminServices
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository,
        protected ImageManager $imageManager,
    ) {}

    /**
     * Get currently authenticated admin.
     */
    public function authAdmin(): ?User
    {
        return $this->adminRepository->authAdmin();
    }

    /**
     * Get paginated admins.
     */
    public function paginateAdmins(int $perPage = 12): LengthAwarePaginator
    {
        return $this->adminRepository->paginate($perPage);
    }

    /**
     * Get all admins.
     */
    public function getAllAdmins(): Collection
    {
        return $this->adminRepository->all();
    }

    /**
     * Get admin by ID.
     */
    public function getAdminById(int $id): User
    {
        $user = $this->adminRepository->find($id);

        if (! $user) {
            throw new ModelNotFoundException(
                'Admin not found.'
            );
        }

        return $user;
    }

    /**
     * Create admin.
     */
    public function createAdmin(CreateAdminData $data): User
    {
        $imagePath = null;

        if ($data->image instanceof UploadedFile) {
            $imagePath = $this->imageManager->upload(
                $data->image,
                'admins'
            );
        }

        $user = $this->adminRepository->create(
            $data,
            $imagePath
        );

        $roleName = ! empty($data->role)
            ? $data->role
            : (Role::find(2)?->name ?? Role::where('name', 'admin')->where('guard_name', 'admin')->first()?->name ?? 'admin');

        $user->syncRoles([
            $roleName,
        ]);

        ActivityLogger::log(
            action: 'CREATED',
            entityType: 'Admin',
            entityId: $user->id,
            description: "Created admin user '{$user->name}' ({$user->email}) with role '{$roleName}'"
        );

        return $user->load([
            'admin',
            'roles',
        ]);
    }

    /**
     * Update admin.
     */
    public function updateAdmin(
        int $id,
        UpdateAdminData $data
    ): User {
        $user = $this->getAdminById($id);

        $imagePath = null;

        if ($data->image instanceof UploadedFile) {

            $oldPath = (
                $user->admin?->image &&
                $user->admin->image !== 'defaults/avatar.png'
            )
                ? $user->admin->image
                : null;

            $imagePath = $this->imageManager->upload(
                $data->image,
                'admins',
                'public',
                $oldPath
            );
        }

        $user = $this->adminRepository->update(
            $user,
            $data,
            $imagePath
        );

        if (! empty($data->role)) {
            $user->syncRoles([
                $data->role,
            ]);
        }

        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'Admin',
            entityId: $user->id,
            description: "Updated admin details for '{$user->name}' ({$user->email})"
        );

        return $user->load([
            'admin',
            'roles',
        ]);
    }

    /**
     * Delete admin (deletes only the admin profile and image, keeping the user record).
     */
    public function deleteAdmin(int $id): bool
    {
        $user = $this->getAdminById($id);

        $this->deleteAdminProfile($user);

        ActivityLogger::log(
            action: 'DELETED',
            entityType: 'Admin',
            entityId: $user->id,
            description: "Removed admin profile & privileges from '{$user->name}' ({$user->email})"
        );

        return true;
    }

    /**
     * Delete only the admin profile data and image, while keeping the user record.
     */
    public function deleteAdminProfile(User $user): void
    {
        $adminProfile = $user->admin()->withTrashed()->first() ?? $user->admin;

        if (! $adminProfile) {
            return;
        }

        $imagePath = $adminProfile->image;

        $adminProfile->forceDelete();

        if (
            $imagePath &&
            ! str_starts_with($imagePath, 'defaults/') &&
            ! str_starts_with($imagePath, 'http')
        ) {
            $this->imageManager->delete(
                $imagePath,
                'public'
            );
        }
    }
}

