@extends('layouts.admin')

@section('content')
<div class="px-5 py-6 bg-[#f8fafc] min-h-screen">
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
            <div class="w-10 h-10 bg-white text-emerald-500 rounded-xl shadow-sm flex items-center justify-center border border-slate-200">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-5 h-5 fill-current">
                        <path d="M64 160C64 124.7 92.7 96 128 96L416 96C451.3 96 480 124.7 480 160L480 192L530.7 192C547.7 192 564 198.7 576 210.7L621.3 256C633.3 268 640 284.3 640 301.3L640 448C640 483.3 611.3 512 576 512L572.7 512C562.3 548.9 528.3 576 488 576C447.7 576 413.8 548.9 403.3 512L300.7 512C290.3 548.9 256.3 576 216 576C175.7 576 141.8 548.9 131.3 512L128 512C92.7 512 64 483.3 64 448L64 400L24 400C10.7 400 0 389.3 0 376C0 362.7 10.7 352 24 352L136 352C149.3 352 160 341.3 160 328C160 314.7 149.3 304 136 304L24 304C10.7 304 0 293.3 0 280C0 266.7 10.7 256 24 256L200 256C213.3 256 224 245.3 224 232C224 218.7 213.3 208 200 208L24 208C10.7 208 0 197.3 0 184C0 170.7 10.7 160 24 160L64 160zM576 352L576 301.3L530.7 256L480 256L480 352L576 352zM256 488C256 465.9 238.1 448 216 448C193.9 448 176 465.9 176 488C176 510.1 193.9 528 216 528C238.1 528 256 510.1 256 488zM488 528C510.1 528 528 510.1 528 488C528 465.9 510.1 448 488 448C465.9 448 448 465.9 448 488C448 510.1 465.9 528 488 528z" />
                    </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Kendaraan</h3>
                <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Registrasi Kendaraan Terdaftar</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Search Bar --}}
            <div class="relative group">
                <input type="text" id="vehicleSearch" placeholder="Cari plat nomor..." 
                    class="w-full sm:w-64 pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 transition-all shadow-sm text-sm outline-none">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <a href="{{ route('admin.kendaraan.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl font-bold text-xs shadow-sm hover:bg-blue-700 transition-all active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                DAFTAR KENDARAAN
            </a>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="vehicleTable">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">No</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">Plat Nomor</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">Jenis Kendaraan</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider border-b border-blue-500">Warna</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-center border-b border-blue-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($kendaraans as $k)
                    <tr class="odd:bg-white even:bg-slate-100 hover:bg-blue-100 transition-colors group vehicle-row">
                        <td class="px-6 py-4">
                            <span class="text-slate-400 font-bold text-xs">#{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-block px-3 py-1 bg-white border border-slate-800 rounded-md font-black text-slate-800 tracking-widest text-sm shadow-sm group-hover:bg-slate-800 group-hover:text-white transition-all">
                                {{ $k->plat_nomor }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="uppercase font-bold text-slate-700 text-xs tracking-tight">{{ $k->jenis_kendaraan }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full border border-slate-200 shadow-sm" style="background-color: {{ strtolower($k->warna) }}"></div>
                                <span class="font-bold text-slate-500 text-[11px] capitalize">{{ $k->warna }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.kendaraan.edit', $k->id_kendaraan) }}" class="p-2 text-amber-500 hover:bg-amber-500 hover:text-white rounded-xl transition-all border border-amber-100 hover:border-amber-500 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.kendaraan.destroy', $k->id_kendaraan) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-red-100 hover:border-red-500 shadow-sm" onclick="return confirm('Hapus data kendaraan?')">
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
                                    <p class="text-slate-600 font-bold text-base">Kendaraan tidak ditemukan</p>
                                    <p class="text-slate-400 text-xs font-medium">Cek kembali plat nomor atau tambahkan data baru.</p>
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
    document.getElementById('vehicleSearch').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('.vehicle-row');
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