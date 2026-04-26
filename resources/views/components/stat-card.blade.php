{{-- resources/views/components/stat-card.blade.php --}}
@props([
    'label'    => 'Label',
    'value'    => '0',
    'icon'     => 'document',
    'color'    => 'green',   // green | blue | amber | red | purple
    'trend'    => null,      // e.g. '+5%' or '-2%'
    'trendUp'  => true,
])

@php
    $colorMap = [
        'green'  => ['bg-primary-50',  'text-primary-600',  'bg-primary-100'],
        'blue'   => ['bg-blue-50',   'text-blue-600',   'bg-blue-100'],
        'amber'  => ['bg-amber-50',  'text-amber-600',  'bg-amber-100'],
        'red'    => ['bg-red-50',    'text-red-600',    'bg-red-100'],
        'purple' => ['bg-purple-50', 'text-purple-600', 'bg-purple-100'],
    ];
    [$cardBg, $iconColor, $iconBg] = $colorMap[$color] ?? $colorMap['green'];

    $icons = [
        'document'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
        'clock'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'check'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'x-circle'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'truck'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>',
    ];
@endphp

<div class="stat-card group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
    {{-- Icon --}}
    <div class="stat-icon {{ $iconBg }}">
        <svg class="w-7 h-7 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            {!! $icons[$icon] ?? $icons['document'] !!}
        </svg>
    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">{{ $label }}</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 leading-none">{{ $value }}</p>
        @if($trend)
            <p class="text-xs font-medium mt-1.5 {{ $trendUp ? 'text-green-600' : 'text-red-500' }}">
                @if($trendUp)
                    <svg class="w-3 h-3 inline -mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                @else
                    <svg class="w-3 h-3 inline -mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                @endif
                {{ $trend }} dari bulan lalu
            </p>
        @endif
    </div>
</div>
