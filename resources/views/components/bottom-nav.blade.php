{{-- resources/views/components/bottom-nav.blade.php --}}
<nav class="fixed bottom-0 inset-x-0 z-30 bg-white border-t border-gray-100 shadow-2xl md:hidden safe-area-inset-bottom">
    <div class="grid grid-cols-3 h-16">

        {{-- Home --}}
        <a href="{{ route('dashboard') }}"
           class="flex flex-col items-center justify-center gap-1 relative
                  {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-gray-400' }}
                  hover:text-primary-600 transition-colors duration-200">
            @if(request()->routeIs('dashboard'))
                <span class="absolute top-0 inset-x-4 h-0.5 bg-primary-600 rounded-b-full"></span>
            @endif
            <svg class="w-5 h-5" fill="{{ request()->routeIs('dashboard') ? 'currentColor' : 'none' }}"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[10px] font-semibold">Beranda</span>
        </a>

        {{-- Pengajuan (Center - Highlight) --}}
        <a href="{{ route('proposal.create') }}"
           class="flex flex-col items-center justify-center gap-1 -mt-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700
                        flex items-center justify-center shadow-lg shadow-primary-600/40
                        hover:shadow-xl hover:shadow-primary-700/40 hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <span class="text-[10px] font-semibold text-primary-600">Ajukan</span>
        </a>

        {{-- Profil --}}
        <a href="#"
           class="flex flex-col items-center justify-center gap-1
                  {{ request()->routeIs('profile.*') ? 'text-primary-600' : 'text-gray-400' }}
                  hover:text-primary-600 transition-colors duration-200">
            <svg class="w-5 h-5" fill="{{ request()->routeIs('profile.*') ? 'currentColor' : 'none' }}"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-[10px] font-semibold">Profil</span>
        </a>

    </div>
</nav>
