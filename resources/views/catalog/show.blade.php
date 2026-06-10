@extends('layouts.app')

@section('title', $product->name . ' - ' . ($global_setting->site_name ?? 'Flora'))

@section('content')
<div class="pt-32 md:pt-48 pb-24">
    <div class="max-w-7xl mx-auto px-6 md:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-12 text-[10px] font-black uppercase tracking-widest text-white/60 items-center space-x-3">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-white transition-colors">{{ $product->category->name }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-white">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            <!-- Product Gallery -->
            <div class="lg:col-span-7">
                <div class="relative rounded-[40px] overflow-hidden shadow-2xl bg-white p-4 md:p-8">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1519378058457-4c29a0a2efac?q=80&w=800' }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-auto max-h-[600px] object-contain transition-transform duration-1000 hover:scale-105">
                    @if($product->is_featured)
                    <div class="absolute top-8 left-8 bg-[#87ceeb] text-white text-[10px] font-black px-6 py-2.5 rounded-full uppercase tracking-widest shadow-xl">Featured</div>
                    @endif
                </div>
            </div>

            <!-- Info Side -->
            <div class="lg:col-span-5 flex flex-col">
                <div class="bg-white rounded-[40px] p-8 md:p-12 shadow-2xl h-full flex flex-col border border-white/20">
                    <span class="text-[#87ceeb] font-bold text-xs uppercase tracking-widest mb-4 block">{{ $product->category->name }}</span>
                    <h1 class="text-4xl md:text-5xl font-black text-[#545454] leading-tight mb-6 uppercase tracking-tighter">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-4 mb-8 pb-8 border-b border-gray-100">
                        <span class="text-3xl md:text-4xl font-black text-[#545454]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>

                    <div class="text-gray-500 text-lg leading-relaxed mb-12 flex-grow italic">
                        <p>{{ $product->description ?? 'Deskripsi produk belum tersedia.' }}</p>
                    </div>

                    <div class="space-y-4 mt-auto">
                        <div class="flex flex-col gap-4">
                            <button onclick="addToCart({{ $product->id }})" class="w-full bg-[#87ceeb] hover:bg-[#545454] text-white font-black text-xs uppercase tracking-widest py-5 px-8 rounded-full flex items-center justify-center transition-all shadow-lg active:scale-95">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Tambah Keranjang
                            </button>
                            <a href="https://wa.me/{{ $global_setting->whatsapp_number }}?text=Halo {{ $global_setting->site_name }}, saya tertarik dengan: {{ $product->name }}" target="_blank" class="w-full bg-white border-2 border-[#87ceeb] text-[#87ceeb] hover:bg-[#87ceeb] hover:text-white font-black text-xs uppercase tracking-widest py-5 px-8 rounded-full flex items-center justify-center transition-all shadow-md active:scale-95">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                Konsultasi WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="lg:col-span-12 mt-32 pt-20 border-t border-white/20">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-16 uppercase tracking-tighter text-center">Produk <span class="text-[#87ceeb]">Terkait</span></h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relProduct)
                    <div class="group rounded-[32px] bg-white p-0 shadow-xl flex flex-col overflow-hidden transition-all hover:-translate-y-2">
                        <div class="h-48 md:h-64 w-full bg-slate-50 relative overflow-hidden">
                            <img src="{{ $relProduct->image ? asset('storage/' . $relProduct->image) : 'https://images.unsplash.com/photo-1519378058457-4c29a0a2efac?q=80&w=800' }}" 
                                 alt="{{ $relProduct->name }}" 
                                 class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <a href="{{ route('catalog.show', $relProduct->slug) }}" class="bg-white text-[#545454] px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl">Detail</a>
                            </div>
                        </div>
                        <div class="p-4 md:p-6 text-center flex flex-col flex-grow">
                            <h3 class="text-sm md:text-base font-bold text-[#545454] mb-2 uppercase tracking-tighter line-clamp-1">{{ $relProduct->name }}</h3>
                            <div class="text-[#87ceeb] font-black text-lg">Rp {{ number_format($relProduct->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
