@extends('layouts.app')

@section('title', 'Katalog Produk - ' . ($global_setting->site_name ?? 'Flora'))

@section('content')
<div class="pt-32 md:pt-48 pb-24">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-6 md:px-8 mb-16">
        <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4" style="font-family: 'Poppins', sans-serif;">
            Katalog Produk
        </h1>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <p class="text-white/80 text-lg max-w-xl font-medium italic">
                Temukan rangkaian bunga terbaik untuk setiap momen spesial Anda.
            </p>
            
            <!-- Category Filter Pills -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('catalog.index') }}" class="px-6 py-2 rounded-full font-bold text-xs uppercase tracking-widest transition-all {{ !request('category') ? 'bg-white text-[#545454] shadow-lg' : 'bg-[#545454]/30 text-white hover:bg-[#545454]/50' }}">
                    Semua
                </a>
                @foreach($global_categories as $cat)
                <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}" class="px-6 py-2 rounded-full font-bold text-xs uppercase tracking-widest transition-all {{ request('category') == $cat->slug ? 'bg-white text-[#545454] shadow-lg' : 'bg-[#545454]/30 text-white hover:bg-[#545454]/50' }}">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-6 md:px-8">
        @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
            @foreach($products as $product)
            <div class="w-full rounded-[24px] bg-[#87ceeb] p-0 shadow-xl flex flex-col overflow-hidden group transition-all hover:-translate-y-2">
                <!-- Image Section -->
                <div class="h-48 md:h-64 w-full bg-white relative overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-110" />
                    @if($product->is_featured)
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-black text-[#87ceeb] uppercase tracking-widest shadow-sm">Featured</div>
                    @endif
                </div>
                
                <!-- Info Section -->
                <div class="relative flex-1 bg-white p-4 md:p-6 flex flex-col justify-between shadow-sm border-t border-gray-50">
                    <div>
                        <h3 class="text-[14px] md:text-lg font-bold leading-tight text-[#545454] uppercase tracking-tighter line-clamp-2">{{ $product->name }}</h3>
                        <p class="text-gray-400 text-[10px] md:text-xs font-bold uppercase mt-1">{{ $product->category->name }}</p>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm md:text-xl font-black text-gray-700">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        
                        <button onclick="addToCart({{ $product->id }})" class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-[#87ceeb] text-white flex items-center justify-center hover:bg-[#545454] transition-all shadow-lg active:scale-90">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </button>
                    </div>
                </div>
                
                <!-- Bottom Link -->
                <a href="{{ route('catalog.show', $product->slug) }}" class="w-full py-3 text-center text-xs md:text-sm font-bold text-white uppercase tracking-widest hover:bg-white/10 transition-colors">Lihat Detail</a>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-16">
            {{ $products->links() }}
        </div>
        @else
        <div class="bg-white/10 backdrop-blur-md rounded-[40px] p-20 text-center border border-white/10">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 text-white">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-white uppercase mb-2">Produk tidak ditemukan</h3>
            <p class="text-white/60">Coba pilih kategori lain atau kembali ke semua produk.</p>
        </div>
        @endif
    </div>
</div>
@endsection
