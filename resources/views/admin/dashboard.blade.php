@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="overflow-hidden -m-4 md:-m-8"> 
    <div class="min-h-screen pb-10 p-4 md:p-8">
        
        {{-- Header Section - Diubah ke Full Blue Gradient --}}
        <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-blue-800 -mt-4 md:-mt-8 -mx-4 md:-mx-8 pt-12 pb-28 px-10 mb-[-6rem] relative shadow-2xl rounded-b-[2rem]">
            <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6 z-10">
                <div class="space-y-1">
                    <h2 class="text-4xl font-bold text-white tracking-tight">Dashboard Admin</h2>
                    <p class="text-blue-100/90 text-sm font-medium">
                        Selamat Datang Admin, <span class="text-white font-bold">{{ session('nama') }}</span>.
                    </p>
                </div>
            </div>
        </div>

        {{-- Stats Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 relative z-20">
            
            {{-- Card 1: User (Tetap Biru/Blue) --}}
            <div class="group bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-blue-50/50 rounded-bl-[3rem] -mr-8 -mt-8 transition-all group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.15em]">User</p>
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl shadow-sm ring-1 ring-blue-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight relative z-10">{{ number_format($count_user ?? 0) }}</h3>
                <p class="text-slate-400 text-[10px] mt-1 font-bold tracking-wide flex items-center gap-1.5">
                    <span class="w-1 h-1 bg-blue-400 rounded-full"></span> Akun Terdaftar
                </p>
                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-blue-400 to-blue-500 transition-all duration-500 group-hover:w-full"></div>
            </div>

            {{-- Card 2: Tarif --}}
            <div class="group bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-blue-50/50 rounded-bl-[3rem] -mr-8 -mt-8 transition-all group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.15em]">Tarif</p>
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl shadow-sm ring-1 ring-blue-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight relative z-10">{{ number_format($count_tarif ?? 0) }}</h3>
                <p class="text-slate-400 text-[10px] mt-1 font-bold tracking-wide flex items-center gap-1.5">
                    <span class="w-1 h-1 bg-blue-400 rounded-full"></span> Kategori Biaya
                </p>
                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-blue-400 to-blue-500 transition-all duration-500 group-hover:w-full"></div>
            </div>

            {{-- Card 3: Area (Diubah dari Purple ke Light Blue/Cyan) --}}
            <div class="group bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-cyan-50/50 rounded-bl-[3rem] -mr-8 -mt-8 transition-all group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.15em]">Area</p>
                    <div class="p-2.5 bg-cyan-50 text-cyan-600 rounded-xl shadow-sm ring-1 ring-cyan-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight relative z-10">{{ number_format($count_area ?? 0) }}</h3>
                <p class="text-slate-400 text-[10px] mt-1 font-bold tracking-wide flex items-center gap-1.5">
                    <span class="w-1 h-1 bg-cyan-400 rounded-full"></span> Lokasi Parkir
                </p>
                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-cyan-400 to-blue-500 transition-all duration-500 group-hover:w-full"></div>
            </div>

            {{-- Card 4: Unit --}}
            <div class="group bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-50/50 rounded-bl-[3rem] -mr-8 -mt-8 transition-all group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.15em]">Unit</p>
                    <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl shadow-sm ring-1 ring-emerald-100">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 640 512"><path d="M64 160C64 124.7 92.7 96 128 96L416 96C451.3 96 480 124.7 480 160L480 192L530.7 192C547.7 192 564 198.7 576 210.7L621.3 256C633.3 268 640 284.3 640 301.3L640 448C640 483.3 611.3 512 576 512L572.7 512C562.3 548.9 528.3 576 488 576C447.7 576 413.8 548.9 403.3 512L300.7 512C290.3 548.9 256.3 576 216 576C175.7 576 141.8 548.9 131.3 512L128 512C92.7 512 64 483.3 64 448L64 400L24 400C10.7 400 0 389.3 0 376C0 362.7 10.7 352 24 352L136 352C149.3 352 160 341.3 160 328C160 314.7 149.3 304 136 304L24 304C10.7 304 0 293.3 0 280C0 266.7 10.7 256 24 256L200 256C213.3 256 224 245.3 224 232C224 218.7 213.3 208 200 208L24 208C10.7 208 0 197.3 0 184C0 170.7 10.7 160 24 160L64 160zM576 352L576 301.3L530.7 256L480 256L480 352L576 352zM256 488C256 465.9 238.1 448 216 448C193.9 448 176 465.9 176 488C176 510.1 193.9 528 216 528C238.1 528 256 510.1 256 488zM488 528C510.1 528 528 510.1 528 488C528 465.9 510.1 448 488 448C465.9 448 448 465.9 448 488C448 510.1 465.9 528 488 528z" /></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight relative z-10">{{ number_format($count_kendaraan ?? 0) }}</h3>
                <p class="text-slate-400 text-[10px] mt-1 font-bold tracking-wide flex items-center gap-1.5">
                    <span class="w-1 h-1 bg-emerald-400 rounded-full"></span> Tipe Kendaraan
                </p>
                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-500 transition-all duration-500 group-hover:w-full"></div>
            </div>

            {{-- Card 5: Aktivitas --}}
            <div class="group bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-amber-50/50 rounded-bl-[3rem] -mr-8 -mt-8 transition-all group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.15em]">Aktivitas</p>
                        <p class="text-[8px] text-red-500 font-black uppercase tracking-widest mt-0.5 flex items-center gap-1">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-red-500"></span>
                            </span>
                            Real Time
                        </p>
                    </div>
                    <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl shadow-sm ring-1 ring-amber-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight relative z-10">{{ number_format($count_logs ?? 0) }}</h3>
                <p class="text-slate-400 text-[10px] mt-1 font-bold tracking-wide flex items-center gap-1.5">
                    <span class="w-1 h-1 bg-amber-400 rounded-full"></span> System Logs
                </p>
                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-amber-400 to-orange-400 transition-all duration-500 group-hover:w-full"></div>
            </div>
        </div>

        {{-- Monitoring Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
            
            {{-- Monitoring 1: Grafik --}}
            <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div>
                        <h4 class="text-xl font-bold text-slate-800 tracking-tight">Analisis Trafik & Aktivitas</h4>
                        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-widest mt-1">Perbandingan Real-time Hari Ini</p>
                    </div>
                    <div class="flex gap-2">
                         <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-bold uppercase">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Kendaraan
                         </div>
                         <div class="flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-bold uppercase">
                            <span class="w-2 h-2 bg-amber-500 rounded-full"></span> Log User
                         </div>
                    </div>
                </div>
                
                <div class="relative h-[400px] w-full">
                    <canvas id="combinedChart"></canvas>
                </div>
            </div>

            {{-- Monitoring 2: Tabel Log Aktivitas Terbaru --}}
            <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm flex flex-col h-full">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-xl font-bold text-slate-800 tracking-tight">Log Terkini</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Real-time Stream</p>
                    </div>
                    
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-red-50 border border-red-100 rounded-xl">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-red-600 uppercase tracking-tighter">L I V E</span>
                    </div>
                </div>

                <div class="space-y-6 flex-grow">
                    @forelse($recent_logs as $log)
                    <div class="relative pl-6 border-l-2 border-slate-100 pb-1 group transition-all">
                        {{-- Dot Timeline - Diubah ke Blue --}}
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white border-4 border-blue-600 group-hover:border-red-500 transition-colors duration-300"></div>
                        
                        <p class="text-[13px] font-bold text-slate-700 leading-tight group-hover:text-slate-900">{{ $log->aktivitas }}</p>
                        
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                {{-- Text Nama - Diubah ke Blue --}}
                                <span class="text-[11px] text-blue-600 font-bold uppercase tracking-tight">{{ $log->nama }}</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-medium italic">{{ \Carbon\Carbon::parse($log->waktu)->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-12 opacity-40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs font-bold uppercase tracking-widest">No Activity Today</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-8 pt-6 border-t border-slate-50">
                    {{-- Button Lihat Semua - Warna Slate ke Blue --}}
                    <a href="{{ route('admin.logs.index') }}" class="group flex items-center justify-center gap-3 w-full py-2 bg-slate-900 hover:bg-blue-600 rounded-2xl transition-all duration-300 shadow-lg shadow-slate-200 hover:shadow-blue-200">
                        <span class="text-[11px] font-black text-white uppercase tracking-[0.2em] ml-2">Lihat Semua Log</span>
                        <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/admin/dashboard.js'])
@endpush