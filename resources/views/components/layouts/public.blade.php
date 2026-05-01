<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Portal Publik E-Proposal Alsintan Dinas Tanaman Pangan dan Hortikultura.' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Beranda' }} — E-Proposal Alsintan DTPH</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite: Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{ $head ?? '' }}
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">    {{-- PUBLIC NAVBAR --}}
    <header class="fixed top-0 inset-x-0 z-50 bg-white shadow-sm border-b border-gray-100" x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-[1400px] xl:max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">
            {{-- Main Top Navbar --}}
            <div class="flex items-center justify-between h-16 md:h-20">
                {{-- Left Section: Hamburger & Logo --}}
                <div class="flex items-center gap-3 lg:gap-0 lg:flex-1">
                    {{-- Hamburger Button (Mobile Only) --}}
                    <div class="lg:hidden flex items-center">
                        <button @click="mobileMenuOpen = true" class="text-gray-600 hover:text-primary-600 p-2 -ml-2 focus:outline-none transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Logo --}}
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}">
                            <x-application-logo class="w-9 h-9 md:w-11 md:h-11 object-contain" />
                        </a>
                    </div>
                </div>

                {{-- Desktop Menu (Desktop Right) --}}
                <nav class="hidden lg:flex flex-1 justify-end gap-5 items-center">
                    <a href="{{ route('home') }}" class="text-sm font-bold text-gray-800 hover:text-primary-600 transition">Beranda</a>
                    
                    {{-- Dropdown Profil --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center gap-1 text-sm font-bold text-gray-600 hover:text-primary-600 transition py-2">
                            Profil
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity.duration.200ms class="absolute left-0 top-full w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50" x-cloak>
                            <a href="{{ route('profil.overview') }}" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Overview</a>
                            <a href="{{ route('profil.visi-misi') }}" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Visi &amp; Misi</a>
                            <a href="{{ route('profil.struktur-organisasi') }}" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Struktur Organisasi</a>
                            <a href="{{ route('profil.tugas-fungsi') }}" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Tugas &amp; Fungsi</a>
                            <a href="{{ route('profil.satuan-kerja') }}" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Satuan Kerja</a>
                        </div>
                    </div>

                    {{-- Dropdown Informasi Publik --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center gap-1 text-sm font-bold text-gray-600 hover:text-primary-600 transition py-2 whitespace-nowrap">
                            Informasi Publik
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity.duration.200ms class="absolute left-0 top-full w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50" x-cloak>
                            <a href="{{ route('informasi.berita-artikel') }}" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Berita &amp; Artikel</a>
                            <a href="#" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Galeri Kegiatan</a>
                            <a href="#" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Pengumuman</a>
                            <a href="#" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Unduh Dokumen</a>
                        </div>
                    </div>

                    <a href="#katalog-alsintan" class="text-sm font-bold text-gray-600 hover:text-primary-600 transition whitespace-nowrap">Katalog Alsintan</a>
                    <a href="#program-bantuan" class="text-sm font-bold text-gray-600 hover:text-primary-600 transition">Program</a>
                    <a href="#" class="text-sm font-bold text-gray-600 hover:text-primary-600 transition">Kontak</a>

                    <div class="h-6 w-px bg-gray-200 mx-1"></div>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold bg-primary-600 text-white px-5 py-2.5 rounded-xl hover:bg-primary-700 shadow-lg shadow-primary-600/30 transition-all hover:-translate-y-0.5 active:scale-95">Daftar</a>
                </nav>

                {{-- Mobile Action Buttons (Right) --}}
                <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
                    <a href="{{ route('login') }}" class="text-xs sm:text-sm font-bold sm:font-semibold text-gray-700 px-2 sm:px-0 py-2 sm:py-0 hover:bg-gray-50 sm:hover:bg-transparent rounded-lg sm:hover:text-primary-600 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-xs sm:text-sm font-bold bg-primary-600 text-white px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg sm:rounded-xl shadow-md sm:shadow-lg sm:shadow-primary-600/30 hover:bg-primary-700 transition-all sm:hover:-translate-y-0.5 active:scale-95">Daftar</a>
                </div>
            </div>
        </div>

        {{-- Mobile Hamburger Slide-over Menu --}}
        <div x-show="mobileMenuOpen" class="lg:hidden fixed inset-0 z-50" x-cloak>
            {{-- Overlay --}}
            <div x-show="mobileMenuOpen" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>
            
            {{-- Menu Content --}}
            <nav x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 w-[85%] max-w-sm bg-white shadow-2xl overflow-y-auto z-50 flex flex-col">
                
                {{-- Header Slide-over --}}
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white/90 backdrop-blur-md z-10">
                    <x-application-logo class="w-8 h-8 object-contain" />
                    <button @click="mobileMenuOpen = false" class="text-gray-400 hover:text-red-500 focus:outline-none bg-gray-50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                {{-- Menu Links --}}
                <div class="px-5 py-6 space-y-3 flex-1">
                    <a href="{{ route('home') }}" class="block px-4 py-3.5 text-sm font-bold text-gray-800 rounded-xl hover:bg-primary-50 hover:text-primary-700 transition-colors">Beranda</a>
                    
                    {{-- Profil Accordion --}}
                    <div x-data="{ openProfil: false }" class="rounded-xl overflow-hidden">
                        <button @click="openProfil = !openProfil" class="w-full flex items-center justify-between px-4 py-3.5 text-sm font-bold text-gray-800 hover:bg-primary-50 transition-colors" :class="openProfil ? 'bg-primary-50 text-primary-700' : ''">
                            Profil
                            <svg :class="{'rotate-180': openProfil}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openProfil" x-collapse class="bg-gray-50 px-4 py-2" x-cloak>
                            <a href="{{ route('profil.overview') }}" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Overview</a>
                            <a href="{{ route('profil.visi-misi') }}" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Visi &amp; Misi</a>
                            <a href="{{ route('profil.struktur-organisasi') }}" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Struktur Organisasi</a>
                            <a href="{{ route('profil.tugas-fungsi') }}" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Tugas &amp; Fungsi</a>
                            <a href="{{ route('profil.satuan-kerja') }}" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Satuan Kerja</a>
                        </div>
                    </div>

                    {{-- Informasi Publik Accordion --}}
                    <div x-data="{ openInfo: false }" class="rounded-xl overflow-hidden">
                        <button @click="openInfo = !openInfo" class="w-full flex items-center justify-between px-4 py-3.5 text-sm font-bold text-gray-800 hover:bg-primary-50 transition-colors" :class="openInfo ? 'bg-primary-50 text-primary-700' : ''">
                            Informasi Publik
                            <svg :class="{'rotate-180': openInfo}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openInfo" x-collapse class="bg-gray-50 px-4 py-2" x-cloak>
                            <a href="{{ route('informasi.berita-artikel') }}" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Berita &amp; Artikel</a>
                            <a href="#" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Galeri Kegiatan</a>
                            <a href="#" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Pengumuman</a>
                            <a href="#" class="block py-2.5 text-sm font-medium text-gray-600 hover:text-primary-600">Unduh Dokumen</a>
                        </div>
                    </div>

                    <a href="#katalog-alsintan" @click="mobileMenuOpen = false" class="block px-4 py-3.5 text-sm font-bold text-gray-800 rounded-xl hover:bg-primary-50 transition-colors">Katalog Alsintan</a>
                    <a href="#program-bantuan" @click="mobileMenuOpen = false" class="block px-4 py-3.5 text-sm font-bold text-gray-800 rounded-xl hover:bg-primary-50 transition-colors">Program Bantuan</a>
                    <a href="#" @click="mobileMenuOpen = false" class="block px-4 py-3.5 text-sm font-bold text-gray-800 rounded-xl hover:bg-primary-50 transition-colors">Kontak</a>
                </div>
            </nav>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="pt-16 md:pt-20 min-h-screen">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="relative bg-gray-950 text-gray-400 overflow-hidden mt-20">

        {{-- Decorative background blobs --}}
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-emerald-900/20 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-emerald-800/10 rounded-full blur-[100px] translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

        {{-- Top accent line --}}
        <div class="h-1 w-full bg-gradient-to-r from-transparent via-emerald-500 to-transparent opacity-60"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10">

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-12 border-b border-white/5">

                {{-- Brand Column --}}
                <div class="lg:col-span-1 space-y-6">
                    <a href="{{ route('home') }}" class="inline-flex">
                        <x-application-logo class="w-10 h-10 object-contain" textColor="text-white" />
                    </a>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi — menghadirkan layanan pertanian modern yang transparan, tepat sasaran, dan berpihak pada petani.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-emerald-600 flex items-center justify-center transition-all duration-300 group/icon hover:-translate-y-1" title="Facebook">
                            <svg class="w-4 h-4 text-gray-400 group-hover/icon:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-emerald-600 flex items-center justify-center transition-all duration-300 group/icon hover:-translate-y-1" title="Instagram">
                            <svg class="w-4 h-4 text-gray-400 group-hover/icon:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-emerald-600 flex items-center justify-center transition-all duration-300 group/icon hover:-translate-y-1" title="YouTube">
                            <svg class="w-4 h-4 text-gray-400 group-hover/icon:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Navigasi Profil --}}
                <div class="space-y-5">
                    <h4 class="text-white text-xs font-black uppercase tracking-[0.15em]">Profil Dinas</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('profil.overview') }}" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Overview</a></li>
                        <li><a href="{{ route('profil.visi-misi') }}" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Visi &amp; Misi</a></li>
                        <li><a href="{{ route('profil.struktur-organisasi') }}" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Struktur Organisasi</a></li>
                        <li><a href="{{ route('profil.tugas-fungsi') }}" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Tugas &amp; Fungsi</a></li>
                        <li><a href="{{ route('profil.satuan-kerja') }}" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Satuan Kerja</a></li>
                    </ul>
                </div>

                {{-- Layanan & Info --}}
                <div class="space-y-5">
                    <h4 class="text-white text-xs font-black uppercase tracking-[0.15em]">Layanan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>E-Proposal Alsintan</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Katalog Alsintan</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Program Bantuan</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Berita &amp; Artikel</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-700 group-hover:bg-emerald-400 transition-colors flex-shrink-0"></span>Unduh Dokumen</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div class="space-y-5">
                    <h4 class="text-white text-xs font-black uppercase tracking-[0.15em]">Kontak Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-7 h-7 rounded-lg bg-emerald-900/50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p class="text-xs text-gray-500 leading-relaxed">Jl. Lintas Timur, Sengeti, Kec. Sekernan, Kab. Muaro Jambi</p>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-900/50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <a href="tel:+62741571234" class="text-xs text-gray-500 hover:text-emerald-400 transition-colors">(0741) 57-1234</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-900/50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <a href="mailto:dtph@muarojambikab.go.id" class="text-xs text-gray-500 hover:text-emerald-400 transition-colors">dtph@muarojambikab.go.id</a>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-7 h-7 rounded-lg bg-emerald-900/50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Senin – Kamis: 07.30–16.00</p>
                                <p class="text-xs text-gray-500">Jumat: 07.30–11.30 WIB</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-[11px] text-gray-600 text-center sm:text-left">
                    &copy; {{ date('Y') }} Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi. Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-5">
                    <a href="#" class="text-[11px] text-gray-600 hover:text-emerald-400 transition-colors">Kebijakan Privasi</a>
                    <span class="text-gray-700">·</span>
                    <a href="#" class="text-[11px] text-gray-600 hover:text-emerald-400 transition-colors">Syarat &amp; Ketentuan</a>
                    <span class="text-gray-700">·</span>
                    <a href="#" class="text-[11px] text-gray-600 hover:text-emerald-400 transition-colors">Peta Situs</a>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
