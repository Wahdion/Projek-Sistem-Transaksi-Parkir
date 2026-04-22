@extends('layouts.admin')

@section('content')
<div class="px-5 py-6 min-h-screen">
    {{-- Alert Success --}}
    @if(session('success'))
    <div class="mb-5 p-3 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 text-sm font-semibold rounded-r-lg shadow-sm flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
    @endif
    
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center border border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Akun</h3>
                <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Kelola Akun User</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Search Bar --}}
            <div class="relative group">
                <input type="text" id="userSearch" placeholder="Cari user..." 
                    class="w-full sm:w-64 pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all shadow-sm text-sm outline-none">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <a href="{{ route('admin.user.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl font-bold text-xs shadow-sm hover:bg-blue-700 transition-all active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                USER BARU
            </a>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="userTable">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">No</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">Nama User</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">Username</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-center border-b border-blue-500">Jabatan</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-center border-b border-blue-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $u)
                    {{-- Row selang-seling: Ganjil Putih, Genap Slate-50 --}}
                    <tr class="odd:bg-white even:bg-slate-100 hover:bg-blue-100 transition-colors group user-row">
                        <td class="px-6 py-4">
                            <span class="text-slate-400 font-bold text-xs">#{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $colors = [
                                        'admin' => 'bg-purple-500',
                                        'petugas' => 'bg-emerald-500',
                                        'owner' => 'bg-amber-500'
                                    ];
                                    $bgColor = $colors[$u->role] ?? 'bg-blue-500';
                                @endphp
                                <div class="w-9 h-9 rounded-lg {{ $bgColor }} flex items-center justify-center text-white font-black text-xs shadow-sm group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($u->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-700 text-sm leading-tight">{{ $u->nama }}</span>
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">ID: {{ $u->id_user }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-slate-500 font-semibold text-xs px-2.5 py-1 bg-white border border-slate-200 rounded-lg shadow-sm">
                                <span class="text-indigo-500 font-bold">@</span>{{ $u->username }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $roleStyles = [
                                    'admin' => 'bg-purple-50 text-purple-600 border-purple-100',
                                    'petugas' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'owner' => 'bg-amber-50 text-amber-600 border-amber-100'
                                ];
                            @endphp
                            <span class="px-3 py-1 border {{ $roleStyles[$u->role] ?? 'bg-slate-50 text-slate-600 border-slate-100' }} rounded-lg text-[9px] font-black uppercase tracking-wider shadow-sm">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.user.edit', $u->id_user) }}" class="p-2 text-amber-500 hover:bg-amber-500 hover:text-white rounded-xl transition-all border border-amber-100 hover:border-amber-500 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.user.destroy', $u->id_user) }}" method="POST" class="inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-red-100 hover:border-red-500 shadow-sm" onclick="return confirm('Hapus user ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    {{-- Pesan Jika Data Tidak Ditemukan --}}
                    <tr id="noResultsRow" class="hidden">
                        <td colspan="5" class="px-6 py-16 text-center bg-white">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-slate-600 font-bold text-base">User tidak ditemukan</p>
                                    <p class="text-slate-400 text-xs font-medium">Kami tidak menemukan data untuk kata kunci tersebut.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('userSearch').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');
        const noResultsRow = document.getElementById('noResultsRow');
        let hasVisibleRow = false;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(searchText)) {
                row.style.display = '';
                hasVisibleRow = true;
            } else {
                row.style.display = 'none';
            }
        });

        if (hasVisibleRow) {
            noResultsRow.classList.add('hidden');
        } else {
            noResultsRow.classList.remove('hidden');
        }
    });
</script>
@endsection