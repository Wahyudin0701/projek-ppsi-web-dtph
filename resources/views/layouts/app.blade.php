<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Portal DTPH Muaro Jambi') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            
            /* Hide scrollbar for sidebar */
            .hide-scrollbar {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }
            .hide-scrollbar::-webkit-scrollbar {
                display: none; /* Chrome, Safari and Opera */
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="bg-[#F8FAFC] text-slate-900 antialiased overflow-hidden flex h-screen" x-data="{ mobileMenuOpen: false }">
        @php
            $roleColor = match(true) {
                auth()->user()->hasRole('super_admin') => [
                    'active' => 'bg-gray-900 text-white',
                    'hover'  => 'text-[#64748B] hover:bg-gray-100 hover:text-gray-900',
                    'avatar' => 'bg-gray-900',
                    'bg'     => 'bg-gray-900'
                ],
                auth()->user()->isAdmin() => [
                    'active' => 'bg-blue-600 text-white',
                    'hover'  => 'text-[#64748B] hover:bg-blue-50 hover:text-blue-600',
                    'avatar' => 'bg-blue-600',
                    'bg'     => 'bg-blue-600'
                ],
                auth()->user()->isPimpinan() => [
                    'active' => 'bg-indigo-600 text-white',
                    'hover'  => 'text-[#64748B] hover:bg-indigo-50 hover:text-indigo-600',
                    'avatar' => 'bg-indigo-600',
                    'bg'     => 'bg-indigo-600'
                ],
                auth()->user()->isKabid() => [
                    'active' => 'bg-amber-600 text-white',
                    'hover'  => 'text-[#64748B] hover:bg-amber-50 hover:text-amber-600',
                    'avatar' => 'bg-amber-600',
                    'bg'     => 'bg-amber-600'
                ],
                default => [
                    'active' => 'bg-[#19A148] text-white',
                    'hover'  => 'text-[#64748B] hover:bg-green-50 hover:text-[#19A148]',
                    'avatar' => 'bg-[#19A148]',
                    'bg'     => 'bg-[#19A148]'
                ]
            };
        @endphp
        
        <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between hidden lg:flex h-screen sticky top-0">
            <!-- Logo Section (Fixed at Top) -->
            <div class="h-24 flex items-center px-8 border-b border-gray-50/50 flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-4">
                    <x-application-logo imgClass="h-12" />
                </a>
            </div>

            <!-- Scrollable Navigation Links -->
            <div class="flex-1 flex flex-col overflow-y-auto hide-scrollbar">
                <div class="p-6 space-y-6">
                    {{-- Global Link --}}
                    @if(auth()->user()->isPetani() || auth()->user()->isUmum())
                    <ul class="space-y-2 mb-6">
                        <li>
                            <a href="{{ route('home') }}" 
                               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ $roleColor['hover'] }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                Beranda
                            </a>
                        </li>
                    </ul>
                    @endif

                    @unless(auth()->user()->isPimpinan() || auth()->user()->isKabid())
                    <ul class="space-y-2 mb-6">
                        <li>
                            <a href="{{ route('dashboard') }}" 
                            class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('dashboard') ? $roleColor['active'] : $roleColor['hover'] }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                    @endunless

                    @if(auth()->user()->hasRole('super_admin'))
                    <div class="mb-6">
                        <h3 class="text-[11px] font-extrabold text-[#94A3B8] uppercase tracking-[0.15em] mb-4 px-3">Super Admin</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('super-admin.users.index') }}" 
                                   class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('super-admin.users.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Manajemen Role
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('super-admin.audit-logs.index') }}" 
                                   class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('super-admin.audit-logs.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Audit Trail
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('super-admin.settings.edit') }}" 
                                   class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('super-admin.settings.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Latar Belakang Web
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('super-admin.backups.index') }}" 
                                   class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('super-admin.backups.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                    Kelola Backup
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif

                    <!-- Menu Utama -->
                    <div>
                        <h3 class="text-[11px] font-extrabold text-[#94A3B8] uppercase tracking-[0.15em] mb-4 px-3">Menu Utama</h3>
                        <ul class="space-y-2">

                            @if(auth()->user()->isAdmin())
                                @php
                                    $isUserShow = request()->routeIs('admin.users.show');
                                    $currentUser = $isUserShow ? request()->route('user') : null;
                                    $isPendingVerif = $currentUser && $currentUser->farmerProfile && in_array($currentUser->farmerProfile->status, ['menunggu', 'reviewed']);
                                    $isMasterList = $currentUser && (!$currentUser->farmerProfile || in_array($currentUser->farmerProfile->status, ['approved', 'rejected']));
                                    $pendingUserVerificationsCount = \App\Models\User::where('role', 'petani')
                                        ->whereHas('farmerProfile', function ($query) {
                                            $query->whereIn('status', ['menunggu', 'reviewed', 'pengajuan_revisi']);
                                        })->count();
                                @endphp
                                <li>
                                    <a href="{{ route('admin.users.kelompok-tani') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ (request()->routeIs('admin.users.kelompok-tani') || request()->routeIs('admin.users.umum') || ($isUserShow && $isMasterList)) ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        Daftar User
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.users.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ (request()->routeIs('admin.users.index') || ($isUserShow && $isPendingVerif)) ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="truncate">Verifikasi User</span>
                                        @if($pendingUserVerificationsCount > 0)
                                            <span class="ml-auto bg-yellow-400 text-yellow-900 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pendingUserVerificationsCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.proposals.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.proposals.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                        Kelola Proposal
                                        @php $pendingCount = \App\Models\Proposal::where('status', 'sedang_diverifikasi_admin')->count(); @endphp
                                        @if($pendingCount > 0)
                                            <span class="ml-auto bg-yellow-400 text-yellow-900 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.programs.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.programs.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122"/>
                                        </svg>
                                        Manajemen Program
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.alsintan.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.alsintan.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h9l1 7M4 11V4M8 10V4M18 5c-.6 0-1 .4-1 1v5.6m-7-.6 11 .9c.6 0 1 .5 1 1.1v.5c0 1.7-1.3 3-3 3h-1.4"/>
                                            <circle cx="7" cy="15" r="5" stroke-width="2"/>
                                            <circle cx="18" cy="18" r="2" stroke-width="2"/>
                                        </svg>
                                        Manajemen Alsintan
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.employees.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.employees.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Kelola Pegawai
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.surat.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.surat.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Kelola Surat
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.contacts.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.contacts.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Kelola Kontak
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Menu Konten Beranda -->
                        <div class="mt-8">
                            <h3 class="text-[11px] font-extrabold text-[#94A3B8] uppercase tracking-[0.15em] mb-4 px-3">Konten Beranda</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('admin.articles.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.articles.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                        Kelola Berita & Artikel
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.documents.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.documents.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Kelola Unduhan Dokumen
                                    </a>

                                </li>
                                <li>
                                    <a href="{{ route('admin.satuan-kerja.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.satuan-kerja.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Kelola Satuan Kerja
                                    </a>
                                </li>

                            @elseif(auth()->user()->isPimpinan())
                                <li>
                                    <a href="{{ route('pimpinan.dashboard') }}"
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('pimpinan.dashboard') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        Dashboard Pimpinan
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pimpinan.proposals.index') }}"
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('pimpinan.proposals.index') || request()->routeIs('pimpinan.proposals.show') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                        Tinjau Proposal
                                        @php $pimpinanPending = \App\Models\Proposal::whereIn('status', ['sedang_diverifikasi_pimpinan', 'menunggu_keputusan_akhir'])->count(); @endphp
                                        @if($pimpinanPending > 0)
                                            <span class="ml-auto bg-indigo-200 text-indigo-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pimpinanPending }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pimpinan.proposals.archives') }}"
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('pimpinan.proposals.archives') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                        Semua Proposal
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pimpinan.reports') }}"
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('pimpinan.reports') || request()->routeIs('pimpinan.reports.users') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Laporan & Rekap
                                    </a>
                                </li>
                            @elseif(auth()->user()->isKabid())
                                <li>
                                    <a href="{{ route('kabid.dashboard') }}"
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('kabid.dashboard') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        Dashboard Kabid
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('kabid.proposals.index') }}"
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('kabid.proposals.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                        Kelola Disposisi
                                        @php $kabidPending = \App\Models\Proposal::where('kabid_id', auth()->id())->whereIn('status', ['persiapan_survei', 'verifikasi_cpcl'])->count(); @endphp
                                        @if($kabidPending > 0)
                                            <span class="ml-auto bg-amber-200 text-amber-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $kabidPending }}</span>
                                        @endif
                                    </a>
                                </li>

                            @elseif(auth()->user()->isApproved())
                                <li>
                                    <a href="{{ route('farmer.proposals.pilih') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('farmer.proposals.pilih', 'farmer.proposals.alsintan*', 'farmer.proposals.bantuan*', 'farmer.proposals.create', 'farmer.proposals.form') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Ajukan Proposal
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('farmer.proposals.index') }}" 
                                       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('farmer.proposals.index') ? $roleColor['active'] : $roleColor['hover'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Riwayat Pengajuan
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    @if(auth()->user()->isPetani() || auth()->user()->isUmum())
                    <div>
                        <h3 class="text-[11px] font-extrabold text-[#94A3B8] uppercase tracking-[0.15em] mb-4 px-3">Akun</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('profile.edit') ? $roleColor['active'] : $roleColor['hover'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                @php
                                    $msgRoute = auth()->user()->isPetani() ? route('farmer.messages.index') : route('user.messages.index');
                                    $msgActive = auth()->user()->isPetani() ? request()->routeIs('farmer.messages.*') : request()->routeIs('user.messages.*');
                                    $unreadCount = \App\Models\Contact::where('user_id', auth()->id())->where('status', 'replied')->count(); // Optional: You might want to track if it's read by user, but let's just display total for now or replied.
                                @endphp
                                <a href="{{ $msgRoute }}" 
                                   class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 {{ $msgActive ? $roleColor['active'] : $roleColor['hover'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Pusat Pesan
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Bottom User Info -->
            <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if(auth()->user()->display_foto)
                            <img src="{{ auth()->user()->display_foto }}" alt="Foto Profile" class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-sm shrink-0">
                        @else
                            <div class="w-11 h-11 rounded-full {{ $roleColor['avatar'] }} border-2 border-white shadow-sm flex items-center justify-center font-extrabold text-white shrink-0">
                                {{ substr(auth()->user()->display_name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="font-extrabold text-[13px] text-[#1E293B] leading-tight">{{ auth()->user()->display_name }}</span>
                            <span class="text-[11px] text-[#94A3B8] font-bold capitalize">{{ auth()->user()->roleLabel }}</span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="p-2 text-[#94A3B8] hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-300">
                            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">

            {{-- ===== MOBILE TOP NAVBAR (lg:hidden) ===== --}}
            <header class="lg:hidden bg-white border-b border-gray-100 flex items-center justify-between px-4 h-16 z-40 flex-shrink-0 relative">
                {{-- Hamburger --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 p-1 rounded-lg hover:bg-gray-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <x-application-logo imgClass="h-8" />
                </a>

                {{-- Right: Bell + Avatar Dropdown --}}
                <div class="flex items-center gap-2">
                    <button class="relative text-gray-500 p-1.5 hover:bg-gray-50 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    
                    {{-- Avatar Dropdown --}}
                    <div class="relative" x-data="{ userMobileOpen: false }" @click.away="userMobileOpen = false">
                        @if(auth()->user()->display_foto)
                            <button @click="userMobileOpen = !userMobileOpen" class="w-9 h-9 rounded-full overflow-hidden border-2 border-white shadow-sm active:scale-95 transition-all focus:outline-none shrink-0">
                                <img src="{{ auth()->user()->display_foto }}" alt="Foto Profile" class="w-full h-full object-cover">
                            </button>
                        @else
                            <button @click="userMobileOpen = !userMobileOpen" class="w-9 h-9 rounded-full {{ $roleColor['avatar'] }} text-white flex items-center justify-center font-bold text-sm shadow-sm active:scale-95 transition-all shrink-0">
                                {{ substr(auth()->user()->display_name, 0, 1) }}
                            </button>
                        @endif

                        <div x-show="userMobileOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden" 
                             x-cloak>
                            <div class="px-5 py-3 border-b border-gray-50 bg-gray-50/50 mb-1">
                                <p class="text-xs font-bold text-gray-800 leading-tight truncate">{{ auth()->user()->display_name }}</p>
                                <p class="text-[10px] text-gray-500 font-medium truncate mt-0.5">{{ auth()->user()->email }}</p>
                            </div>
                            @if(auth()->user()->isPetani() || auth()->user()->isUmum())
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            @endif
                            <div class="my-1 border-t border-gray-50"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="w-full flex items-center gap-3 px-5 py-2.5 text-sm text-red-600 hover:bg-red-50 font-bold transition-colors text-left">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    <span class="pointer-events-none">Keluar</span>
                                </button>
                            </form>
                        </div>
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
                 class="lg:hidden fixed inset-0 bg-black/50 z-40 backdrop-blur-sm"
                 x-cloak></div>

            {{-- Drawer Panel --}}
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="lg:hidden fixed top-0 left-0 h-full w-72 bg-white z-50 flex flex-col shadow-2xl"
                 x-cloak>

                {{-- Drawer Header --}}
                <div class="{{ $roleColor['bg'] }} px-5 pt-10 pb-6">
                    <div class="flex items-center justify-between mb-5">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            <x-application-logo imgClass="h-8" textColor="text-white" />
                        </a>
                        <button @click="mobileMenuOpen = false" class="text-white/70 hover:text-white p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-3">
                        @if(auth()->user()->display_foto)
                            <img src="{{ auth()->user()->display_foto }}" alt="Foto Profile" class="w-12 h-12 rounded-full object-cover border-2 border-white/40 shadow-sm shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-full bg-white/20 border-2 border-white/40 flex items-center justify-center font-extrabold text-white text-lg shrink-0">
                                {{ substr(auth()->user()->display_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <div class="font-extrabold text-white text-sm leading-tight">{{ auth()->user()->display_name }}</div>
                                <div class="text-white/70 text-xs mt-0.5">
                                    {{ auth()->user()->roleLabel }}
                                </div>
                        </div>
                    </div>
                </div>

                {{-- Drawer Nav Links --}}
                <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                    @if(auth()->user()->isPetani() || auth()->user()->isUmum())
                    <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ $roleColor['hover'] }} mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                        Beranda
                    </a>
                    @endif

                    @unless(auth()->user()->isPimpinan() || auth()->user()->isKabid())
                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('dashboard') ? $roleColor['active'] : $roleColor['hover'] }} mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    @endunless

                    @if(auth()->user()->hasRole('super_admin'))
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-3 mb-2 mt-2">SUPER ADMIN</p>
                        <a href="{{ route('super-admin.users.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('super-admin.users.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Manajemen Role
                        </a>
                        <a href="{{ route('super-admin.audit-logs.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('super-admin.audit-logs.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Audit Trail
                        </a>
                        <a href="{{ route('super-admin.settings.edit') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('super-admin.settings.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Latar Belakang Web
                        </a>
                        <a href="{{ route('super-admin.backups.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('super-admin.backups.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            Kelola Backup
                        </a>
                        <div class="my-3 border-t border-gray-100"></div>
                    @endif

                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-3 mb-2">MENU UTAMA</p>

                    @if(auth()->user()->isAdmin())
                        @php
                            $isUserShow = request()->routeIs('admin.users.show');
                            $currentUser = $isUserShow ? request()->route('user') : null;
                            $isPendingVerif = $currentUser && $currentUser->farmerProfile && in_array($currentUser->farmerProfile->status, ['menunggu', 'reviewed']);
                            $isMasterList = $currentUser && (!$currentUser->farmerProfile || in_array($currentUser->farmerProfile->status, ['approved', 'rejected']));
                            $pendingUserVerificationsCount = \App\Models\User::where('role', 'petani')
                                ->whereHas('farmerProfile', function ($query) {
                                    $query->whereIn('status', ['menunggu', 'reviewed', 'pengajuan_revisi']);
                                })->count();
                            $pendingCount = \App\Models\Proposal::where('status', 'sedang_diverifikasi_admin')->count();
                        @endphp
                        <a href="{{ route('admin.users.kelompok-tani') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ (request()->routeIs('admin.users.kelompok-tani') || request()->routeIs('admin.users.umum') || ($isUserShow && $isMasterList)) ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Daftar User
                        </a>
                        <a href="{{ route('admin.users.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ (request()->routeIs('admin.users.index') || ($isUserShow && $isPendingVerif)) ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="truncate">Verifikasi User</span>
                            @if($pendingUserVerificationsCount > 0)
                                <span class="ml-auto bg-yellow-400 text-yellow-900 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pendingUserVerificationsCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.proposals.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.proposals.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Kelola Proposal
                            @if($pendingCount > 0)
                                <span class="ml-auto bg-yellow-400 text-yellow-900 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.programs.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.programs.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Manajemen Program
                        </a>

                        <a href="{{ route('admin.alsintan.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.alsintan.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                            </svg>
                            Manajemen Alsintan
                        </a>
                        <a href="{{ route('admin.employees.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.employees.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Kelola Pegawai
                        </a>
                        <a href="{{ route('admin.surat.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.surat.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Kelola Surat
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.contacts.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Kelola Kontak
                        </a>

                        <div class="my-3 border-t border-gray-100"></div>
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-3 mb-2">KONTEN BERANDA</p>

                        <a href="{{ route('admin.articles.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.articles.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Kelola Berita & Artikel
                        </a>
                        <a href="{{ route('admin.documents.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.documents.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Kelola Unduhan Dokumen
                        </a>

                        <a href="{{ route('admin.satuan-kerja.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('admin.satuan-kerja.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Kelola Satuan Kerja
                        </a>

                    @elseif(auth()->user()->isPimpinan())
                        <a href="{{ route('pimpinan.dashboard') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('pimpinan.dashboard') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard Pimpinan
                        </a>
                        <a href="{{ route('pimpinan.proposals.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('pimpinan.proposals.index') || request()->routeIs('pimpinan.proposals.show') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Tinjau Proposal
                            @php $pimpinanPending = \App\Models\Proposal::whereIn('status', ['sedang_diverifikasi_pimpinan', 'menunggu_keputusan_akhir'])->count(); @endphp
                            @if($pimpinanPending > 0)
                                <span class="ml-auto bg-indigo-200 text-indigo-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pimpinanPending }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pimpinan.proposals.archives') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('pimpinan.proposals.archives') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            Semua Proposal
                        </a>
                        <a href="{{ route('pimpinan.reports') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('pimpinan.reports') || request()->routeIs('pimpinan.reports.users') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Laporan & Rekap
                        </a>
                    @elseif(auth()->user()->isKabid())
                        <a href="{{ route('kabid.dashboard') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('kabid.dashboard') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard Kabid
                        </a>
                        <a href="{{ route('kabid.proposals.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('kabid.proposals.*') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Kelola Disposisi
                            @php $kabidPending = \App\Models\Proposal::where('kabid_id', auth()->id())->whereIn('status', ['persiapan_survei', 'verifikasi_cpcl'])->count(); @endphp
                            @if($kabidPending > 0)
                                <span class="ml-auto bg-amber-200 text-amber-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $kabidPending }}</span>
                            @endif
                        </a>

                    @elseif(auth()->user()->isApproved())
                        <a href="{{ route('farmer.proposals.pilih') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('farmer.proposals.pilih', 'farmer.proposals.alsintan*', 'farmer.proposals.bantuan*', 'farmer.proposals.create', 'farmer.proposals.form') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Ajukan Proposal
                        </a>
                        <a href="{{ route('farmer.proposals.index') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 {{ request()->routeIs('farmer.proposals.index') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Riwayat Pengajuan
                        </a>
                    @endif

                    @if(auth()->user()->isPetani() || auth()->user()->isUmum())
                    <div class="border-t border-gray-100 my-2 pt-2">
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-3 mb-2">AKUN</p>
                        <a href="{{ route('profile.edit') }}" @click="mobileMenuOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm {{ request()->routeIs('profile.edit') ? $roleColor['active'] : $roleColor['hover'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                    </div>
                    @endif
                </nav>

                {{-- Drawer Footer: Logout --}}
                <div class="p-4 border-t border-gray-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm text-red-500 hover:bg-red-50 w-full transition-colors">
                            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span class="pointer-events-none">Keluar dari Akun</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- ===== DESKTOP TOP NAVBAR (hidden on mobile/tablet) ===== --}}
            <header class="hidden lg:flex h-20 bg-white border-b border-gray-100 items-center justify-between px-8 z-40 relative">
                <div>
                    <h1 class="font-extrabold text-xl text-gray-800">{{ $header ?? 'Dashboard' }}</h1>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">Portal DTPH Muaro Jambi</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <button class="text-gray-400 hover:text-primary-600 relative">
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>

                    <div class="relative" x-data="{ userOpen: false }" @click.away="userOpen = false">
                        <button @click="userOpen = !userOpen" class="flex items-center gap-3 p-1 rounded-xl transition-all border border-transparent  group">
                            @if(auth()->user()->display_foto)
                                <img src="{{ auth()->user()->display_foto }}" alt="Foto Profile" class="w-9 h-9 rounded-full object-cover shadow-sm transition-all shrink-0">
                            @else
                                <div class="w-9 h-9 rounded-full {{ $roleColor['avatar'] }} text-white flex items-center justify-center font-bold shadow-sm transition-all shrink-0">
                                    {{ substr(auth()->user()->display_name, 0, 1) }}
                                </div>
                            @endif
                            <div class="hidden md:block text-left">
                                <div class="font-bold text-sm text-gray-800 leading-tight group-hover:text-primary-700 transition-colors">{{ auth()->user()->display_name }}</div>
                                <div class="text-[11px] text-gray-500 font-medium capitalize">{{ auth()->user()->roleLabel }}</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" :class="userOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="userOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden" 
                             x-cloak>
                            <div class="px-5 py-3 border-b border-gray-50 bg-gray-50/50 mb-1">
                                <p class="text-xs font-bold text-gray-800 leading-tight truncate">{{ auth()->user()->display_name }}</p>
                                <p class="text-[10px] text-gray-500 font-medium truncate mt-0.5">{{ auth()->user()->email }}</p>
                            </div>
                            @if(auth()->user()->isPetani() || auth()->user()->isUmum())
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            @endif
                            <div class="my-1 border-t border-gray-50"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="w-full flex items-center gap-3 px-5 py-2.5 text-sm text-red-600 hover:bg-red-50 font-bold transition-colors text-left">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    <span class="pointer-events-none">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content scrollable -->
            <div class="flex-1 overflow-y-auto p-4 md:p-6 pb-6">
                {{ $slot }}
            </div>
        </main>
        
        @stack('scripts')
    </body>
</html>
