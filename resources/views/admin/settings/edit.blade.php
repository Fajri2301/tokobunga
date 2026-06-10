@extends('layouts.admin')

@section('header', 'Pengaturan Website Global')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        
        <!-- Flash Message Success -->
        @if(session('success'))
            <div class="m-8 p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center shadow-sm animate-fade-in">
                <svg class="w-6 h-6 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Flash Message Error -->
        @if($errors->any())
            <div class="m-8 p-5 bg-red-50 border border-red-100 text-red-700 rounded-2xl flex flex-col shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-6 h-6 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <span class="font-bold">Terjadi Kesalahan!</span>
                </div>
                <ul class="list-disc list-inside text-sm ml-9">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-12 space-y-12">
            @csrf
            @method('PUT')

            <!-- Branding Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div>
                    <h3 class="text-xl font-black text-blue-900">Branding</h3>
                    <p class="text-slate-400 text-sm mt-2 font-medium">Kelola identitas visual utama website Anda.</p>
                </div>
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Website</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border {{ $errors->has('site_name') ? 'border-red-500' : 'border-slate-200' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 outline-none transition-all font-bold">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Logo Utama</label>
                            <input type="file" name="site_logo" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-200 outline-none">
                            @if($setting->site_logo)
                                <div class="mt-4 p-4 bg-blue-900/10 rounded-2xl inline-block">
                                    <img src="{{ asset('storage/' . $setting->site_logo) }}" class="h-10">
                                </div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Icon Website (Favicon)</label>
                            <input type="file" name="site_favicon" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-200 outline-none">
                            @if($setting->site_favicon)
                                <div class="mt-4 p-3 bg-white rounded-2xl inline-block border border-slate-100 shadow-sm">
                                    <img src="{{ asset('storage/' . $setting->site_favicon) }}" class="h-8 w-8 object-contain">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="pt-12 border-t border-slate-50 grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div>
                    <h3 class="text-xl font-black text-indigo-600">SEO Metadata</h3>
                    <p class="text-slate-400 text-sm mt-2 font-medium">Optimalkan pencarian website Anda di Google.</p>
                </div>
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-500 outline-none transition-all font-bold" placeholder="Judul SEO (Gunakan Nama Toko)">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-500 outline-none transition-all font-medium" placeholder="Deskripsi singkat untuk hasil pencarian Google...">{{ old('meta_description', $setting->meta_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $setting->meta_keywords) }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-500 outline-none transition-all font-bold" placeholder="bunga segar, toko bunga jakarta, florist">
                    </div>
                </div>
            </div>

            <!-- Kontak Section -->
            <div class="pt-12 border-t border-slate-50 grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div>
                    <h3 class="text-xl font-black text-emerald-600">Kontak Bisnis</h3>
                    <p class="text-slate-400 text-sm mt-2 font-medium">Nomor WhatsApp diawali 628...</p>
                </div>
                <div class="lg:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-emerald-500 outline-none transition-all font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Telepon Toko</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $setting->phone_number) }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 outline-none transition-all font-bold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 outline-none transition-all font-bold">
                    </div>
                </div>
            </div>

            <!-- Location Section -->
            <div class="pt-12 border-t border-slate-50 grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div>
                    <h3 class="text-xl font-black text-amber-600">Lokasi & Sosial</h3>
                    <p class="text-slate-400 text-sm mt-2 font-medium">Link Gmaps & Sosial Media.</p>
                </div>
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Toko</label>
                        <textarea name="address" rows="3" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 outline-none transition-all font-medium">{{ old('address', $setting->address) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Link Embed Google Maps</label>
                        <textarea name="google_maps_link" rows="3" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 outline-none transition-all font-medium" placeholder="https://www.google.com/maps/embed?pb=...">{{ old('google_maps_link', $setting->google_maps_link) }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Instagram URL</label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $setting->instagram_url) }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Teks Footer</label>
                            <input type="text" name="footer_text" value="{{ old('footer_text', $setting->footer_text) }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 outline-none transition-all font-bold">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-8">
                <button type="submit" class="px-12 py-5 bg-blue-500 hover:bg-blue-600 text-white font-black rounded-3xl shadow-2xl shadow-blue-200 transition-all transform hover:scale-105 active:scale-95 uppercase tracking-widest text-sm">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
