@extends('layouts.app')

@section('title', 'Hubungi Kami - ' . ($global_setting->site_name ?? 'Flora'))

@section('content')
<div class="pt-32 md:pt-48 pb-24">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-6 md:px-8 mb-16 text-center">
        <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4" style="font-family: 'Poppins', sans-serif;">
            Hubungi Kami
        </h1>
        <p class="text-white/80 text-lg md:text-xl max-w-2xl mx-auto font-medium italic">
            "Kami siap membantu mewujudkan setiap rangkaian bunga impian Anda. Jangan ragu untuk menyapa."
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-8">
        <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col lg:flex-row items-stretch min-h-[600px]">
            <!-- Info Side -->
            <div class="w-full lg:w-[400px] bg-[#545454] p-10 md:p-16 text-white flex flex-col justify-between relative">
                <!-- Decoration -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full"></div>
                
                <div class="relative z-10 flex flex-col gap-12">
                    <div>
                        <h2 class="text-3xl font-black uppercase tracking-tight mb-8">Info Kontak</h2>
                        <div class="flex flex-col gap-8">
                            <div class="flex items-start gap-5">
                                <div class="w-12 h-12 shrink-0 rounded-2xl bg-white/10 flex items-center justify-center text-[#87ceeb] shadow-inner">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-1">Alamat</span>
                                    <span class="text-sm font-medium leading-relaxed">{{ $global_setting->address ?? 'Jl. Bunga Melati No. 123, Jakarta' }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-5">
                                <div class="w-12 h-12 shrink-0 rounded-2xl bg-white/10 flex items-center justify-center text-[#87ceeb] shadow-inner">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-1">WhatsApp</span>
                                    <span class="text-sm font-medium">{{ $global_setting->whatsapp_number ?? '0812-3456-7890' }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-5">
                                <div class="w-12 h-12 shrink-0 rounded-2xl bg-white/10 flex items-center justify-center text-[#87ceeb] shadow-inner">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-1">Email</span>
                                    <span class="text-sm font-medium">{{ $global_setting->email ?? 'hello@flora.com' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 pt-12 border-t border-white/10 mt-12 flex gap-4">
                    <!-- Social Links -->
                    @if($global_setting->instagram_url)
                    <a href="{{ $global_setting->instagram_url }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-[#87ceeb] transition-all">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.074 4.771 4.85.012 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.149 3.252-1.074 4.771-4.85 4.771-1.266.012-1.646.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.149-4.771-1.074-4.771-4.85-.012-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.149-3.252 1.074-4.771 4.85-4.771 1.266-.012 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-5.838 2.435-5.838 5.838s2.435 5.838 5.838 5.838 5.838-2.435 5.838-5.838-2.435-5.838-5.838-5.838zm0 10.175c-2.396 0-4.337-1.942-4.337-4.337s1.941-4.337 4.337-4.337 4.337 1.942 4.337 4.337-1.941 4.337-4.337 4.337zm6.406-11.845c-.864 0-1.564.7-1.564 1.564s.7 1.564 1.564 1.564 1.564-.7 1.564-1.564-.701-1.564-1.564-1.564z"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Map Side -->
            <div class="flex-1 min-h-[400px] relative">
                @if($global_setting->google_maps_link)
                <iframe src="{{ $global_setting->google_maps_link }}" class="absolute inset-0 w-full h-full border-none" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                @else
                <div class="absolute inset-0 bg-slate-50 flex items-center justify-center text-slate-300 italic font-bold">Peta belum dikonfigurasi.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
