@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="overflow-hidden -m-4 md:-m-8">
    <div class="min-h-screen pb-10 p-4 md:p-8">

        {{-- Header Banner: Tema Emerald --}}
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-10 rounded-l-[4rem] text-white relative overflow-hidden -mr-8 mb-8 shadow-xl shadow-emerald-900/10 border-l border-b border-white/10">
            
            {{-- Dekorasi Ikon di Background --}}
            <i class="fas fa-user-shield absolute -right-10 -bottom-10 text-[200px] opacity-10 transform rotate-12 pointer-events-none"></i>
            
            <div class="relative z-10">
                <h1 class="text-3xl font-bold mt-6 tracking-tight leading-tight">
                    Selamat Bekerja,
                    <span class="text-emerald-100">{{ session('nama') ?? 'Petugas' }}!</span>
                </h1>
                <p class="opacity-80 mt-2 text-sm font-medium max-w-md">
                    Fokus pada pelayanan kendaraan masuk dan keluar dengan teliti untuk kenyamanan pengguna YonParkir.
                </p>
                
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('petugas.transaksi.create') }}" 
                    class="bg-white text-emerald-600 px-6 py-3.5 rounded-2xl font-bold hover:bg-emerald-50 transition-all shadow-lg flex items-center gap-2 active:scale-95">
                        <i class="fas fa-plus-circle text-lg"></i> Input Kendaraan Masuk
                    </a>
                    <a href="{{ route('petugas.transaksi.index') }}" 
                    class="bg-emerald-500/20 border border-white/30 text-white px-6 py-3.5 rounded-2xl font-bold hover:bg-white/10 backdrop-blur-sm transition-all flex items-center gap-2 active:scale-95">
                        <i class="fas fa-list text-lg"></i> List Parkir Aktif
                    </a>
                </div>
            </div>
        </div>

        {{-- Judul Seksi --}}
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-800 tracking-tight">Status Kapasitas Area</h3>
        </div>

        {{-- Grid Area Parkir --}}
        <div class="max-w-7xl mx-auto px-4 md:px-0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                @foreach($areas as $area)
                @php 
                    $terisi = $area->transaksi_masuk_count ?? 0;
                    $kapasitas = $area->kapasitas > 0 ? $area->kapasitas : 1; // Hindari bagi nol
                    $sisa = $area->kapasitas - $terisi;
                    $persen = ($terisi / $kapasitas) * 100;
                    $isFull = $sisa <= 0;
                @endphp

                {{-- Card Area: Deep Emerald --}}
                <div class="group relative bg-[#064e3b] rounded-[2.5rem] p-8 border border-white/10 shadow-[0_20px_50px_-15px_rgba(5,150,105,0.4)] hover:shadow-[0_30px_60_px_-10px_rgba(5,150,105,0.6)] transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                    
                    <div class="relative z-10">
                        {{-- Header Card --}}
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl bg-emerald-500 text-white shadow-lg border border-white/20">
                                <i class="fas {{ $isFull ? 'fa-ban' : 'fa-parking' }}"></i>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-black text-emerald-200 uppercase tracking-[0.2em] block mb-1">Kapasitas</span>
                                <div class="flex items-baseline justify-end gap-1">
                                    <span class="text-3xl font-black text-white">{{ $terisi }}</span>
                                    <span class="text-emerald-300 font-bold text-lg">/ {{ $area->kapasitas }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Info Area --}}
                        <div class="mb-6">
                            <h4 class="text-xl font-black text-white uppercase tracking-tight">{{ $area->nama_area }}</h4>
                            <p class="text-[10px] font-bold text-emerald-200/60 mt-1 uppercase tracking-widest">Sistem Parkir Otomatis</p>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="space-y-3">
                            <div class="flex justify-between items-end">
                                <span class="text-[11px] font-black text-emerald-100 uppercase tracking-tighter">Okupansi</span>
                                <span class="text-xs font-black text-white">{{ round($persen) }}%</span>
                            </div>
                            <div class="w-full bg-emerald-900/50 h-4 rounded-xl p-1 shadow-inner border border-white/10 overflow-hidden">
                                <div class="h-full rounded-lg transition-all duration-1000 shadow-[0_0_15px_rgba(16,185,129,0.5)] bg-emerald-400" 
                                    style="width: {{ $persen > 100 ? 100 : $persen }}%">
                                </div>
                            </div>
                        </div>

                        {{-- Footer Card --}}
                        <div class="mt-8 pt-6 border-t border-white/10 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                @if($isFull)
                                    <span class="px-4 py-2 bg-white/10 text-white border border-white/20 rounded-full text-[10px] font-black uppercase tracking-wider">
                                        <i class="fas fa-exclamation-triangle text-[10px] mr-1 text-yellow-300"></i> FULL
                                    </span>
                                @else
                                    <span class="px-4 py-2 bg-emerald-500 text-white rounded-full text-[10px] font-black uppercase tracking-wider shadow-md">
                                        <i class="fas fa-check-circle text-[10px] mr-1"></i> READY
                                    </span>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="block text-[9px] font-black text-emerald-300 uppercase tracking-widest leading-none">Sisa</span>
                                <span class="text-sm font-black text-white uppercase italic tracking-widest">
                                    {{ $sisa < 0 ? 0 : $sisa }} SLOT
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection