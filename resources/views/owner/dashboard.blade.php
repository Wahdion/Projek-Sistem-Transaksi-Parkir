@extends('layouts.owner')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Banner: Gold/Dark Theme --}}
    <div class="bg-gradient-to-r from-yellow-700 via-amber-600 to-yellow-800 p-10 rounded-l-[4rem] text-white relative overflow-hidden -mr-8 mb-10 shadow-2xl shadow-yellow-900/20 border-l border-b border-white/10">
        
        {{-- Dekorasi Ikon di Background --}}
        <i class="fas fa-crown absolute right-8 text-[200px] opacity-10 transform rotate-12 pointer-events-none"></i>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-black mt-6 tracking-tight leading-tight">
                Haloo Boss!!,
                <span class="text-yellow-200">{{ session('nama') }}!</span>
            </h1>
            <p class="text-white/80 mt-2 text-sm font-medium max-w-lg leading-relaxed">
                Pantau performa pendapatan dan statistik transaksi parkir secara <span class="font-bold text-yellow-300 italic underline decoration-yellow-400">real-time</span> untuk memaksimalkan profit YonParkir.
            </p>
            
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('owner.laporan.index') }}" 
                class="bg-slate-900 text-yellow-500 px-6 py-3.5 rounded-2xl font-black hover:bg-black transition-all shadow-xl flex items-center gap-3 active:scale-95 border border-yellow-600/30">
                    <i class="fas fa-file-invoice-dollar text-lg"></i> Lihat Rekapan Laporan
                </a>
            </div>
        </div>
    </div>
    
    {{-- Section Title --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight">Ringkasan <span class="text-yellow-500 italic">Bisnis</span></h2>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.3em] mt-1">Data Performa: {{ date('d F Y') }}</p>
        </div>
        <div class="h-[1px] flex-grow bg-white/5 mx-8 hidden md:block mb-3"></div>
        <div class="flex items-center gap-3 bg-slate-900 px-4 py-2 rounded-xl border border-white/5 shadow-inner">
            <i class="fas fa-calendar-day text-yellow-500"></i>
            <span class="text-xs font-black text-slate-300 uppercase tracking-widest">{{ date('l') }}</span>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 items-start">
        
        {{-- Card Pendapatan: Fokus Emas --}}
        <div class="relative bg-slate-900 p-8 rounded-[3rem] border border-white/5 shadow-2xl hover:shadow-yellow-500/10 transition-all group overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 text-slate-950 rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-yellow-500/20 group-hover:rotate-6 transition-transform">
                        <i class="fas fa-wallet font-black"></i>
                    </div>
                    <div class="text-right">
                        <span class="block text-[9px] font-black text-yellow-500 bg-yellow-500/10 px-3 py-1 rounded-full uppercase tracking-widest border border-yellow-500/20">Live: {{ date('d M') }}</span>
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Total Pendapatan</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-lg font-black text-yellow-500">Rp</span>
                    <h3 class="text-4xl font-black text-white tracking-tighter">{{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                </div>
                <p class="mt-4 text-[9px] font-bold text-slate-600 italic">*Akumulasi biaya parkir hari ini</p>
            </div>
        </div>

        {{-- Card Kendaraan Aktif: Fokus Slate/Amber --}}
        <div class="relative bg-slate-900 p-8 rounded-[3rem] border border-white/5 shadow-2xl hover:shadow-amber-500/10 transition-all group overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-8">
                    <div class="w-16 h-16 bg-slate-800 text-amber-500 border border-amber-500/30 rounded-2xl flex items-center justify-center text-2xl shadow-lg group-hover:-rotate-6 transition-transform">
                         <i class="fas fa-car"></i>
                    </div>
                    <div class="text-right">
                        <span class="block text-[9px] font-black text-amber-500 bg-amber-500/10 px-3 py-1 rounded-full uppercase tracking-widest border border-amber-500/20">Jam: {{ date('H:i') }}</span>
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Kendaraan Ter-parkir</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-black text-white tracking-tighter">{{ $parkirAktif }}</h3>
                    <span class="text-sm font-black text-amber-500/60 uppercase tracking-widest">Unit</span>
                </div>
                <p class="mt-4 text-[9px] font-bold text-slate-600 italic">*Kendaraan aktif di lokasi</p>
            </div>
        </div>

        {{-- Card Okupansi: Fokus Progress Bar Gold --}}
        <div class="relative bg-slate-900 p-8 rounded-[3rem] border border-white/5 shadow-2xl transition-all group overflow-hidden">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-8">
                    <div class="w-16 h-16 bg-gradient-to-tr from-slate-800 to-slate-700 text-yellow-500 rounded-2xl flex items-center justify-center text-2xl border border-white/5 shadow-xl">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 bg-white/5 text-slate-400 text-[9px] font-black rounded-full uppercase border border-white/10 tracking-widest">
                            {{ $listArea->count() }} Lokasi
                        </span>
                    </div>
                </div>

                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Okupansi Keseluruhan</p>
                <div class="flex items-center gap-4 mb-6">
                    <h3 class="text-4xl font-black text-white tracking-tighter">{{ $persentaseOkupansi }}%</h3>
                    <div class="flex-grow bg-slate-800 h-3 rounded-full overflow-hidden border border-white/5 shadow-inner">
                        <div class="bg-gradient-to-r from-yellow-600 via-amber-500 to-yellow-400 h-full rounded-full transition-all duration-1000 ease-out shadow-[0_0_15px_rgba(234,179,8,0.3)]" style="width: {{ $persentaseOkupansi }}%"></div>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/5 space-y-4">
                    @foreach($listArea as $area)
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wide">{{ $area->nama_area }}</span>
                            <span class="text-[10px] font-black text-white">{{ $area->terisi }}/{{ $area->kapasitas }} <span class="text-slate-500">Unit</span></span>
                        </div>
                        <div class="w-full bg-slate-800 h-1 rounded-full overflow-hidden">
                            @php 
                                $percent = ($area->kapasitas > 0) ? ($area->terisi / $area->kapasitas) * 100 : 0;
                                $color = $percent >= 90 ? 'bg-red-500' : ($percent >= 70 ? 'bg-yellow-500' : 'bg-emerald-500');
                            @endphp
                            <div class="{{ $color }} h-full transition-all duration-700 shadow-sm" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Section: Pendapatan --}}
    <div class="bg-slate-900 rounded-[3rem] p-10 border border-white/5 shadow-2xl mb-12">
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-500/10 rounded-2xl flex items-center justify-center border border-yellow-500/20 text-yellow-500">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight">Trafik <span class="text-yellow-500">Pendapatan</span></h2>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mt-1">Analisis Revenue (7 Hari Terakhir)</p>
                </div>
            </div>
        </div>

        <div class="relative h-[300px] w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Chart Section: Trafik Kendaraan --}}
    <div class="bg-slate-900 rounded-[3rem] p-10 border border-white/5 shadow-2xl mb-12">
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center border border-amber-500/20 text-amber-500">
                    <i class="fas fa-truck-moving text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight">Volume <span class="text-amber-500">Transaksi</span></h2>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mt-1">Perbandingan Jenis Kendaraan</p>
                </div>
            </div>
        </div>

        <div class="relative h-[350px] w-full">
            <canvas id="vehicleChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labelHari = @json($labelGrafik);
        Chart.defaults.color = '#64748b'; // Slate 500
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

        // 1. GRAFIK PENDAPATAN
        const revenueCanvas = document.getElementById('revenueChart');
        if (revenueCanvas) {
            const ctxRev = revenueCanvas.getContext('2d');
            const dataPendapatan = @json($grafikPendapatan);

            const revGradient = ctxRev.createLinearGradient(0, 0, 0, 300);
            revGradient.addColorStop(0, 'rgba(234, 179, 8, 0.25)');
            revGradient.addColorStop(1, 'rgba(234, 179, 8, 0)');

            new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: labelHari,
                    datasets: [{
                        label: 'Pendapatan',
                        data: dataPendapatan,
                        borderColor: '#eab308', // Gold
                        borderWidth: 4,
                        backgroundColor: revGradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0f172a',
                        pointBorderColor: '#eab308',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { size: 14, weight: '800' },
                            padding: 15,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: { color: 'rgba(255, 255, 255, 0.03)' },
                            ticks: { font: { weight: '700' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: '700' } }
                        }
                    }
                }
            });
        }

        // 2. GRAFIK KENDARAAN (Stacked Bar Gold/Amber)
        const vehicleCanvas = document.getElementById('vehicleChart');
        if (vehicleCanvas) {
            const ctxVeh = vehicleCanvas.getContext('2d');
            const colors = [
                { back: '#eab308', border: '#eab308' }, // Yellow/Gold
                { back: '#f59e0b', border: '#f59e0b' }, // Amber
                { back: '#94a3b8', border: '#94a3b8' }, // Slate
                { back: '#ffffff', border: '#ffffff' }  // White
            ];

            const rawData = @json($datasetKendaraan);
            const datasets = Object.keys(rawData).map((jenis, index) => {
                const color = colors[index % colors.length];
                return {
                    label: jenis,
                    data: rawData[jenis],
                    backgroundColor: color.back,
                    borderRadius: 6,
                    barPercentage: 0.6
                };
            });

            new Chart(ctxVeh, {
                type: 'bar',
                data: { labels: labelHari, datasets: datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#f8fafc',
                                font: { size: 11, weight: '800' },
                                usePointStyle: true,
                                padding: 25
                            }
                        }
                    },
                    scales: {
                        y: { 
                            stacked: false,
                            grid: { color: 'rgba(255, 255, 255, 0.03)' },
                            ticks: { stepSize: 1, font: { weight: '700' } }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { weight: '700' } }
                        }
                    }
                }
            });
        }
    });
</script>

@push('scripts')
    @vite(['resources/js/petugas/index.js'])
@endpush
@endsection