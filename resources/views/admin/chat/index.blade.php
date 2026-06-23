@extends('layouts.admin')

@section('header', 'Live Support AI')

@section('content')
<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden flex flex-col md:flex-row h-[calc(100vh-200px)] relative">
    
    <!-- Sidebar: Session List -->
    <div id="chat-sidebar" class="w-full md:w-1/3 border-r border-slate-50 flex flex-col transition-all duration-300 z-20 bg-white">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
            <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Percakapan Aktif</h3>
            <span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $sessions->count() }} Sesi</span>
        </div>
        <div class="flex-1 overflow-y-auto no-scrollbar p-2 space-y-2">
            @forelse($sessions as $session)
            <button onclick="selectSession('{{ $session->session_id }}')" id="btn-{{ $session->session_id }}" class="session-btn w-full text-left p-4 rounded-2xl hover:bg-blue-50 transition-all group relative border border-transparent">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">Customer #{{ substr($session->session_id, 0, 8) }}</p>
                        <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ $session->last_message->message ?? '...' }}</p>
                    </div>
                    @if($session->unread_count > 0)
                    <span class="bg-blue-600 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full shrink-0">{{ $session->unread_count }}</span>
                    @endif
                </div>
            </button>
            @empty
            <p class="text-center py-10 text-xs text-slate-400 italic">Belum ada chat masuk.</p>
            @endforelse
        </div>
    </div>

    <!-- Chat Area -->
    <div id="chat-main" class="flex-1 flex flex-col bg-slate-50/30 absolute inset-0 md:relative translate-x-full md:translate-x-0 transition-transform duration-300 z-30 bg-white md:bg-transparent">
        
        <!-- No Chat Selected Placeholder -->
        <div id="no-chat" class="flex-1 flex flex-col items-center justify-center text-slate-300">
            <svg class="w-20 h-20 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <p class="text-sm font-medium italic">Pilih percakapan untuk membalas</p>
        </div>

        <div id="active-chat" class="hidden flex-1 flex flex-col h-full">
            <!-- Chat Header -->
            <div class="p-4 md:p-6 bg-white border-b border-slate-50 flex items-center gap-4">
                <button onclick="backToList()" class="md:hidden p-2 text-slate-400 hover:bg-slate-50 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <div class="flex-1">
                    <h4 id="chat-title" class="font-bold text-slate-800 text-sm truncate">...</h4>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest mt-0.5 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Online
                    </p>
                </div>
            </div>

            <!-- Messages List -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 md:p-8 space-y-6 no-scrollbar bg-slate-50/50">
                <!-- Messages dynamic -->
            </div>

            <!-- Input Area -->
            <form onsubmit="sendAdminMessage(event)" class="p-4 md:p-6 bg-white border-t border-slate-50 flex items-center gap-3">
                <input type="text" id="message-input" placeholder="Tulis balasan..." class="flex-1 bg-slate-50 border-none rounded-2xl px-6 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500/10 transition-all shadow-inner">
                <button type="submit" class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg hover:bg-blue-700 active:scale-95 transition-all shrink-0">
                    <svg class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let currentSession = null;

    function backToList() {
        document.getElementById('chat-main').classList.add('translate-x-full');
    }

    async function selectSession(sessionId) {
        currentSession = sessionId;
        
        // UI Navigation (Mobile)
        document.getElementById('chat-main').classList.remove('translate-x-full');
        document.getElementById('no-chat').classList.add('hidden');
        document.getElementById('active-chat').classList.remove('hidden');
        
        document.getElementById('chat-title').innerText = 'Customer #' + sessionId.substring(0, 8);
        
        // Highlight active btn
        document.querySelectorAll('.session-btn').forEach(b => b.classList.remove('bg-blue-100', 'border-blue-200'));
        document.getElementById('btn-' + sessionId).classList.add('bg-blue-100', 'border-blue-200');

        loadMessages(sessionId);
    }

    async function loadMessages(sessionId) {
        const res = await fetch(`/admin/chat/${sessionId}`);
        const messages = await res.json();
        renderMessages(messages);
    }

    function renderMessages(messages) {
        const container = document.getElementById('chat-messages');
        container.innerHTML = '';
        messages.forEach(msg => {
            const isMe = msg.sender_type === 'admin';
            const isBot = msg.sender_type === 'bot';
            
            let bgClass = 'bg-white text-slate-700 border border-slate-100 rounded-tl-none';
            if(isMe) bgClass = 'bg-blue-600 text-white rounded-tr-none shadow-blue-200';
            if(isBot) bgClass = 'bg-slate-200 text-slate-600 rounded-tl-none border-dashed border-slate-300';

            const html = `
                <div class="flex ${isMe ? 'justify-end' : 'justify-start'} animate-fade-in">
                    <div class="${bgClass} p-4 rounded-3xl text-sm max-w-[85%] md:max-w-[70%] shadow-sm relative">
                        ${isBot ? '<p class="text-[8px] font-black uppercase opacity-50 mb-1">Flora Bot AI</p>' : ''}
                        <p class="font-medium leading-relaxed">${msg.message}</p>
                        <p class="text-[9px] ${isMe ? 'text-white/50' : 'text-slate-400'} mt-2 text-right">${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
        container.scrollTop = container.scrollHeight;
    }

    async function sendAdminMessage(e) {
        e.preventDefault();
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        if(!message || !currentSession) return;

        const originalText = message;
        input.value = '';

        // Optimistic UI: Tampilkan langsung di layar seperti WhatsApp
        const container = document.getElementById('chat-messages');
        const timeStr = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        const html = `
            <div class="flex justify-end animate-fade-in">
                <div class="bg-blue-600 text-white rounded-tr-none shadow-blue-200 p-4 rounded-3xl text-sm max-w-[85%] md:max-w-[70%] shadow-sm relative">
                    <p class="font-medium leading-relaxed">${originalText}</p>
                    <p class="text-[9px] text-white/50 mt-2 text-right">${timeStr}</p>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        container.scrollTop = container.scrollHeight;

        try {
            const res = await fetch('{{ route("admin.chat.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: currentSession,
                    message: originalText
                })
            });

            const data = await res.json();
            if(data.status !== 'success') throw new Error('Failed to send');
            
        } catch (err) {
            alert('Gagal mengirim pesan. Silakan coba lagi.');
            input.value = originalText;
        }
    }

    // Real-time Listeners
    document.addEventListener('DOMContentLoaded', () => {
        if (window.Echo) {
            window.Echo.channel('admin.chats')
                .listen('.message.sent', (e) => {
                    if(e.message && currentSession === e.message.session_id) {
                        loadMessages(currentSession);
                    }
                });
        }
    });
</script>
@endsection
