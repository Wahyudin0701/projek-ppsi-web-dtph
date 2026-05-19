<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendaftaran Kelompok Tani - E-Proposal Alsintan</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js (for password toggle) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans text-gray-800 antialiased bg-white">

    <div class="min-h-screen flex">
        
        {{-- LEFT COLUMN: Branding / Hero --}}
        <div class="hidden lg:flex lg:w-1/2 relative flex-col justify-between overflow-hidden opacity-0 animate-fade-in">
            {{-- Background Image & Overlay --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/img_dtph.png') }}" class="w-full h-full object-cover" alt="Branding Background">
                <div class="absolute inset-0 bg-black/70"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-primary-950/90 via-primary-900/40 to-emerald-950/80"></div>
            </div>

            {{-- Background decorative shapes --}}
            <div class="absolute inset-0 pointer-events-none z-10">
                <div class="absolute top-[30%] -left-[10%] w-[50%] h-[50%] rounded-full bg-green-500/5 blur-3xl"></div>
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
                    Wujudkan <br/> <span class="text-emerald-400">Pertanian Modern</span> <br/> yang Maju
                </h1>
                <p class="text-gray-200 text-lg max-w-md mx-auto leading-relaxed font-medium opacity-0 animate-fade-in-up delay-200">
                    Daftarkan Kelompok Tani Anda untuk mendapatkan kemudahan akses bantuan dan peminjaman alat mesin pertanian secara digital.
                </p>

                {{-- Trust Badges / Stats --}}
                <div class="mt-12 grid grid-cols-3 gap-8 w-full max-w-lg border-t border-white/10 pt-10">
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">Mudah</p>
                        <p class="mt-1 text-xs font-bold text-emerald-400 uppercase tracking-wider">Proses Cepat</p>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">Adil</p>
                        <p class="mt-1 text-xs font-bold text-emerald-400 uppercase tracking-wider">Transparan</p>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">Pasti</p>
                        <p class="mt-1 text-xs font-bold text-emerald-400 uppercase tracking-wider">Terintegrasi</p>
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
                <img src="{{ asset('images/img_dtph.png') }}" class="w-full h-full object-cover opacity-60" alt="Hero">
                <div class="absolute inset-0 bg-gradient-to-b from-black/65 via-primary-900/50 to-primary-900"></div>

                {{-- Content: Logo kiri + Teks rata kiri (rata atas) --}}
                <div class="absolute inset-0 px-8 pt-10 flex flex-col justify-start">
                    <div class="flex items-center gap-4 mb-6">
                        <x-application-logo class="w-14 h-14 object-contain drop-shadow-2xl flex-shrink-0" textColor="text-white" />
                    </div>
                    <div class="text-left sm:text-center ">
                        <h2 class="text-white font-black text-2xl sm:text-4xl leading-tight drop-shadow-lg opacity-0 animate-fade-in-up delay-200">Daftar Akun Baru</h2>
                        <p class="text-emerald-300 text-xs sm:text-lg font-bold mt-0.5 opacity-0 animate-fade-in-up delay-300">Modernisasi Pertanian Muaro Jambi</p>
                    </div>
                </div>
            </div>

            {{-- Scrollable Form Area --}}
            <div class="lg:flex lg:items-center lg:justify-center lg:h-screen">
                <div class="w-full max-w-2xl mx-auto lg:h-screen lg:overflow-y-auto custom-scrollbar
                            mt-[calc(16rem-2.5rem)] sm:mt-[calc(18rem-2.5rem)] lg:mt-0
                            relative z-10 bg-gray-50 lg:bg-white rounded-t-[2.5rem] lg:rounded-none
                            min-h-[calc(100vh-16rem)] sm:min-h-[calc(100vh-18rem)] lg:min-h-0">
                <div class="p-6 sm:p-8 lg:p-12">
                    {{-- Header (Desktop only) --}}
                    <div class="hidden lg:block mb-8 text-left">
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 mb-2">
                            Daftar Akun <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-primary-800">Baru</span>
                        </h2>
                        <p class="text-gray-500 text-sm leading-relaxed">Lengkapi formulir di bawah ini dengan data kelompok tani yang valid.</p>
                    </div>

                {{-- Form --}}
                @php
                    $initialStep = 1;
                    if($role === 'petani') {
                        if ($errors->has('name') || $errors->has('email') || $errors->has('password')) {
                            $initialStep = 1;
                        } elseif ($errors->has('nama_ketua') || $errors->has('nik_ketua') || $errors->has('no_wa')) {
                            $initialStep = 2;
                        } elseif ($errors->has('grade') || $errors->has('luas_lahan') || $errors->has('komoditi') || $errors->has('komoditi_utama') || $errors->has('kecamatan') || $errors->has('alamat')) {
                            $initialStep = 3;
                        }
                    }
                @endphp
                <form method="POST" action="{{ route('register') }}" 
                      x-data="{ 
                          step: {{ $initialStep }}, 
                          maxStep: {{ $role === 'petani' ? 4 : 1 }},
                          selectedKomoditi: [],
                          komoditiUtama: '',
                          review: {},
                          updateReview() {
                              this.review = {
                                  name: document.getElementById('name').value,
                                  email: document.getElementById('email').value,
                                  nama_ketua: document.getElementById('nama_ketua') ? document.getElementById('nama_ketua').value : '',
                                  nik_ketua: document.getElementById('nik_ketua') ? document.getElementById('nik_ketua').value : '',
                                  no_wa: document.getElementById('no_wa') ? document.getElementById('no_wa').value : '',
                                  grade: document.getElementById('grade') ? document.getElementById('grade').value : '',
                                  luas_lahan: document.getElementById('luas_lahan') ? document.getElementById('luas_lahan').value : '',
                                  komoditi: this.selectedKomoditi.length > 0 ? this.selectedKomoditi.join(', ') : '',
                                  komoditi_utama: document.getElementById('komoditi_utama') ? document.getElementById('komoditi_utama').value : '',
                                  kecamatan: document.getElementById('kecamatan') ? document.getElementById('kecamatan').value : '',
                                  alamat: document.getElementById('alamat') ? document.getElementById('alamat').value : ''
                              }
                          }
                      }" 
                      class="space-y-5 flex-1 pb-10">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role }}">

                    @if($role === 'petani')
                    {{-- Stepper --}}
                    <div class="mb-8 mt-2 px-2 sm:px-4">
                        <div class="flex items-center justify-between relative">
                            <div class="absolute left-0 top-4 transform -translate-y-1/2 w-full h-1 bg-gray-200 z-0 rounded-full"></div>
                            <div class="absolute left-0 top-4 transform -translate-y-1/2 h-1 bg-[#19A148] z-0 rounded-full transition-all duration-500 ease-in-out" :style="'width: ' + ((step - 1) / (maxStep - 1) * 100) + '%'"></div>
                            
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 ring-4 ring-white" :class="step >= 1 ? 'bg-[#19A148] text-white shadow-md' : 'bg-gray-200 text-gray-500'">1</div>
                                <span class="text-[10px] sm:text-xs font-bold mt-2 transition-colors duration-300" :class="step >= 1 ? 'text-[#19A148]' : 'text-gray-400'">Akun</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 ring-4 ring-white" :class="step >= 2 ? 'bg-[#19A148] text-white shadow-md' : 'bg-gray-200 text-gray-500'">2</div>
                                <span class="text-[10px] sm:text-xs font-bold mt-2 transition-colors duration-300" :class="step >= 2 ? 'text-[#19A148]' : 'text-gray-400'">Ketua</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 ring-4 ring-white" :class="step >= 3 ? 'bg-[#19A148] text-white shadow-md' : 'bg-gray-200 text-gray-500'">3</div>
                                <span class="text-[10px] sm:text-xs font-bold mt-2 transition-colors duration-300" :class="step >= 3 ? 'text-[#19A148]' : 'text-gray-400'">Lahan</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 ring-4 ring-white" :class="step >= 4 ? 'bg-[#19A148] text-white shadow-md' : 'bg-gray-200 text-gray-500'">4</div>
                                <span class="text-[10px] sm:text-xs font-bold mt-2 transition-colors duration-300" :class="step >= 4 ? 'text-[#19A148]' : 'text-gray-400'">Review</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- STEP 1: Akun -->
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nama Kelompok Tani / Umum -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-bold text-gray-800 mb-2">{{ $role === 'umum' ? 'Nama Lengkap' : 'Nama Kelompok Tani' }}</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" :required="step === 1" autofocus
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                        placeholder="{{ $role === 'umum' ? 'Masukkan nama lengkap' : 'Masukkan nama kelompok tani' }}">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="{{ $role === 'umum' ? 'md:col-span-2' : '' }}">
                                <label for="email" class="block text-sm font-bold text-gray-800 mb-2">Alamat Email</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" :required="step === 1"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                        placeholder="email@contoh.com">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            
                            @if($role === 'petani')
                            <div class="hidden md:block"></div>
                            @endif

                            <!-- Kata Sandi -->
                            <div x-data="{ showPassword: false }">
                                <label for="password" class="block text-sm font-bold text-gray-800 mb-2">Kata Sandi</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>
                                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" :required="step === 1"
                                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                        placeholder="••••••••">
                                    
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

                            <!-- Konfirmasi Kata Sandi -->
                            <div x-data="{ showPasswordConf: false }">
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-800 mb-2">Konfirmasi Sandi</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>
                                    <input :type="showPasswordConf ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" :required="step === 1"
                                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                        placeholder="••••••••">
                                    
                                    <button type="button" @click="showPasswordConf = !showPasswordConf" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg x-show="!showPasswordConf" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPasswordConf" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    @if($role === 'petani')
                    <!-- STEP 2: Ketua -->
                    <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nama Ketua -->
                            <div class="md:col-span-2">
                                <label for="nama_ketua" class="block text-sm font-bold text-gray-800 mb-2">Nama Ketua Kelompok</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <input type="text" name="nama_ketua" id="nama_ketua" value="{{ old('nama_ketua') }}" :required="step === 2"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                        placeholder="Sesuai KTP">
                                </div>
                                <x-input-error :messages="$errors->get('nama_ketua')" class="mt-2" />
                            </div>

                            <!-- NIK Ketua -->
                            <div>
                                <label for="nik_ketua" class="block text-sm font-bold text-gray-800 mb-2">NIK Ketua</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                    </div>
                                    <input type="text" name="nik_ketua" id="nik_ketua" value="{{ old('nik_ketua') }}" :required="step === 2"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                        placeholder="16 digit NIK">
                                </div>
                                <x-input-error :messages="$errors->get('nik_ketua')" class="mt-2" />
                            </div>

                            <!-- No WhatsApp -->
                            <div>
                                <label for="no_wa" class="block text-sm font-bold text-gray-800 mb-2">Nomor WhatsApp</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                    <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}" :required="step === 2"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                        placeholder="08xx-xxxx-xxxx">
                                </div>
                                <x-input-error :messages="$errors->get('no_wa')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Lahan -->
                    <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Grade Tani -->
                            <div>
                                <label for="grade" class="block text-sm font-bold text-gray-800 mb-2">Grade Tani</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                    </div>
                                    <select name="grade" id="grade" :required="step === 3"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] sm:text-sm appearance-none transition-all bg-white">
                                        <option value="" disabled selected>Pilih Grade</option>
                                        <option value="Pemula">Pemula</option>
                                        <option value="Madya">Madya</option>
                                        <option value="Utama">Utama</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                            </div>

                            <!-- Luas Lahan Total -->
                            <div>
                                <label for="luas_lahan" class="block text-sm font-bold text-gray-800 mb-2">Luas Lahan Total (Hektar)</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                    </div>
                                    <input type="number" step="0.01" name="luas_lahan" id="luas_lahan" value="{{ old('luas_lahan') }}" :required="step === 3"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                        placeholder="Misal: 2.5">
                                </div>
                                <x-input-error :messages="$errors->get('luas_lahan')" class="mt-2" />
                            </div>

                            <!-- Komoditi -->
                            <div class="md:col-span-2">
                                <label for="komoditi" class="block text-sm font-bold text-gray-800 mb-2">Pilih Komoditi</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-1">
                                    @foreach(['Padi Sawah', 'Padi Gogo', 'Jagung', 'Cabai', 'Sayuran', 'Kelapa Sawit'] as $kom)
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="checkbox" name="komoditi[]" value="{{ $kom }}" x-model="selectedKomoditi" :required="selectedKomoditi.length === 0 && step === 3"
                                            class="w-4 h-4 text-[#19A148] border-gray-300 rounded focus:ring-[#19A148] transition-colors cursor-pointer" @change="if(!selectedKomoditi.includes(komoditiUtama)) komoditiUtama = selectedKomoditi.length > 0 ? selectedKomoditi[0] : ''">
                                        <span class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors">{{ $kom }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('komoditi')" class="mt-2" />
                            </div>

                            <!-- Komoditi Utama (Dynamic) -->
                            <div x-show="selectedKomoditi.length > 0" x-cloak x-transition>
                                <label for="komoditi_utama" class="block text-sm font-bold text-gray-800 mb-2">Komoditi Utama</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-[#19A148]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                    </div>
                                    <select name="komoditi_utama" id="komoditi_utama" x-model="komoditiUtama" :required="selectedKomoditi.length > 0 && step === 3"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] sm:text-sm appearance-none transition-all bg-white">
                                        <template x-for="kom in selectedKomoditi" :key="kom">
                                            <option :value="kom" x-text="kom"></option>
                                        </template>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('komoditi_utama')" class="mt-2" />
                            </div>

                            <!-- Kecamatan -->
                            <div>
                                <label for="kecamatan" class="block text-sm font-bold text-gray-800 mb-2">Kecamatan</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <select name="kecamatan" id="kecamatan" :required="step === 3"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] sm:text-sm appearance-none transition-all bg-white">
                                        <option value="" disabled selected>Pilih Kecamatan</option>
                                        <option value="BAHAR SELATAN">BAHAR SELATAN</option>
                                        <option value="BAHAR UTARA">BAHAR UTARA</option>
                                        <option value="JAMBI LUAR KOTA">JAMBI LUAR KOTA</option>
                                        <option value="KUMPEH">KUMPEH</option>
                                        <option value="KUMPEH ULU">KUMPEH ULU</option>
                                        <option value="MARO SEBO">MARO SEBO</option>
                                        <option value="MESTONG">MESTONG</option>
                                        <option value="SEKERNAN">SEKERNAN</option>
                                        <option value="SUNGAI BAHAR">SUNGAI BAHAR</option>
                                        <option value="SUNGAI GELAM">SUNGAI GELAM</option>
                                        <option value="TAMAN RAJO">TAMAN RAJO</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                            </div>

                            <!-- Alamat Lengkap / Titik Lokasi -->
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-bold text-gray-800 mb-2">Alamat Lengkap / Titik Lokasi</label>
                                <div class="relative group">
                                    <div class="absolute top-3 left-3.5 flex items-start pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#19A148] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <textarea name="alamat" id="alamat" rows="3" :required="step === 3"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm resize-none"
                                        placeholder="Detail alamat sekretariat kelompok tani..."></textarea>
                                </div>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: Review Data -->
                    <div x-show="step === 4" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 mb-6 space-y-4">
                            <h3 class="font-bold text-gray-800 border-b border-gray-200 pb-2 mb-3">Review Data Kelompok Tani</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Nama Kelompok</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.name"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Email</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.email"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Nama Ketua</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.nama_ketua"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">NIK Ketua</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.nik_ketua"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">No. WhatsApp</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.no_wa"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Grade</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.grade"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Luas Lahan (Ha)</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.luas_lahan"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Semua Komoditi</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.komoditi"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Komoditi Utama</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.komoditi_utama"></p>
                                </div>
                                <div class="sm:col-span-2">
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Kecamatan</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.kecamatan"></p>
                                </div>
                                <div class="sm:col-span-2">
                                    <p class="text-gray-500 text-[11px] font-semibold uppercase tracking-wider">Alamat Lengkap</p>
                                    <p class="font-medium text-gray-900 mt-0.5" x-text="review.alamat"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Checkbox Persetujuan -->
                        <div class="flex items-start bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:border-[#19A148]/50 transition-colors cursor-pointer" @click="document.getElementById('persetujuan_data').click()">
                            <div class="flex items-center h-5 mt-1">
                                <input id="persetujuan_data" name="persetujuan_data" type="checkbox" :required="step === 4"
                                    class="w-5 h-5 text-[#19A148] bg-white border-gray-300 rounded focus:ring-[#19A148] focus:ring-2 cursor-pointer" @click.stop>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="persetujuan_data" class="font-bold text-gray-800 cursor-pointer block">Pernyataan Kebenaran Data</label>
                                <p class="text-gray-500 text-xs mt-1 leading-relaxed">Saya menyatakan bahwa seluruh data kelompok tani yang saya inputkan di atas adalah benar dan dapat dipertanggungjawabkan sesuai dengan kondisi yang sebenarnya.</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Info Alert --}}
                    <div x-show="step === maxStep" x-cloak class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 mt-6 flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="ml-3 text-xs text-blue-800 leading-relaxed">
                            <strong class="font-semibold">Catatan:</strong>
                            Pendaftaran akun Kelompok Tani memerlukan verifikasi manual oleh Admin Dinas sebelum dapat mengakses sistem dan mengajukan usulan.
                        </p>
                    </div>
                    @endif

                    {{-- Form Actions (Buttons) --}}
                    <div class="pt-6 flex gap-4">
                        <!-- Back Button -->
                        <button type="button" x-show="step > 1" x-cloak @click="step--" 
                                class="flex-1 py-3.5 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all active:scale-[0.98]">
                            Kembali
                        </button>

                        <!-- Next Button -->
                        <button type="button" x-show="step < maxStep" @click="if($el.closest('form').reportValidity()) { if(step === maxStep - 1) updateReview(); step++; }"
                                class="flex-1 flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#19A148] hover:bg-[#158C3D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all active:scale-[0.98]">
                            Selanjutnya
                            <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Submit Button -->
                        <button type="submit" x-show="step === maxStep"
                                class="flex-1 flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#19A148] hover:bg-[#158C3D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all active:scale-[0.98]">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Daftar Akun
                        </button>
                    </div>

                    {{-- Divider --}}
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-white px-3 text-gray-400 font-medium">Sudah punya akun?</span>
                        </div>
                    </div>

                    {{-- Login Link Button --}}
                    <div>
                        <a href="{{ route('login') }}" class="w-full flex justify-center items-center py-3.5 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-[#19A148] bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all active:scale-[0.98]">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk Sekarang
                        </a>
                    </div>

                </form>

                {{-- Footer --}}
                <div class="py-4 text-center mt-auto">
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
