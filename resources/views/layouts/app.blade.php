<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Proposal DTPH') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .sidebar-link-active { @apply bg-primary-600 text-white shadow-md; }
            .sidebar-link { @apply text-gray-600 hover:bg-green-50 hover:text-primary-600 transition-colors; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F8FAFC] text-slate-900 antialiased overflow-hidden flex h-screen" x-data="{ mobileMenuOpen: false }">
        
        <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between hidden md:flex h-screen sticky top-0">
            <div class="flex-1 flex flex-col overflow-y-auto">
                <!-- Logo Section -->
                <div class="h-24 flex items-center px-8 border-b border-gray-50/50">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4">
                        <x-application-logo class="w-12 h-12 object-contain" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="p-6 space-y-8">
                    <!-- Menu Utama -->
                    <div>
                        <h3 class="text-[11px] font-extrabold text-[#94A3B8] uppercase tracking-[0.15em] mb-4 px-3">Menu Utama</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('dashboard') }}" 
                                   class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-[#19A148] text-white shadow-lg shadow-[#19A148]/30' : 'text-[#64748B] hover:bg-green-50 hover:text-[#19A148]' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>

                            @if(auth()->user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin.users.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-[#19A148] text-white shadow-lg shadow-[#19A148]/30' : 'text-[#64748B] hover:bg-green-50 hover:text-[#19A148]' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Verifikasi User
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.programs.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.programs.*') ? 'bg-[#19A148] text-white shadow-lg shadow-[#19A148]/30' : 'text-[#64748B] hover:bg-green-50 hover:text-[#19A148]' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        Manajemen Program
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="#" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm text-[#64748B] hover:bg-green-50 hover:text-[#19A148] transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        Katalog Alsintan
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('farmer.proposals.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('farmer.proposals.*') ? 'bg-[#19A148] text-white shadow-lg shadow-[#19A148]/30' : 'text-[#64748B] hover:bg-green-50 hover:text-[#19A148]' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Riwayat Pengajuan
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Akun -->
                    <div>
                        <h3 class="text-[11px] font-extrabold text-[#94A3B8] uppercase tracking-[0.15em] mb-4 px-3">Akun</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('profile.edit') ? 'bg-[#19A148] text-white shadow-lg shadow-[#19A148]/30' : 'text-[#64748B] hover:bg-green-50 hover:text-[#19A148]' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bottom User Info -->
            <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-[#19A148] border-2 border-white shadow-sm flex items-center justify-center font-extrabold text-white">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-[13px] text-[#1E293B] leading-tight">{{ auth()->user()->name }}</span>
                            <span class="text-[11px] text-[#94A3B8] font-bold capitalize">{{ auth()->user()->role ?? 'Kelompok Tani' }}</span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-[#94A3B8] hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">

            {{-- ===== MOBILE TOP NAVBAR (md:hidden) ===== --}}
            <header class="md:hidden bg-white border-b border-gray-100 flex items-center justify-between px-4 h-16 z-30 flex-shrink-0">
                {{-- Hamburger --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 p-1 rounded-lg hover:bg-gray-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="w-8 h-8 object-contain" />
                </a>

                {{-- Right: Bell + Avatar --}}
                <div class="flex items-center gap-3">
                    <button class="relative text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-[#19A148] text-white flex items-center justify-center font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- Mobile Left Drawer Overlay --}}
            {{-- Backdrop --}}
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition-opacity ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenuOpen = false"
                 class="md:hidden fixed inset-0 bg-black/50 z-40 backdrop-blur-sm"
                 x-cloak></div>

            {{-- Drawer Panel --}}
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="md:hidden fixed top-0 left-0 h-full w-72 bg-white z-50 flex flex-col shadow-2xl"
                 x-cloak>

                {{-- Drawer Header --}}
                <div class="bg-[#19A148] px-5 pt-10 pb-6">
                    <div class="flex items-center justify-between mb-5">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <x-application-logo class="w-8 h-8 object-contain" textColor="text-white" />
                        </a>
                        <button @click="mobileMenuOpen = false" class="text-white/70 hover:text-white p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-white/20 border-2 border-white/40 flex items-center justify-center font-extrabold text-white text-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-extrabold text-white text-sm leading-tight">{{ auth()->user()->name }}</div>
                            <div class="text-white/70 text-xs mt-0.5">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Kelompok Tani' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Drawer Nav Links --}}
                <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-3 mb-2">Menu Utama</p>
                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('dashboard') ? 'bg-[#19A148] text-white' : 'text-gray-600 hover:bg-green-50 hover:text-[#19A148]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Beranda
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.users.*') ? 'bg-[#19A148] text-white' : 'text-gray-600 hover:bg-green-50 hover:text-[#19A148]' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Verifikasi User
                        </a>
                        <a href="{{ route('admin.programs.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('admin.programs.*') ? 'bg-[#19A148] text-white' : 'text-gray-600 hover:bg-green-50 hover:text-[#19A148]' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Manajemen Program
                        </a>
                    @else
                        <a href="{{ route('farmer.proposals.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('farmer.proposals.*') ? 'bg-[#19A148] text-white' : 'text-gray-600 hover:bg-green-50 hover:text-[#19A148]' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Riwayat Usulan
                        </a>
                    @endif

                    <div class="border-t border-gray-100 my-2 pt-2">
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-3 mb-2">Akun</p>
                        <a href="{{ route('profile.edit') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('profile.edit') ? 'bg-[#19A148] text-white' : 'text-gray-600 hover:bg-green-50 hover:text-[#19A148]' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                    </div>
                </nav>

                {{-- Drawer Footer: Logout --}}
                <div class="p-4 border-t border-gray-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm text-red-500 hover:bg-red-50 w-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Keluar dari Akun
                        </button>
                    </form>
                </div>
            </div>

            {{-- ===== DESKTOP TOP NAVBAR (hidden on mobile) ===== --}}
            <header class="hidden md:flex h-20 bg-white border-b border-gray-100 items-center justify-between px-8 z-10">
                <div>
                    <h1 class="font-extrabold text-xl text-gray-800">{{ $header ?? 'Dashboard' }}</h1>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">Dinas Tanaman Pangan dan Hortikultura</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <button class="text-gray-400 hover:text-primary-600 relative">
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>

                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-primary-500 text-white flex items-center justify-center font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <div class="font-bold text-sm text-gray-800 leading-tight">{{ auth()->user()->name }}</div>
                            <div class="text-[11px] text-gray-500 capitalize">{{ auth()->user()->role ?? 'Kelompok Tani' }}</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </header>

            <!-- Page Content scrollable -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8 pb-24 md:pb-8">
                {{ $slot }}
            </div>

            {{-- ===== MOBILE BOTTOM NAVBAR (md:hidden) ===== --}}
            @if(!auth()->user()->isAdmin())
            <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-30 flex items-center justify-around px-4 h-16 shadow-[0_-4px_20px_rgba(0,0,0,0.07)]">
                {{-- Beranda --}}
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-0.5 min-w-0 flex-1">
                    <svg class="w-6 h-6 {{ request()->routeIs('dashboard') ? 'text-[#19A148]' : 'text-gray-400' }}" 
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-[10px] font-bold {{ request()->routeIs('dashboard') ? 'text-[#19A148]' : 'text-gray-400' }}">Beranda</span>
                </a>

                {{-- FAB Ajukan (centre) --}}
                <a href="{{ route('farmer.proposals.index') }}" class="flex flex-col items-center flex-1 -mt-6">
                    <div class="w-14 h-14 rounded-full bg-[#19A148] flex items-center justify-center shadow-lg shadow-green-200 border-4 border-white">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-[#19A148] mt-0.5">Ajukan</span>
                </a>

                {{-- Profil --}}
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-0.5 min-w-0 flex-1">
                    <svg class="w-6 h-6 {{ request()->routeIs('profile.*') ? 'text-[#19A148]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-[10px] font-bold {{ request()->routeIs('profile.*') ? 'text-[#19A148]' : 'text-gray-400' }}">Profil</span>
                </a>
            </nav>
            @endif

        </main>
    </body>
</html>
