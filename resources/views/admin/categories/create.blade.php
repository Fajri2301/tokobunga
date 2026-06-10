@extends('layouts.admin')

@section('header', 'Tambah Kategori')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex items-center">
            <a href="{{ route('admin.categories.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Buat Kategori Baru</h2>
        </div>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" placeholder="Contoh: Bunga Mawar" required>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active_on_home" id="is_active_on_home" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition">
                <label for="is_active_on_home" class="ml-3 text-sm font-medium text-gray-700">Aktifkan di Halaman Utama (Tampilkan 4 produk dari kategori ini)</label>
            </div>

            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Upload Gambar</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" accept="image/*">
                <p class="mt-2 text-xs text-gray-500 italic">*Pilih file gambar dari komputer Anda (JPG, PNG, max 2MB).</p>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
