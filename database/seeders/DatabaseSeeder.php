<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@flora.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        // Seed default site settings — bisa diubah lewat panel admin setelah deploy.
        // updateOrCreate memastikan data ini tidak ditimpa ulang jika seeder dijalankan dua kali.
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Zanki Dausat Flower',
                'meta_title' => 'Zanki Dausat Flower - Premium Florist',
                'meta_description' => 'Toko bunga terpercaya dengan rangkaian bunga segar pilihan.',
                'phone_number' => '0812-3456-7890',
                'whatsapp_number' => '628123456789',
                'email' => 'hello@zankidausat.com',
                'address' => 'Jl. Bunga Melati No. 123, Jakarta',
                'footer_text' => 'Menghadirkan keindahan alam langsung ke depan pintu Anda.',
            ]
        );

        $categories = [
            ['name' => 'Bunga Papan', 'image' => 'https://images.unsplash.com/photo-1596073413908-4402caddecff?q=80&w=400'],
            ['name' => 'Buket Bunga', 'image' => 'https://images.unsplash.com/photo-1523694553227-ec1c4669772c?q=80&w=400'],
            ['name' => 'Bunga Meja', 'image' => 'https://images.unsplash.com/photo-1519336367661-eba9c1dfa5e9?q=80&w=400'],
            ['name' => 'Standing Flower', 'image' => 'https://images.unsplash.com/photo-1511690078903-71dc5a49f5e3?q=80&w=400'],
        ];

        foreach ($categories as $cat) {
            $category = Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'image' => $cat['image'],
            ]);

            for ($i = 1; $i <= 5; $i++) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $cat['name'].' '.$i,
                    'slug' => Str::slug($cat['name'].' '.$i),
                    'description' => 'Ini adalah deskripsi untuk '.$cat['name'].' '.$i.'. Bunga segar pilihan yang dirangkai dengan penuh cinta untuk momen spesial Anda.',
                    'price' => rand(150000, 1500000),
                    'image' => $cat['image'], // Reusing category image for simplicity in demo
                    'is_featured' => $i <= 2,
                ]);
            }
        }
    }
}
