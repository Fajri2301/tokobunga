<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        // Cari record terbaik (yang paling akhir diupdate atau memiliki data terisi)
        $best = DB::table('settings')
            ->whereNotNull('site_name')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->first();

        if (! $best) {
            $best = DB::table('settings')->orderByDesc('id')->first();
        }

        if ($best) {
            // Hapus semua row duplikat lainnya
            DB::table('settings')->where('id', '!=', $best->id)->delete();

            // Jika row terbaik belum bernomor id = 1, sesuaikan agar id = 1
            if ($best->id != 1) {
                // Pastikan tidak ada konflik id = 1
                DB::table('settings')->where('id', 1)->delete();
                DB::table('settings')->where('id', $best->id)->update(['id' => 1]);
            }
        } else {
            // Jika tabel kosong sama sekali, buat 1 record default
            DB::table('settings')->insert([
                'id' => 1,
                'site_name' => 'Zanki Dausat Flower',
                'meta_title' => 'Zanki Dausat Flower - Premium Florist',
                'meta_description' => 'Toko bunga terpercaya dengan rangkaian bunga segar pilihan.',
                'phone_number' => '0812-3456-7890',
                'whatsapp_number' => '628123456789',
                'email' => 'hello@zankidausat.com',
                'address' => 'Jl. Bunga Melati No. 123, Jakarta',
                'footer_text' => 'Menghadirkan keindahan alam langsung ke depan pintu Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: data consolidation is irreversible and idempotent
    }
};
