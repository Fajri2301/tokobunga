@extends('layouts.admin')

@section('header', 'Tambah Akun Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.users.index') }}" class="p-2 text-slate-400 hover:text-[#545454] hover:bg-white rounded-xl transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-[#545454] tracking-tight">Admin Baru</h2>
            <p class="text-sm text-slate-400 font-medium">Buat kredensial untuk admin baru.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#0cc0df]/20 focus:border-[#0cc0df] transition-all text-[#545454] font-medium"
                    placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="text-rose-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Email Login</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#0cc0df]/20 focus:border-[#0cc0df] transition-all text-[#545454] font-medium"
                    placeholder="contoh@email.com">
                @error('email')
                    <p class="text-rose-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#0cc0df]/20 focus:border-[#0cc0df] transition-all text-[#545454] font-medium"
                        placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-rose-500 text-xs font-bold mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#0cc0df]/20 focus:border-[#0cc0df] transition-all text-[#545454] font-medium"
                        placeholder="Ulangi password">
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="btn-premium flex items-center px-8 py-4 rounded-xl text-sm font-bold shadow-lg shadow-[#0cc0df]/30 group w-full sm:w-auto justify-center">
                    Simpan Admin Baru
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
