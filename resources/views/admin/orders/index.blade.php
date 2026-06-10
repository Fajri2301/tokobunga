@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-left">
        <div>
            <h2 class="text-xl font-bold text-slate-900 text-left">Manajemen Pesanan</h2>
            <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest text-left">Halaman {{ $orders->currentPage() }} dari {{ $orders->lastPage() }}</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="w-full text-left border-collapse min-w-[850px]">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black text-left">
                    <th class="px-6 py-5 text-left">No. Invoice</th>
                    <th class="px-6 py-5 text-left">Pelanggan</th>
                    <th class="px-6 py-5 text-left">Total</th>
                    <th class="px-6 py-5 text-center text-left">Status</th>
                    <th class="px-8 py-5 text-right text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($orders as $order)
                <tr class="hover:bg-slate-50/80 transition-all duration-300 text-left">
                    <td class="px-6 py-4 text-left">
                        <span class="font-bold text-royal-600 text-left">{{ $order->order_number }}</span>
                        <div class="text-[10px] text-slate-400 mt-0.5 text-left">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 text-left">
                        <div class="font-bold text-slate-900 text-left">{{ $order->customer_name }}</div>
                        <div class="text-xs text-slate-500 text-left">{{ $order->customer_phone }}</div>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-900 text-left">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'processed' => 'bg-blue-100 text-blue-700',
                                'shipped' => 'bg-purple-100 text-purple-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-3 py-1 {{ $statusClasses[$order->status] ?? 'bg-slate-100' }} text-[10px] font-black uppercase tracking-widest rounded-full text-left">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex justify-end items-center gap-3 text-left">
                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-slate-50 transition-all shadow-sm text-left">
                                Lihat Detail
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus data pesanan ini?')" class="text-left">
                                @csrf @method('DELETE')
                                <button class="p-2 text-slate-300 hover:text-red-600 transition-all text-left">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="p-8 border-t border-slate-50 bg-slate-50/30 text-left">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
