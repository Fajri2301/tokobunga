@extends('layouts.app')

@section('title', 'Keranjang Belanja - ' . ($global_setting->site_name ?? 'Flora'))

@section('content')
<div class="pt-32 md:pt-48 pb-24">
    <div class="max-w-7xl mx-auto px-6 md:px-8">
        <div class="text-center mb-16">
            <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4" style="font-family: 'Poppins', sans-serif;">
                Keranjang <span class="text-[#87ceeb]">Anda</span>
            </h1>
            <p class="text-white/80 text-lg md:text-xl max-w-2xl mx-auto font-medium italic">
                Tinjau pilihan buket terbaik Anda sebelum kami kirimkan kebahagiaan.
            </p>
        </div>

        @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-6">
                @foreach($cart as $id => $details)
                <div class="bg-white rounded-[32px] p-6 shadow-xl flex flex-col md:flex-row items-center gap-6 relative group border border-white/20 transition-all hover:shadow-2xl">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl overflow-hidden flex-shrink-0 bg-slate-50 border border-slate-100 p-2">
                        <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-grow text-center md:text-left">
                        <h3 class="text-xl md:text-2xl font-black text-[#545454] uppercase tracking-tighter">{{ $details['name'] }}</h3>
                        <p class="text-[#87ceeb] font-bold text-lg">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                        
                        <div class="flex flex-col md:flex-row items-center gap-6 mt-4">
                            <div class="flex items-center bg-slate-50 rounded-full border border-slate-200 p-1">
                                <button onclick="updateQuantity({{ $id }}, {{ $details['quantity'] - 1 }})" class="w-8 h-8 flex items-center justify-center rounded-full text-[#545454] hover:bg-white hover:shadow-sm transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg></button>
                                <span class="px-6 font-black text-[#545454]">{{ $details['quantity'] }}</span>
                                <button onclick="updateQuantity({{ $id }}, {{ $details['quantity'] + 1 }})" class="w-8 h-8 flex items-center justify-center rounded-full text-[#545454] hover:bg-white hover:shadow-sm transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg></button>
                            </div>
                            <button onclick="removeFromCart({{ $id }})" class="text-red-400 hover:text-red-600 transition-colors flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Checkout Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[40px] p-8 md:p-10 shadow-2xl sticky top-28 border border-white/20">
                    <h3 class="text-2xl font-black text-[#545454] uppercase tracking-tighter mb-8">Ringkasan</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center text-gray-400">
                            <span class="text-[10px] font-black uppercase tracking-widest">Item</span>
                            <span class="font-bold text-[#545454]">{{ count($cart) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Total Tagihan</span>
                            <span class="text-2xl font-black text-[#545454]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form id="checkout-form" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-4">Nama Penerima</label>
                            <input type="text" name="customer_name" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-[#87ceeb] outline-none transition-all font-medium text-[#545454]" placeholder="Contoh: Budi Santoso">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-4">No. WhatsApp</label>
                            <input type="text" name="customer_phone" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-[#87ceeb] outline-none transition-all font-medium text-[#545454]" placeholder="Contoh: 08123456789">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-4">Alamat Pengiriman</label>
                            <textarea name="customer_address" required rows="3" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-[#87ceeb] outline-none transition-all font-medium text-[#545454] resize-none" placeholder="Tuliskan alamat lengkap..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full py-5 bg-[#87ceeb] text-white font-black uppercase text-xs tracking-widest rounded-full shadow-lg shadow-[#87ceeb]/20 hover:bg-[#545454] transition-all transform hover:scale-[1.02] flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            Kirim ke WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-32 bg-white/10 backdrop-blur-md rounded-[40px] border border-white/10 shadow-2xl">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-8 text-white">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h3 class="text-4xl font-black text-white uppercase tracking-tighter mb-4">Keranjang Kosong</h3>
            <p class="text-white/60 text-lg mb-12">Mulailah memilih rangkaian bunga terbaik kami untuk momen spesial Anda.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block px-12 py-5 bg-[#87ceeb] text-white font-black uppercase text-xs tracking-widest rounded-full hover:bg-white hover:text-[#545454] transition-all shadow-xl">Jelajahi Katalog</a>
        </div>
        @endif
    </div>
</div>

<script>
    function updateQuantity(id, quantity) {
        if(quantity < 1) return;
        fetch('{{ route('cart.update') }}', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, quantity })
        }).then(() => location.reload());
    }

    function removeFromCart(id) {
        if(!confirm('Hapus produk ini dari keranjang?')) return;
        fetch('{{ route('cart.remove') }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id })
        }).then(() => location.reload());
    }

    document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = e.target.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Memproses...';

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        fetch('{{ route('cart.checkout') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if(result.status === 'success') {
                window.location.href = result.redirect_url;
            } else {
                alert('Terjadi kesalahan, silakan coba lagi.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    });
</script>
@endsection
