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

            // Dukungan untuk Intervention Image v2 dan v3
            if (method_exists(\Intervention\Image\ImageManager::class, 'read')) {
                // Syntax Intervention v3
                $image = \Intervention\Image\Laravel\Facades\Image::read($file->getRealPath());
                $encoded = $image->toWebp(80);
            } else {
                // Syntax Intervention v2 (Fallback)
                $facade = class_exists(\Intervention\Image\Facades\Image::class) 
                    ? \Intervention\Image\Facades\Image::class 
                    : \Intervention\Image\ImageManagerStatic::class;
                $image = $facade::make($file->getRealPath());
                $encoded = $image->encode('webp', 80);
            }
            
            // Simpan ke storage public
            Storage::disk('public')->put($path, (string) $encoded);
            
            return $path;
        } catch (\Throwable $e) {
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
