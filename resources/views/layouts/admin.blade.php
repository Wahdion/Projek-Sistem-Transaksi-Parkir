<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | ParkirYon</title>

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

        .sidebar-admin {
            background-color: #2563eb;
        }

        .nav-transition {
            transition: all 0.3s ease;
        }

        .nav-active {
            background: rgba(255, 255, 255, 0.2); 
            backdrop-filter: blur(12px);
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-right: 6px solid #ffffff; 
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-hover:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(8px);
        }

        #admin-sidebar::-webkit-scrollbar {
            display: none;
        }
        #admin-sidebar {
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

        /* Rotasi Ikon Toggle (jika masih diperlukan) */
        .sidebar-closed #toggle-icon {
            transform: rotate(180deg);
        }

        #vehicleEntryChart {
            filter: drop-shadow(0px 10px 15px rgba(37, 99, 235, 0.2));
        }
    </style>
</head>

<body class="antialiased text-slate-600">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside id="main-sidebar" class="relative w-64 sidebar-admin flex flex-col flex-shrink-0 shadow-2xl z-20 transition-all duration-300 ease-in-out">
            
            <div class="pt-10 pb-6 flex items-center justify-center w-full overflow-hidden">
                <span class="text-2xl font-black tracking-[0.2em] text-white uppercase drop-shadow-md whitespace-nowrap">
                    Yon Parkir</span>
                </span>
            </div>

            <nav id="admin-sidebar" class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">
                <p class="px-4 text-[10px] font-black text-blue-100 uppercase tracking-[0.25em] mb-4 opacity-70 whitespace-nowrap">
                    Admin Management
                </p>

                <a href="{{ url('/admin/dashboard') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('admin/dashboard') ? 'nav-active' : 'text-white' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('admin/dashboard') ? 'text-white' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="font-extrabold text-sm tracking-wide whitespace-nowrap">Dashboard</span>
                </a>

                <a href="{{ url('/admin/user') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('admin/user*') ? 'nav-active' : 'text-white' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('admin/user*') ? 'text-white' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-extrabold text-sm tracking-wide whitespace-nowrap">Kelola User</span>
                </a>

                <a href="{{ url('/admin/tarif') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('admin/tarif*') ? 'nav-active' : 'text-white' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('admin/tarif*') ? 'text-white' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-extrabold text-sm tracking-wide whitespace-nowrap">Tarif Parkir</span>
                </a>

                <a href="{{ url('/admin/area') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('admin/area*') ? 'nav-active' : 'text-white' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('admin/area*') ? 'text-white' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span class="font-extrabold text-sm tracking-wide whitespace-nowrap">Area Parkir</span>
                </a>
                
                {{-- Menu Kendaraan Terdaftar --}}
                <a href="{{ url('/admin/kendaraan') }}" 
                    class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('admin/kendaraan*') ? 'nav-active' : 'text-white' }}">
                    <i class="fas fa-car-side text-xl w-6 flex-shrink-0 {{ request()->is('admin/kendaraan*') ? 'text-white' : 'text-blue-200' }}"></i>
                    <span class="font-extrabold text-sm tracking-wide whitespace-nowrap">Kendaraan Terdaftar</span>
                </a>

                <a href="{{ url('/admin/logs') }}" 
                   class="nav-transition nav-hover flex items-center gap-3 px-5 py-4 rounded-2xl {{ request()->is('admin/logs*') ? 'nav-active' : 'text-white' }}">
                    <svg class="w-6 h-6 flex-shrink-0 {{ request()->is('admin/logs*') ? 'text-white' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-extrabold text-sm tracking-wide whitespace-nowrap">Log Aktivitas</span>
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
        <main class="flex-1 flex flex-col min-w-0 bg-slate-50 transition-all duration-300">
          <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0">
    
    {{-- AREA: Tombol Hamburger + Breadcrumb --}}
    <div class="flex items-center gap-4">
        <button id="btn-toggle" class="-ml-4 p-2 rounded-lg bg-slate-50 border border-slate-200 text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all">
            <i class="fas fa-bars text-lg"></i>
        </button>
        
        <div class="flex items-center gap-2">
            <i class="fas fa-user-circle text-blue-600 text-lg"></i>
            <span class="text-xs font-black text-blue-600 uppercase tracking-widest">ADMIN</span>
            <span class="text-slate-300 text-xs">/</span>
            <span class="text-xs font-bold text-black uppercase tracking-widest">
                {{ str_replace('-', ' ', Request::segment(2) ?? 'Dashboard') }}
            </span>
        </div>
    </div>

    {{-- Bagian kanan header tetap (Nama User & Avatar) --}}
    <div class="flex items-center gap-4 pl-4">
        <div class="text-right hidden sm:block">
            <p class="text-sm font-extrabold text-slate-800 mb-1.5 leading-none">
                {{ session('nama') ?? 'User' }}
            </p>
            <div class="flex items-center justify-end gap-1.5">
                <span class="text-[10px] font-bold text-slate-500 tracking-wider">Sebagai :</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-blue-600 border border-emerald-100 uppercase tracking-tighter shadow-sm">
                    {{ session('role') ?? 'Guest' }}
                </span>
            </div>
        </div>
     <div class="relative group cursor-pointer">
    <div class="w-11 h-11 rounded-3xl bg-gradient-to-tr from-blue-600 to-blue-500 p-[2px] shadow-lg shadow-emerald-500/20 transform transition-transform group-hover:rotate-6">
        <div class="w-full h-full bg-gradient-to-tr from-blue-600 to-blue-500 rounded-3xl flex items-center justify-center border-2 border-white overflow-hidden text-white">
            @php
                $inisial = strtoupper(substr(session('nama') ?? 'A', 0, 1));
            @endphp
            {{-- Warna diubah menjadi text-white dan menghapus bg-clip-text --}}
            <span class="text-white font-black text-lg">
                {{ $inisial }}
            </span>
        </div>
    </div>
    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
</div>
    </div>
</header>

            <div class="flex-1 overflow-y-auto p-6 lg:p-8 pl-10">
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