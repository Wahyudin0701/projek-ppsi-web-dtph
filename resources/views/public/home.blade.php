<x-layouts.public>
    <x-slot:title>Portal E-Proposal Publik</x-slot:title>

    {{-- HERO SECTION --}}
    <section class="relative text-white overflow-hidden py-24 md:py-32">
        {{-- Background Image & Overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/img_dtph.png') }}" class="w-full h-full object-cover" alt="Background">
            {{-- Darker Overlays for contrast --}}
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-primary-950/90 via-primary-900/60 to-emerald-950/90"></div>
        </div>

        {{-- Decorations --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-[30%] -right-[10%] w-[70%] h-[100%] rounded-full bg-white/5 blur-3xl"></div>
            <div class="absolute -bottom-[20%] -left-[10%] w-[50%] h-[80%] rounded-full bg-emerald-500/10 blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 animate-fade-in-up">
                Sistem E-Proposal <br class="hidden md:block" /> <span class="text-emerald-300">Dinas Pertanian</span>
            </h1>
            <p class="mt-4 text-lg md:text-xl text-primary-100 max-w-3xl mx-auto leading-relaxed animate-fade-in-up delay-100">
                Portal resmi Dinas Tanaman Pangan dan Hortikultura untuk pengajuan proposal peminjaman alat mesin pertanian (Alsintan) dan program bantuan pendanaan secara digital, transparan, dan efisien.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up delay-200">
                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-primary-800 bg-white hover:bg-gray-50 shadow-lg shadow-white/10 hover:shadow-xl transition-all hover:-translate-y-0.5 active:scale-95">
                        Daftar Akun Sekarang
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-primary-800 bg-white hover:bg-gray-50 shadow-lg shadow-white/10 hover:shadow-xl transition-all hover:-translate-y-0.5 active:scale-95">
                        Masuk ke Dashboard
                    </a>
                @endguest
                <a href="#katalog-alsintan" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-primary-400 text-base font-bold rounded-xl text-white hover:bg-primary-600/50 hover:border-primary-300 transition-all">
                    Lihat Katalog Alsintan
                </a>
            </div>
            <p class="mt-4 text-sm text-primary-200/80 animate-fade-in-up delay-300">
                <span class="font-semibold text-white">Catatan:</span> Pendaftaran akun membutuhkan verifikasi manual oleh Admin Dinas sebelum dapat mengajukan usulan.
            </p>
        </div>
    </section>

    {{-- KATALOG ALAT PERTANIAN SECTION --}}
    <section id="katalog-alsintan" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Katalog Alsintan (Pinjam Pakai)</h2>
                <div class="mt-2 w-24 h-1.5 bg-primary-500 mx-auto rounded-full"></div>
                <p class="mt-4 text-gray-600 text-lg">Daftar alat dan mesin pertanian yang tersedia untuk dipinjam oleh Kelompok Tani terdaftar.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $katalog = [
                        ['nama' => 'Traktor Roda 4 — 45 PK', 'desc' => 'Traktor bertenaga besar untuk pengolahan lahan kering maupun sawah skala luas.', 'img' => 'tractor'],
                        ['nama' => 'Pompa Air Centrifugal 3"', 'desc' => 'Mesin pompa untuk irigasi sawah dengan kapasitas sedot dan dorong tinggi.', 'img' => 'pump'],
                        ['nama' => 'Combine Harvester', 'desc' => 'Mesin panen padi multifungsi yang mempercepat proses pemotongan dan perontokan.', 'img' => 'harvester'],
                    ];
                @endphp

                @foreach($katalog as $item)
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-primary-200 transition-all duration-300 group flex flex-col">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100 relative overflow-hidden h-48 flex items-center justify-center">
                        {{-- Placeholder for Image --}}
                        <div class="absolute inset-0 bg-gradient-to-tr from-gray-200 to-gray-100 group-hover:scale-105 transition-transform duration-500"></div>
                        <svg class="w-16 h-16 text-gray-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div class="absolute top-4 right-4 bg-primary-100 text-primary-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">Pinjam Pakai</div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $item['nama'] }}</h3>
                        <p class="mt-2 text-gray-500 text-sm flex-1">{{ $item['desc'] }}</p>
                        <a href="{{ auth()->check() ? route('katalog') : route('login') }}" class="mt-6 w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-200 text-sm font-semibold rounded-xl text-primary-600 bg-white hover:bg-primary-50 hover:border-primary-200 transition-colors">
                            {{ auth()->check() ? 'Lihat Detail' : 'Pinjam Alat' }}
                            <svg class="ml-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:text-primary-800 transition inline-flex items-center gap-1">
                    Lihat Seluruh Katalog 
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- PROGRAM BANTUAN SECTION --}}
    <section id="program-bantuan" class="py-20 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Program Bantuan & Pendanaan</h2>
                <div class="mt-2 w-24 h-1.5 bg-emerald-500 mx-auto rounded-full"></div>
                <p class="mt-4 text-gray-600 text-lg">Informasi program bantuan permanen dan pendanaan untuk Kelompok Tani tahun anggaran berjalan.</p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6">
                @php
                    $programs = [
                        ['nama' => 'Bantuan Pupuk Subsidi & Bibit Unggul 2025', 'tipe' => 'Bantuan Permanen', 'buka' => '01 Mei 2025', 'tutup' => '30 Jun 2025', 'status' => 'Segera Buka', 'color' => 'amber'],
                        ['nama' => 'Pendanaan Pengembangan Irigasi Desa', 'tipe' => 'Usulan Pendanaan', 'buka' => '15 Mar 2025', 'tutup' => '15 Mei 2025', 'status' => 'Dibuka', 'color' => 'green'],
                    ];
                @endphp

                @foreach($programs as $program)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 flex flex-col md:flex-row gap-6 items-start md:items-center justify-between shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-{{ $program['color'] }}-100 text-{{ $program['color'] }}-800 text-xs font-bold px-2.5 py-1 rounded-md">{{ $program['status'] }}</span>
                            <span class="text-gray-500 text-sm font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                {{ $program['tipe'] }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $program['nama'] }}</h3>
                        <div class="mt-3 flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Dibuka: <span class="font-medium text-gray-700">{{ $program['buka'] }}</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Ditutup: <span class="font-medium text-gray-700">{{ $program['tutup'] }}</span>
                            </span>
                        </div>
                    </div>
                    
                    <a href="{{ auth()->check() ? route('program') : route('login') }}" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors flex-shrink-0">
                        {{ auth()->check() ? 'Lihat Program' : 'Ajukan Program' }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CALL TO ACTION (CTA) SECTION --}}
    <section class="py-20 bg-white relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-primary-900 rounded-3xl p-8 md:p-16 text-center text-white shadow-2xl overflow-hidden relative">
                <div class="absolute inset-0 opacity-10">
                    <svg viewBox="0 0 400 400" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4">Mulai Ajukan Proposal Anda</h2>
                    <p class="text-primary-200 text-lg max-w-2xl mx-auto mb-10">Bergabunglah dengan ratusan Kelompok Tani lainnya yang telah memanfaatkan kemudahan layanan digital kami.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        @guest
                            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-primary-500 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 hover:bg-primary-400 hover:-translate-y-1 transition-all">
                                Daftar Akun Kelompok Tani
                            </a>
                            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white/10 text-white font-bold rounded-xl border border-white/20 hover:bg-white/20 transition-all">
                                Sudah punya akun? Masuk
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-12 py-4 bg-primary-500 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 hover:bg-primary-400 hover:-translate-y-1 transition-all">
                                Masuk ke Panel Dashboard Anda
                            </a>
                        @endguest
                    </div>
                    <div class="mt-8 inline-flex items-center gap-2 bg-black/20 px-4 py-2 rounded-lg text-sm text-primary-200 border border-white/5">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Pendaftaran akun membutuhkan verifikasi manual oleh Admin Dinas.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.public>
