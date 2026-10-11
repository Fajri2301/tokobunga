<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\SettingRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    use HasImageUpload;

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
        $data = $request->validate([
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
            'instagram_url' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string|max:255',
        ]);

        try {
            $setting = Setting::first() ?? new Setting(['id' => 1]);

            // Auto-prefix https:// jika user mengetik domain tanpa protokol
            if (!empty($data['instagram_url']) && !str_starts_with($data['instagram_url'], 'http://') && !str_starts_with($data['instagram_url'], 'https://')) {
                $data['instagram_url'] = 'https://' . $data['instagram_url'];
            }
            if (!empty($data['facebook_url']) && !str_starts_with($data['facebook_url'], 'http://') && !str_starts_with($data['facebook_url'], 'https://')) {
                $data['facebook_url'] = 'https://' . $data['facebook_url'];
            }

            // Handle Logo
            if ($request->hasFile('site_logo')) {
                $data['site_logo'] = $this->uploadImage($request->file('site_logo'), 'settings', $setting->site_logo);
            }

            // Handle Favicon
            if ($request->hasFile('site_favicon')) {
                $data['site_favicon'] = $this->uploadImage($request->file('site_favicon'), 'settings', $setting->site_favicon);
            }

            $setting->fill($data);
            $setting->save();
            $this->repository->clearCache();

            return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Update Settings Error: '.$e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: '.$e->getMessage()])->withInput();
        }
    }
}
