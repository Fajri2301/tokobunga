@extends('layouts.app')

@section('title', 'Tentang Kami - ' . ($global_setting->site_name ?? 'Flora'))

@section('content')
<div class="pt-32 md:pt-48 pb-24">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-6 md:px-8 mb-16 text-center">
        <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4" style="font-family: 'Poppins', sans-serif;">
            Tentang Kami
        </h1>
        <p class="text-white/80 text-lg md:text-xl max-w-2xl mx-auto font-medium italic">
            "{{ $about->subtitle ?? 'Menghadirkan keindahan alam langsung ke depan pintu Anda dengan rangkaian bunga segar pilihan.' }}"
        </p>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-6 md:px-8">
        <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col lg:flex-row items-stretch">
            <!-- Image Side -->
            <div class="w-full lg:w-1/2 relative min-h-[400px]">
                <img src="{{ $about && $about->image ? Storage::url($about->image) : 'https://images.unsplash.com/photo-1533633036055-2e58445a20d1?q=80&w=800&auto=format&fit=crop' }}" 
                     alt="Our Shop" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#545454]/10 backdrop-blur-[2px]"></div>
            </div>

            <!-- Text Side -->
            <div class="w-full lg:w-1/2 p-8 md:p-16 flex flex-col justify-center gap-8">
                <div>
                    <h2 class="text-3xl font-black text-[#545454] uppercase tracking-tight mb-4">Kisah Kami</h2>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        {{ $about->description_1 ?? 'Berawal dari kecintaan kami terhadap seni merangkai bunga, Flora hadir untuk menjadi bagian dari setiap momen berharga Anda. Kami percaya bahwa setiap bunga memiliki cerita, dan setiap rangkaian adalah ungkapan perasaan yang tulus.' }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div class="flex flex-col gap-2">
                        <span class="text-4xl font-black text-[#87ceeb]">{{ $about->experience_years ?? '10+' }}</span>
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Tahun Pengalaman</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="text-4xl font-black text-[#87ceeb]">{{ $about->clients_count ?? '5K+' }}</span>
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Pelanggan Puas</span>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-black text-[#545454] uppercase tracking-tight mb-4">Visi Kami</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $about->description_2 ?? 'Menjadi toko bunga pilihan utama yang dikenal karena kualitas kesegaran bunga, kreativitas tanpa batas, dan pelayanan yang menyentuh hati.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Section: Mengapa Memilih Kami -->
        <div class="mt-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-4">Mengapa Memilih Kami</h2>
                <div class="w-24 h-2 bg-[#87ceeb] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Reason 1 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-[32px] hover:bg-white/20 transition-all group">
                    <div class="w-16 h-16 bg-[#87ceeb] rounded-2xl flex items-center justify-center text-white mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white uppercase mb-3">Kualitas Premium</h3>
                    <p class="text-white/70 leading-relaxed">Kami hanya menggunakan bunga segar pilihan yang didatangkan langsung dari perkebunan terbaik setiap harinya.</p>
                </div>

                <!-- Reason 2 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-[32px] hover:bg-white/20 transition-all group">
                    <div class="w-16 h-16 bg-[#87ceeb] rounded-2xl flex items-center justify-center text-white mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white uppercase mb-3">Pengiriman Tepat Waktu</h3>
                    <p class="text-white/70 leading-relaxed">Tim logistik kami memastikan buket bunga Anda sampai di tujuan tepat waktu dengan kondisi yang tetap prima.</p>
                </div>

                <!-- Reason 3 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-[32px] hover:bg-white/20 transition-all group">
                    <div class="w-16 h-16 bg-[#87ceeb] rounded-2xl flex items-center justify-center text-white mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white uppercase mb-3">Desain Eksklusif</h3>
                    <p class="text-white/70 leading-relaxed">Setiap rangkaian dirancang secara khusus oleh florist berpengalaman kami untuk memberikan kesan yang unik dan mendalam.</p>
                </div>
            </div>
        </div>

        <!-- Section: Rating & Penilaian -->
        <div class="mt-24 bg-white rounded-[40px] p-8 md:p-16 shadow-2xl">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12 mb-16">
                <div class="text-center lg:text-left">
                    <h2 class="text-4xl font-black text-[#545454] uppercase tracking-tighter mb-4">Apa Kata Mereka?</h2>
                    <p class="text-gray-500 text-lg">Kepercayaan Anda adalah prioritas kami. Berikut adalah ulasan dari para pelanggan setia Flora.</p>
                </div>
                <div class="bg-[#87ceeb]/10 p-8 rounded-3xl border border-[#87ceeb]/20 text-center flex flex-col items-center shrink-0">
                    <span class="text-6xl font-black text-[#87ceeb] mb-2">{{ number_format($averageRating, 1) }}</span>
                    <div class="flex text-yellow-400 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 {{ $i <= round($averageRating) ? 'fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Dari {{ $totalReviews }} Ulasan</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($reviews as $review)
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 flex flex-col gap-4 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#87ceeb] rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($review->name, 0, 1)) }}
                            </div>
                            <span class="font-bold text-[#545454]">{{ $review->name }}</span>
                        </div>
                        <div class="flex text-yellow-400 scale-75 origin-right">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm italic leading-relaxed">"{{ $review->comment }}"</p>
                    <span class="text-[10px] text-gray-400 font-medium uppercase mt-auto">{{ $review->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <div class="col-span-full py-12 text-center text-gray-400 italic">Belum ada ulasan yang ditampilkan.</div>
                @endforelse
            </div>
        </div>

        <!-- Decorative Banner -->
        <div class="mt-24 bg-[#545454] rounded-[40px] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 border border-white/10 shadow-xl">
            <div class="text-center md:text-left">
                <h3 class="text-2xl font-black text-white uppercase mb-2">Siap Kirim Kebahagiaan?</h3>
                <p class="text-white/60">Jelajahi koleksi terbaik kami sekarang juga.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="px-10 py-4 bg-[#87ceeb] text-white rounded-full font-black uppercase tracking-widest hover:bg-white hover:text-[#545454] transition-all shadow-lg">
                Lihat Katalog
            </a>
        </div>
    </div>
</div>
@endsection
