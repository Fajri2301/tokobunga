<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Contracts\SettingRepositoryInterface;

class SettingController extends Controller
{
    use \App\Traits\HasImageUpload;

    protected SettingRepositoryInterface $repository;

    public function __construct(SettingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function edit()
    {
        $setting = $this->repository->getGlobalSettings();
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        try {
            $setting = Setting::firstOrCreate(['id' => 1]);

            $request->validate([
                'site_name' => 'required|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255',
                'site_logo' => 'nullable|mimes:jpeg,png,jpg,svg,webp|max:2048',
                'site_favicon' => 'nullable|mimes:png,ico,svg,xml|max:512',
                'phone_number' => 'nullable|string|max:20',
                'whatsapp_number' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'google_maps_link' => 'nullable|string',
                'instagram_url' => 'nullable|url|max:255',
                'facebook_url' => 'nullable|url|max:255',
                'footer_text' => 'nullable|string|max:255',
            ]);

            $data = $request->only([
                'site_name', 'meta_title', 'meta_description', 'meta_keywords',
                'phone_number', 'whatsapp_number', 'email', 
                'address', 'google_maps_link', 'instagram_url', 'facebook_url', 'footer_text'
            ]);

            // Security: XSS Protection for Google Maps
            if (!empty($data['google_maps_link'])) {
                if (!str_contains($data['google_maps_link'], '<iframe')) {
                    return back()->withErrors(['google_maps_link' => 'Input harus berupa kode <iframe> Google Maps yang valid.'])->withInput();
                }
            }

            // Handle Logo
            if ($request->hasFile('site_logo')) {
                $data['site_logo'] = $this->uploadImage($request->file('site_logo'), 'settings', $setting->site_logo);
            }

            // Handle Favicon
            if ($request->hasFile('site_favicon')) {
                $data['site_favicon'] = $this->uploadImage($request->file('site_favicon'), 'settings', $setting->site_favicon);
            }

            $setting->update($data);
            $this->repository->clearCache();

            return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Update Settings Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()])->withInput();
        }
    }
}
