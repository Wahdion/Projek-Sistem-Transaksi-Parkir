@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto"> 
        
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-6 px-4 sm:px-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white text-emerald-500 rounded-xl shadow-sm flex items-center justify-center border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-5 h-5 fill-current">
                        <path d="M64 160C64 124.7 92.7 96 128 96L416 96C451.3 96 480 124.7 480 160L480 192L530.7 192C547.7 192 564 198.7 576 210.7L621.3 256C633.3 268 640 284.3 640 301.3L640 448C640 483.3 611.3 512 576 512L572.7 512C562.3 548.9 528.3 576 488 576C447.7 576 413.8 548.9 403.3 512L300.7 512C290.3 548.9 256.3 576 216 576C175.7 576 141.8 548.9 131.3 512L128 512C92.7 512 64 483.3 64 448L64 400L24 400C10.7 400 0 389.3 0 376C0 362.7 10.7 352 24 352L136 352C149.3 352 160 341.3 160 328C160 314.7 149.3 304 136 304L24 304C10.7 304 0 293.3 0 280C0 266.7 10.7 256 24 256L200 256C213.3 256 224 245.3 224 232C224 218.7 213.3 208 200 208L24 208C10.7 208 0 197.3 0 184C0 170.7 10.7 160 24 160L64 160zM576 352L576 301.3L530.7 256L480 256L480 352L576 352zM256 488C256 465.9 238.1 448 216 448C193.9 448 176 465.9 176 488C176 510.1 193.9 528 216 528C238.1 528 256 510.1 256 488zM488 528C510.1 528 528 510.1 528 488C528 465.9 510.1 448 488 448C465.9 448 448 465.9 448 488C448 510.1 465.9 528 488 528z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Tambah Kendaraan</h3>
                    <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Registrasi Unit Kendaraan Baru</p>
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
                <form method="POST" action="{{ route('admin.kendaraan.store') }}" class="space-y-6">
                    @csrf 

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
                                <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/5 transition-all outline-none uppercase placeholder:normal-case"
                                    placeholder=" Masukan Nomor Kendaraan">
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
                                    <option value="" disabled selected>Jenis Kendaraan</option>
                                    <option value="motor">MOTOR</option>
                                    <option value="mobil">MOBIL</option>
                                    <option value="lainnya">LAINNYA</option>
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
                                <span class="absolute inset-y-0 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                </span>
                                <input type="text" name="warna" value="{{ old('warna') }}" required
                                    class="w-full pl-4 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/5 transition-all outline-none"
                                    placeholder="Contoh: Hitam, Putih, DLL">
                            </div>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                        <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 bg-blue-600 text-white rounded-xl font-black text-[11px] shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95 uppercase tracking-widest">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Kendaraan
                        </button>
                        
                        <button type="reset" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 bg-slate-200 text-slate-500 rounded-xl font-bold text-[11px] hover:bg-slate-300 hover:text-slate-600 transition-all active:scale-95 uppercase tracking-widest">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection