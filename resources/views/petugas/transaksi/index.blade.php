@extends('layouts.petugas')

@section('title', 'Monitoring Parkir')

@section('content')
<div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
    
    {{-- Header Section: Emerald Theme --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Kendaraan <span class="text-emerald-600">Terparkir</span></h1>
            <p class="text-slate-500 text-sm font-medium mt-1" id="search-status">
                Menampilkan seluruh kendaraan yang berstatus <span class="text-emerald-600 font-bold">'masuk'</span>
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto items-center">
            {{-- Search Bar --}}
            <div class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <div id="search-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <div id="search-spinner" class="hidden">
                        <i class="fas fa-circle-notch fa-spin text-emerald-600"></i>
                    </div>
                </div>
                <input type="text" 
                       id="search-input"
                       placeholder="Cari Plat Nomor..." 
                       class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all font-bold text-slate-700 placeholder:text-slate-400 shadow-sm"
                       autocomplete="off">
            </div>

            <a href="{{ route('petugas.transaksi.create') }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-emerald-600 text-white rounded-2xl font-black text-sm hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20 active:scale-95">
                Check-in Baru
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white border-b border-slate-200">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em]">Identitas Kendaraan</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-center">Area Parkir</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-center">Waktu Masuk</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body" class="divide-y divide-slate-100">
                    @fragment('table-pencarian')
                        @forelse($transaksi as $item)
                        <tr class="odd:bg-white even:bg-slate-50 hover:bg-emerald-50 transition-colors group user-row">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="flex items-center justify-center">
                                        @php
                                            $jenis = strtolower($item->tarif->jenis_kendaraan);
                                        @endphp

                                        @if(Str::contains($jenis, 'motor'))
                                            <i class="fas fa-motorcycle text-3xl text-slate-700 group-hover:text-emerald-600 transition-colors"></i>
                                        @elseif(Str::contains($jenis, 'mobil'))
                                            <i class="fas fa-car text-3xl text-slate-700 group-hover:text-emerald-600 transition-colors"></i>
                                        @elseif(Str::contains($jenis, 'truck') || Str::contains($jenis, 'truk'))
                                            <i class="fas fa-truck text-3xl text-slate-700 group-hover:text-emerald-600 transition-colors"></i>
                                        @else
                                            <i class="fas fa-car-side text-3xl text-slate-700 group-hover:text-emerald-600 transition-colors"></i>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 text-xl font-black tracking-widest leading-none mb-1">
                                            {{ strtoupper($item->kendaraan->plat_nomor) }}
                                        </span>
                                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider">
                                            <span class="text-emerald-600">{{ $item->tarif->jenis_kendaraan }}</span>
                                            <span class="text-slate-300">•</span>
                                            <span class="text-slate-400">{{ $item->kendaraan->warna }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <span class="inline-flex items-center px-4 py-1.5 bg-teal-50 text-teal-700 rounded-full text-[10px] font-black uppercase tracking-tight border border-teal-100">
                                    {{ $item->area->nama_area }}
                                </span>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-slate-800 font-black text-lg leading-none mb-1">{{ $item->waktu_masuk->format('H:i') }}</span>
                                    <span class="text-slate-400 text-[10px] font-bold uppercase tracking-tighter">{{ $item->waktu_masuk->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex items-center justify-center gap-3">
                                    <button type="button" 
                                        onclick="konfirmasiCheckout('{{ $item->id_parkir }}', '{{ $item->kendaraan->plat_nomor }}', '{{ $item->waktu_masuk->toIso8601String() }}', {{ $item->tarif->tarif_per_jam }})"
                                        class="w-10 h-10 flex items-center justify-center bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20 active:scale-95 group"
                                        title="Checkout">
                                        <i class="fas fa-sign-out-alt text-sm transition-transform group-hover:translate-x-0.5"></i>
                                    </button>

                                    <a href="{{ route('petugas.transaksi.print', $item->id_parkir) }}" 
                                    target="_blank"
                                    class="flex items-center gap-2 px-3 py-2 bg-slate-900 text-white rounded-2xl font-black text-[10px] tracking-tighter hover:bg-slate-700 hover:text-white transition-all border border-slate-200"
                                    title="Cetak Ulang Struk">
                                        <i class="fas fa-print"></i>
                                        <span>Cetak Ulang</span>
                                    </a>
                                </div>

                                <form id="form-checkout-{{ $item->id_parkir }}" 
                                    action="{{ route('petugas.transaksi.update', $item->id_parkir) }}" 
                                    method="POST" class="hidden">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-24 text-center">
                                <div class="flex flex-col items-center opacity-20">
                                    <i class="fas fa-search text-5xl mb-4"></i>
                                    <span class="text-sm font-black uppercase tracking-widest">Tidak ada kendaraan</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    @endfragment
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.indexRoute = "{{ route('petugas.transaksi.index') }}";
    
    @if(session('download_struk'))
        window.downloadStrukUrl = "{{ route('petugas.transaksi.print', session('download_struk')) }}";
    @else
        window.downloadStrukUrl = null;
    @endif
</script>

@push('scripts')
    @vite(['resources/js/petugas/index.js'])
@endpush
@endsection