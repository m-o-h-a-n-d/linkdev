<?php

namespace App\Services\Setting;

use App\Data\Setting\UpdateSettingData;
use App\Models\Setting;
use App\Repositories\Contracts\Setting\SettingRepositoryInterface;
use App\Utility\ActivityLogger;
use App\Utility\ImageManager;
use Illuminate\Http\UploadedFile;

class SettingService
{
    public function __construct(
        protected SettingRepositoryInterface $settingRepository,
        protected ImageManager $imageManager
    ) {}

    /**
     * Retrieve the current system settings.
     */
    public function getSettings(): Setting
    {
        return $this->settingRepository->getSettings();
    }

    /**
     * Update settings and manage media uploads.
     */
    public function update(UpdateSettingData $data): Setting
    {
        $setting = $this->getSettings();
        $imagePaths = [];

        // 1. Favicon Upload
        if ($data->favicon instanceof UploadedFile) {
            $oldFavicon = ($setting->favicon && ! str_starts_with($setting->favicon, 'frontend/'))
                ? $setting->favicon
                : null;

            $imagePaths['favicon'] = $this->imageManager->upload(
                $data->favicon,
                'settings',
                'public',
                $oldFavicon
            );
        }

        // 2. Logo / Icon Upload
        if ($data->icon instanceof UploadedFile) {
            $oldIcon = ($setting->icon && ! str_starts_with($setting->icon, 'frontend/'))
                ? $setting->icon
                : null;

            $imagePaths['icon'] = $this->imageManager->upload(
                $data->icon,
                'settings',
                'public',
                $oldIcon
            );
        }

        // 3. Matches Diagram / Bracket Image Upload
        if ($data->matches_image instanceof UploadedFile) {
            $oldMatchesImage = ($setting->matches_image && ! str_starts_with($setting->matches_image, 'frontend/'))
                ? $setting->matches_image
                : null;

            $imagePaths['matches_image'] = $this->imageManager->upload(
                $data->matches_image,
                'settings',
                'public',
                $oldMatchesImage
            );
        }

        $updatedSetting = $this->settingRepository->update($setting, $data, $imagePaths);

        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'Setting',
            entityId: $updatedSetting->id,
            description: "Updated system settings (Session: '{$updatedSetting->session}', Header: '{$updatedSetting->header}')."
        );

        return $updatedSetting;
    }
}
