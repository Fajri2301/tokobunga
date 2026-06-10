<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - {{ $global_setting->site_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .sidebar-active { transform: translateX(0); }
        .mobile-overlay-active { opacity: 1; visibility: visible; }
        [x-cloak] { display: none !important; }
        
        /* Fix for Horizontal Scroll */
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .btn-premium {
            background-color: #87ceeb;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-premium:hover {
            background-color: #545454;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-slate-50 antialiased text-[#545454]">
    <div class="min-h-screen flex relative overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 opacity-0 invisible pointer-events-none transition-all duration-300 md:hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-[#545454] text-white z-50 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shadow-2xl">
            <div class="p-8 border-b border-white/10 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#545454] shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
                    </div>
                    <div>
                        <span class="text-lg font-black tracking-tighter uppercase leading-none block">{{ $global_setting->site_name }}</span>
                        <span class="text-[10px] tracking-[0.3em] font-bold opacity-50 uppercase">Admin Panel</span>
                    </div>
                </a>
                <button class="md:hidden text-white/50 hover:text-white" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-2 py-8 overflow-y-auto no-scrollbar">
                @php
                    $menus = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                        ['route' => 'admin.orders.index', 'label' => 'Pesanan Masuk', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                        ['route' => 'admin.chat.index', 'label' => 'Live Chat', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
                        ['route' => 'admin.categories.index', 'label' => 'Kategori', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                        ['route' => 'admin.products.index', 'label' => 'Produk', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                        ['route' => 'admin.banners.index', 'label' => 'Banner Hero', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['route' => 'admin.reviews.index', 'label' => 'Ulasan Pelanggan', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
                        ['route' => 'admin.settings.edit', 'label' => 'Pengaturan', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                    ];
                @endphp

                @foreach($menus as $menu)
                <a href="{{ route($menu['route']) }}" class="group flex items-center px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs($menu['route'] . '*') ? 'bg-[#87ceeb] text-white shadow-xl shadow-[#87ceeb]/20' : 'text-white/50 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="{{ $menu['icon'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="font-bold text-xs uppercase tracking-widest">{{ $menu['label'] }}</span>
                </a>
                @endforeach
            </nav>

            <div class="p-6 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-6 py-4 text-xs font-black text-rose-400 hover:bg-rose-500/10 rounded-2xl transition-all uppercase tracking-widest">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navigation -->
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 h-20 flex items-center justify-between px-6 md:px-10 sticky top-0 z-30">
                <div class="flex items-center">
                    <button class="md:hidden p-2 text-[#545454] mr-4 bg-slate-50 rounded-xl" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    <h1 class="text-sm font-black text-[#545454] uppercase tracking-widest hidden sm:block">@yield('header', 'Dashboard Overview')</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Notification Bell -->
                    <div class="relative group mr-2">
                        <button class="relative p-2 text-slate-400 hover:bg-slate-50 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span id="notifBadge" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white hidden animate-ping"></span>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 p-4">
                            <h5 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Notifikasi Terbaru</h5>
                            <div id="notifList" class="space-y-3 max-h-60 overflow-y-auto no-scrollbar">
                                <p class="text-center py-4 text-xs text-slate-400 italic">Belum ada notifikasi baru</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] font-black text-[#545454] leading-none uppercase tracking-widest">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-bold text-[#87ceeb] mt-1 uppercase tracking-[0.2em]">Super Admin</p>
                    </div>
                    <div class="h-10 w-10 rounded-2xl bg-[#545454] flex items-center justify-center text-white font-black shadow-lg shadow-[#545454]/20 uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-10">
                @if($errors->any())
                <div class="mb-8 p-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-2xl shadow-sm">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span class="font-black uppercase text-[10px] tracking-widest">Ada kesalahan input:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs font-medium space-y-1 ml-1 opacity-90">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Floating Success Notification -->
    @if(session('success'))
    <div id="successToast" class="fixed bottom-10 left-1/2 transform -translate-x-1/2 z-[100] transition-all duration-500 translate-y-20 opacity-0">
        <div class="bg-[#545454] text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-4 border border-white/10">
            <div class="h-8 w-8 bg-[#87ceeb] rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('opacity-0');
            overlay.classList.toggle('invisible');
            overlay.classList.toggle('mobile-overlay-active');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('successToast');
            if (toast) {
                setTimeout(() => {
                    toast.classList.remove('translate-y-20', 'opacity-0');
                    toast.classList.add('translate-y-0', 'opacity-100');
                }, 100);
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 4000);
            }
        });
    </script>
</body>
</html>
