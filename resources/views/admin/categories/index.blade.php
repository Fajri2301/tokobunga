@extends('layouts.admin')

@section('header', 'Manajemen Kategori')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-left">
        <div>
            <h2 class="text-xl font-bold text-slate-900 text-left">Daftar Kategori</h2>
            <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest text-left">Halaman {{ $categories->currentPage() }} dari {{ $categories->lastPage() }}</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="w-full sm:w-auto px-6 py-3.5 bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Tambah Kategori
        </a>
    </div>

    <div class="table-responsive">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black">
                    <th class="px-8 py-5 text-left">Info Kategori</th>
                    <th class="px-6 py-5 text-center text-left">Tampil di Home</th>
                    <th class="px-8 py-5 text-right text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($categories as $category)
                <tr class="hover:bg-slate-50/80 transition-all duration-300">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4 text-left">
                            <div class="h-12 w-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-100 text-left">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="text-left">
                                <div class="font-bold text-slate-900">{{ $category->name }}</div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $category->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($category->is_active_on_home)
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest rounded-lg border border-emerald-100 text-left">Aktif</span>
                        @else
                            <span class="px-3 py-1 bg-slate-50 text-slate-400 text-[9px] font-black uppercase tracking-widest rounded-lg border border-slate-100 text-left">Tidak</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2 text-left">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-300 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all text-left">
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

    @if($categories->hasPages())
    <div class="p-8 border-t border-slate-50 bg-slate-50/30 text-left">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
