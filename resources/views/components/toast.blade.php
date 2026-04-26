{{-- resources/views/components/toast.blade.php --}}
{{--
    Usage in controller:
    return back()->with('toast', ['type' => 'success', 'message' => 'Data berhasil disimpan!']);

    Toast types: success | error | warning | info
--}}

@if(session('toast'))
<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 4500)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-8"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-250"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-8"
    class="fixed top-5 right-5 z-[9999] w-80 max-w-[calc(100vw-2.5rem)]"
    style="display: none"
>
    @php
        $toast = session('toast');
        $type = $toast['type'] ?? 'info';
        $message = $toast['message'] ?? '';

        $styles = [
            'success' => ['bg-emerald-50 border-emerald-400', 'text-emerald-700', 'bg-emerald-100'],
            'error'   => ['bg-red-50 border-red-400',     'text-red-700',     'bg-red-100'],
            'warning' => ['bg-amber-50 border-amber-400', 'text-amber-700',   'bg-amber-100'],
            'info'    => ['bg-blue-50 border-blue-400',   'text-blue-700',    'bg-blue-100'],
        ];
        [$cardClass, $textClass, $iconBg] = $styles[$type] ?? $styles['info'];

        $icons = [
            'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'error'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
            'info'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ];
    @endphp

    <div class="flex items-start gap-3 p-4 rounded-2xl border shadow-xl {{ $cardClass }}">
        <div class="flex-shrink-0 w-9 h-9 rounded-xl {{ $iconBg }} {{ $textClass }} flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                {!! $icons[$type] ?? $icons['info'] !!}
            </svg>
        </div>
        <div class="flex-1 min-w-0 pt-0.5">
            <p class="text-sm font-semibold {{ $textClass }}">
                {{ ['success' => 'Berhasil!', 'error' => 'Gagal!', 'warning' => 'Perhatian!', 'info' => 'Info'][$type] ?? 'Info' }}
            </p>
            <p class="text-xs {{ $textClass }} opacity-80 mt-0.5">{{ $message }}</p>
        </div>
        <button @click="show = false" class="{{ $textClass }} opacity-60 hover:opacity-100 transition flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Progress bar --}}
    <div class="mt-1 h-0.5 rounded-full {{ $iconBg }} overflow-hidden">
        <div class="{{ $textClass }} h-full opacity-40" style="animation: shrink 4.5s linear forwards">
            <div class="h-full bg-current w-full"></div>
        </div>
    </div>
</div>

<style>
    @keyframes shrink {
        from { width: 100%; }
        to   { width: 0%; }
    }
</style>
@endif
