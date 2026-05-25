@props([
    'person' => [],
    'size'   => 'md', // lg | md | sm
])

@php
$jabatan  = $person['jabatan']  ?? '';
$nama     = $person['nama']     ?? '';
$nip      = $person['nip']      ?? '';
$initials = $person['initials'] ?? substr($nama, 0, 2);
$color    = $person['color']    ?? ['bg' => 'bg-emerald-600', 'ring' => 'ring-emerald-400', 'badge' => 'bg-emerald-100 text-emerald-800'];
$photo    = $person['photo']    ?? null; // path to actual photo if available

$avatarSize  = match($size) { 'lg' => 'w-28 h-28 text-3xl', 'md' => 'w-20 h-20 text-xl', default => 'w-16 h-16 text-base' };
$cardPadding = match($size) { 'lg' => 'px-6 py-6', 'md' => 'px-5 py-5', default => 'px-4 py-4' };
$nameSize    = match($size) { 'lg' => 'text-base', 'md' => 'text-sm', default => 'text-xs' };
$nipSize     = match($size) { 'lg' => 'text-xs', default => 'text-[10px]' };
$badgeSize   = match($size) { 'lg' => 'text-xs px-3 py-1', default => 'text-[10px] px-2 py-0.5' };
@endphp

<div class="w-full bg-white rounded-2xl shadow-sm hover:shadow-md border border-gray-100 hover:border-gray-200 transition-all duration-200 overflow-hidden group">
    {{-- Colored accent bar --}}
    <div class="{{ $color['bg'] }} h-1.5 w-full"></div>

    <div class="{{ $cardPadding }} flex flex-col items-center text-center">
        {{-- Avatar / Photo --}}
        <div class="relative mb-3">
            @if($photo)
                <img src="{{ asset($photo) }}" alt="{{ $nama }}"
                     class="{{ $avatarSize }} rounded-full object-cover ring-4 {{ $color['ring'] }} shadow-md">
            @else
                {{-- Dummy avatar with initials --}}
                <div class="{{ $avatarSize }} rounded-full {{ $color['bg'] }} ring-4 {{ $color['ring'] }} shadow-md flex items-center justify-center font-extrabold text-white select-none">
                    {{ strtoupper($initials) }}
                </div>
            @endif
        </div>

        {{-- Badge Jabatan --}}
        <span class="{{ $badgeSize }} {{ $color['badge'] }} font-bold rounded-full mb-2 inline-block leading-tight">
            {{ $jabatan }}
        </span>

        {{-- Nama --}}
        <p class="{{ $nameSize }} font-bold text-gray-900 leading-snug mb-1">{{ $nama }}</p>

        {{-- NIP --}}
        @if($nip)
        <p class="{{ $nipSize }} text-gray-400 font-mono">NIP. {{ $nip }}</p>
        @endif
    </div>
</div>
