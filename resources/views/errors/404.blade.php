@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan - ' . $global_setting->site_name)

@section('content')
<div style="background-image: url('{{ asset('assets/BG.svg') }}'); background-size: cover; background-position: center top; background-attachment: fixed;" class="min-h-screen flex items-center justify-center py-20 px-4">
    <div class="max-w-2xl w-full bg-white/40 backdrop-blur-2xl rounded-[4rem] border border-white p-12 md:p-24 text-center shadow-2xl animate-fade-in">
        <h1 class="font-heading text-8xl md:text-9xl font-bold text-white italic drop-shadow-2xl">404</h1>
        <div class="mt-8 space-y-6">
            <h2 class="font-heading text-4xl font-bold text-royal-600 italic">Mahakarya Tersembunyi</h2>
            <p class="text-blue-100 text-lg font-medium">Maaf, halaman yang Anda cari tidak dapat kami temukan di taman bunga kami.</p>
            <div class="pt-10">
                <a href="{{ route('home') }}" class="inline-block px-12 py-5 bg-royal-600 text-white font-black uppercase text-xs tracking-widest rounded-full shadow-xl shadow-royal-900/20 hover:bg-royal-700 transition-all transform hover:scale-105 active:scale-95">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
