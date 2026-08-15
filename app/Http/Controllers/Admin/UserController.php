<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * Display a listing of users.
     */
    public function index(): View
    {
        $users = $this->userService->paginate(15);

        return view('backend.users.index', compact('users'));
    }

    /**
     * Toggle admin role for the user.
     */
    public function toggleAdmin(int $id): RedirectResponse
    {
        $isPromoted = $this->userService->toggleAdminRole($id);

        $message = $isPromoted
            ? 'User assigned to admin role successfully.'
            : 'User removed from admin role successfully.';

        return back()->with('success', $message);
    }

    /**
     * Permanently remove the user.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->userService->destroy($id);

        return back()->with('success', 'User deleted permanently from all related tables.');
    }
}
