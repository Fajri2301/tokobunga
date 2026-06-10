@extends('layouts.admin')

@section('header', 'Manajemen Tentang Kami')

@section('content')
<div class="max-w-4xl pb-20">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10">
            @csrf
            @method('PUT')

            <!-- Section 1: Tentang Kami Utama -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                    Seksi Tentang Kami Utama
                </h3>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Utama</label>
                            <input type="text" name="title" value="{{ $about->title }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subjudul (Warna Biru)</label>
                            <input type="text" name="subtitle" value="{{ $about->subtitle }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Paragraf 1 (Teks Tebal)</label>
                        <textarea name="description_1" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500" required>{{ $about->description_1 }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Paragraf 2</label>
                        <textarea name="description_2" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500">{{ $about->description_2 }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Pengalaman</label>
                            <input type="text" name="experience_years" value="{{ $about->experience_years }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Pelanggan</label>
                            <input type="text" name="clients_count" value="{{ $about->clients_count }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">% Bunga Segar</label>
                            <input type="text" name="fresh_flowers_pct" value="{{ $about->fresh_flowers_pct }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Utama (Seksi Tentang Kami)</label>
                        <input type="file" name="image" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500" accept="image/*">
                        @if($about->image)
                            <div class="mt-4 p-4 bg-gray-50 rounded-2xl inline-block border border-dashed border-gray-200">
                                <img src="{{ asset('storage/' . $about->image) }}" class="h-32 object-contain">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- Section 2: Creativity Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-purple-600 rounded-full"></span>
                    Seksi Creativity in Creating
                </h3>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Kecil (Atas)</label>
                            <input type="text" name="creativity_title" value="{{ $about->creativity_title }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500" placeholder="Creativity in Creating">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Utama (Besar)</label>
                            <input type="text" name="creativity_subtitle" value="{{ $about->creativity_subtitle }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500" placeholder="Always fresh and unique bouquets">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Creativity</label>
                        <textarea name="creativity_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500">{{ $about->creativity_description }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kiri (Radius 80%)</label>
                            <input type="file" name="image_creativity_left" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500" accept="image/*">
                            @if($about->image_creativity_left)
                                <div class="mt-4 p-4 bg-gray-50 rounded-2xl inline-block border border-dashed border-gray-200">
                                    <img src="{{ asset('storage/' . $about->image_creativity_left) }}" class="h-32 w-32 object-cover" style="border-radius: 80%;">
                                </div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kanan (Radius 80%)</label>
                            <input type="file" name="image_creativity_right" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-blue-500" accept="image/*">
                            @if($about->image_creativity_right)
                                <div class="mt-4 p-4 bg-gray-50 rounded-2xl inline-block border border-dashed border-gray-200">
                                    <img src="{{ asset('storage/' . $about->image_creativity_right) }}" class="h-32 w-32 object-cover" style="border-radius: 80%;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <button type="submit" class="px-10 py-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Semua Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
