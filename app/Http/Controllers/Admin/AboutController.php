<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        // Ambil data pertama, jika tidak ada buat baru dengan nilai default
        $about = About::firstOrCreate(['id' => 1], [
            'title' => 'Membawa Kesegaran',
            'subtitle' => 'Alam ke Ruangan Anda',
            'description_1' => 'TokoBunga lahir dari kecintaan kami terhadap seni merangkai bunga.',
            'description_2' => 'Setiap koleksi kami dirangkai dengan tangan-tangan ahli menggunakan bunga segar pilihan.',
            'creativity_title' => 'Creativity in Creating',
            'creativity_subtitle' => 'Always fresh and unique bouquets',
            'creativity_description' => 'Kami menyediakan berbagai pilihan rangkaian bunga berkualitas yang dirangkai dengan bunga segar pilihan dan desain elegan untuk berbagai kebutuhan dan momen penting Anda di wilayah Jabodetabek.',
            'experience_years' => '10+',
            'clients_count' => '5K+',
            'fresh_flowers_pct' => '100%'
        ]);

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = About::first();

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description_1' => 'required|string',
            'description_2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'creativity_title' => 'nullable|string|max:255',
            'creativity_subtitle' => 'nullable|string|max:255',
            'creativity_description' => 'nullable|string',
            'image_creativity_left' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_creativity_right' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'experience_years' => 'nullable|string|max:50',
            'clients_count' => 'nullable|string|max:50',
            'fresh_flowers_pct' => 'nullable|string|max:50',
        ]);

        $data = $request->except(['image', 'image_creativity_left', 'image_creativity_right']);

        // Handle Main Image
        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        // Handle Creativity Left Image
        if ($request->hasFile('image_creativity_left')) {
            if ($about->image_creativity_left) {
                Storage::disk('public')->delete($about->image_creativity_left);
            }
            $data['image_creativity_left'] = $request->file('image_creativity_left')->store('about', 'public');
        }

        // Handle Creativity Right Image
        if ($request->hasFile('image_creativity_right')) {
            if ($about->image_creativity_right) {
                Storage::disk('public')->delete($about->image_creativity_right);
            }
            $data['image_creativity_right'] = $request->file('image_creativity_right')->store('about', 'public');
        }

        $about->update($data);

        return redirect()->back()->with('success', 'Informasi Tentang Kami & Creativity berhasil diperbarui.');
    }
}
