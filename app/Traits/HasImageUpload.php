<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait HasImageUpload
{
    /**
     * Handle image upload and return the path.
     */
    public function uploadImage(UploadedFile $file, string $folder, ?string $oldPath = null): string
    {
        if ($oldPath) {
            $this->deleteImage($oldPath);
        }

        // Jangan convert jika file berupa SVG atau ICO
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, ['svg', 'ico', 'xml'])) {
            return $file->store($folder, 'public');
        }

        try {
            // Generate nama file dengan ekstensi .webp
            $filename = uniqid('img_') . '_' . time() . '.webp';
            $path = $folder . '/' . $filename;

            // Baca image dengan Intervention v3 lalu convert ke WebP kualitas 80%
            $image = \Intervention\Image\Laravel\Facades\Image::read($file->getRealPath());
            $encoded = $image->toWebp(80);
            
            // Simpan ke storage public
            Storage::disk('public')->put($path, (string) $encoded);
            
            return $path;
        } catch (\Exception $e) {
            // Jika terjadi error pada proses convert, gunakan cara normal sebagai fallback
            \Illuminate\Support\Facades\Log::error('Image optimization failed: ' . $e->getMessage());
            return $file->store($folder, 'public');
        }
    }

    /**
     * Delete image from storage.
     */
    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
