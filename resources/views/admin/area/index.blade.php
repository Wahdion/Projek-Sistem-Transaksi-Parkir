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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Area Parkir</h3>
                <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Pantau Kapasitas Parkir</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Search Bar --}}
            <div class="relative group">
                <input type="text" id="areaSearch" placeholder="Cari nama area..." 
                    class="w-full sm:w-64 pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all shadow-sm text-sm outline-none">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <a href="{{ route('admin.area.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl font-bold text-xs shadow-sm hover:bg-blue-700 transition-all active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                AREA BARU
            </a>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="areaTable">
                <thead>
                    <tr class="bg-blue-600 border-b border-blue-500 text-white">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider">Info Area</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider">Status Okupansi</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-center">Total Slot</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($areas as $area)
                    <tr class="odd:bg-white even:bg-slate-100 hover:bg-blue-100 transition-colors group area-row">
                        <td class="px-6 py-4">
                            <span class="text-slate-400 font-bold text-xs">#{{ $area->id_area }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xs border border-indigo-200 shadow-sm group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($area->nama_area, 0, 2)) }}
                                </div>
                                <span class="font-bold text-slate-700 text-sm tracking-tight">{{ $area->nama_area }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $persentase = $area->kapasitas > 0 ? ($area->terisi / $area->kapasitas) * 100 : 0;
                                $barColor = $persentase >= 90 ? 'bg-rose-500' : ($persentase >= 70 ? 'bg-amber-500' : 'bg-emerald-500');
                                $textColor = $persentase >= 90 ? 'text-rose-600' : ($persentase >= 70 ? 'text-amber-600' : 'text-emerald-600');
                                $bgBadge = $persentase >= 90 ? 'bg-rose-50' : ($persentase >= 70 ? 'bg-amber-50' : 'bg-emerald-50');
                            @endphp
                            <div class="flex flex-col w-44">
                                <div class="flex justify-between items-center mb-1.5">
                                    <span class="px-2 py-0.5 rounded {{ $bgBadge }} text-[9px] font-black {{ $textColor }} uppercase border border-current opacity-80">
                                        {{ $area->terisi }} Terisi
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-500">{{ round($persentase) }}%</span>
                                </div>
                                <div class="w-full bg-slate-200/50 rounded-full h-2 overflow-hidden shadow-inner">
                                    <div class="{{ $barColor }} h-full transition-all duration-1000 ease-out shadow-[0_0_8px_rgba(0,0,0,0.1)]" style="width: {{ $persentase }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-white text-slate-600 rounded-lg text-[10px] font-black border border-slate-200 shadow-sm group-hover:border-indigo-300 transition-colors">
                                {{ $area->kapasitas }} SLOT
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.area.edit', $area->id_area) }}" class="p-2 text-amber-500 hover:bg-amber-500 hover:text-white rounded-xl transition-all border border-amber-100 hover:border-amber-500 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.area.destroy', $area->id_area) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-red-100 hover:border-red-500 shadow-sm" onclick="return confirm('Hapus area parkir ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    {{-- Pesan Jika Data Kosong --}}
                    <tr id="noResultsRow" class="hidden">
                        <td colspan="5" class="px-6 py-16 text-center bg-white">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-slate-600 font-bold text-base">Area tidak ditemukan</p>
                                    <p class="text-slate-400 text-xs font-medium">Pastikan nama area yang anda cari sudah sesuai.</p>
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
    document.getElementById('areaSearch').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('.area-row');
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