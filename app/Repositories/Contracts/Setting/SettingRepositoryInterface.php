<?php

namespace App\Repositories\Contracts\Setting;

use App\Data\Setting\UpdateSettingData;
use App\Models\Setting;

interface SettingRepositoryInterface
{
    /**
     * Retrieve the singleton system settings model.
     */
    public function getSettings(): Setting;

    /**
     * Update the settings record with payload data and processed image paths.
     *
     * @param array<string, string|null> $imagePaths
     */
    public function update(Setting $setting, UpdateSettingData $data, array $imagePaths = []): Setting;
}
