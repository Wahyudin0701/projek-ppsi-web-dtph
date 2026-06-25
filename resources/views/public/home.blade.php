<x-layouts.public>
    <x-slot:title>Beranda</x-slot:title>

    {{-- Inline styles for scroll animations --}}
    <x-slot:head>
        <style>
            /* Base reveal states */
            .reveal {
                opacity: 0;
                transform: translateY(40px);
                transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .reveal-left {
                opacity: 0;
                transform: translateX(-50px);
                transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .reveal-right {
                opacity: 0;
                transform: translateX(50px);
                transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .reveal-scale {
                opacity: 0;
                transform: scale(0.92);
                transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .reveal-section {
                opacity: 0;
                transform: translateY(60px);
                transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
            }

            /* Visible state — all types snap here */
            .reveal.visible,
            .reveal-left.visible,
            .reveal-right.visible,
            .reveal-scale.visible,
            .reveal-section.visible {
                opacity: 1;
                transform: none;
            }

            /* Stagger delays */
            .reveal-delay-1 {
                transition-delay: 0.08s;
            }

            .reveal-delay-2 {
                transition-delay: 0.18s;
            }

            .reveal-delay-3 {
                transition-delay: 0.28s;
            }

            .reveal-delay-4 {
                transition-delay: 0.38s;
            }

            .reveal-delay-5 {
                transition-delay: 0.48s;
            }

            /* Floating orbs on hero */
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-12px);
                }
            }

            .float-anim {
                animation: float 6s ease-in-out infinite;
            }

            /* Animated gradient */
            @keyframes gradient-move {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            .gradient-anim {
                background-size: 200% 200%;
                animation: gradient-move 8s ease infinite;
            }

            /* Smooth section separator fade */
            section {
                transition: background-color 0.4s ease;
            }

            /* Fix horizontal overflow from translateX animations */
            html, body { overflow-x: hidden; }
        </style>
    </x-slot:head>

    {{-- ============================================================ --}}
    {{-- HERO SECTION — Full viewport, left-aligned, cinematic        --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-screen flex items-center overflow-hidden -mt-16 md:-mt-20 pt-16 md:pt-20">
        {{-- Background --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ \App\Models\Setting::get('homepage_background') ? asset('storage/' . \App\Models\Setting::get('homepage_background')) : asset('images/img_dtph.png') }}" class="w-full h-full object-cover" alt="Gedung DTPH Muaro Jambi" loading="eager">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-950/95 via-gray-950/70 to-gray-950/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-950/80 via-transparent to-transparent"></div>
        </div>

        {{-- Subtle grain texture --}}
        <div class="absolute inset-0 z-[1] opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E');"></div>

        {{-- Glowing orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-[1]">
            <div class="absolute top-[20%] left-[10%] w-[500px] h-[500px] rounded-full bg-[#19A148]/15 blur-[150px] float-anim"></div>
            <div class="absolute bottom-[10%] right-[20%] w-[300px] h-[300px] rounded-full bg-emerald-500/8 blur-[120px]" style="animation: float 8s ease-in-out 2s infinite;"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="max-w-4xl">


                {{-- Headline --}}
                <h1 class="reveal text-[2.25rem] md:text-[2.75rem] lg:text-[3.5rem] font-black text-white leading-[1.08] tracking-[-0.02em] mb-6">
                    Portal<br />
                    Dinas Tanaman Pangan dan Hortikultura<br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-green-300 to-teal-400 gradient-anim">Kab. Muaro Jambi</span>
                </h1>

                {{-- Subtext --}}
                <p class="reveal reveal-delay-1 text-[17px] md:text-lg text-white/55 leading-relaxed max-w-lg mb-10">
                    Layanan pengajuan proposal peminjaman alsintan dan program bantuan pertanian — <span class="text-white/80 font-medium">digital, transparan, dan efisien.</span>
                </p>

                {{-- CTA Buttons --}}
                <div class="reveal reveal-delay-2 flex flex-col sm:flex-row gap-3.5 mb-14">
                    @guest
                    <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-2.5 px-7 py-[14px] bg-[#19A148] hover:bg-[#148f3d] text-white text-[15px] font-bold rounded-[14px] shadow-lg shadow-[#19A148]/25 hover:shadow-xl hover:shadow-[#19A148]/30 hover:-translate-y-0.5 transition-all duration-300">
                        Daftar Akun Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2.5 px-7 py-[14px] bg-white/[0.07] hover:bg-white/[0.12] backdrop-blur-sm border border-white/[0.12] hover:border-white/[0.2] text-white/90 text-[15px] font-semibold rounded-[14px] transition-all duration-300">
                        Masuk ke Akun Anda
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="group inline-flex items-center justify-center gap-2.5 px-7 py-[14px] bg-[#19A148] hover:bg-[#148f3d] text-white text-[15px] font-bold rounded-[14px] shadow-lg shadow-[#19A148]/25 hover:shadow-xl hover:shadow-[#19A148]/30 hover:-translate-y-0.5 transition-all duration-300">
                        Masuk ke Dashboard
                    </a>
                    @endguest
                </div>

                {{-- Metrics --}}
                <div class="reveal reveal-delay-3 flex items-center gap-8 sm:gap-10">
                    @foreach([
                    ['value' => '500+', 'label' => 'Kelompok Tani'],
                    ['value' => '1.200+', 'label' => 'Proposal Disetujui'],
                    ['value' => '50+', 'label' => 'Unit Alsintan'],
                    ] as $metric)
                    <div>
                        <p class="text-2xl md:text-[28px] font-black text-white tracking-tight leading-none">{{ $metric['value'] }}</p>
                        <p class="text-[13px] text-white/40 font-medium mt-1.5">{{ $metric['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- VIDEO TUTORIAL SECTION                                        --}}
    {{-- ============================================================ --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="reveal-section max-w-2xl mx-auto text-center mb-12">
                <p class="text-[13px] font-bold uppercase tracking-[0.15em] text-[#19A148] mb-3">Video Tutorial</p>
                <h2 class="text-3xl md:text-[2.5rem] font-black text-gray-900 tracking-tight leading-tight">Alur Akun Kelompok Tani<br><span class="text-[#19A148]">Portal DTPH</span></h2>
                <p class="mt-4 text-gray-500 text-[16px] leading-relaxed">Pelajari cara mendaftar dan menggunakan portal DTPH Muaro Jambi melalui panduan video berikut ini.</p>
            </div>

            {{-- Video Embed --}}
            <div class="reveal-section max-w-4xl mx-auto">
                <div class="relative group">
                    {{-- Glow Effect --}}
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#19A148] to-[#0d7a38] rounded-2xl blur-lg opacity-25 group-hover:opacity-40 transition duration-500"></div>
                    {{-- Video Container --}}
                    <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">

                        {{-- YouTube iFrame --}}
                        <div class="relative w-full" style="padding-top: 56.25%;">
                            <iframe
                                class="absolute inset-0 w-full h-full"
                                src="https://www.youtube.com/embed/9FHI3QSmjFQ?si=ZRMNwsieoPyvmzJ7&rel=0&modestbranding=1&color=white"
                                title="Tutorial Alur Akun Kelompok Tani Portal DTPH Muaro Jambi"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>

                {{-- CTA bawah video --}}
                <div class="mt-8 flex items-center justify-center">
                    <a href="https://youtu.be/9FHI3QSmjFQ?si=ZRMNwsieoPyvmzJ7" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        Tonton di YouTube
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- LAYANAN / FEATURES SECTION                                   --}}
    {{-- ============================================================ --}}
    <section class="py-16 md:py-24 bg-white">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="reveal-section max-w-xl mx-auto text-center mb-16">
                <p class="text-[13px] font-bold uppercase tracking-[0.15em] text-[#19A148] mb-3">Layanan Kami</p>
                <h2 class="text-3xl md:text-[2.5rem] font-black text-gray-900 tracking-tight leading-tight">Kemudahan layanan pertanian dalam satu platform.</h2>
                <p class="mt-4 text-gray-500 text-[16px] leading-relaxed">Semua kebutuhan pengajuan proposal dan informasi alsintan tersedia secara digital.</p>
            </div>

            {{-- Feature Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-5xl mx-auto">
                @foreach([
                [
                'title' => 'Peminjaman Alat & Mesin Pertanian',
                'desc' => 'Fasilitas peminjaman berbagai jenis alsintan seperti traktor, pompa air, dan mesin panen untuk mendukung produktivitas kelompok tani di Kabupaten Muaro Jambi.',
                'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                'link' => '#katalog',
                'linkText' => 'Lihat Katalog Alsintan',
                'featured' => false,
                ],
                [
                'title' => 'Program Bantuan Pertanian',
                'desc' => 'Penyaluran dukungan pemerintah berupa bibit unggul, pupuk subsidi, serta pendanaan pengembangan infrastruktur pertanian untuk kelompok tani yang terverifikasi.',
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'link' => '#program',
                'linkText' => 'Jelajahi Program',
                'featured' => false,
                ],
                ] as $i => $feature)
                <div class="{{ $i === 0 ? 'reveal-left' : 'reveal-right' }} reveal-delay-{{ $i + 1 }} group relative rounded-[1.5rem] p-8 transition-all duration-500 hover:-translate-y-1 flex flex-col items-center text-center
                    {{ $feature['featured']
                        ? 'bg-[#19A148] shadow-xl shadow-[#19A148]/15'
                        : 'bg-gray-50/80 hover:bg-white border border-gray-100/80 hover:border-gray-200 hover:shadow-xl hover:shadow-gray-200/50' }}">



                    <h3 class="text-lg font-bold mb-2.5 {{ $feature['featured'] ? 'text-white' : 'text-gray-900' }}">{{ $feature['title'] }}</h3>
                    <p class="text-[15px] leading-relaxed mb-6 {{ $feature['featured'] ? 'text-white/70' : 'text-gray-500' }}">{{ $feature['desc'] }}</p>

                    <a href="{{ $feature['link'] }}" class="inline-flex items-center gap-1.5 text-sm font-bold transition-colors
                        {{ $feature['featured'] ? 'text-white/90 hover:text-white' : 'text-[#19A148] hover:text-[#148f3d]' }}">
                        {{ $feature['linkText'] }}
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- KATALOG ALSINTAN SECTION                                     --}}
    {{-- ============================================================ --}}
    <section id="katalog" class="py-16 md:py-24 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal-section relative mb-14">
                <div class="text-center max-w-2xl mx-auto flex flex-col items-center">
                    <p class="text-[13px] font-bold uppercase tracking-[0.15em] text-[#19A148] mb-3">Alsintan Tersedia</p>
                    <h2 class="text-3xl md:text-[2.5rem] font-black text-gray-900 tracking-tight leading-tight mb-3">Katalog Alat & Mesin Pertanian</h2>
                    <p class="text-gray-500 text-[16px] mb-6 md:mb-0">Tersedia untuk dipinjam oleh kelompok tani yang telah terverifikasi.</p>
                </div>
                <div class="md:absolute md:bottom-1 md:right-0 flex justify-center w-full md:w-auto">
                    <a href="{{ route('katalog') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-[#19A148] hover:text-[#148f3d]">
                        Lihat Semua
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                $katalog = \App\Models\Alsintan::with('category')->take(3)->get();
                @endphp

                @foreach($katalog as $i => $item)
                <div class="reveal-scale reveal-delay-{{ $i + 1 }} group bg-white rounded-[1.5rem] border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-gray-200/50 hover:-translate-y-1 hover:border-gray-200 transition-all duration-500 flex flex-col">
                    <div class="h-52 bg-gray-100 relative overflow-hidden flex items-center justify-center">
                        @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                        <img src="{{ asset('images/Lambang_Kabupaten_Muaro_Jambi.png') }}" alt="{{ $item->name }}" class="w-24 h-auto object-contain opacity-30 grayscale group-hover:scale-110 transition-transform duration-700">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent z-0"></div>

                        <div class="absolute top-4 left-4 z-10">
                            <span class="text-[11px] font-bold text-white bg-black/30 backdrop-blur-sm px-3 py-1.5 rounded-lg uppercase tracking-wider">{{ $item->category ? $item->category->name : '-' }}</span>
                        </div>
                        <div class="absolute top-4 right-4 z-10">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-gray-800 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg border border-gray-100 shadow-sm">
                                <span class="w-1.5 h-1.5 bg-[#19A148] rounded-full"></span>
                                {{ $item->available_stock }} unit
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-[17px] font-bold text-gray-900 group-hover:text-[#19A148] transition-colors mb-2">{{ $item->name }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed flex-1 line-clamp-2">{{ $item->description }}</p>
                        <a href="{{ auth()->check() ? route('katalog') : route('login') }}" class="mt-5 w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-gray-50 group-hover:bg-[#19A148] text-sm font-bold rounded-xl text-gray-600 group-hover:text-white border border-gray-100 group-hover:border-[#19A148] transition-all duration-300">
                            {{ auth()->check() ? 'Lihat Detail' : 'Login untuk Pinjam' }}
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- PROGRAM BANTUAN SECTION                                      --}}
    {{-- ============================================================ --}}
    <section id="program" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal-section relative mb-14">
                <div class="text-center max-w-2xl mx-auto flex flex-col items-center">
                    <p class="text-[13px] font-bold uppercase tracking-[0.15em] text-[#19A148] mb-3">Program Bantuan</p>
                    <h2 class="text-3xl md:text-[2.5rem] font-black text-gray-900 tracking-tight leading-tight mb-3">Dukungan & Pendanaan Pertanian</h2>
                    <p class="text-gray-500 text-[16px] mb-6 md:mb-0">Informasi program bantuan dan pendanaan untuk kelompok tani tahun anggaran berjalan.</p>
                </div>
                <div class="md:absolute md:bottom-1 md:right-0 flex justify-center w-full md:w-auto">
                    <a href="{{ route('program') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-[#19A148] hover:text-[#148f3d]">
                        Lihat Semua
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @php
                $programs = [
                ['nama' => 'Bantuan Pupuk Subsidi & Bibit Unggul 2025', 'tipe' => 'Bantuan Permanen', 'buka' => '01 Mei 2025', 'tutup' => '30 Jun 2025', 'status' => 'Segera Buka', 'status_color' => 'text-amber-600 bg-amber-50 border-amber-100', 'dot_color' => 'bg-amber-500'],
                ['nama' => 'Pendanaan Pengembangan Irigasi Desa', 'tipe' => 'Usulan Pendanaan', 'buka' => '15 Mar 2025', 'tutup' => '15 Mei 2025', 'status' => 'Dibuka', 'status_color' => 'text-emerald-700 bg-emerald-50 border-emerald-100', 'dot_color' => 'bg-emerald-500'],
                ];
                @endphp

                @foreach($programs as $i => $program)
                <div class="{{ $i === 0 ? 'reveal-left' : 'reveal-right' }} reveal-delay-{{ $i + 1 }} group bg-white rounded-[1.5rem] p-7 border border-gray-100 hover:shadow-xl hover:shadow-gray-200/50 hover:-translate-y-1 hover:border-gray-200 transition-all duration-500 flex flex-col md:flex-row gap-6 justify-between items-start md:items-center">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg border text-[11px] font-bold uppercase tracking-wider {{ $program['status_color'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $program['dot_color'] }} animate-pulse"></span>
                                {{ $program['status'] }}
                            </span>
                            <span class="text-gray-500 text-[13px] font-semibold flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ $program['tipe'] }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#19A148] transition-colors leading-tight">{{ $program['nama'] }}</h3>
                        <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-gray-500">
                            <span class="flex items-center gap-1.5 font-medium">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Buka: <span class="text-gray-700">{{ $program['buka'] }}</span>
                            </span>
                            <span class="flex items-center gap-1.5 font-medium">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tutup: <span class="text-gray-700">{{ $program['tutup'] }}</span>
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('program') }}" class="w-full md:w-auto inline-flex justify-center items-center gap-2 px-6 py-3.5 bg-gray-50 group-hover:bg-[#19A148] text-sm font-bold rounded-xl text-gray-600 group-hover:text-white border border-gray-100 group-hover:border-[#19A148] transition-all duration-300 shrink-0">
                        Lihat Detail
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CARA KERJA / HOW IT WORKS                                    --}}
    {{-- ============================================================ --}}
    <section class="py-16 md:py-24 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal-section text-center max-w-xl mx-auto mb-20">
                <p class="text-[13px] font-bold uppercase tracking-[0.15em] text-[#19A148] mb-3">Cara Kerja</p>
                <h2 class="text-3xl md:text-[2.5rem] font-black text-gray-900 tracking-tight leading-tight">Empat langkah mudah untuk mengajukan proposal.</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-5 relative">
                {{-- Connecting line --}}
                <div class="hidden lg:block absolute top-10 left-[14%] right-[14%] h-[2px] bg-[#19A148] opacity-30"></div>

                @foreach([
                ['step' => '01', 'title' => 'Daftar Akun', 'desc' => 'Buat akun kelompok tani dan tunggu verifikasi.', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'active' => true],
                ['step' => '02', 'title' => 'Pilih Jenis', 'desc' => 'Pilih pengajuan alsintan atau program bantuan.', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'active' => true],
                ['step' => '03', 'title' => 'Ajukan Proposal', 'desc' => 'Isi formulir dan unggah dokumen pendukung.', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'active' => true],
                ['step' => '04', 'title' => 'Pantau & Terima', 'desc' => 'Pantau status secara real-time hingga persetujuan.', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'active' => true],
                ] as $i => $s)
                <div class="reveal-scale reveal-delay-{{ $i + 1 }} flex flex-col items-center text-center group transition-all duration-500 hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center transition-all duration-500 border {{ $s['active'] ? 'bg-[#19A148] border-[#19A148] shadow-lg shadow-[#19A148]/15 scale-105' : 'bg-gray-50 border-gray-100 group-hover:bg-[#19A148] group-hover:border-[#19A148] group-hover:shadow-lg group-hover:shadow-[#19A148]/15 group-hover:scale-105' }}">
                            <svg class="w-8 h-8 transition-all duration-500 group-hover:rotate-12 group-hover:scale-110 {{ $s['active'] ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $s['icon'] }}" />
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-7 h-7 rounded-lg bg-[#19A148] text-white text-[11px] font-black flex items-center justify-center shadow-md">{{ $s['step'] }}</div>
                    </div>
                    <h3 class="text-[15px] font-bold mb-1.5 transition-colors {{ $s['active'] ? 'text-[#19A148]' : 'text-gray-900 group-hover:text-[#19A148]' }}">{{ $s['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-[200px]">{{ $s['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>




    {{-- ============================================================ --}}
    {{-- CTA SECTION                                                  --}}
    {{-- ============================================================ --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal-scale relative overflow-hidden bg-gray-950 rounded-[2rem] p-10 md:p-16 shadow-2xl">
                {{-- Grid pattern --}}
                <div class="absolute inset-0 opacity-[0.04]">
                    <svg viewBox="0 0 400 400" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="cta-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                                <path d="M 32 0 L 0 0 0 32" fill="none" stroke="white" stroke-width="0.5" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#cta-grid)" />
                    </svg>
                </div>
                {{-- Glow --}}
                <div class="absolute top-0 right-0 w-96 h-96 bg-[#19A148]/20 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/3"></div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
                    <div class="max-w-md text-center lg:text-left">
                        <h2 class="text-3xl md:text-[2.25rem] font-black text-white tracking-tight leading-tight mb-4">Siap mengajukan proposal Anda?</h2>
                        <p class="text-white/50 text-[16px] leading-relaxed">Bergabunglah bersama ratusan kelompok tani yang telah merasakan kemudahan layanan digital ini.</p>
                    </div>
                    <div class="flex flex-col gap-3 shrink-0 w-full lg:w-auto">
                        @guest
                        <a href="{{ route('register') }}" class="group w-full lg:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-[#19A148] hover:bg-[#148f3d] text-white text-[15px] font-bold rounded-[14px] shadow-lg shadow-[#19A148]/30 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="w-full lg:w-auto inline-flex items-center justify-center px-8 py-4 bg-white/[0.07] hover:bg-white/[0.12] text-white/80 font-semibold rounded-[14px] border border-white/[0.08] hover:border-white/[0.15] transition-all">
                            Sudah punya akun? Masuk
                        </a>
                        @else
                        <a href="{{ route('dashboard') }}" class="group w-full lg:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-[#19A148] hover:bg-[#148f3d] text-white text-[15px] font-bold rounded-[14px] shadow-lg shadow-[#19A148]/30 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                            Buka Dashboard Saya
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- SCROLL REVEAL SCRIPT                                         --}}
    {{-- ============================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectors = '.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-section';
            const elements = document.querySelectorAll(selectors);

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.08,
                rootMargin: '0px 0px -50px 0px'
            });

            elements.forEach(el => observer.observe(el));
        });
    </script>

</x-layouts.public>