<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke platform E-Proposal Alsintan DTPH untuk mengajukan peminjaman alat pertanian.">
    <title>Masuk — E-Proposal Alsintan DTPH</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-50 font-sans">

<div class="min-h-screen flex" x-data="{ showPass: false }">

    {{-- ============================================================
         LEFT PANEL — Illustration (Desktop only)
         ============================================================ --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-primary-700 via-primary-600 to-emerald-500">

        {{-- Decorative circles --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-16 -right-16 w-80 h-80 rounded-full bg-white/5"></div>
        <div class="absolute top-1/2 left-1/3 w-40 h-40 rounded-full bg-white/10 blur-xl"></div>

        <div class="relative z-10 flex flex-col justify-between p-12 w-full">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-white text-sm">E-Proposal Alsintan</p>
                    <p class="text-primary-200 text-xs">Dinas Tanaman Pangan & Hortikultura</p>
                </div>
            </div>

            {{-- Center Content --}}
            <div class="text-center flex flex-col items-center gap-6">
                {{-- SVG Illustration --}}
                <div class="w-64 h-64 relative animate-fade-in-up">
                    <svg viewBox="0 0 300 280" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full drop-shadow-2xl">
                        {{-- Ground --}}
                        <ellipse cx="150" cy="250" rx="130" ry="18" fill="rgba(255,255,255,0.1)"/>
                        {{-- Tractor body --}}
                        <rect x="80" y="160" width="140" height="75" rx="12" fill="rgba(255,255,255,0.9)"/>
                        <rect x="100" y="140" width="80" height="45" rx="8" fill="rgba(255,255,255,0.95)"/>
                        {{-- Cabin windows --}}
                        <rect x="108" y="148" width="28" height="22" rx="4" fill="#a7f3d0"/>
                        <rect x="144" y="148" width="28" height="22" rx="4" fill="#a7f3d0"/>
                        {{-- Exhaust pipe --}}
                        <rect x="175" y="122" width="8" height="24" rx="3" fill="rgba(255,255,255,0.7)"/>
                        <ellipse cx="179" cy="120" rx="6" ry="4" fill="rgba(255,255,255,0.5)"/>
                        {{-- Wheels --}}
                        <circle cx="108" cy="235" r="32" fill="rgba(16,100,52,0.8)" stroke="rgba(255,255,255,0.3)" stroke-width="4"/>
                        <circle cx="108" cy="235" r="18" fill="rgba(255,255,255,0.2)"/>
                        <circle cx="192" cy="235" r="22" fill="rgba(16,100,52,0.8)" stroke="rgba(255,255,255,0.3)" stroke-width="4"/>
                        <circle cx="192" cy="235" r="12" fill="rgba(255,255,255,0.2)"/>
                        {{-- Plow attachment --}}
                        <path d="M220 200 L260 220 L255 235 L215 215 Z" fill="rgba(255,255,255,0.6)" rx="4"/>
                        {{-- Crops / Plants --}}
                        <g fill="rgba(255,255,255,0.7)">
                            <path d="M30 220 Q35 190 45 185 Q50 190 45 220 Z"/>
                            <path d="M40 220 Q50 200 55 185 Q60 195 50 220 Z"/>
                            <path d="M50 220 Q45 195 55 175 Q65 185 55 220 Z"/>
                        </g>
                        <g fill="rgba(255,255,255,0.7)">
                            <path d="M250 215 Q255 195 262 192 Q265 197 258 215 Z"/>
                            <path d="M258 215 Q265 198 270 190 Q274 198 264 215 Z"/>
                        </g>
                        {{-- Sun --}}
                        <circle cx="60" cy="70" r="28" fill="rgba(251,191,36,0.7)"/>
                        <line x1="60" y1="30" x2="60" y2="18" stroke="rgba(251,191,36,0.5)" stroke-width="3" stroke-linecap="round"/>
                        <line x1="60" y1="110" x2="60" y2="122" stroke="rgba(251,191,36,0.5)" stroke-width="3" stroke-linecap="round"/>
                        <line x1="20" y1="70" x2="8" y2="70" stroke="rgba(251,191,36,0.5)" stroke-width="3" stroke-linecap="round"/>
                        <line x1="100" y1="70" x2="112" y2="70" stroke="rgba(251,191,36,0.5)" stroke-width="3" stroke-linecap="round"/>
                        <line x1="32" y1="42" x2="24" y2="34" stroke="rgba(251,191,36,0.5)" stroke-width="3" stroke-linecap="round"/>
                        <line x1="88" y1="98" x2="96" y2="106" stroke="rgba(251,191,36,0.5)" stroke-width="3" stroke-linecap="round"/>
                        {{-- Cloud --}}
                        <ellipse cx="220" cy="55" rx="45" ry="22" fill="rgba(255,255,255,0.3)"/>
                        <ellipse cx="195" cy="60" rx="28" ry="18" fill="rgba(255,255,255,0.25)"/>
                        <ellipse cx="245" cy="62" rx="25" ry="16" fill="rgba(255,255,255,0.25)"/>
                    </svg>
                </div>

                <div class="animate-fade-in-up delay-200">
                    <h2 class="text-3xl font-extrabold text-white leading-tight">
                        Digitalisasi<br>Peminjaman Alsintan
                    </h2>
                    <p class="text-primary-100 text-sm mt-3 leading-relaxed max-w-xs mx-auto">
                        Ajukan proposal peminjaman alat dan mesin pertanian kapan saja, di mana saja — cukup dari genggaman Anda.
                    </p>
                </div>
            </div>

            {{-- Bottom Stats --}}
            <div class="grid grid-cols-3 gap-4 animate-fade-in-up delay-300">
                @foreach([['150+', 'Alat Tersedia'], ['2.400+', 'Petani Aktif'], ['98%', 'Kepuasan']] as $stat)
                <div class="text-center">
                    <p class="text-2xl font-extrabold text-white">{{ $stat[0] }}</p>
                    <p class="text-primary-200 text-xs mt-0.5">{{ $stat[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ============================================================
         RIGHT PANEL — Login Form
         ============================================================ --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
        <div class="w-full max-w-md animate-fade-in-up">

            {{-- Mobile Logo --}}
            <div class="flex items-center gap-3 mb-8 lg:hidden">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">E-Proposal Alsintan</p>
                    <p class="text-primary-600 text-xs">DTPH</p>
                </div>
            </div>

            {{-- Heading --}}
            <h1 class="text-2xl font-extrabold text-gray-900">Selamat Datang Kembali 👋</h1>
            <p class="text-gray-500 text-sm mt-1.5">Masuk untuk mengakses layanan e-proposal alsintan.</p>

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5" id="loginForm">
                @csrf

                {{-- NIK / Email --}}
                <div>
                    <label for="nik" class="form-label">NIK / Email</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input id="nik" type="text" name="nik" placeholder="Masukkan NIK 16 digit atau Email"
                               value="{{ old('nik') }}"
                               class="form-input pl-11 {{ $errors->has('nik') ? 'form-input-error' : '' }}"
                               autocomplete="username" autofocus>
                    </div>
                    @error('nik')
                        <p class="form-error"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="form-label mb-0">Kata Sandi</label>
                        <a href="#" class="text-xs text-primary-600 font-medium hover:text-primary-800 transition">Lupa kata sandi?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" :type="showPass ? 'text' : 'password'" name="password"
                               placeholder="Kata sandi Anda"
                               class="form-input pl-11 pr-11 {{ $errors->has('password') ? 'form-input-error' : '' }}"
                               autocomplete="current-password">
                        <button type="button" @click="showPass = !showPass"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                            <svg x-show="!showPass" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPass" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-2.5">
                    <input id="remember" type="checkbox" name="remember"
                           class="w-4.5 h-4.5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 cursor-pointer">
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">Ingat saya di perangkat ini</label>
                </div>

                {{-- Submit --}}
                <button id="btnLogin" type="submit" class="btn-primary w-full py-3.5 text-base">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Masuk Sekarang
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400 font-medium">Belum punya akun?</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Register Link --}}
            <a href="{{ route('register') }}"
               class="btn-secondary w-full py-3.5 text-base">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Daftar Akun Baru
            </a>

            {{-- Footer --}}
            <p class="text-center text-xs text-gray-400 mt-8">
                © {{ date('Y') }} Dinas Tanaman Pangan dan Hortikultura.<br>Semua hak dilindungi.
            </p>
        </div>
    </div>
</div>

</body>
</html>
