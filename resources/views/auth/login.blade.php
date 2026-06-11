<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - E-Proposal Alsintan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Lambang_Kabupaten_Muaro_Jambi.png') }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js (for password toggle) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans text-gray-800 antialiased bg-white">

    <div class="min-h-screen flex">
        
        {{-- LEFT COLUMN: Branding / Hero --}}
        <div class="hidden lg:flex lg:w-1/2 relative flex-col justify-between overflow-hidden opacity-0 animate-fade-in">
            {{-- Background Image & Overlay --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ \App\Models\Setting::get('homepage_background') ? asset('storage/' . \App\Models\Setting::get('homepage_background')) : asset('images/img_dtph.png') }}" class="w-full h-full object-cover" alt="Branding Background">
                <div class="absolute inset-0 bg-black/70"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-primary-950/90 via-primary-900/40 to-emerald-950/80"></div>
            </div>

            {{-- Background decorative shapes --}}
            <div class="absolute inset-0 pointer-events-none z-10">
                <div class="absolute top-[30%] -left-[10%] w-[50%] h-[50%] rounded-full bg-white/5 blur-3xl"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[60%] h-[60%] rounded-full bg-emerald-500/10 blur-3xl"></div>
            </div>

            <div class="relative z-20 p-8 lg:px-12 pt-12">
                <a href="{{ route('home') }}">
                    <x-application-logo class="w-12 h-12 object-contain" textColor="text-white" />
                </a>
            </div>
            
            {{-- Center Content (Persuasive Text) --}}
            <div class="relative z-20 flex-1 flex flex-col items-center justify-center p-8 lg:px-16 text-center">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-6 leading-tight opacity-0 animate-fade-in-up delay-100">
                    Membangun <br/> <span class="text-emerald-400">Ketahanan Pangan</span> <br/> Bersama
                </h1>
                <p class="text-gray-200 text-lg max-w-md mx-auto leading-relaxed font-medium opacity-0 animate-fade-in-up delay-200">
                    Modernisasi pertanian Muaro Jambi melalui akses alsintan dan layanan program bantuan yang lebih mudah, transparan, serta terintegrasi untuk kesejahteraan petani.
                </p>

                {{-- Trust Badges / Stats --}}
                <div class="mt-12 grid grid-cols-3 gap-8 w-full max-w-lg border-t border-white/10 pt-10">
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">150+</p>
                        <p class="mt-1 text-xs font-bold text-emerald-400 uppercase tracking-wider">Unit Alat</p>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">2.4k</p>
                        <p class="mt-1 text-xs font-bold text-emerald-400 uppercase tracking-wider">Petani</p>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">24h</p>
                        <p class="mt-1 text-xs font-bold text-emerald-400 uppercase tracking-wider">Akses</p>
                    </div>
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="relative z-20 p-8 lg:px-16 pb-12 text-center text-white/50 text-xs">
                &copy; 2026 Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi
            </div>
        </div>

        {{-- RIGHT COLUMN: Form Area --}}
        <div class="w-full lg:w-1/2 relative">
            {{-- Mobile: Fixed Background (doesn't scroll) --}}
            <div class="lg:hidden fixed top-0 left-0 right-0 h-64 sm:h-72 z-0 bg-primary-900 opacity-0 animate-fade-in">
                <img src="{{ \App\Models\Setting::get('homepage_background') ? asset('storage/' . \App\Models\Setting::get('homepage_background')) : asset('images/img_dtph.png') }}" class="w-full h-full object-cover opacity-60" alt="Hero">
                <div class="absolute inset-0 bg-gradient-to-b from-black/65 via-primary-900/50 to-primary-900"></div>

                {{-- Content: Logo kiri + Teks rata kiri (rata atas) --}}
                <div class="absolute inset-0 px-8 pt-10 flex flex-col justify-start">
                    <div class="flex items-center gap-4 mb-6">
                        <x-application-logo class="w-14 h-14 object-contain drop-shadow-2xl flex-shrink-0" textColor="text-white" />
                    </div>
                    <div class="text-left sm:text-center ">
                        <h2 class="text-white font-black text-2xl sm:text-4xl leading-tight drop-shadow-lg opacity-0 animate-fade-in-up delay-200">Selamat Datang</h2>
                        <p class="text-emerald-300 text-xs sm:text-lg font-bold mt-0.5 opacity-0 animate-fade-in-up delay-300">Layanan Bantuan dan Peminjaman Alsintan DTPH</p>
                    </div>
                </div>


            </div>

            {{-- Scrollable Form Area --}}
            <div class="lg:flex lg:items-center lg:justify-center lg:h-screen">
                <div class="w-full  max-w-2xl mx-auto lg:h-screen lg:overflow-y-auto custom-scrollbar
                            mt-[calc(16rem-2.5rem)] sm:mt-[calc(18rem-2.5rem)] lg:mt-0
                            relative z-10 bg-gray-50 lg:bg-white rounded-t-[2.5rem] lg:rounded-none
                            min-h-[calc(100vh-16rem)] sm:min-h-[calc(100vh-18rem)] lg:min-h-0">
                    <div class="p-6 sm:p-10 lg:p-16">

                        {{-- Header (Desktop only) --}}
                        <div class="hidden lg:block mb-10 text-left">
                            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 mb-2">
                                Selamat Datang <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-primary-800">Kembali</span>
                            </h2>
                            <p class="text-gray-500 text-sm leading-relaxed">Masuk untuk mengakses layanan e-proposal bantuan dan alsintan dengan aman dan mudah.</p>
                        </div>

                        @if (session('status'))
                            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in-down">
                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="font-bold text-sm">{{ session('status') }}</span>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-800 mb-2">Email</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all sm:text-sm bg-white"
                                        placeholder="Masukkan Email yang terdaftar">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div x-data="{ showPassword: false }">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="password" class="block text-sm font-bold text-gray-800">Kata Sandi</label>
                                    @if (Route::has('password.request'))
                                        <a tabindex="-1" href="{{ route('password.request') }}" class="text-xs font-semibold text-green-600 hover:text-green-700 hover:underline">
                                            Lupa kata sandi?
                                        </a>
                                    @endif
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required
                                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all sm:text-sm bg-white"
                                        placeholder="Kata sandi Anda">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-600">Ingat saya di perangkat ini</label>
                            </div>

                            <!-- Login Button -->
                            <div>
                                <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#19A148] hover:bg-[#158C3D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Masuk Sekarang
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="relative py-1">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                                <div class="relative flex justify-center text-xs">
                                    <span class="bg-gray-50 lg:bg-white px-3 text-gray-400 font-medium">Belum punya akun?</span>
                                </div>
                            </div>

                            <!-- Register Button -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <a href="{{ route('register', ['role' => 'petani']) }}" class="w-full flex justify-center items-center py-3.5 px-2 border border-gray-300 rounded-xl shadow-sm text-xs sm:text-[13px] font-bold text-[#19A148] bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all active:scale-[0.98]">
                                    Kelompok Tani
                                </a>
                                <a href="{{ route('register', ['role' => 'umum']) }}" class="w-full flex justify-center items-center py-3.5 px-2 border border-gray-300 rounded-xl shadow-sm text-xs sm:text-[13px] font-bold text-[#19A148] bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all active:scale-[0.98]">
                                    Umum
                                </a>
                            </div>

                        </form>

                        {{-- Footer --}}
                        <div class="py-6 text-center mt-4">
                            <p class="text-xs text-gray-400 leading-relaxed">
                                &copy; 2026 Dinas Tanaman Pangan dan Hortikultura.<br/>
                                Semua hak dilindungi.
                            </p>
                        </div>
                    </div>{{-- /.p-6 --}}
                </div>{{-- /.scrollable inner --}}
            </div>{{-- /.scrollable wrapper --}}
        </div>{{-- /.right column --}}

    </div>

</body>
</html>
