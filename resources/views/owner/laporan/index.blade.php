@extends('layouts.owner')

@section('title', 'Rekap Laporan')

@section('content')
<div class="max-w-7xl mx-auto text-slate-200">
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            {{-- Mengubah Biru menjadi Kuning/Emas --}}
            <h1 class="text-3xl font-black text-white">Rekap <span class="text-yellow-500 italic">Laporan</span></h1>
            <p class="text-slate-500 text-sm font-medium">Filter data transaksi sesuai rentang waktu yang diinginkan.</p>
        </div>
        
        @if($laporan->count() > 0)
        {{-- Mengubah Emerald menjadi Slate/Gold --}}
        <a href="{{ route('owner.laporan.export.csv', request()->all()) }}" 
           class="flex items-center justify-center gap-3 px-6 py-4 bg-yellow-600 hover:bg-yellow-700 text-slate-950 text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-yellow-600/20 active:scale-95 group">
            <i class="fas fa-file-csv text-lg group-hover:rotate-12 transition-transform"></i>
            Export data ke Excel 
        </a>
        @endif
    </div>

    {{-- Filter Card: Menyesuaikan dengan gaya Dashboard (Dark Slate) --}}
    <div class="bg-slate-900 p-8 rounded-[2rem] border border-white/5 shadow-2xl mb-8">
        <form action="{{ route('owner.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-black text-yellow-500/50 uppercase ml-2 tracking-widest">Dari Tanggal</label>
                <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="w-full px-5 py-3 bg-slate-800 border border-white/5 rounded-2xl focus:ring-4 focus:ring-yellow-500/10 outline-none font-bold text-white transition-all">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-black text-yellow-500/50 uppercase ml-2 tracking-widest">Sampai Tanggal</label>
                <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="w-full px-5 py-3 bg-slate-800 border border-white/5 rounded-2xl focus:ring-4 focus:ring-yellow-500/10 outline-none font-bold text-white transition-all">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-black text-yellow-500/50 uppercase ml-2 tracking-widest">Area Parkir</label>
                <select name="id_area" class="w-full px-5 py-3 bg-slate-800 border border-white/5 rounded-2xl focus:ring-4 focus:ring-yellow-500/10 outline-none font-bold text-white transition-all cursor-pointer">
                    <option value="">Semua Area</option>
                    @foreach($listArea as $area)
                        <option value="{{ $area->id_area }}" {{ request('id_area') == $area->id_area ? 'selected' : '' }}>{{ $area->nama_area }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Tombol Cari: Aksen Emas --}}
            <button type="submit" class="bg-gradient-to-r from-yellow-600 to-amber-500 text-slate-950 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:brightness-110 transition-all shadow-lg shadow-yellow-500/20 active:scale-95">
                <i class="fas fa-search mr-2"></i> Cari Data
            </button>
        </form>
    </div>

    {{-- Hasil Rekap --}}
    <div class="bg-slate-900 rounded-[2rem] border border-white/5 shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-white/5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5">
            <div>
                <h3 class="font-black text-yellow-500 uppercase text-xs tracking-widest">Hasil Transaksi</h3>
                <p class="text-[10px] text-slate-500 font-bold mt-1">Ditemukan {{ $laporan->count() }} data transaksi</p>
            </div>
            {{-- Card Total Pendapatan --}}
            <div class="bg-slate-800 px-8 py-4 rounded-[1.5rem] border border-yellow-500/20 text-right shadow-inner">
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-tighter mb-1">Total Pendapatan</p>
                <p class="text-2xl font-black text-emerald-500 font-mono italic">
                    <span class="text-lg not-italic mr-1 text-emerald-600">Rp</span>{{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 border-b border-white/5">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">Waktu Masuk</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">Waktu Keluar</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">Plat Nomor</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">Jenis</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">Area</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Total Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($laporan as $row)
                    <tr class="hover:bg-yellow-500/5 transition-colors group">
                        <td class="px-8 py-5 text-sm font-bold text-slate-500">
                            {{ $row->waktu_masuk ? date('d/m/Y H:i', strtotime($row->waktu_masuk)) : '-' }}
                        </td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-300">
                            {{ $row->waktu_keluar ? date('d/m/Y H:i', strtotime($row->waktu_keluar)) : '-' }}
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-yellow-500/10 text-yellow-500 text-xs font-black rounded-lg uppercase tracking-wider border border-yellow-500/20">
                                {{ $row->plat_nomor }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-400 text-center capitalize">{{ $row->jenis_kendaraan }}</td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-400 text-center">
                            <span class="px-3 py-1 bg-slate-800 rounded-full text-[10px] uppercase font-black text-slate-500 border border-white/5">
                                {{ $row->nama_area }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-sm font-black text-emerald-500 font-mono italic">Rp {{ number_format($row->biaya_total, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center text-slate-600 text-2xl border border-white/5">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <p class="text-slate-500 font-bold italic">Data tidak ditemukan untuk rentang waktu ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection