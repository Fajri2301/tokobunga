<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class SettingRepository implements SettingRepositoryInterface
{
    public function getGlobalSettings()
    {
        return Cache::remember('site_settings', 3600, function () {
            return Setting::firstOrCreate(['id' => 1], [
                'site_name' => 'Flora',
                'footer_text' => 'Flora - Specialized Smells, Specialized Bouquets',
                'meta_title' => 'Flora Premium Florist',
                'meta_description' => 'Toko bunga terpercaya dengan rangkaian bunga segar pilihan.',
                'whatsapp_number' => '628123456789'
            ]);
        });
    }

    public function clearCache(): void
    {
        Cache::forget('site_settings');
    }
}
