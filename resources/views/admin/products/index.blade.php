@extends('layouts.admin')

@section('header', 'Manajemen Produk')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <!-- Header Tabel -->
    <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Daftar Produk</h2>
            <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-medium">Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="w-full sm:w-auto px-6 py-3.5 bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Tambah Produk
        </a>
    </div>
    
    <!-- Kontainer Geser (Responsive) -->
    <div class="table-responsive">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black">
                    <th class="px-8 py-5">Produk & Info</th>
                    <th class="px-6 py-5 text-center">Kategori</th>
                    <th class="px-6 py-5 text-center">Harga</th>
                    <th class="px-6 py-5 text-center">Status</th>
                    <th class="px-8 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($products as $product)
                <tr class="hover:bg-slate-50/80 transition-all duration-300">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="relative flex-shrink-0">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-14 w-14 rounded-2xl object-cover shadow-sm border border-slate-100">
                                @else
                                <div class="h-14 w-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 border border-dashed border-slate-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="font-bold text-slate-900 truncate max-w-[200px]">{{ $product->name }}</div>
                                <div class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter truncate max-w-[150px] opacity-70">{{ $product->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="inline-block px-3 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-black rounded-xl uppercase tracking-widest border border-blue-100">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-5 font-bold text-slate-900 whitespace-nowrap text-center text-sm">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($product->is_featured)
                        <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-[9px] font-black uppercase tracking-widest rounded-lg border border-amber-100">Unggulan</span>
                        @else
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-100">Reguler</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2.5 text-slate-300 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="p-8 border-t border-slate-50 bg-slate-50/30">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
