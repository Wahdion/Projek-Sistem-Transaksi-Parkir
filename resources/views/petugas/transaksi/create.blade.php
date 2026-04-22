@extends('layouts.petugas')

@section('title', 'Registrasi Masuk')

@section('content')
{{-- Container Utama: Mengunci tinggi agar tidak scroll (h-screen minus navbar/header) --}}
        
<div class="h-[calc(100vh-130px)] flex items-center justify-center p-4 overflow-hidden">
    <div class="w-full max-w-5xl">
        
        <div class="bg-white border rounded-[2.5rem] border-slate-300 shadow-2xl shadow-emerald-900/10 overflow-hidden">
            <form action="{{ route('petugas.transaksi.store') }}" method="POST" id="form-masuk">
                @csrf
                
                <div class="flex flex-col md:flex-row min-h-[420px]">
                    
                 {{-- Sisi Kiri: Visual Identity --}}
<div class="w-full md:w-[38%] relative flex flex-col p-10 overflow-hidden group">
    {{-- Background & Overlay --}}
    <img src="https://i.pinimg.com/736x/79/29/7c/79297ca8cabfc811f11b8e13060b2377.jpg" 
         class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Latar Belakang">
    <div class="absolute inset-0 bg-emerald-600/90 mix-blend-multiply"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/90 via-transparent to-emerald-500/30"></div>

    <div class="relative z-10 flex flex-col h-full w-full">
        
        {{-- LOGO AREA: Dipaksa ke paling atas dengan mt-0 dan mb-auto --}}
        <div class="flex flex-col items-center justify-start w-full mt-0 mb-auto">
            <div class="shadow-2xl transform transition-transform duration-500 group-hover:scale-105">
                <img src="{{ asset('assets/images/logo-YonParkir.png') }}" 
                     alt="Logo YonParkir" 
                     class="h-28 w-auto object-contain filter drop-shadow-[0_20px_20px_rgba(0,0,0,0.4)]">
            </div>
        </div>

        {{-- TEXT AREA: Dipaksa tetap di bawah --}}
        <div class="w-full text-center pb-6">
            <h2 class="text-3xl font-black text-white tracking-tight uppercase leading-tight">
                Check-in<br><span class="text-emerald-300">Kendaraan</span>
            </h2>
            <div class="flex justify-center mt-4">
                <div class="h-1.5 w-12 bg-emerald-400 rounded-full group-hover:w-20 transition-all duration-500"></div>
            </div>
            <p class="text-emerald-100 text-[10px] mt-8 font-bold uppercase tracking-[0.4em] opacity-70">
                Sistem Parkir YonParkir
            </p>
        </div>

    </div>
</div>

                    {{-- Sisi Kanan: Form Input (Logika Asli) --}}
                    <div class="w-full md:w-[65%] p-10 md:p-14 flex flex-col justify-center bg-white">
                        <div class="grid grid-cols-2 gap-x-10 gap-y-7">
                            
                            {{-- Input Plat Nomor --}}
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic">Plat Nomor</label>
                                <input type="text" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor') }}"
                                    class="w-full h-[64px] px-6 py-4 rounded-2xl border-2 border-slate-300 bg-slate-50/50 focus:bg-white focus:border-emerald-500 outline-none transition-all font-black text-[1 rem] tracking-widest placeholder:text-slate-400 uppercase" 
                                    placeholder="No Kendaraan..." required autofocus autocomplete="off">
                                <div id="status_kendaraan" class="hidden text-[8px] font-extrabold uppercase mt-1 px-2.5 py-1 rounded-lg inline-block shadow-sm"></div>
                            </div>

                            {{-- Dropdown Jenis Kendaraan --}}
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic">Jenis Kendaraan</label>
                                <div class="relative">
                                    <select name="id_tarif" id="id_tarif" 
                                            class="w-full h-[64px] px-6 py-4 rounded-2xl border-2 border-slate-300 bg-slate-50/50 focus:bg-white focus:border-emerald-500 outline-none transition-all font-bold text-slate-700 appearance-none text-[0.9rem]" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach($tarifs as $tr)
                                            <option value="{{ $tr->id_tarif }}" data-jenis="{{ $tr->jenis_kendaraan }}">
                                                {{ strtoupper($tr->jenis_kendaraan) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-400">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Input Warna --}}
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic">Warna</label>
                                <input type="text" name="warna" id="warna" value="{{ old('warna') }}"
                                   class="w-full h-[64px] px-6 py-4 rounded-2xl border-2 border-slate-300 bg-slate-50/50 focus:bg-white focus:border-emerald-500 outline-none transition-all font-black text-[0.9rem] tracking-widest placeholder:text-slate-400" 
                                    placeholder="Warna Kendaraan..." required autocomplete="off">
                            </div>

                            {{-- Dropdown Area Parkir --}}
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic">Area Parkir</label>
                                <div class="relative">
                                    <select name="id_area" 
                                            class="w-full h-[64px] px-6 py-4 rounded-2xl border-2 border-slate-300 bg-slate-50/50 focus:bg-white focus:border-emerald-500 outline-none transition-all font-bold text-slate-700 appearance-none text-[0.9rem]" required>
                                        <option value="">-- Area Parkir --</option>
                                        @foreach($areas as $ar)
                                            <option value="{{ $ar->id_area }}">
                                                {{ $ar->nama_area }} ({{ $ar->kapasitas - $ar->terisi }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-400">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-10 pt-8 border-t border-slate-50 flex items-center gap-4">
                            <a href="{{ route('petugas.transaksi.index') }}" 
                            class="flex-1 inline-flex items-center justify-center gap-3 px-6 py-4.5 bg-red-500 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] hover:bg-red-600 transition-all active:scale-95 group border border-slate-200">
                                <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1 text-sm"></i> 
                                <span>Batal</span>
                            </a>

                            <button type="submit" 
                                    class="flex-[2] bg-emerald-500 hover:bg-emerald-600 text-white py-4.5 rounded-2xl font-black uppercase tracking-[0.2em] text-[13px] transition-all shadow-xl shadow-emerald-500/20 active:scale-95 flex items-center justify-center gap-4">
                                <i class="fas fa-print text-lg"></i> 
                                <span>CHECK-IN</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    @vite(['resources/js/petugas/create.js'])
@endpush