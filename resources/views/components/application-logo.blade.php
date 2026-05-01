@props(['textColor' => 'text-gray-800'])

<div class="flex items-center gap-3">
    <img src="{{ asset('build/assets/Lambang_Kabupaten_Muaro_Jambi.png') }}" {{ $attributes->merge(['class' => 'h-12 w-auto']) }}>
    <div class="flex flex-col">
        <span class="font-extrabold text-lg {{ $textColor }} leading-tight">DTPH</span>
        <span class="text-xs font-bold text-primary-600 tracking-wide uppercase">Muaro Jambi</span>
    </div>
</div>

