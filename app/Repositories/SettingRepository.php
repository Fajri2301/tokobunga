<?php

namespace App\Repositories;

use App\Contracts\SettingRepositoryInterface;
use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    public function getGlobalSettings()
    {
        // Row settings dijamin ada oleh DatabaseSeeder.
        // Jika tidak ada (misal fresh install tanpa seeder), kembalikan instance kosong agar tidak crash.
        return Setting::firstOrNew(['id' => 1]);
    }

    public function clearCache(): void
    {
        // Kept for the interface contract. Global settings are read directly
        // so updates made by admin are visible on the next public request.
    }
}
