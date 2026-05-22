@props(['textColor' => 'text-gray-800', 'imgClass' => 'h-12'])

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <img src="{{ asset('images/Lambang_Kabupaten_Muaro_Jambi.png') }}" class="{{ $imgClass }} w-auto object-contain">
    <div class="flex flex-col">
        <span class="font-extrabold text-lg {{ $textColor }} leading-tight">DTPH</span>
        <span class="text-xs font-bold {{ $textColor }} opacity-90 tracking-wide uppercase">Muaro Jambi</span>
    </div>
</div>

