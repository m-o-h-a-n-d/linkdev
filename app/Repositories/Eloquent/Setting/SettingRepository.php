<?php

namespace App\Repositories\Eloquent\Setting;

use App\Data\Setting\UpdateSettingData;
use App\Models\Setting;
use App\Repositories\Contracts\Setting\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    /**
     * Retrieve the singleton system settings record.
     */
    public function getSettings(): Setting
    {
        return Setting::firstOrCreate(
            ['id' => 1],
            [
                'session'       => 'Season 2025/26',
                'header'        => 'Every throw, every save, every point.',
                'description'   => 'The public portal for handball competitions — follow live matches, group standings, and team form as the season unfolds.',
                'favicon'       => null,
                'icon'          => null,
                'matches_image' => 'frontend/images/ihf-bracket.png',
            ]
        );
    }

    /**
     * Update the settings record with data and optional uploaded image paths.
     */
    public function update(Setting $setting, UpdateSettingData $data, array $imagePaths = []): Setting
    {
        $payload = [
            'session'     => $data->session,
            'header'      => $data->header,
            'description' => $data->description,
        ];

        foreach ($imagePaths as $field => $path) {
            if ($path !== null) {
                $payload[$field] = $path;
            }
        }

        $setting->update($payload);

        return $setting->fresh();
    }
}
