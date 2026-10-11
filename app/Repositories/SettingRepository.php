<?php

namespace App\Repositories;

use App\Contracts\SettingRepositoryInterface;
use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    public function getGlobalSettings()
    {
        // Settings adalah single row (singleton) untuk seluruh website.
        // Ambil baris setting pertama yang ada, atau buat baru dengan default jika tabel masih kosong.
        return Setting::first() ?? Setting::create([
            'id' => 1,
            'site_name' => 'Zanki Dausat Flower',
            'meta_title' => 'Zanki Dausat Flower - Premium Florist',
            'meta_description' => 'Toko bunga terpercaya dengan rangkaian bunga segar pilihan.',
            'phone_number' => '0812-3456-7890',
            'whatsapp_number' => '628123456789',
            'email' => 'hello@zankidausat.com',
            'address' => 'Jl. Bunga Melati No. 123, Jakarta',
            'footer_text' => 'Menghadirkan keindahan alam langsung ke depan pintu Anda.',
        ]);
    }

    public function clearCache(): void
    {
        // Kept for the interface contract. Global settings are read directly
        // so updates made by admin are visible on the next public request.
    }
}
