@extends('layouts.admin')

@section('content')
<div class="px-5 py-6 min-h-screen">
    {{-- Alert Success --}}
    @if(session('success'))
    <div class="mb-5 p-3 bg-blue-50 border-l-4 border-blue-500 text-blue-800 text-sm font-semibold rounded-r-lg shadow-sm flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
    @endif
    
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center border border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Tarif Parkir Kendaraan</h3>
                <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Kelola Biaya Parkir Kendaraan</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Search Bar --}}
            <div class="relative group">
                <input type="text" id="tarifSearch" placeholder="Cari jenis kendaraan..." 
                    class="w-full sm:w-64 pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl focus:border-blue-500 transition-all shadow-sm text-sm outline-none">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <a href="{{ route('admin.tarif.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl font-bold text-xs shadow-sm hover:bg-blue-700 transition-all active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                TAMBAH TARIF
            </a>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="tarifTable">
                <thead>
                    <tr class="bg-blue-600 border-b border-blue-500 text-white">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider">Jenis Kendaraan</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-center">Tarif / Jam</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-center">Update Terakhir</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($tarifs as $t)
                    <tr class="odd:bg-white even:bg-slate-100 hover:bg-blue-100 transition-colors group tarif-row">
                        <td class="px-6 py-4">
                            <span class="text-slate-400 font-bold text-xs">#{{ $t->id_tarif }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $isMobil = str_contains(strtolower($t->jenis_kendaraan), 'mobil');
                                    $bgColor = $isMobil ? 'bg-blue-500' : 'bg-orange-500';
                                @endphp
                                <div class="w-9 h-9 rounded-lg {{ $bgColor }} flex items-center justify-center text-white shadow-sm transition-transform group-hover:scale-110">
                                    @if($isMobil)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 640 512"><path d="M173.1 25.9L151.5 88h337l-21.6-62.1c-3.7-10.6-13.8-17.9-25.1-17.9H198.2c-11.3 0-21.3 7.3-25.1 17.9zM27.4 162c-16.4 4.5-27.4 20.9-24.4 37.6l23 128C28.5 342.1 41 352 54.8 352H64V432c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V352H480v80c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V352h9.2c13.8 0 26.3-9.9 28.8-24.4l23-128c3-16.7-7.9-33.1-24.4-37.6L496.1 131.2c-10.1-2.8-20.4-4.2-30.8-4.2H174.7c-10.4 0-20.7 1.4-30.8 4.2L27.4 162zM96 288a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm416 32a32 32 0 1 1 0-64 32 32 0 1 1 0 64z"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 640 512"><path d="M280 32c-13.3 0-24 10.7-24 24s10.7 24 24 24h56.6l22.5 48.7L264 200c-33.4-25.1-75-40-120-40H88c-13.3 0-24 10.7-24 24s10.7 24 24 24h56c78.5 0 143.2 59.6 151.2 136H269.8c-11.2-59.2-63.3-104-125.8-104C73.3 240 16 297.3 16 368s57.3 128 128 128c62.5 0 114.5-44.8 125.8-104H320c13.3 0 24-10.7 24-24v-22.5c0-45.1 25.7-85.4 65.5-107.7l12.1 26.1c-32.4 23.2-53.5 61.2-53.5 104.1c0 70.7 57.3 128 128 128s128-57.3 128-128c0-70.7-57.3-128-128-128c-10.7 0-21 1.3-30.9 3.8l-31.4-67.8H488c13.3 0 24-10.7 24-24s-10.7-24-24-24h-53.3c-6.9 0-13.7 3-18.4 8.2l-17.1 12.8L373.8 45.9c-3.9-8.5-12.4-13.9-21.8-13.9H280z"/></svg>
                                    @endif
                                </div>
                                <span class="font-bold text-slate-700 text-sm tracking-tight">{{ $t->jenis_kendaraan }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-xs font-bold shadow-sm">
                                Rp {{ number_format($t->tarif_per_jam, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-tight">
                                {{ \Carbon\Carbon::parse($t->updated_at)->format('d M Y, H:i') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.tarif.edit', $t->id_tarif) }}" class="p-2 text-amber-500 hover:bg-amber-500 hover:text-white rounded-xl transition-all border border-amber-50 hover:border-amber-500 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.tarif.destroy', $t->id_tarif) }}" method="POST" class="inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-red-50 hover:border-red-500 shadow-sm" onclick="return confirm('Hapus pengaturan tarif ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    {{-- Baris Pesan Jika Kosong --}}
                    <tr id="noResultsRow" class="hidden">
                        <td colspan="5" class="px-6 py-16 text-center bg-white">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-slate-600 font-bold text-base">Tarif tidak ditemukan</p>
                                    <p class="text-slate-400 text-xs">Coba cari dengan nama kendaraan yang berbeda.</p>
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
    document.getElementById('tarifSearch').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('.tarif-row');
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

        // Tampilkan/Sembunyikan pesan kosong
        if (hasVisibleRow) {
            noResultsRow.classList.add('hidden');
        } else {
            noResultsRow.classList.remove('hidden');
        }
    });
</script>
@endsection