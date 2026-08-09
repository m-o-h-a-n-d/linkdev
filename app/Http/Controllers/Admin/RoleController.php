<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::with('permissions')->get();

        return view('backend.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $modules = config('permissions.modules', []);

        return view('backend.roles.create', compact('modules'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name' => 'admin',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created and permissions assigned successfully!');
    }

    public function show(int $id): View
    {
        $role = Role::with('permissions')->findOrFail($id);

        return view('backend.roles.show', compact('role'));
    }

    public function edit(int $id): View
    {
        $role = Role::with('permissions')->findOrFail($id);
        $modules = config('permissions.modules', []);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('backend.roles.edit', compact('role', 'modules', 'rolePermissions'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->update(['name' => $request->input('name')]);

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'super-admin') {
            return back()->with('error', 'Super Admin role cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
    }
}
