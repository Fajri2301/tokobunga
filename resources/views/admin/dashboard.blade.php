@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Stat Card: Total Produk -->
    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex items-center group hover:shadow-xl transition-all duration-500">
        <div class="h-14 w-14 rounded-2xl bg-[#87ceeb]/10 text-[#87ceeb] flex items-center justify-center mr-5 group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Produk</p>
            <h3 class="text-3xl font-black text-[#545454] tracking-tighter">{{ $stats['products_count'] }}</h3>
        </div>
    </div>

    <!-- Stat Card: Total Pesanan -->
    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex items-center group hover:shadow-xl transition-all duration-500">
        <div class="h-14 w-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center mr-5 group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Pesanan</p>
            <h3 class="text-3xl font-black text-[#545454] tracking-tighter">{{ $stats['orders_count'] }}</h3>
        </div>
    </div>

    <!-- Stat Card: Pesanan Bulan Ini -->
    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex items-center group hover:shadow-xl transition-all duration-500">
        <div class="h-14 w-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mr-5 group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Bulan Ini</p>
            <h3 class="text-3xl font-black text-[#545454] tracking-tighter">{{ $stats['orders_this_month'] }}</h3>
        </div>
    </div>

    <!-- Stat Card: Omzet Bulan Ini -->
    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex items-center group hover:shadow-xl transition-all duration-500">
        <div class="h-14 w-14 rounded-2xl bg-[#87ceeb]/10 text-[#87ceeb] flex items-center justify-center mr-5 group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Omzet</p>
            <h3 class="text-2xl font-black text-[#545454] tracking-tighter">Rp {{ number_format($stats['revenue_this_month'], 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h2 class="text-xl font-black text-[#545454] uppercase tracking-tighter">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-black text-[#87ceeb] uppercase tracking-widest hover:text-[#545454] transition-colors">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">
                        <th class="px-8 py-5">Invoice</th>
                        <th class="px-8 py-5">Pelanggan</th>
                        <th class="px-8 py-5">Total</th>
                        <th class="px-8 py-5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recent_orders as $order)
                    <tr class="text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5 font-black text-[#87ceeb]">#{{ $order->order_number }}</td>
                        <td class="px-8 py-5 font-bold">{{ $order->customer_name }}</td>
                        <td class="px-8 py-5 font-black text-slate-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-8 py-5 text-right">
                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest
                                @if($order->status == 'pending') bg-amber-50 text-amber-600
                                @elseif($order->status == 'completed') bg-emerald-50 text-emerald-600
                                @else bg-blue-50 text-blue-600 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-slate-400 italic">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="text-xl font-black text-[#545454] uppercase tracking-tighter">Produk Terlaris</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">
                        <th class="px-8 py-5">Nama Produk</th>
                        <th class="px-8 py-5 text-right">Volume Terjual</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($top_products as $product)
                    <tr class="text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5 font-bold uppercase tracking-tighter">{{ $product->product_name }}</td>
                        <td class="px-8 py-5 text-right">
                            <span class="text-lg font-black text-[#545454]">{{ $product->total_sold }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase ml-1">Item</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-8 py-12 text-center text-slate-400 italic">Belum ada data penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-8 bg-[#545454] rounded-[40px] p-10 border border-white/10 shadow-2xl relative overflow-hidden group">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32 transition-transform duration-700 group-hover:scale-110"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
        <div>
            <h2 class="text-2xl font-black text-white uppercase tracking-tighter mb-2">Aksi Cepat Administrator</h2>
            <p class="text-white/60 text-sm">Kelola inventaris dan pengaturan toko Anda dalam satu klik.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('admin.products.create') }}" class="px-8 py-4 bg-[#87ceeb] text-white rounded-full font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-[#87ceeb]/20 hover:bg-white hover:text-[#545454] transition-all">
                Tambah Produk Baru
            </a>
            <a href="{{ route('admin.settings.edit') }}" class="px-8 py-4 bg-white/10 text-white border border-white/20 rounded-full font-black text-[10px] uppercase tracking-[0.2em] hover:bg-white hover:text-[#545454] transition-all">
                Buka Pengaturan
            </a>
        </div>
    </div>
</div>
@endsection
