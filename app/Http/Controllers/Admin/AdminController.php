<?php

namespace App\Http\Controllers\Admin;

<<<<<<< HEAD
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
=======
use App\Data\Admin\CreateAdminData;
use App\Data\Admin\UpdateAdminData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Services\Admin\AdminServices;
use App\Services\Admin\Role\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct(
        protected AdminServices $adminServices,
        protected RoleService $roleService
    ) {}

    /**
     * Display a listing of admins.
     */
    public function index(): View
    {
        $admins = $this->adminServices->paginateAdmins(12);

        return view('backend.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create(): View
    {
        $roles = $this->roleService->getAllRoles();

        return view('backend.admins.create', compact('roles'));
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(CreateAdminRequest $request): RedirectResponse
    {
        $adminData = CreateAdminData::from($request);
        
        $this->adminServices->createAdmin($adminData);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully!');
    }

    /**
     * Display the specified admin.
     */
    public function show(int $id): View
    {
        $admin = $this->adminServices->getAdminById($id);

        return view('backend.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(int $id): View
    {
        $admin = $this->adminServices->getAdminById($id);
        $roles = $this->roleService->getAllRoles();

        return view('backend.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(UpdateAdminRequest $request, int $id): RedirectResponse
    {
        $adminData = UpdateAdminData::from($request);

        $this->adminServices->updateAdmin($id, $adminData);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->adminServices->deleteAdmin($id);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully!');
>>>>>>> feature/admin-admin
    }
}
