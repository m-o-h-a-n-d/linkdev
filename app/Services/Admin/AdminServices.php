<?php

namespace App\Services\Admin;

use App\Data\Admin\CreateAdminData;
use App\Data\Admin\UpdateAdminData;
use App\Models\User;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Utility\ImageManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;

class AdminServices
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository,
        protected ImageManager $imageManager,
    ) {}

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

        if (! empty($data->role)) {
            $user->syncRoles([
                $data->role,
            ]);
        }

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

        return $user->load([
            'admin',
            'roles',
        ]);
    }

    /**
     * Delete admin.
     */
    public function deleteAdmin(int $id): bool
    {
        $user = $this->getAdminById($id);

        $imagePath = $user->admin?->image;

        $deleted = $this->adminRepository->delete($user);

        if (
            $deleted &&
            $imagePath &&
            $imagePath !== 'defaults/avatar.png'
        ) {
            $this->imageManager->delete(
                $imagePath,
                'public'
            );
        }

        return $deleted;
    }

    /**
     * Delete only the admin profile data and image, while keeping the user record.
     */
    public function deleteAdminProfile(User $user): void
    {
        $adminProfile = $user->admin;

        if (! $adminProfile) {
            return;
        }

        $imagePath = $adminProfile->image;

        $adminProfile->forceDelete();

        if (
            $imagePath &&
            $imagePath !== 'defaults/avatar.png'
        ) {
            $this->imageManager->delete(
                $imagePath,
                'public'
            );
        }
    }
}

