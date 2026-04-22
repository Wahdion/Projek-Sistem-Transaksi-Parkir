<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Owner') | ParkirYon</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-YonParkir.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo-YonParkir.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
        }

        .sidebar-owner {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            border-right: 1px solid rgba(234, 179, 8, 0.1);
        }

        .nav-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Indikator Menu Aktif - Glassmorphism Gold */
        .nav-active {
            background: rgba(234, 179, 8, 0.15) !important; 
            backdrop-filter: blur(10px);
            color: #eab308 !important;
            border: 1px solid rgba(234, 179, 8, 0.3) !important;
            border-right: 6px solid #eab308 !important; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .nav-hover:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(6px);
            color: #fde047;
        }

        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(234, 179, 8, 0.2);
            border-radius: 10px;
        }

        .sidebar-closed {
            width: 0 !important;
            min-width: 0 !important;
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body class="antialiased text-slate-400">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside id="sidebar" class="w-64 sidebar-owner flex flex-col flex-shrink-0 shadow-2xl z-20 transition-all duration-300">
            {{-- Logo --}}
            <div class="pt-10 pb-8 flex items-center justify-center w-full overflow-hidden">
                <span class="text-2xl font-black tracking-[0.2em] text-white uppercase drop-shadow-lg whitespace-nowrap">
                    Yon<span class="text-yellow-500">Parkir</span>
                </span>
            </div>

            {{-- Navigasi --}}
            <nav class="flex-1 px-4 py-4 space-y-3 overflow-y-auto sidebar-scroll">
                <p class="px-5 text-[10px] font-black text-yellow-500/60 uppercase tracking-[0.25em] mb-4 whitespace-nowrap">
                    Owner Reports
                </p>

                {{-- Menu Dashboard --}}
                <a href="{{ route('owner.dashboard') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('owner/dashboard*') ? 'nav-active' : 'text-slate-300' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('owner/dashboard*') ? 'text-yellow-500' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="font-bold text-sm tracking-wide whitespace-nowrap">Dashboard</span>
                </a>

                {{-- Menu Rekapan Petugas --}}
                <a href="{{ route('owner.petugas.index') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('owner/petugas*') ? 'nav-active' : 'text-slate-300' }}">
                    <i class="fas fa-user-shield text-xl w-6 flex-shrink-0 {{ request()->is('owner/petugas*') ? 'text-yellow-500' : 'text-slate-500' }}"></i>
                    <span class="font-bold text-sm tracking-wide whitespace-nowrap">Pegawai / Petugas</span>
                </a>

                {{-- Menu Rekap Laporan --}}
                <a href="{{ route('owner.laporan.index') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('owner/laporan*') ? 'nav-active' : 'text-slate-300' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('owner/laporan*') ? 'text-yellow-500' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-bold text-sm tracking-wide whitespace-nowrap">Rekap Laporan</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/10">
                <a href="{{ url('/logout') }}" 
                   class="flex items-center justify-center gap-3 px-4 py-3.5 rounded-2xl bg-red-500 text-white hover:bg-red-600 transition-all duration-300 font-black shadow-lg shadow-red-900/20 group">
                    <i class="fas fa-sign-out-alt text-lg transform group-hover:-translate-x-1 transition-transform"></i>
                    <span class="text-[11px] uppercase tracking-[0.2em] whitespace-nowrap">Logout</span>
                </a>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 flex flex-col min-w-0 bg-slate-950 transition-all duration-300">
            <header class="h-16 bg-slate-900 border-b border-white/5 flex items-center justify-between px-8 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button id="hamburger" class="p-2.5 rounded-xl bg-slate-800 border border-white/5 text-yellow-500 hover:bg-yellow-500 hover:text-slate-900 transition-all shadow-lg">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chart-line text-yellow-500 text-sm"></i>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black text-yellow-500 uppercase tracking-widest">{{ Request::segment(1) }}</span>
                            <span class="text-slate-600 text-xs">/</span>
                            <span class="text-xs font-bold text-white uppercase tracking-widest">{{ str_replace('-', ' ', Request::segment(2) ?? 'Dashboard') }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 pl-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-extrabold text-white mb-1 leading-none">{{ session('nama') ?? 'Owner' }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 uppercase tracking-tighter">
                            {{ session('role') ?? 'Owner' }}
                        </span>
                    </div>
                    <div class="relative group cursor-pointer">
                        <div class="w-11 h-11 rounded-3xl bg-gradient-to-tr from-yellow-600 to-amber-400 p-[2px] shadow-lg shadow-yellow-500/20 transform transition-transform group-hover:rotate-6">
                            <div class="w-full h-full bg-gradient-to-tr from-yellow-600 to-amber-500 rounded-3xl flex items-center justify-center border-2 border-white overflow-hidden text-white">
                                @php $inisial = strtoupper(substr(session('nama') ?? 'A', 0, 1)); @endphp
                                <span class="text-white font-black text-lg">{{ $inisial }}</span>
                            </div>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-slate-900 rounded-full"></div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-6 lg:p-10 bg-slate-950">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const hamburger = document.getElementById('hamburger');
            hamburger.addEventListener('click', () => sidebar.classList.toggle('sidebar-closed'));
        });
    </script>
    @stack('scripts')
</body>
</html>