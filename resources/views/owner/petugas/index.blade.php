@extends('layouts.owner')

@section('title', 'Pegawai')

@section('content')
<div class="space-y-6">
    {{-- Header Page --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Data Petugas</h1>
            <p class="text-slate-400 text-sm">Daftar seluruh petugas parkir yang terdaftar di sistem.</p>
        </div>
        <div class="px-6 py-3 bg-yellow-500/10 border border-yellow-500/20 rounded-2xl">
            <span class="text-xs font-bold text-yellow-500 uppercase tracking-widest block">Total Petugas</span>
            <span class="text-2xl font-black text-white">{{ $totalPetugas }} Orang</span>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-slate-900/50 border border-white/5 rounded-3xl overflow-hidden backdrop-blur-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5">
                    <th class="px-6 py-4 text-[10px] font-black text-yellow-500 uppercase tracking-[0.2em]">No</th>
                    <th class="px-6 py-4 text-[10px] font-black text-yellow-500 uppercase tracking-[0.2em]">Nama Petugas</th>
                    <th class="px-6 py-4 text-[10px] font-black text-yellow-500 uppercase tracking-[0.2em]">Username</th>
                    <th class="px-6 py-4 text-[10px] font-black text-yellow-500 uppercase tracking-[0.2em]">Role Access</th>
                    <th class="px-6 py-4 text-[10px] font-black text-yellow-500 uppercase tracking-[0.2em]">ID User</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($petugas as $key => $p)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-6 py-4 text-sm font-bold text-slate-500">{{ $key + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-yellow-500/20 flex items-center justify-center text-yellow-500 font-bold text-xs">
                                {{ strtoupper(substr($p->nama, 0, 1)) }}
                            </div>
                            <span class="text-sm font-bold text-white tracking-wide">{{ $p->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-400">{{ $p->username }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 uppercase">
                            {{ $p->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs font-mono text-slate-500">#{{ $p->id_user }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center">
                        <i class="fas fa-user-slash text-4xl text-slate-700 mb-3 block"></i>
                        <span class="text-slate-500 font-medium text-sm">Belum ada data petugas yang terdaftar.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection