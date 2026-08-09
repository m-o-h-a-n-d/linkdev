<?php

namespace App\Http\Controllers\Admin;

use App\Data\Admin\Role\RoleData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\CreateRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Services\Admin\Role\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService
    ) {}

    public function index(): View
    {
        $roles = $this->roleService->getAllRoles();

        return view('backend.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $modules = config('permissions.modules', []);

        return view('backend.roles.create', compact('modules'));
    }

    public function store(CreateRoleRequest $request): RedirectResponse
    {
        $roleData = RoleData::from($request);

        $this->roleService->createRole($roleData);

        return redirect()->route('admin.roles.index')->with('success', 'Role created and permissions assigned successfully!');
    }

    public function show(int $id): View
    {
        $role = $this->roleService->getRoleById($id);

        return view('backend.roles.show', compact('role'));
    }

    public function edit(int $id): View
    {
        $role = $this->roleService->getRoleById($id);
        $modules = config('permissions.modules', []);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('backend.roles.edit', compact('role', 'modules', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, int $id): RedirectResponse
    {
        $roleData = RoleData::from($request);

        $this->roleService->updateRole($id, $roleData);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->roleService->deleteRole($id);

        if (! $deleted) {
            return back()->with('error', 'Super Admin role cannot be deleted or role does not exist.');
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
    }
}
