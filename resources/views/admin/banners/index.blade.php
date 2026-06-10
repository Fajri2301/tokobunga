@extends('layouts.admin')

@section('header', 'Manajemen Banner')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Daftar Banner</h2>
        <a href="{{ route('admin.banners.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Upload Banner
        </a>
    </div>
    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($banners as $banner)
        <div class="relative group rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
            <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-48 object-cover">
            <div class="p-4 bg-white flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-800">{{ $banner->title ?? 'Tanpa Judul' }}</h3>
                    <p class="text-xs text-gray-400">Diunggah pada: {{ $banner->created_at->format('d M Y') }}</p>
                </div>
                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
