@extends('layouts.app')

@section('title', 'Katalog Produk - ' . ($global_setting->site_name ?? 'Zanki Dausat Flower'))

@section('content')
<div class="pt-28 sm:pt-32 md:pt-48 pb-24">

    {{-- ── Header Section ──────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mb-10 sm:mb-16">
        <div class="mb-6 reveal" data-reveal-delay="0">
            <p class="text-white/60 text-xs font-bold uppercase tracking-[0.3em] mb-3">Koleksi Kami</p>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black text-white uppercase tracking-tighter leading-none">
                Katalog <span class="text-[#0cc0df]">Produk</span>
            </h1>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 reveal" data-reveal-delay="100">
            <p class="text-white/70 text-base max-w-md leading-relaxed">
                Temukan rangkaian bunga terbaik untuk setiap momen spesial Anda.
            </p>

            {{-- Category Filter Pills — scroll horizontal di mobile --}}
            <div class="w-full md:w-auto overflow-x-auto scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0 pb-1">
                <div class="flex flex-nowrap md:flex-wrap gap-2 w-max md:w-auto min-w-full sm:min-w-0">
                    <a href="{{ route('catalog.index') }}"
                       class="shrink-0 px-5 py-2 rounded-full font-semibold text-xs uppercase tracking-widest transition-all duration-200
                              {{ !request('category') ? 'bg-[#FAF8F5] text-[#0D2137] shadow-lg shadow-black/10' : 'bg-white/10 text-white hover:bg-white/20 border border-white/20' }}">
                        Semua
                    </a>
                    @foreach($global_categories as $cat)
                    <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}"
                       class="shrink-0 px-5 py-2 rounded-full font-semibold text-xs uppercase tracking-widest transition-all duration-200
                              {{ request('category') == $cat->slug ? 'bg-[#FAF8F5] text-[#0D2137] shadow-lg shadow-black/10' : 'bg-white/10 text-white hover:bg-white/20 border border-white/20' }}">
                        {{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── Products Grid ────────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
            @foreach($products as $i => $product)
            <div class="group reveal" data-reveal-delay="{{ ($i % 4) * 80 }}">
                <div class="w-full rounded-2xl bg-white shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-200 flex flex-col overflow-hidden
                            transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-[0_10px_40px_rgba(0,0,0,0.1)]">

                    {{-- Image — bisa diklik langsung ke detail --}}
                    <a href="{{ route('catalog.show', $product->slug) }}" class="relative h-36 sm:h-48 md:h-60 w-full bg-gray-50 overflow-hidden rounded-t-2xl border-b border-gray-100 block">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-contain p-3 sm:p-4 transition-transform duration-500 group-hover:scale-108"
                             loading="lazy">
                        @if($product->is_featured)
                        <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-[#0cc0df] text-white text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            ✦ Featured
                        </div>
                        @endif
                    </a>

                    {{-- Info --}}
                    <div class="flex-1 p-3 sm:p-4 md:p-5 flex flex-col gap-1 sm:gap-2">
                        <p class="text-[9px] sm:text-[10px] font-bold text-[#0cc0df] uppercase tracking-widest">{{ $product->category->name }}</p>
                        <a href="{{ route('catalog.show', $product->slug) }}" class="text-xs sm:text-sm md:text-[15px] font-bold leading-tight text-[#0D2137] line-clamp-2 hover:text-[#0cc0df] transition-colors">{{ $product->name }}</a>
                    </div>

                    {{-- Price & Action — harga full-width, aksi di baris bawah agar tidak pecah di layar kecil --}}
                    <div class="px-3 pb-3 sm:px-4 sm:pb-4 md:px-5 md:pb-5 flex flex-col gap-2">
                        <span class="text-sm sm:text-base md:text-lg font-black text-[#0D2137]">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <div class="flex items-center justify-between gap-2">
                            <a href="{{ route('catalog.show', $product->slug) }}"
                               class="flex-1 text-center text-[10px] font-bold text-gray-500 hover:text-[#0cc0df] transition-colors uppercase tracking-wider bg-[#FAF8F5] border border-gray-200 px-3 py-2 rounded-xl">
                                Detail
                            </a>
                            <button onclick="addToCart({{ $product->id }}, this)" aria-label="Tambah ke keranjang"
                                     class="w-9 h-9 shrink-0 rounded-xl bg-[#FAF8F5] border border-gray-200 text-gray-400 flex items-center justify-center
                                            hover:bg-[#0cc0df] hover:text-white hover:border-[#0cc0df] transition-all duration-300 shadow-sm active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-12 sm:mt-16 pagination-dark">
            {{ $products->links() }}
        </div>

        @else
        <div class="bg-white/10 backdrop-blur-md rounded-[24px] sm:rounded-[40px] p-10 sm:p-20 text-center border border-white/10 reveal">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 text-white">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white uppercase mb-2 tracking-tight">Produk tidak ditemukan</h3>
            <p class="text-white/60 mb-8">Coba pilih kategori lain atau kembali ke semua produk.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block px-8 py-3 bg-[#FAF8F5] text-[#0D2137] rounded-full font-bold text-sm hover:bg-[#0cc0df] hover:text-white transition-all">
                Lihat Semua Produk
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
