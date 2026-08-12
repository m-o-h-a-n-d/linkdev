<?php

namespace App\Http\Controllers\Admin;

use App\Data\Admin\UpdateAdminData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use App\Services\Admin\AdminServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminProfile extends Controller
{
    public function __construct(
        protected AdminServices $adminServices
    ) {}

    /**
     * Display the authenticated admin profile.
     */
    public function index(): View
    {
        $admin = $this->adminServices->authAdmin();

        return view('backend.profile.index', compact('admin'));
        
    }

    /**
     * Update the authenticated admin profile.
     */
    public function update(UpdateAdminProfileRequest $request): RedirectResponse
    {
        $admin = $this->adminServices->authAdmin();

        if (! $admin) {
            return redirect()->back()->with('error', 'Admin not authenticated.');
        }

        $adminData = UpdateAdminData::from($request);

        $this->adminServices->updateAdmin($admin->id, $adminData);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profile updated successfully!');
    }
}


