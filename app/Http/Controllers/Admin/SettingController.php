<?php

namespace App\Http\Controllers\Admin;

use App\Data\Setting\UpdateSettingData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Services\Setting\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    /**
     * Display the settings edit form.
     */
    public function edit(): View
    {
        $settings = $this->settingService->getSettings();

        return view('backend.settings.edit', compact('settings'));
    }

    /**
     * Update the system settings.
     */
    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $settingData = UpdateSettingData::from($request);

        $this->settingService->update($settingData);

        return redirect()->route('admin.settings.edit')
            ->with('success', 'System settings have been updated successfully!');
    }
}
