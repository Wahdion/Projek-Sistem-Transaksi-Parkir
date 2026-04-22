<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Petugas') | ParkirYon</title>

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
            background-color: #f8fafc;
        }

        /* Sidebar Hijau Emerald Gradasi */
        .sidebar-emerald {
            background: linear-gradient(180deg, #059669 0%, #064e3b 100%);
        }

        .nav-transition {
            transition: all 0.3s ease;
        }

        /* Indikator Menu Aktif - Glassmorphism Hijau */
        .nav-active {
            background: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(10px);
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            
            /* Garis aksen putih di kanan */
            border-right: 6px solid #ffffff; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Hover effect */
        .nav-hover:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(6px);
        }

        /* Custom Scrollbar untuk Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            display: none;
        }
        .sidebar-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* State Sidebar Tertutup */
        .sidebar-closed {
            width: 0 !important;
            min-width: 0 !important;
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body class="antialiased text-slate-600">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside id="main-sidebar" class="w-64 sidebar-emerald flex flex-col flex-shrink-0 shadow-2xl z-20 transition-all duration-300 ease-in-out">
            {{-- Logo --}}
            <div class="pt-10 pb-8 flex items-center justify-center w-full overflow-hidden">
                <span class="text-2xl font-black tracking-[0.2em] text-white uppercase drop-shadow-lg whitespace-nowrap">
                    Yon<span class="text-emerald-300">Parkir</span>
                </span>
            </div>

            {{-- Navigasi --}}
            <nav class="flex-1 px-4 py-4 space-y-3 overflow-y-auto sidebar-scroll">
                <p class="px-5 text-[10px] font-black text-emerald-100 uppercase tracking-[0.25em] mb-4 opacity-70 whitespace-nowrap">
                    Petugas Menu
                </p>

                {{-- Menu Dashboard --}}
                <a href="{{ route('petugas.dashboard') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('petugas/dashboard') ? 'nav-active' : 'text-white' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('petugas/dashboard') ? 'text-white' : 'text-emerald-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="font-bold text-sm tracking-wide whitespace-nowrap">Dashboard</span>
                </a>

                {{-- Menu Transaksi --}}
                <a href="{{ route('petugas.transaksi.index') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('petugas/transaksi*') ? 'nav-active' : 'text-white' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('petugas/transaksi*') ? 'text-white' : 'text-emerald-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold text-sm tracking-wide whitespace-nowrap">Transaksi Parkir</span>
                </a>
            </nav>

            {{-- Logout Button --}}
            <div class="p-6 border-t border-white/10">
                <a href="{{ url('/logout') }}" 
                   class="flex items-center justify-center gap-3 px-4 py-3.5 rounded-2xl bg-red-500 text-white hover:bg-red-600 transition-all duration-300 font-black shadow-lg shadow-red-900/20 group">
                    <i class="fas fa-sign-out-alt text-lg transform group-hover:-translate-x-1 transition-transform"></i>
                    <span class="text-[11px] uppercase tracking-[0.2em] whitespace-nowrap">Logout</span>
                </a>
            </div>
        </aside>

        {{-- Main Content Area --}}
        <main class="flex-1 flex flex-col min-w-0 bg-slate-50 transition-all duration-300">
            {{-- Header --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0">
                
                {{-- AREA: Tombol Hamburger + Breadcrumbs --}}
                <div class="flex items-center gap-4">
                    <button id="btn-toggle" class="-ml-4 p-2 rounded-lg bg-slate-50 border border-slate-200 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-all">
                        <i class="fas fa-bars text-lg"></i>
                    </button>

                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-circle text-emerald-600 text-lg"></i>
                        <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">
                            {{ Request::segment(1) }}
                        </span>
                        <span class="text-slate-300 text-xs">/</span>
                        <span class="text-xs font-bold text-black uppercase tracking-widest">
                            {{ str_replace('-', ' ', Request::segment(2) ?? 'Dashboard') }}
                        </span>
                    </div>
                </div>

                {{-- User Profile --}}
                <div class="flex items-center gap-4 pl-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-extrabold text-slate-800 mb-1.5 leading-none">
                            {{ session('nama') ?? 'User' }}
                        </p>
                        <div class="flex items-center justify-end gap-1.5">
                            <span class="text-[10px] font-bold text-slate-500 tracking-wider">Sebagai :</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-tighter shadow-sm">
                                {{ session('role') ?? 'Guest' }}
                            </span>
                        </div>
                    </div>
                    <div class="relative group cursor-pointer">
                        <div class="w-11 h-11 rounded-3xl bg-gradient-to-tr from-emerald-600 to-teal-500 p-[2px] shadow-lg shadow-emerald-500/20 transform transition-transform group-hover:rotate-6">
                              <div class="w-full h-full  bg-gradient-to-tr from-emerald-600 to-teal-500 rounded-3xl flex items-center justify-center border-2 border-white overflow-hidden text-white">
            @php
                $inisial = strtoupper(substr(session('nama') ?? 'A', 0, 1));
            @endphp
            {{-- Warna diubah menjadi text-white dan menghapus bg-clip-text --}}
            <span class="text-white font-black text-lg">
                {{ $inisial }}
            </span>
        </div>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                    </div>
                </div>
            </header>

            {{-- Main Scrollable Content --}}
            <div class="flex-1 overflow-y-auto p-6 lg:p-10 bg-[#f8fafc]">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('main-sidebar');
            const btnToggle = document.getElementById('btn-toggle');
            
            btnToggle.addEventListener('click', function() {
                sidebar.classList.toggle('sidebar-closed');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>