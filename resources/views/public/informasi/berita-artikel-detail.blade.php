<x-layouts.public>
    <x-slot:title>{{ $article->title }} - DTPH Muaro Jambi</x-slot:title>

    @php
        $kategori = $article->category;
        $label = ucfirst($kategori);
        if ($kategori === 'berita') {
            $labelColor = 'bg-blue-100 text-blue-700';
            $accent = 'from-blue-800 to-blue-950';
        } elseif ($kategori === 'program') {
            $labelColor = 'bg-primary-100 text-primary-700';
            $accent = 'from-primary-700 to-primary-950';
        } elseif ($kategori === 'artikel') {
            $labelColor = 'bg-amber-100 text-amber-700';
            $accent = 'from-amber-700 to-amber-950';
        } else {
            $labelColor = 'bg-violet-100 text-violet-700';
            $accent = 'from-violet-800 to-violet-950';
        }
        $waktuBaca = max(1, ceil(str_word_count(strip_tags($article->content)) / 200)) . ' menit baca';
    @endphp

    <div class="bg-white min-h-screen pt-12 md:pt-16 pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                <a href="{{ route('informasi.berita-artikel') }}" class="hover:text-primary-600 transition-colors">Berita &amp; Artikel</a>
                <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                <span class="text-primary-600">{{ $label }}</span>
            </nav>

            {{-- Title --}}
            <h1 class="text-3xl md:text-[2.5rem] font-black text-gray-900 leading-tight mb-4">
                {{ $article->title }}
            </h1>

            {{-- Author & Date --}}
            <div class="mb-6">
                <p class="text-[15px] text-gray-500 mb-2">
                    {{ $article->author_name }} | <span class="text-red-600 font-bold">Dinas Tanaman Pangan dan Hortikultura Muaro Jambi</span>
                </p>
                <p class="text-sm text-gray-400">
                    {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->locale('id')->translatedFormat('l, d M Y H:i') : '-' }} WIB
                </p>
            </div>

            {{-- Share --}}
            <div class="flex items-center gap-3 mb-8">
                <span class="text-[13px] text-gray-700 font-medium">Bagikan:</span>
                
                {{-- WhatsApp --}}
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . request()->fullUrl()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
                
                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                
                {{-- X (Twitter) --}}
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article->title) }}" target="_blank" class="w-9 h-9 rounded-full bg-black text-white flex items-center justify-center hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.007 4.15H5.059z"/></svg>
                </a>
                
                {{-- Copy Link --}}
                <button onclick="navigator.clipboard.writeText('{{ request()->fullUrl() }}'); alert('Tautan disalin!')" class="w-9 h-9 rounded-full bg-gray-400 text-white flex items-center justify-center hover:bg-gray-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </button>
            </div>

            {{-- Main Image --}}
            @if($article->image_path)
            <div class="mb-10">
                <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="w-full h-auto rounded-xl object-cover max-h-[500px] mb-3">
                <p class="text-[13px] text-gray-500">{{ $article->title }}</p>
            </div>
            @endif

            {{-- Content Area --}}
            @php
                $content = $article->content;
                $locationString = '<strong>Muaro Jambi, Dinas Tanaman Pangan dan Hortikultura</strong> - ';
                
                if (str_starts_with(trim($content), '<p>')) {
                    $content = preg_replace('/^<p>/i', '<p>' . $locationString, trim($content));
                } elseif (str_starts_with(trim($content), '<div>')) {
                    $content = preg_replace('/^<div>/i', '<div>' . $locationString, trim($content));
                } else {
                    $content = $locationString . trim($content);
                }
            @endphp
            <div class="trix-content prose prose-lg prose-gray max-w-none text-gray-800 leading-relaxed mb-16">
                {!! $content !!}
            </div>

            {{-- Tags/Category --}}
            <div class="py-6 border-y border-gray-200 mb-12">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-gray-900">Kategori:</span>
                    <span class="px-3 py-1 bg-gray-100 hover:bg-primary-50 hover:text-primary-700 text-gray-700 text-xs font-bold rounded-full uppercase tracking-wider cursor-pointer transition-colors">{{ $label }}</span>
                </div>
            </div>

            {{-- Related Articles Area --}}
            @if($relatedArticles->count() > 0)
            <div class="mt-16">
                <h3 class="text-2xl font-black text-gray-900 mb-8">Artikel Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                    <a href="{{ route('informasi.berita-artikel.detail', $rel->slug) }}" class="group block bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="h-40 relative overflow-hidden bg-gray-100">
                            @if($rel->image_path)
                                <img src="{{ Storage::url($rel->image_path) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @endif
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-primary-600 transition-colors line-clamp-2 mb-2">{{ $rel->title }}</h4>
                            <p class="text-xs text-gray-400">{{ $rel->published_at ? \Carbon\Carbon::parse($rel->published_at)->locale('id')->translatedFormat('d M Y') : '-' }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Back Button --}}
            <div class="flex justify-center pt-12">
                <a href="{{ route('informasi.berita-artikel') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold text-sm rounded-2xl hover:bg-gray-50 transition-all duration-300 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Daftar Artikel
                </a>
            </div>

        </div>
    </div>
</x-layouts.public>
