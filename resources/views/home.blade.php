@extends('layouts.app')

@section('content')

    <!-- 5B. Hero Section -->
    <section class="pt-24 sm:pt-28 md:pt-36 max-w-7xl mx-auto px-4 sm:px-6 md:px-16 relative z-10">
        <div class="swiper hero-swiper overflow-hidden md:!overflow-visible"> 
            <div class="swiper-wrapper">
                @forelse($banners as $banner)
                    <div class="swiper-slide">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-12 min-h-[300px] md:min-h-[350px]">
                            <div class="w-full md:w-1/2 flex flex-col justify-center text-center md:text-left py-0 self-center z-20">
                                <span class="text-[#0cc0df] text-sm uppercase tracking-[0.2em] font-black mb-2 block">Edisi Terbatas</span>
                                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white leading-[1.1] mb-2 drop-shadow-sm">
                                    {!! nl2br(e($banner->title ?? 'Aroma Spesial, Buket Istimewa')) !!}
                                </h1>
                                <p class="text-[#FAF8F5]/90 text-lg leading-snug mb-4 max-w-lg mx-auto md:mx-0 font-medium">
                                    {{ $banner->subtitle ?? 'Hadirkan kebahagiaan melalui rangkaian bunga pilihan.' }}
                                </p>
                                <div class="flex justify-center md:justify-start">
                                    <a href="{{ route('catalog.index') }}" class="w-fit h-[48px] px-10 bg-white text-[#0cc0df] font-bold rounded-full flex items-center justify-center transition-all shadow-lg hover:bg-gray-50 text-base border border-gray-100">
                                        Pesan Buket Anda
                                    </a>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 flex items-center justify-center relative">
                                <div class="aspect-[5/4] w-full max-w-[750px] flex items-center justify-center relative md:translate-y-4 lg:translate-y-8 scale-100 sm:scale-105 md:scale-125">
                                    <img src="{{ str_starts_with($banner->image, 'http') ? $banner->image : asset('storage/' . $banner->image) }}"
                                         class="h-full w-full object-contain drop-shadow-[0_20px_60px_rgba(0,0,0,0.1)]"
                                         alt="{{ $banner->title }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- FIX: branded fallback, bukan teks plain italic --}}
                    <div class="swiper-slide">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-12 min-h-[300px] md:min-h-[350px]">
                            <div class="w-full md:w-1/2 flex flex-col justify-center text-center md:text-left py-0 self-center z-20">
                                <span class="text-[#0cc0df] text-sm uppercase tracking-[0.2em] font-black mb-2 block">Koleksi Terbaru</span>
                                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white leading-[1.1] mb-4 drop-shadow-sm">
                                    Buket Segar,<br>Momen Istimewa
                                </h1>
                                <p class="text-[#FAF8F5]/90 text-lg leading-snug mb-6 max-w-lg mx-auto md:mx-0 font-medium">
                                    Temukan rangkaian bunga pilihan untuk setiap perayaan hidup Anda.
                                </p>
                                <div class="flex justify-center md:justify-start">
                                    <a href="{{ route('catalog.index') }}" class="w-fit h-[48px] px-10 bg-white text-[#0cc0df] font-bold rounded-full flex items-center justify-center transition-all shadow-lg hover:bg-gray-50 text-base border border-gray-100">
                                        Lihat Katalog
                                    </a>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 flex items-center justify-center opacity-20">
                                <svg class="w-48 h-48 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>

            {{-- Navigasi manual (desktop) --}}
            <button aria-label="Banner sebelumnya" class="hero-prev absolute left-0 lg:-left-4 top-1/2 -translate-y-1/2 z-20 hidden md:flex w-11 h-11 items-center justify-center rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-white hover:bg-white/30 transition-all shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button aria-label="Banner berikutnya" class="hero-next absolute right-0 lg:-right-4 top-1/2 -translate-y-1/2 z-20 hidden md:flex w-11 h-11 items-center justify-center rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-white hover:bg-white/30 transition-all shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </section>

    <!-- Wave Effect -->
    <div class="w-full relative z-0 leading-[0] -mt-14 sm:-mt-20 md:-mt-32 lg:-mt-40">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-[100.5%] h-auto min-w-[100.5%] -ml-[0.25%]" preserveAspectRatio="none">
            <path fill="#FAF8F5" fill-opacity="1" d="M0,256L26.7,245.3C53.3,235,107,213,160,202.7C213.3,192,267,192,320,202.7C373.3,213,427,235,480,213.3C533.3,192,587,128,640,90.7C693.3,53,747,43,800,53.3C853.3,64,907,96,960,122.7C1013.3,149,1067,171,1120,160C1173.3,149,1227,107,1280,112C1333.3,117,1387,171,1413,197.3L1440,224L1440,320L1413.3,320C1386.7,320,1333,320,1280,320C1226.7,320,1173,320,1120,320C1066.7,320,1013,320,960,320C906.7,320,853,320,800,320C746.7,320,693,320,640,320C586.7,320,533,320,480,320C426.7,320,373,320,320,320C266.7,320,213,320,160,320C106.7,320,53,320,27,320L0,320Z"></path>
        </svg>
    </div>

    <div class="bg-[#FAF8F5] relative -mt-1 shadow-sm z-20 pb-4 md:pb-6">
        <!-- Ad Banner Section -->
        <section class="pt-12 pb-6 px-6 md:px-8 relative">
            <div class="relative w-full max-w-[1200px] mx-auto">
                <img src="{{ asset('assets/kembangataskiri.png') }}" alt="Decoration" class="absolute -top-10 -left-2 sm:-top-20 md:-top-28 md:left-0 w-20 sm:w-40 md:w-72 h-auto z-20 pointer-events-none drop-shadow-lg">
                <img src="{{ asset('assets/kembangbawahkanan.png') }}" alt="Decoration" class="absolute -bottom-10 -right-2 sm:-bottom-20 md:-bottom-28 md:right-0 w-20 sm:w-40 md:w-72 h-auto z-20 pointer-events-none drop-shadow-lg">
                <div class="filter drop-shadow-[0_20px_50px_rgba(0,0,0,0.2)] relative z-10">
                    @if($adBanner)
                        <img src="{{ str_starts_with($adBanner->image, 'http') ? $adBanner->image : asset('storage/' . $adBanner->image) }}" class="w-full h-auto object-cover ad-banner-custom-cut" alt="Promo">
                    @else
                        <div class="relative w-full h-[300px] bg-slate-100 flex items-center justify-center text-slate-400 font-bold italic border-2 border-dashed border-slate-200 ad-banner-custom-cut">Silakan unggah Banner Iklan.</div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Kategori -->
        <section class="py-4 max-w-7xl mx-auto px-6 md:px-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-[#0D2137] tracking-tight uppercase">Kategori</h2>
                <div class="h-px flex-grow ml-4 bg-slate-200 hidden md:block"></div>
            </div>
            <div class="flex overflow-x-auto pb-4 gap-6 md:gap-10 scrollbar-hide snap-x snap-mandatory pt-2">
                @foreach($categories as $category)
                <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="flex-none group snap-center text-center">
                    <div class="relative mb-2">
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full p-1 border-2 border-slate-300 group-hover:border-[#F4799A] transition-all duration-300">
                            <div class="w-full h-full rounded-full bg-white overflow-hidden flex items-center justify-center p-2 shadow-sm">
                                <img src="{{ str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image) }}" class="w-full h-full object-contain group-hover:scale-110 transition-all" alt="{{ $category->name }}">
                            </div>
                        </div>
                        <div class="absolute -top-1 -right-1 bg-[#F4799A] text-white text-[8px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm z-10">{{ $category->products_count ?? $category->products()->count() }}</div>
                    </div>
                    <span class="block text-[10px] md:text-xs font-bold text-[#0D2137] group-hover:text-[#F4799A] transition-colors uppercase tracking-tighter">{{ $category->name }}</span>
                </a>
                @endforeach
            </div>
        </section>
    </div>

    <!-- Main Content with Dark Background -->
    <div class="bg-[#FAF8F5] -mt-8 pt-12 pb-24 relative">
        <!-- Floral Transition Element -->
        <div class="relative z-30 -mt-20 mb-10 flex justify-center px-6">
            <img src="{{ asset('assets/elementbunga1000x300pxlandskap.png') }}" 
                 class="w-full max-w-[300px] h-auto pointer-events-none drop-shadow-2xl" 
                 alt="Floral Decoration">
        </div>

        <!-- Dynamic Category Bento Grids -->
        @foreach($homeCategories as $index => $homeCat)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 {{ $index === 0 ? 'mt-4' : 'mt-16 sm:mt-24' }} mb-8 text-center md:text-left">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-[#0D2137] uppercase tracking-tighter">
                {{ $homeCat->name }}
            </h2>
        </div>
        <section class="pb-12 max-w-7xl mx-auto px-4 sm:px-6 md:px-8 relative z-10">
            <div class="w-full flex flex-col-reverse lg:flex-row gap-6 items-stretch">
                <div class="flex-1 flex flex-col gap-6">
                        {{-- FIX: Semua 3 kartu tampil; mobile pakai scroll horizontal --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                            @foreach($homeCat->products->take(3) as $pIndex => $product)
                            <div class="w-full rounded-[24px] bg-white border border-gray-200 shadow-[0_4px_20px_rgba(0,0,0,0.05)] hover:shadow-[0_10px_40px_rgba(0,0,0,0.1)] hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group {{ $pIndex == 2 ? 'hidden md:flex' : '' }}">
                                <div class="h-40 md:h-56 w-full bg-gray-50 relative p-4 flex items-center justify-center overflow-hidden rounded-t-[24px] border-b border-gray-100">
                                    <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-110" />
                                </div>
                                <div class="relative flex-1 p-5 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] text-[#0cc0df] font-bold uppercase tracking-widest mb-1.5 block">{{ $product->category->name ?? '' }}</span>
                                        <h3 class="text-sm md:text-base font-bold leading-snug text-[#0D2137] line-clamp-2">{{ $product->name }}</h3>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-sm md:text-base font-black text-[#0D2137]">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                        {{-- FIX: pass `this` agar button bisa disabled saat loading --}}
                                        <button onclick="addToCart({{ $product->id }}, this)" class="flex h-10 w-10 md:h-11 md:w-11 items-center justify-center bg-[#FAF8F5] text-gray-400 hover:bg-[#0cc0df] hover:text-white transition-colors duration-300 rounded-2xl shadow-sm active:scale-95 border border-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                                        </button>
                                    </div>
                                </div>
                                {{-- FIX: CTA "Lihat Detail" dibuat kontras dan mencolok --}}
                                <a href="{{ route('catalog.show', $product->slug) }}" class="w-full py-3.5 text-center text-xs font-bold text-white bg-[#0cc0df] border-t border-[#0cc0df]/20 hover:bg-[#09a8c4] transition-colors tracking-widest uppercase">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                            @endforeach
                        </div>

                    <div class="bg-white rounded-tl-lg rounded-tr-[50px] rounded-br-lg rounded-bl-[50px] p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mt-auto border border-slate-200">
                        <div class="max-w-sm">
                            <h2 class="text-[#0D2137] text-lg sm:text-xl font-bold mb-2 uppercase">INSPIRASI {{ $homeCat->name }}</h2>
                            <p class="text-slate-500 text-sm italic">Koleksi terkurasi untuk menemani setiap detak momen berharga dalam hidup Anda.</p>
                        </div>
                        <a href="{{ route('catalog.index', ['category' => $homeCat->slug]) }}" class="bg-[#0cc0df] text-white font-bold py-2 px-6 rounded-full whitespace-nowrap hover:bg-[#09a8c4] transition shadow-md">
                            Jelajahi Sekarang
                        </a>
                    </div>
                </div>

                <div class="w-full lg:w-[350px] xl:w-[400px] shrink-0 relative rounded-t-[200px] rounded-b-[24px] overflow-hidden shadow-2xl min-h-[300px] sm:min-h-[400px] border-4 border-slate-100">
                    <div class="swiper bento-swiper h-full w-full">
                        <div class="swiper-wrapper">
                            @forelse($homeCat->products as $product)
                            <div class="swiper-slide relative">
                                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                <div class="absolute inset-x-0 bottom-0 h-3/5 bg-gradient-to-t from-[#0D2137] via-[#0D2137]/80 to-transparent flex items-end p-8">
                                    <h3 class="text-white text-2xl md:text-3xl font-bold leading-snug drop-shadow-md uppercase tracking-tighter">
                                        {{ $product->name }}
                                    </h3>
                                </div>
                            </div>
                            @empty
                            <div class="swiper-slide bg-[#0cc0df] flex items-center justify-center text-white italic">Produk belum tersedia.</div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination !bottom-8"></div>
                    </div>
                </div>
            </div>
        </section>
        @endforeach
    </div>
@endsection
