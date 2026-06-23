<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $global_setting->meta_title ?? 'Flora - Premium Florist Shop')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', $global_setting->meta_description)">
    <meta name="keywords" content="@yield('meta_keywords', $global_setting->meta_keywords)">
    <meta name="author" content="Flora Florist">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $global_setting->meta_title)">
    <meta property="og:description" content="@yield('meta_description', $global_setting->meta_description)">
    <meta property="og:image" content="@yield('og_image', asset('assets/Home.svg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', $global_setting->meta_title)">
    <meta property="twitter:description" content="@yield('meta_description', $global_setting->meta_description)">
    <meta property="twitter:image" content="@yield('og_image', asset('assets/Home.svg'))">

    @if($global_setting->favicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($global_setting->favicon) }}">
    @endif
    
    <!-- Google Fonts: Poppins & Dancing Script -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
            color: #1e293b; 
            background-color: #87ceeb; 
            font-family: 'Poppins', sans-serif; 
        }
        main {
            flex: 1 0 auto;
        }
        
        .max-w-7xl { max-width: 1280px !important; }
        
        /* Navbar Transition */
        nav.nav-transparent {
            background-color: transparent;
            border-color: transparent;
            box-shadow: none;
        }
        nav.nav-solid {
            background-color: #545454;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        nav.nav-solid .nav-link { color: white; }
        nav.nav-solid .logo-text { color: white; }
        nav.nav-transparent .nav-link { color: white; }
        nav.nav-transparent .logo-text { color: white; }

        /* Sidebar Styles */
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
        #sidebar.translate-x-full {
            transform: translateX(100%);
        }
        
        /* Search Modal Styles */
        #search-modal {
            transition: opacity 0.2s ease-in-out;
        }
    </style>
