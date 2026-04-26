<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar akun E-Proposal Alsintan DTPH untuk mulai mengajukan peminjaman alat pertanian.">
    <title>Daftar Akun — E-Proposal Alsintan DTPH</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-gray-50 font-sans py-8 px-4"
      x-data="{
          showPass: false,
          showPassConfirm: false,
          peran: '',
          peranOptions: [
              { value: 'petani_individu', label: 'Petani Individu', desc: 'Saya seorang petani perseorangan', icon: '🧑‍🌾' },
              { value: 'kelompok_tani',   label: 'Kelompok Tani',   desc: 'Saya mewakili kelompok tani', icon: '👥' },
              { value: 'penyuluh',        label: 'Penyuluh Lapangan', desc: 'Saya penyuluh pertanian', icon: '📋' },
          ]
      }">

    <div class="max-w-lg mx-auto">

        {{-- Header --}}
        <div class="text-center mb-8 animate-fade-in-down">
            <div class="inline-flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900">Buat Akun Baru</h1>
            <p class="text-gray-500 text-sm mt-1.5">Bergabung dan nikmati kemudahan pengajuan alsintan secara digital.</p>
        </div>

        {{-- Card --}}
        <div class="card p-6 md:p-8 animate-fade-in-up">

            <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm">
                @csrf

                {{-- Pilih Peran --}}
                <div>
                    <label class="form-label">Saya adalah <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2">
                        <template x-for="opt in peranOptions" :key="opt.value">
                            <label :for="'peran_' + opt.value"
                                   class="relative flex flex-col items-center gap-1.5 p-3.5 rounded-xl border-2 cursor-pointer transition-all duration-200"
                                   :class="peran === opt.value
                                       ? 'border-primary-500 bg-primary-50 shadow-md shadow-primary-100'
                                       : 'border-gray-200 bg-white hover:border-primary-200 hover:bg-primary-50/50'">
                                <input type="radio" name="peran" :id="'peran_' + opt.value" :value="opt.value"
                                       x-model="peran" class="sr-only">
                                <span class="text-2xl" x-text="opt.icon"></span>
                                <span class="text-xs font-semibold text-center leading-tight"
                                      :class="peran === opt.value ? 'text-primary-700' : 'text-gray-700'"
                                      x-text="opt.label"></span>
                                <span class="text-[10px] text-center leading-tight"
                                      :class="peran === opt.value ? 'text-primary-500' : 'text-gray-400'"
                                      x-text="opt.desc"></span>
                                {{-- Check icon --}}
                                <div x-show="peran === opt.value"
                                     class="absolute top-2 right-2 w-4 h-4 rounded-full bg-primary-600 flex items-center justify-center"
                                     style="display:none">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </label>
                        </template>
                    </div>
                    @error('peran')
                        <p class="form-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input id="name" type="text" name="name" placeholder="Nama sesuai KTP"
                               value="{{ old('name') }}" autocomplete="name"
                               class="form-input pl-11 {{ $errors->has('name') ? 'form-input-error' : '' }}">
                    </div>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- NIK --}}
                <div>
                    <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        </div>
                        <input id="nik" type="text" name="nik" placeholder="16 digit NIK"
                               value="{{ old('nik') }}" maxlength="16" inputmode="numeric"
                               class="form-input pl-11 {{ $errors->has('nik') ? 'form-input-error' : '' }}">
                    </div>
                    @error('nik') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- No. HP --}}
                <div>
                    <label for="phone" class="form-label">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <input id="phone" type="tel" name="phone" placeholder="08xx-xxxx-xxxx"
                               value="{{ old('phone') }}" inputmode="tel"
                               class="form-input pl-11 {{ $errors->has('phone') ? 'form-input-error' : '' }}">
                    </div>
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="form-label">Email <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input id="email" type="email" name="email" placeholder="email@contoh.com"
                               value="{{ old('email') }}" autocomplete="email"
                               class="form-input pl-11 {{ $errors->has('email') ? 'form-input-error' : '' }}">
                    </div>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="form-label">Kata Sandi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input id="password" :type="showPass ? 'text' : 'password'" name="password"
                                   placeholder="Min. 8 karakter"
                                   class="form-input pr-11 {{ $errors->has('password') ? 'form-input-error' : '' }}"
                                   autocomplete="new-password">
                            <button type="button" @click="showPass = !showPass" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <svg x-show="!showPass" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPass" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('password') <p class="form-error text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Sandi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input id="password_confirmation" :type="showPassConfirm ? 'text' : 'password'"
                                   name="password_confirmation" placeholder="Ulangi kata sandi"
                                   class="form-input pr-11" autocomplete="new-password">
                            <button type="button" @click="showPassConfirm = !showPassConfirm" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <svg x-show="!showPassConfirm" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassConfirm" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Agreement --}}
                <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-3.5">
                    <input id="agree" type="checkbox" name="agree" required
                           class="mt-0.5 w-4.5 h-4.5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 cursor-pointer flex-shrink-0">
                    <label for="agree" class="text-xs text-gray-600 cursor-pointer leading-relaxed">
                        Saya menyetujui <a href="#" class="text-primary-600 font-semibold hover:underline">Syarat & Ketentuan</a>
                        dan <a href="#" class="text-primary-600 font-semibold hover:underline">Kebijakan Privasi</a>
                        penggunaan platform E-Proposal Alsintan DTPH.
                    </label>
                </div>

                {{-- Submit --}}
                <button id="btnRegister" type="submit" class="btn-primary w-full py-3.5 text-base">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Buat Akun Sekarang
                </button>
            </form>

            {{-- Login Link --}}
            <div class="text-center mt-6 pt-5 border-t border-gray-100">
                <p class="text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:text-primary-800 transition">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
