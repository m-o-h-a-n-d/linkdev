<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utility\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->with('roles')
            ->latest()
            ->paginate(15);

        return view('backend.users.index', compact('users'));
    }

    public function toggleAdmin(User $user): RedirectResponse
    {
        $adminRole = Role::findByName('super-admin', 'admin');

        if ($user->hasRole($adminRole)) {
            DB::transaction(function () use ($user, $adminRole) {
                $user->removeRole($adminRole);

                $profile = $user->admin()->withTrashed()->first();

                if ($profile) {
                    $profile->forceDelete();
                }

                ActivityLogger::log(
                    action: 'STATUS_CHANGE',
                    entityType: 'User',
                    entityId: $user->id,
                    description: "Removed admin role privileges from user '{$user->name}' ({$user->email})."
                );
            });

            return back()->with('success', 'User removed from admin role successfully.');
        }

        DB::transaction(function () use ($user, $adminRole) {
            $user->assignRole($adminRole);

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
                description: "Promoted user '{$user->name}' ({$user->email}) to super-admin."
            );
        });

        return back()->with('success', 'User assigned to admin role successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $userName = $user->name;
        $userEmail = $user->email;
        $userId = $user->id;

        DB::transaction(function () use ($user, $userName, $userEmail, $userId) {
            $user->roles()->detach();

            $user->admin()->withTrashed()->forceDelete();

            $user->forceDelete();

            ActivityLogger::log(
                action: 'DELETED',
                entityType: 'User',
                entityId: $userId,
                description: "Permanently deleted user account '{$userName}' ({$userEmail})."
            );
        });

        return back()->with('success', 'User deleted permanently from all related tables.');
    }
}
