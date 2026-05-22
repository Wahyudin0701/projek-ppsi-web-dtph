<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Portal DTPH Muaro Jambi — Layanan digital Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi.' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Beranda' }} — Portal DTPH Muaro Jambi</title>

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
                            <x-application-logo imgClass="h-9 md:h-11" />
                        </a>
                    </div>
                </div>

                {{-- Desktop Menu (Desktop Right) --}}
                <nav class="hidden lg:flex flex-1 justify-end gap-5 items-center">
                    <a href="{{ route('home') }}" class="text-sm font-bold transition {{ request()->routeIs('home') ? 'text-primary-600' : 'text-gray-800 hover:text-primary-600' }}">Beranda</a>
                    
                    {{-- Dropdown Profil --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center gap-1 text-sm font-bold transition py-2 {{ request()->routeIs('profil.*') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                            Profil
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity.duration.200ms class="absolute left-0 top-full w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50" x-cloak>
                            <a href="{{ route('profil.overview') }}" class="block px-5 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.overview') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">Overview</a>
                            <a href="{{ route('profil.visi-misi') }}" class="block px-5 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.visi-misi') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">Visi &amp; Misi</a>
                            <a href="{{ route('profil.struktur-organisasi') }}" class="block px-5 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.struktur-organisasi') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">Struktur Organisasi</a>
                            <a href="{{ route('profil.tugas-fungsi') }}" class="block px-5 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.tugas-fungsi') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">Tugas &amp; Fungsi</a>
                            <a href="{{ route('profil.satuan-kerja') }}" class="block px-5 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.satuan-kerja') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">Satuan Kerja</a>
                        </div>
                    </div>

                    {{-- Dropdown Informasi Publik --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center gap-1 text-sm font-bold transition py-2 whitespace-nowrap {{ request()->routeIs('informasi.*') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                            Informasi Publik
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity.duration.200ms class="absolute left-0 top-full w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50" x-cloak>
                            <a href="{{ route('informasi.berita-artikel') }}" class="block px-5 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('informasi.berita-artikel') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">Berita &amp; Artikel</a>
                            <a href="{{ route('informasi.unduh-dokumen') }}" class="block px-5 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('informasi.unduh-dokumen') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">Unduh Dokumen</a>
                            <a href="{{ route('informasi.faq') }}" class="block px-5 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('informasi.faq') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">FAQ (Tanya Jawab)</a>
                        </div>
                    </div>

                    <a href="{{ route('katalog') }}" class="text-sm font-bold transition whitespace-nowrap {{ request()->routeIs('katalog') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">Katalog Alsintan</a>
                    <a href="{{ route('program') }}" class="text-sm font-bold transition whitespace-nowrap {{ request()->routeIs('program') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">Program Bantuan</a>
                    <a href="{{ route('kontak') }}" class="text-sm font-bold transition {{ request()->routeIs('kontak') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">Kontak</a>

                    <div class="h-6 w-px bg-gray-200 mx-1"></div>
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition">Masuk</a>
                        <div class="relative ml-2" x-data="{ regisOpen: false }" @click.away="regisOpen = false" @mouseenter="regisOpen = true" @mouseleave="regisOpen = false">
                            <button class="text-sm font-bold bg-primary-600 text-white px-5 py-2.5 rounded-xl hover:bg-primary-700 shadow-lg shadow-primary-600/30 transition-all flex items-center gap-1">
                                Daftar
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="regisOpen" x-transition.opacity.duration.200ms class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50" x-cloak>
                                <a href="{{ route('register', ['role' => 'petani']) }}" class="block px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">Sebagai Kelompok Tani</a>
                                <a href="{{ route('register', ['role' => 'umum']) }}" class="block px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">Sebagai Umum</a>
                            </div>
                        </div>
                    @else
                        @php
                            $userAvatarBg = match(true) {
                                auth()->user()->isPimpinan() => 'bg-indigo-600',
                                auth()->user()->isKabid() => 'bg-amber-600',
                                default => 'bg-[#19A148]'
                            };
                        @endphp
                        {{-- Profile Dropdown --}}
                        <div class="relative ml-2" x-data="{ userOpen: false }" @click.away="userOpen = false">
                            <button @click="userOpen = !userOpen" class="flex items-center gap-2 p-1 rounded-2xl hover:bg-gray-50 transition-all border border-transparent hover:border-gray-100 group">
                                <div class="w-10 h-10 rounded-full {{ $userAvatarBg }} text-white flex items-center justify-center font-bold text-lg shadow-sm group-hover:shadow-md transition-all">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" :class="userOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="userOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                 class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden" 
                                 x-cloak>
                                <div class="px-5 py-3 border-b border-gray-50 mb-1">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mt-0.5">{{ auth()->user()->roleLabel }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Edit Profil
                                </a>
                                <div class="my-1 border-t border-gray-50"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-2.5 text-sm text-red-600 hover:bg-red-50 font-bold transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </nav>

                {{-- Mobile Action Buttons (Right) --}}
                <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
                    @guest
                        <a href="{{ route('login') }}" class="text-xs sm:text-sm font-bold sm:font-semibold text-gray-700 px-2 sm:px-0 py-2 sm:py-0 hover:bg-gray-50 sm:hover:bg-transparent rounded-lg sm:hover:text-primary-600 transition">Masuk</a>
                        <div class="relative" x-data="{ mobRegisOpen: false }" @click.away="mobRegisOpen = false">
                            <button @click="mobRegisOpen = !mobRegisOpen" class="text-xs sm:text-sm font-bold bg-primary-600 text-white px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg sm:rounded-xl shadow-md sm:shadow-lg sm:shadow-primary-600/30 hover:bg-primary-700 transition-all flex items-center gap-1">
                                Daftar
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="mobRegisOpen" x-transition.opacity.scale.80 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50" x-cloak>
                                <a href="{{ route('register', ['role' => 'petani']) }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">Kelompok Tani</a>
                                <a href="{{ route('register', ['role' => 'umum']) }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">Umum</a>
                            </div>
                        </div>
                    @else
                        {{-- Mobile Profile Avatar --}}
                        <div class="relative" x-data="{ mobileUserOpen: false }" @click.away="mobileUserOpen = false">
                            <button @click="mobileUserOpen = !mobileUserOpen" class="w-10 h-10 rounded-full {{ $userAvatarBg }} text-white flex items-center justify-center font-bold shadow-md active:scale-90 transition-all border-2 border-white ring-1 ring-gray-100">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </button>
                            
                            <div x-show="mobileUserOpen" 
                                 x-transition.opacity.scale.80
                                 class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50 overflow-hidden" 
                                 x-cloak>
                                <a href="{{ route('dashboard') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-bold">Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-bold">Profil Saya</a>
                                <div class="border-t border-gray-50 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-5 py-3 text-sm text-red-600 font-black hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
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
                    <x-application-logo imgClass="h-8" />
                    <button @click="mobileMenuOpen = false" class="text-gray-400 hover:text-red-500 focus:outline-none bg-gray-50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                {{-- Menu Links --}}
                <div class="px-5 py-6 space-y-3 flex-1">
                    <a href="{{ route('home') }}" class="block px-4 py-3.5 text-sm font-bold rounded-xl transition-colors {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-700' : 'text-gray-800 hover:bg-primary-50 hover:text-primary-700' }}">Beranda</a>
                    
                    {{-- Profil Accordion --}}
                    <div x-data="{ openProfil: false }" class="rounded-xl overflow-hidden">
                        <button @click="openProfil = !openProfil" class="w-full flex items-center justify-between px-4 py-3.5 text-sm font-bold transition-colors {{ request()->routeIs('profil.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-800 hover:bg-primary-50' }}" :class="openProfil ? 'bg-primary-50 text-primary-700' : ''">
                            Profil
                            <svg :class="{'rotate-180': openProfil}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openProfil" x-collapse class="bg-gray-50 px-4 py-2" x-cloak>
                            <a href="{{ route('profil.overview') }}" class="block py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.overview') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">Overview</a>
                            <a href="{{ route('profil.visi-misi') }}" class="block py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.visi-misi') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">Visi &amp; Misi</a>
                            <a href="{{ route('profil.struktur-organisasi') }}" class="block py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.struktur-organisasi') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">Struktur Organisasi</a>
                            <a href="{{ route('profil.tugas-fungsi') }}" class="block py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.tugas-fungsi') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">Tugas &amp; Fungsi</a>
                            <a href="{{ route('profil.satuan-kerja') }}" class="block py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('profil.satuan-kerja') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">Satuan Kerja</a>
                        </div>
                    </div>

                    {{-- Informasi Publik Accordion --}}
                    <div x-data="{ openInfo: false }" class="rounded-xl overflow-hidden">
                        <button @click="openInfo = !openInfo" class="w-full flex items-center justify-between px-4 py-3.5 text-sm font-bold transition-colors {{ request()->routeIs('informasi.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-800 hover:bg-primary-50' }}" :class="openInfo ? 'bg-primary-50 text-primary-700' : ''">
                            Informasi Publik
                            <svg :class="{'rotate-180': openInfo}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openInfo" x-collapse class="bg-gray-50 px-4 py-2" x-cloak>
                            <a href="{{ route('informasi.berita-artikel') }}" class="block py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('informasi.berita-artikel') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">Berita &amp; Artikel</a>
                            <a href="{{ route('informasi.unduh-dokumen') }}" class="block py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('informasi.unduh-dokumen') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">Unduh Dokumen</a>
                            <a href="{{ route('informasi.faq') }}" class="block py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('informasi.faq') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-600' }}">FAQ (Tanya Jawab)</a>
                        </div>
                    </div>

                    <a href="{{ route('katalog') }}" @click="mobileMenuOpen = false" class="block px-4 py-3.5 text-sm font-bold rounded-xl transition-colors {{ request()->routeIs('katalog') ? 'bg-primary-50 text-primary-700' : 'text-gray-800 hover:bg-primary-50' }}">Katalog Alsintan</a>
                    <a href="{{ route('program') }}" @click="mobileMenuOpen = false" class="block px-4 py-3.5 text-sm font-bold rounded-xl transition-colors {{ request()->routeIs('program') ? 'bg-primary-50 text-primary-700' : 'text-gray-800 hover:bg-primary-50' }}">Program Bantuan</a>
                    <a href="{{ route('kontak') }}" @click="mobileMenuOpen = false" class="block px-4 py-3.5 text-sm font-bold rounded-xl transition-colors {{ request()->routeIs('kontak') ? 'bg-primary-50 text-primary-700' : 'text-gray-800 hover:bg-primary-50' }}">Kontak</a>
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
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-primary-900/20 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-primary-800/10 rounded-full blur-[100px] translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

        {{-- Top accent line --}}
        <div class="h-1 w-full bg-gradient-to-r from-transparent via-primary-500 to-transparent opacity-60"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10">

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-12 border-b border-white/5">

                {{-- Brand Column --}}
                <div class="lg:col-span-1 space-y-6">
                    <a href="{{ route('home') }}" class="inline-flex">
                        <x-application-logo imgClass="h-10" textColor="text-white" />
                    </a>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi — menghadirkan layanan pertanian modern yang transparan, tepat sasaran, dan berpihak pada petani.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 group/icon hover:-translate-y-1" title="Facebook">
                            <svg class="w-4 h-4 text-gray-400 group-hover/icon:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 group/icon hover:-translate-y-1" title="Instagram">
                            <svg class="w-4 h-4 text-gray-400 group-hover/icon:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 group/icon hover:-translate-y-1" title="YouTube">
                            <svg class="w-4 h-4 text-gray-400 group-hover/icon:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Navigasi Profil --}}
                <div class="space-y-5">
                    <h4 class="text-white text-xs font-black uppercase tracking-[0.15em]">Profil Dinas</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('profil.overview') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Overview</a></li>
                        <li><a href="{{ route('profil.visi-misi') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Visi &amp; Misi</a></li>
                        <li><a href="{{ route('profil.struktur-organisasi') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Struktur Organisasi</a></li>
                        <li><a href="{{ route('profil.tugas-fungsi') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Tugas &amp; Fungsi</a></li>
                        <li><a href="{{ route('profil.satuan-kerja') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Satuan Kerja</a></li>
                    </ul>
                </div>

                {{-- Layanan & Info --}}
                <div class="space-y-5">
                    <h4 class="text-white text-xs font-black uppercase tracking-[0.15em]">Layanan</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Portal DTPH Muaro Jambi</a></li>
                        <li><a href="{{ route('katalog') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Katalog Alsintan</a></li>
                        {{-- <li><a href="{{ route('program') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Program Bantuan</a></li> --}}
                        <li><a href="{{ route('informasi.berita-artikel') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Berita &amp; Artikel</a></li>
                        <li><a href="{{ route('informasi.unduh-dokumen') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>Unduh Dokumen</a></li>
                        <li><a href="{{ route('informasi.faq') }}" class="text-sm text-gray-500 hover:text-primary-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>FAQ (Tanya Jawab)</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div class="space-y-5">
                    <h4 class="text-white text-xs font-black uppercase tracking-[0.15em]">Kontak Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-7 h-7 rounded-lg bg-primary-900/50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p class="text-xs text-gray-500 leading-relaxed">Komplek Perkantoran Bukit Cinto Kenang, Sengeti, Muaro Jambi 36381</p>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-primary-900/50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <a href="tel:+62741123456" class="text-xs text-gray-500 hover:text-primary-400 transition-colors">(0741) 123456</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-primary-900/50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <a href="mailto:kontak@dtph-muarojambi.go.id" class="text-xs text-gray-500 hover:text-primary-400 transition-colors">kontak@dtph-muarojambi.go.id</a>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-7 h-7 rounded-lg bg-primary-900/50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Senin – Jumat</p>
                                <p class="text-[10px] text-primary-500 font-bold uppercase">08.00 – 16.00 WIB</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-[11px] text-gray-600 text-center sm:text-left">
                    &copy; {{ date('Y') }} Portal DTPH Muaro Jambi — Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi. Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-5">
                    <a href="#" class="text-[11px] text-gray-600 hover:text-primary-400 transition-colors">Kebijakan Privasi</a>
                    <span class="text-gray-700">·</span>
                    <a href="#" class="text-[11px] text-gray-600 hover:text-primary-400 transition-colors">Syarat &amp; Ketentuan</a>
                    <span class="text-gray-700">·</span>
                    <a href="#" class="text-[11px] text-gray-600 hover:text-primary-400 transition-colors">Peta Situs</a>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
