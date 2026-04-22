@extends('layouts.admin')

@section('content')
<div>
    <div class="max-w-4xl mx-auto"> 
        
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-6 px-4 sm:px-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Edit Area Parkir</h3>
                    <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Perbarui Konfigurasi Lokasi Parkir</p>
                </div>
            </div>
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.area.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-bold uppercase tracking-wider hover:bg-slate-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Form Container --}}
        <div class="bg-white rounded-[1.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
            <div class="h-1 w-full bg-gradient-to-r from-blue-600 to-indigo-600"></div>
            
            <div class="p-8 md:p-10">
                <form action="{{ route('admin.area.update', $area->id_area) }}" method="POST" class="space-y-6">
                    @csrf 
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- Nama Area --}}
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Nama Lokasi Area</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </span>
                                <input type="text" name="nama_area" value="{{ old('nama_area', $area->nama_area) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/5 transition-all outline-none"
                                    placeholder="Contoh: Gedung A, Lantai 1">
                            </div>
                        </div>

                        {{-- Kapasitas --}}
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Kapasitas Maksimal (Slot)</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                                    </svg>
                                </span>
                                <input type="number" name="kapasitas" value="{{ old('kapasitas', $area->kapasitas) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/5 transition-all outline-none"
                                    placeholder="00">
                            </div>
                            <p class="text-[9px] text-slate-400 italic ml-1">*Kapasitas saat ini mempengaruhi perhitungan okupansi.</p>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                        <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 bg-blue-600 text-white rounded-xl font-black text-[11px] shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95 uppercase tracking-widest">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        
                        <a href="{{ route('admin.area.index') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 bg-slate-200 text-slate-500 rounded-xl font-bold text-[11px] hover:bg-slate-300 hover:text-slate-600 transition-all active:scale-95 uppercase tracking-widest">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection