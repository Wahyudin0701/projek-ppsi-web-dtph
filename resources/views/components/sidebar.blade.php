{{-- resources/views/components/sidebar.blade.php --}}
<div class="flex flex-col h-full">

    {{-- Logo / Brand --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-md flex-shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
            </svg>
        </div>
        <div>
            <p class="font-bold text-sm text-gray-900 leading-tight">E-Proposal</p>
            <p class="text-[11px] text-primary-600 font-medium">Alsintan DTPH</p>
        </div>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

        {{-- Menu Label --}}
        <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Menu Utama</p>

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('katalog') }}"
           class="nav-link {{ request()->routeIs('katalog') ? 'nav-link-active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <span>Katalog Alsintan</span>
        </a>

        <a href="{{ route('proposal.create') }}"
           class="nav-link {{ request()->routeIs('proposal.*') ? 'nav-link-active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Ajukan Proposal</span>
        </a>

        <div class="pt-4 pb-1">
            <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Akun</p>
        </div>

        <a href="#" class="nav-link">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Profil Saya</span>
        </a>

    </nav>

    {{-- User Info Footer --}}
    <div class="px-4 py-4 border-t border-gray-100">
        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition cursor-pointer">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                P
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">Petani Demo</p>
                <p class="text-xs text-gray-500 truncate">Petani Individu</p>
            </div>
            <svg class="w-4 h-4 text-gray-400 ml-auto flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
        </div>
    </div>
</div>
