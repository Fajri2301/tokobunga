<?php

namespace App\Repositories;

use App\Contracts\SettingRepositoryInterface;
use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    public function getGlobalSettings()
    {
        return Setting::firstOrCreate(['id' => 1], [
            'site_name' => 'Zanki Dausat Flower',
            'footer_text' => 'Menghadirkan keindahan alam langsung ke depan pintu Anda.',
            'meta_title' => 'Zanki Dausat Flower - Premium Florist',
            'meta_description' => 'Toko bunga terpercaya dengan rangkaian bunga segar pilihan.',
            'whatsapp_number' => '628123456789',
        ]);
    }

    public function clearCache(): void
    {
        // Kept for the interface contract. Global settings are read directly
        // so updates made by admin are visible on the next public request.
    }
}
