{{-- resources/views/components/badge-status.blade.php --}}
@props(['status' => 'menunggu'])

@php
    $map = [
        'menunggu' => ['badge-menunggu', 'Menunggu',
            '<circle cx="8" cy="8" r="3" fill="currentColor"/>'],
        'survei'   => ['badge-survei',   'Survei',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'],
        'diterima' => ['badge-diterima', 'Diterima',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>'],
        'ditolak'  => ['badge-ditolak',  'Ditolak',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>'],
    ];

    [$class, $label, $iconPath] = $map[strtolower($status)] ?? $map['menunggu'];
    $isMenunggu = strtolower($status) === 'menunggu';
@endphp

<span class="badge {{ $class }}">
    @if($isMenunggu)
        <span class="w-2 h-2 rounded-full bg-current animate-pulse-soft"></span>
    @else
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            {!! $iconPath !!}
        </svg>
    @endif
    {{ $label }}
</span>
