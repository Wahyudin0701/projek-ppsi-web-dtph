<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Platform digital pengajuan proposal peminjaman alsintan Dinas Tanaman Pangan dan Hortikultura.' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — E-Proposal Alsintan DTPH</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite: Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{ $head ?? '' }}
</head>
<body class="h-full bg-gray-50" x-data="{ sidebarOpen: false }">

    {{-- ============================================================
         TOAST NOTIFICATION AREA
         ============================================================ --}}
    <x-toast />

    {{-- ============================================================
         SIDEBAR OVERLAY (Mobile)
         ============================================================ --}}
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm md:hidden"
        style="display:none"
    ></div>

    {{-- ============================================================
         SIDEBAR (Desktop: fixed | Mobile: drawer)
         ============================================================ --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-100 shadow-xl
               transition-transform duration-300 ease-in-out
               md:translate-x-0 md:shadow-none"
    >
        <x-sidebar />
    </aside>

    {{-- ============================================================
         MAIN CONTENT WRAPPER
         ============================================================ --}}
    <div class="flex flex-col min-h-screen md:pl-64">

        {{-- TOP NAVBAR --}}
        <x-navbar />

        {{-- PAGE CONTENT --}}
        <main class="flex-1 px-4 py-6 md:px-8 md:py-8 pb-24 md:pb-8">
            {{-- Page Header Slot (optional) --}}
            @isset($header)
                <div class="mb-6 animate-fade-in-down">
                    {{ $header }}
                </div>
            @endisset

            {{-- Flash Messages --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mb-4 flex items-center gap-3 p-4 rounded-xl border toast-success animate-fade-in-down">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-auto text-green-600 hover:text-green-800"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mb-4 flex items-center gap-3 p-4 rounded-xl border toast-error animate-fade-in-down">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                    <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            @endif

            {{-- Main Slot --}}
            <div class="animate-fade-in-up">
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- ============================================================
         BOTTOM NAVIGATION BAR (Mobile Only)
         ============================================================ --}}
    <x-bottom-nav />

</body>
</html>
