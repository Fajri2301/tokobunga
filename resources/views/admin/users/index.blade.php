@extends('layouts.admin')

@section('header', 'Manajemen Akun Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-black text-[#545454] tracking-tight">Daftar Admin</h2>
            <p class="text-sm text-slate-400 font-medium mt-1">Kelola akun admin yang dapat mengakses panel ini.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-premium flex items-center px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-[#0cc0df]/30 group">
            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Admin
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-start text-emerald-600 animate-fade-in shadow-sm">
        <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start text-rose-600 animate-fade-in shadow-sm">
        <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-sm font-bold">{{ session('error') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <div class="table-responsive">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="p-5 text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Nama</th>
                        <th class="p-5 text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Email</th>
                        <th class="p-5 text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Tgl Dibuat</th>
                        <th class="p-5 text-xs font-black text-slate-400 uppercase tracking-widest text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-slate-500 uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-[#545454]">{{ $user->name }}</p>
                                    @if(auth()->id() === $user->id)
                                    <span class="inline-block px-2 py-0.5 bg-[#0cc0df]/10 text-[#0cc0df] text-[10px] font-bold uppercase tracking-wider rounded-md mt-1">Anda (Saat ini)</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-5 font-medium text-slate-500 whitespace-nowrap">
                            {{ $user->email }}
                        </td>
                        <td class="p-5 text-sm font-medium text-slate-400 whitespace-nowrap">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="p-5 text-right whitespace-nowrap">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-400 hover:text-[#0cc0df] hover:bg-[#0cc0df]/10 rounded-xl transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400 font-medium">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Belum ada data admin.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