</head>
<body class="antialiased relative z-0 overflow-x-hidden min-h-screen flex flex-col">
    <!-- SVG Background Effect - Fixed Edge-to-Edge -->
    <img src="{{ asset('assets/Home.svg') }}" class="absolute top-0 left-0 w-screen h-auto min-h-full object-cover z-[-1] pointer-events-none" alt="Background SVG">
    
    <!-- Navigation -->
    <nav id="main-nav" class="fixed top-0 left-0 right-0 z-50 h-20 flex items-center transition-all duration-300 nav-transparent">
        <div class="max-w-7xl mx-auto px-6 md:px-8 w-full flex justify-between items-center">
            <!-- Logo Flora -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#545454] shadow-sm">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
                </div>
                <span class="logo-text text-[20px] font-bold tracking-tight transition-colors duration-300">Flora</span>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="nav-link text-sm font-semibold hover:opacity-75 transition-all">Beranda</a>
                <a href="{{ route('pages.about') }}" class="nav-link text-sm font-semibold hover:opacity-75 transition-all">Tentang Kami</a>
                <a href="{{ route('catalog.index') }}" class="nav-link text-sm font-semibold hover:opacity-75 transition-all">Katalog</a>
                <a href="{{ route('pages.contact') }}" class="nav-link text-sm font-semibold hover:opacity-75 transition-all">Kontak</a>
            </div>

            <!-- Action Icons -->
            <div class="flex items-center gap-4">
                <!-- Search Trigger -->
                <button onclick="openSearch()" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-white/40 transition-all border border-white/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>

                <!-- Cart Trigger -->
                <a href="{{ route('cart.index') }}" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#545454] shadow-sm relative hover:scale-105 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @if(count(session('cart', [])) > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">{{ count(session('cart', [])) }}</span>
                    @endif
                </a>

                <!-- Mobile Toggle -->
                <button class="md:hidden text-white ml-2 p-1" onclick="toggleSidebar()">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-[60] hidden backdrop-blur-sm"></div>
    <div id="sidebar" class="fixed top-0 right-0 bottom-0 w-72 bg-[#545454] z-[70] translate-x-full shadow-2xl p-8 flex flex-col">
        <div class="flex justify-between items-center mb-12">
            <span class="text-white font-bold text-xl">Menu</span>
            <button onclick="toggleSidebar()" class="text-white/70 hover:text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex flex-col gap-6">
            <a href="{{ route('home') }}" class="text-white text-lg font-medium hover:translate-x-2 transition-transform">Beranda</a>
            <a href="{{ route('pages.about') }}" class="text-white text-lg font-medium hover:translate-x-2 transition-transform">Tentang Kami</a>
            <a href="{{ route('catalog.index') }}" class="text-white text-lg font-medium hover:translate-x-2 transition-transform">Katalog</a>
            <a href="{{ route('pages.contact') }}" class="text-white text-lg font-medium hover:translate-x-2 transition-transform">Kontak</a>
            <div class="h-px bg-white/10 my-4"></div>
            <a href="{{ route('cart.index') }}" class="text-white text-lg font-medium">Keranjang ({{ count(session('cart', [])) }})</a>
        </nav>
    </div>

    <!-- Interactive Search Modal -->
    <div id="search-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 md:p-10">
        <div class="absolute inset-0 bg-[#545454]/95 backdrop-blur-md"></div>
        <button onclick="closeSearch()" class="absolute top-6 right-6 text-white/70 hover:text-white z-10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        
        <div class="relative w-full max-w-3xl text-center">
            <h2 class="text-white text-2xl md:text-4xl font-bold mb-8">Cari Produk Kami</h2>
            <form action="{{ route('catalog.index') }}" method="GET" class="relative group">
                <input type="text" name="q" id="search-input" placeholder="Ketik nama bunga atau kategori..." 
                       class="w-full bg-white/10 border-b-2 border-white/30 text-white text-xl md:text-3xl py-4 px-2 outline-none focus:border-white transition-all placeholder:text-white/40">
                <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 text-white/50 group-focus-within:text-white">
                    <svg class="w-8 h-8 md:w-12 md:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
            <p class="text-white/40 mt-6 text-sm uppercase tracking-widest">Tekan ENTER untuk mencari</p>
        </div>
    </div>

    <main class="flex-grow pt-0">
        @yield('content')
    </main>

    <!-- Premium Footer -->
    <footer class="bg-white pt-24 pb-12 mt-auto relative">
        <!-- Decoration element for transition -->
        <div class="absolute top-0 left-0 w-full h-1 bg-[#87ceeb]"></div>

        <div class="max-w-7xl mx-auto px-6 md:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand Section -->
                <div class="flex flex-col gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-[#87ceeb] rounded-xl flex items-center justify-center text-white shadow-lg">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
                        </div>
                        <span class="text-2xl font-black text-[#545454] tracking-tighter uppercase">{{ $global_setting->site_name ?? 'Flora' }}</span>
                    </div>
                    <p class="text-gray-500 leading-relaxed max-w-xs italic text-sm">
                        "{{ $global_setting->footer_text ?? 'Menghadirkan keindahan alam langsung ke depan pintu Anda dengan rangkaian bunga segar pilihan.' }}"
                    </p>
                    <div class="flex gap-4">
                        @if($global_setting->instagram_url)
                        <a href="{{ $global_setting->instagram_url }}" class="w-10 h-10 rounded-full border border-gray-100 flex items-center justify-center text-gray-400 hover:bg-[#87ceeb] hover:text-white hover:border-[#87ceeb] transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.074 4.771 4.85.012 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.149 3.252-1.074 4.771-4.85 4.771-1.266.012-1.646.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.149-4.771-1.074-4.771-4.85-.012-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.149-3.252 1.074-4.771 4.85-4.771 1.266-.012 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-5.838 2.435-5.838 5.838s2.435 5.838 5.838 5.838 5.838-2.435 5.838-5.838-2.435-5.838-5.838-5.838zm0 10.175c-2.396 0-4.337-1.942-4.337-4.337s1.941-4.337 4.337-4.337 4.337 1.942 4.337 4.337-1.941 4.337-4.337 4.337zm6.406-11.845c-.864 0-1.564.7-1.564 1.564s.7 1.564 1.564 1.564 1.564-.7 1.564-1.564-.701-1.564-1.564-1.564z"/></svg>
                        </a>
                        @endif
                        @if($global_setting->facebook_url)
                        <a href="{{ $global_setting->facebook_url }}" class="w-10 h-10 rounded-full border border-gray-100 flex items-center justify-center text-gray-400 hover:bg-[#87ceeb] hover:text-white hover:border-[#87ceeb] transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Navigation Section -->
                <div>
                    <h4 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-8">Eksplorasi</h4>
                    <ul class="flex flex-col gap-4">
                        <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-[#87ceeb] transition-colors text-sm font-medium">Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="text-gray-500 hover:text-[#87ceeb] transition-colors text-sm font-medium">Katalog Produk</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-gray-500 hover:text-[#87ceeb] transition-colors text-sm font-medium">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Categories Quick Links -->
                <div>
                    <h4 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-8">Kategori</h4>
                    <ul class="flex flex-col gap-4">
                        @foreach($global_categories->take(4) as $cat)
                        <li><a href="{{ route('catalog.index', ['category' => $cat->slug]) }}" class="text-gray-500 hover:text-[#87ceeb] transition-colors text-sm font-medium">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Section -->
                <div>
                    <h4 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-8">Kontak Kami</h4>
                    <div class="flex flex-col gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 shrink-0 rounded-lg bg-gray-50 flex items-center justify-center text-[#87ceeb]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="text-gray-500 text-sm leading-relaxed">{{ $global_setting->address ?? 'Jl. Bunga Melati No. 123, Jakarta' }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 shrink-0 rounded-lg bg-gray-50 flex items-center justify-center text-[#87ceeb]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <span class="text-gray-500 text-sm font-medium">{{ $global_setting->whatsapp_number ?? '0812-3456-7890' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="pt-12 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <p class="text-gray-400 text-xs font-medium">
                    © {{ date('Y') }} {{ $global_setting->site_name ?? 'Flora' }}. All rights reserved.
                </p>
                <div class="flex items-center gap-8">
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors text-xs font-medium">Syarat & Ketentuan</a>
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors text-xs font-medium">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>
<!-- Floating Chat Widget -->
<div id="chat-widget" class="fixed bottom-6 right-6 z-[90]">
    <!-- Chat Button -->
    <button onclick="toggleChat()" class="w-14 h-14 bg-[#545454] text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-all border-4 border-white">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
    </button>

    <!-- Chat Window -->
    <div id="chat-window" class="absolute bottom-20 right-0 w-[calc(100vw-3rem)] sm:w-[350px] max-h-[75vh] bg-white rounded-3xl shadow-2xl border border-slate-100 hidden flex flex-col overflow-hidden animate-fade-in-up">
        <!-- Header -->
        <div class="bg-[#545454] p-5 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#87ceeb]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm">Flora Bot</h4>
                    <p class="text-[10px] opacity-70">Online • Siap membantu</p>
                </div>
            </div>
            <button onclick="toggleChat()" class="text-white/50 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 min-h-[250px] overflow-y-auto p-4 space-y-4 bg-slate-50">
            <!-- Messages will appear here -->
            <div class="bg-blue-50 p-3 rounded-2xl rounded-tl-none text-xs text-slate-700 max-w-[80%] border border-blue-100">
                Halo! Ada yang bisa Flora bantu hari ini? 🌸
            </div>
        </div>

        <!-- Input Area -->
        <form id="chat-form" onsubmit="sendChatMessage(event)" class="p-4 bg-white border-t border-slate-100 flex items-center gap-2">
            <input type="text" id="chat-input" placeholder="Tulis pesan..." class="flex-1 bg-slate-50 border-none rounded-full px-4 py-2 text-xs outline-none focus:ring-2 focus:ring-[#545454]/10 transition-all">
            <button type="submit" class="w-9 h-9 bg-[#545454] text-white rounded-full flex items-center justify-center shadow-lg active:scale-95 transition-all">
                <svg class="w-4 h-4 rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
            </button>
        </form>
    </div>
</div>

    <script>
        // Chat Toggle
        function toggleChat() {
            const chatBox = document.getElementById('chat-window');
            chatBox.classList.toggle('hidden');
            if(!chatBox.classList.contains('hidden')) {
                loadChatHistory();
                document.getElementById('chat-input').focus();
            }
        }

        // Load History
        async function loadChatHistory() {
            try {
                const res = await fetch('/chat/messages');
                const messages = await res.json();
                const container = document.getElementById('chat-messages');
                container.innerHTML = '';
                messages.forEach(msg => appendMessage(msg));
                scrollToBottom();
            } catch (err) { console.error('Failed to load chat:', err); }
        }

        // Append UI
        function appendMessage(msg) {
            const container = document.getElementById('chat-messages');
            if(!container) return;
            
            const isMe = msg.sender_type === 'customer';
            const time = msg.created_at ? new Date(msg.created_at) : new Date();
            const timeStr = time.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            // Check for image in metadata
            let imageHtml = '';
            if (msg.metadata && msg.metadata.image_url) {
                imageHtml = `
                    <a href="${msg.metadata.image_url}" target="_blank">
                        <img src="${msg.metadata.image_url}" alt="Product Image" class="mt-2 rounded-lg max-w-full h-auto" />
                    </a>
                `;
            }

            const html = `
                <div class="flex ${isMe ? 'justify-end' : 'justify-start'} animate-fade-in mb-4">
                    <div class="${isMe ? 'bg-[#545454] text-white rounded-tr-none' : 'bg-white text-slate-700 rounded-tl-none border border-slate-100'} p-3 rounded-2xl text-xs max-w-[85%] shadow-sm">
                        ${msg.message}
                        ${imageHtml}
                        <p class="text-[9px] ${isMe ? 'text-white/50' : 'text-slate-400'} mt-1 text-right">${timeStr}</p>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            scrollToBottom();
        }

        function scrollToBottom() {
            setTimeout(() => {
                const container = document.getElementById('chat-messages');
                if(container) container.scrollTop = container.scrollHeight;
            }, 100);
        }

        // Send Message
        async function sendChatMessage(e) {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            if(!message) return;

            // Optimistic UI
            appendMessage({sender_type: 'customer', message: message});
            input.value = '';

            try {
                // We don't need to handle the response here because the broadcast will do it.
                await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({message: message})
                });
            } catch (err) { console.error('Send error:', err); }
        }

        // Initialize App Scripts
        document.addEventListener('DOMContentLoaded', () => {
            // Real-time Chat Listener
            if (window.Echo) {
                const sessionId = '{{ session()->getId() }}';
                window.Echo.channel('chat.' + sessionId)
                    .listen('.message.sent', (event) => {
                        // The full message object is now in event.message
                        if(event.message.sender_type !== 'customer') {
                            appendMessage(event.message);
                        }
                    });
            }

            // Navbar Scroll Effect
            window.addEventListener('scroll', function() {
                const nav = document.getElementById('main-nav');
                if (window.scrollY > 50) {
                    nav.classList.remove('nav-transparent');
                    nav.classList.add('nav-solid');
                } else {
                    nav.classList.remove('nav-solid');
                    nav.classList.add('nav-transparent');
                }
            });
        });

        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('translate-x-full')) {
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // Search Modal
        function openSearch() {
            const modal = document.getElementById('search-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('search-input').focus();
            }, 100);
            document.body.style.overflow = 'hidden';
        }

        function closeSearch() {
            const modal = document.getElementById('search-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Add to Cart Function
        window.addToCart = function(productId) {
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload();
                }
            });
        };
    </script>
</body>
</html>
