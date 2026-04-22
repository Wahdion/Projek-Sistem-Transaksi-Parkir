@extends('layouts.admin')

@section('content')
<div class="px-5 py-6 bg-[#f8fafc] min-h-screen">
    
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center border border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Log Aktivitas</h3>
                <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Jejak Audit Pengguna & Transaksi</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Search Bar --}}
            <div class="relative group">
                <input type="text" id="logSearch" placeholder="Cari aktivitas atau nama..." 
                    class="w-full sm:w-64 pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all shadow-sm text-sm outline-none">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            {{-- Badge Total (Opsional) --}}
            <div class="hidden md:flex px-4 py-2 bg-red-100 rounded-xl border border-slate-200 items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></div>
                <span class="text-[10px] font-bold text-red-600 uppercase tracking-tight">System Live</span>
            </div>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="logTable">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">Waktu</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">Pengguna</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                    <tr class="odd:bg-white even:bg-slate-50/50 hover:bg-blue-50 transition-colors group log-row">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-slate-700 font-bold text-xs uppercase tracking-tighter">
                                    {{ date('d M Y', strtotime($log->waktu)) }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-mono">
                                    {{ date('H:i:s', strtotime($log->waktu)) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-700 text-xs uppercase">{{ $log->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-block px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-600 font-semibold text-xs shadow-sm group-hover:border-indigo-100 group-hover:bg-indigo-50/30 transition-all">
                                {{ $log->aktivitas }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="noResultsRow">
                        <td colspan="3" class="px-6 py-20 text-center bg-white">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-slate-600 font-bold text-base">Belum ada log terekam</p>
                                    <p class="text-slate-400 text-xs font-medium">Sistem akan otomatis mencatat setiap aktivitas di sini.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                    {{-- Baris ini muncul hanya jika hasil pencarian kosong --}}
                    <tr id="emptySearchRow" class="hidden">
                        <td colspan="3" class="px-6 py-20 text-center bg-white">
                            <div class="flex flex-col items-center justify-center gap-3 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <p class="text-xs font-bold uppercase tracking-widest">Data tidak ditemukan</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('logSearch').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('.log-row');
        const emptyRow = document.getElementById('emptySearchRow');
        let hasMatch = false;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(searchText)) {
                row.style.display = '';
                hasMatch = true;
            } else {
                row.style.display = 'none';
            }
        });

        if (hasMatch || rows.length === 0) {
            emptyRow.classList.add('hidden');
        } else {
            emptyRow.classList.remove('hidden');
        }
    });
</script>
@endsection