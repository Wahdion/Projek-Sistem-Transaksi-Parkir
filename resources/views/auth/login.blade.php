<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | YonParkir</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-YonParkir.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo-YonParkir.png') }}">

    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-50">

<main class="min-h-screen flex items-center justify-center p-6 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-blue-700">

    <section class="relative bg-white/95 backdrop-blur-sm w-full max-w-[25rem] rounded-[2rem] shadow-2xl overflow-hidden border border-white/20">

        <div class="p-8">
            <header class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center mb-4">
                    <img 
                        src="{{ asset('assets/images/logo-YonParkir.png') }}" 
                        alt="Logo YonParkir" 
                        class="h-24 w-auto object-contain drop-shadow-md"
                    >
                </div>
                <p class="text-slate-500 text-xs mt-2 font-medium">
                    Silakan login untuk masuk ke dashboard 
                </p>
            </header>

            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-xl bg-red-50 border border-red-100 text-red-600 text-xs animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 ml-1">
                        Username
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Masukan Username"
                            required
                            class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-1 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition-all duration-200 shadow-sm"
                        >
                    </div>
                </div>

              <div>
    <div class="flex justify-between mb-1.5 ml-1">
        <label for="password" class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">
            Password
        </label>
    </div>
    <div class="relative">
        {{-- Ikon Gembok (Kiri) --}}
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </span>

        {{-- Input Password --}}
        <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            required
            class="block w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-1 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition-all duration-200 shadow-sm"
        >

        {{-- Tombol Mata (Kanan) --}}
        <button 
            type="button" 
            onclick="togglePassword()"
            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-600 transition-colors focus:outline-none"
        >
            <i id="eyeIcon" class="fas fa-eye text-sm"></i>
        </button>
    </div>
</div>

                <div class="pt-2 flex flex-col sm:flex-row gap-3">
                    <button
                        type="submit"
                        class="flex-1 py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-blue-500/25"
                    >
                        Login
                    </button>
                    <a
                        href="/"
                        class="flex-1 py-3 px-4 border border-gray-300 text-center text-sm font-bold rounded-xl text-gray-600 bg-gray-300 hover:bg-gray-300 focus:outline-none transition-all duration-300 transform hover:-translate-y-1"
                    >
                        Batal
                    </a>
                </div>
            </form>
            
            <footer class="pt-6 border-t border-gray-100 text-center">
                <p class="text-[10px] text-gray-400 font-semibold tracking-widest uppercase">
                    &copy; 2026 YonParkir System
                </p>
                <p class="text-[9px] text-gray-400 mt-1">
                    Developed by <span class="text-blue-400">@wahdion</span>
                </p>
            </footer>
        </div>
    </section>
</main>

</body>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            // Ubah ke text (lihat password)
            passwordInput.type = 'text';
            // Ganti ikon ke mata tertutup
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            // Ubah kembali ke password
            passwordInput.type = 'password';
            // Ganti ikon ke mata terbuka
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
</html>