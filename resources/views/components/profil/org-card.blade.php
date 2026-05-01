@props([
    'title' => '',
    'color' => 'emerald',
    'icon'  => null,
    'size'  => 'md', // md | sm
])

@php
$colorMap = [
    'emerald' => ['bg' => 'bg-emerald-600', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'light' => 'bg-emerald-50', 'connector' => 'bg-emerald-200'],
    'blue'    => ['bg' => 'bg-blue-600',    'text' => 'text-blue-700',    'border' => 'border-blue-200',    'light' => 'bg-blue-50',    'connector' => 'bg-blue-200'],
    'green'   => ['bg' => 'bg-green-600',   'text' => 'text-green-700',   'border' => 'border-green-200',   'light' => 'bg-green-50',   'connector' => 'bg-green-200'],
    'lime'    => ['bg' => 'bg-lime-600',    'text' => 'text-lime-700',    'border' => 'border-lime-200',    'light' => 'bg-lime-50',    'connector' => 'bg-lime-200'],
    'teal'    => ['bg' => 'bg-teal-600',    'text' => 'text-teal-700',    'border' => 'border-teal-200',    'light' => 'bg-teal-50',    'connector' => 'bg-teal-200'],
    'cyan'    => ['bg' => 'bg-cyan-600',    'text' => 'text-cyan-700',    'border' => 'border-cyan-200',    'light' => 'bg-cyan-50',    'connector' => 'bg-cyan-200'],
];

$c = $colorMap[$color] ?? $colorMap['emerald'];

$icons = [
    'crown'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l3.5 7L12 5l3.5 5L19 3l2 9H3L5 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2z"/>',
    'office' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
    'plant'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
    'flower' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.209 0-4 1.791-4 4s1.791 4 4 4 4-1.791 4-4-1.791-4-4-4zm0 0V4m0 8c0-2.209-1.791-4-4-4m4 4c2.209 0 4-1.791 4-4"/>',
    'tool'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
    'speak'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>',
];
$svgPath = $icons[$icon] ?? null;
@endphp

<div class="flex flex-col items-center">
    <div class="w-full border-2 {{ $c['border'] }} {{ $c['light'] }} rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
        {{-- Colored top bar --}}
        <div class="{{ $c['bg'] }} {{ $size === 'sm' ? 'h-1.5' : 'h-2' }}"></div>
        <div class="{{ $size === 'sm' ? 'px-3 py-3' : 'px-4 py-4' }} flex items-center gap-3">
            @if($svgPath)
            <div class="flex-shrink-0 w-9 h-9 {{ $c['bg'] }} rounded-lg flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $svgPath !!}
                </svg>
            </div>
            @endif
            <p class="{{ $size === 'sm' ? 'text-xs' : 'text-sm' }} font-bold {{ $c['text'] }} leading-snug text-center flex-1">{{ $title }}</p>
        </div>
    </div>
</div>
