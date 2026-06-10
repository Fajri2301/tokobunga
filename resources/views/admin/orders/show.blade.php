@extends('layouts.admin')

@section('content')
<div class="max-w-4xl pb-20">
    <div class="mb-8">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-bold text-slate-400 hover:text-royal-600 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Customer Info -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 italic font-heading">Detail Pesanan</h2>
                        <p class="text-royal-600 font-bold tracking-widest uppercase text-[10px] mt-1">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal Pesanan</div>
                        <div class="font-bold text-slate-900">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-10 mb-12">
                    <div>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nama Pelanggan</h4>
                        <p class="font-bold text-slate-900 text-lg">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">No. WhatsApp</h4>
                        <a href="https://wa.me/{{ $order->customer_phone }}" target="_blank" class="font-bold text-royal-600 text-lg flex items-center hover:underline">
                            {{ $order->customer_phone }}
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="mb-10 text-left">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Alamat Pengiriman</h4>
                    <p class="text-slate-600 leading-relaxed">{{ $order->customer_address }}</p>
                </div>

                <div class="border-t border-slate-100 pt-10">
                    <h4 class="font-heading text-2xl font-bold text-slate-900 italic mb-6">Mahakarya yang Dipesan</h4>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl overflow-hidden shadow-sm">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">{{ $item->product_name }}</div>
                                    <div class="text-xs text-slate-500">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</div>
                                </div>
                            </div>
                            <div class="font-bold text-slate-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-slate-100 flex justify-between items-center text-left">
                    <span class="text-lg font-bold text-slate-900">Total Pembayaran</span>
                    <span class="text-3xl font-black text-royal-600 italic font-heading">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-8">
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 text-left">Kelola Status</h4>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div class="relative">
                        <select name="status" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 focus:border-royal-600 outline-none transition-all font-bold text-sm appearance-none bg-slate-50">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>⚙️ Diproses</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Dikirim</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-5 bg-white border-2 border-slate-100 text-slate-900 font-black uppercase text-xs tracking-[0.2em] rounded-2xl hover:bg-slate-50 transition-all shadow-xl active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Perbarui Status
                    </button>
                </form>
            </div>

            <div class="bg-red-50 rounded-[2.5rem] p-8 border border-red-100">
                <h4 class="text-[10px] font-black uppercase tracking-widest text-red-400 mb-4 text-left">Area Bahaya</h4>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus permanen data pesanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-4 bg-white text-red-600 border border-red-200 font-black uppercase text-[10px] tracking-widest rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm">Hapus Pesanan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
