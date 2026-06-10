@extends('layouts.admin')

@section('header', 'Edit Produk')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex items-center">
            <a href="{{ route('admin.products.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Edit Produk: {{ $product->name }}</h2>
        </div>
        
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ $product->name }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" required>
                </div>
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" required>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                <input type="number" name="price" id="price" value="{{ $product->price }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">{{ $product->description }}</textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Ganti Gambar Produk</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" accept="image/*">
                @if($product->image)
                <div class="mt-4">
                    <p class="text-xs text-gray-500 mb-2">Gambar Saat Ini:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" class="h-32 rounded-lg border border-gray-100">
                </div>
                @endif
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition">
                <label for="is_featured" class="ml-3 text-sm font-medium text-gray-700">Tandai sebagai Produk Unggulan (Tampil di Beranda)</label>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    Perbarui Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
