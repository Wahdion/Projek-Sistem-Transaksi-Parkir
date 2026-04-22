@extends('layouts.admin')

@section('content')
<div class="py-6">
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
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Edit Data Kendaraan</h3>
                    <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Perbarui Informasi <span class="text-indigo-600">{{ $kendaraan->plat_nomor }}</span></p>
                </div>
            </div>
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.kendaraan.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-bold uppercase tracking-wider hover:bg-slate-50 transition-all">
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
                <form method="POST" action="{{ route('admin.kendaraan.update', $kendaraan->id_kendaraan) }}" class="space-y-6">
                    @csrf 
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- Plat Nomor --}}
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Plat Nomor</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10m-10 5h10" />
                                    </svg>
                                </span>
                                <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/5 transition-all outline-none uppercase placeholder:normal-case"
                                    placeholder="Contoh: B 1234 ABC">
                            </div>
                        </div>

                        {{-- Jenis Kendaraan --}}
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Jenis Kendaraan</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </span>
                                <select name="jenis_kendaraan" required 
                                    class="w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/5 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="motor" {{ $kendaraan->jenis_kendaraan == 'motor' ? 'selected' : '' }}>MOTOR</option>
                                    <option value="mobil" {{ $kendaraan->jenis_kendaraan == 'mobil' ? 'selected' : '' }}>MOBIL</option>
                                    <option value="lainnya" {{ $kendaraan->jenis_kendaraan == 'lainnya' ? 'selected' : '' }}>LAINNYA</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Warna Kendaraan --}}
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Warna</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </span>
                                <input type="text" name="warna" value="{{ old('warna', $kendaraan->warna) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/5 transition-all outline-none"
                                    placeholder="Contoh: Hitam Metalik, Putih">
                            </div>
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
                        
                        <a href="{{ route('admin.kendaraan.index') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 bg-slate-200 text-slate-500 rounded-xl font-bold text-[11px] hover:bg-slate-300 hover:text-slate-600 transition-all active:scale-95 uppercase tracking-widest text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection