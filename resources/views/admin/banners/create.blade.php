@extends('layouts.admin')

@section('header', 'Upload Banner Baru')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih File Banner (Ukuran Rekomendasi: 1920x1080)</label>
                <input type="file" name="image" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none" required accept="image/*">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Banner</label>
                    <select name="type" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none" required>
                        <option value="hero">Hero Banner (Slider Atas)</option>
                        <option value="iklan">Banner Iklan (Tengah Halaman)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Banner (Opsional)</label>
                    <input type="text" name="title" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none" placeholder="Contoh: Promo Spesial Ramadhan">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subjudul (Opsional)</label>
                    <input type="text" name="subtitle" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none" placeholder="Contoh: Diskon hingga 50%">
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Simpan Banner</button>
            </div>
        </form>
    </div>
</div>
@endsection
