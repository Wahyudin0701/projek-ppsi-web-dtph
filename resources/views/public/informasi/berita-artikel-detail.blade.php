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

    <div class="bg-[#f8faf9] min-h-screen">

        {{-- Article Hero --}}
        <div class="relative overflow-hidden mb-6 min-h-[380px] md:min-h-[460px] flex flex-col justify-end mx-auto">

            {{-- Background Photo (jika ada) atau fallback gradient --}}
            @if($article->image_path)
                <img src="{{ Storage::url($article->image_path) }}"
                     alt="{{ $article->title }}"
                     class="absolute inset-0 w-full h-full object-cover object-center">
            @endif

            {{-- Gradient Overlay (selalu tampil di atas foto atau sebagai background) --}}
            <div class="absolute inset-0 bg-gradient-to-br {{ $accent }} {{ $article->image_path ? 'opacity-75' : 'opacity-100' }}"></div>

            {{-- Extra bottom shadow for readability --}}
            <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="relative mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-32">
                <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-white/60 mb-8">
                    <a href="{{ route('home') }}" class="text-white/70 hover:text-white underline decoration-transparent hover:decoration-white/50 underline-offset-4 transition-all duration-300">Beranda</a>
                    <svg class="w-3 h-3 text-white/30" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                    <a href="{{ route('informasi.berita-artikel') }}" class="text-white/70 hover:text-white underline decoration-transparent hover:decoration-white/50 underline-offset-4 transition-all duration-300">Berita &amp; Artikel</a>
                    <svg class="w-3 h-3 text-white/30" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                    <span class="text-white">{{ $label }}</span>
                </nav>
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm border border-white/20 text-white text-xs font-bold rounded-full uppercase tracking-wider">{{ $label }}</span>
                    <span class="text-white text-xs">{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-white leading-tight mb-6 max-w-4xl">{{ $article->title }}</h1>
                <div class="flex items-center gap-4 pb-12">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($article->author_name, 0, 2)) }}
                    </div>
                    <div class="text-left">
                        <p class="text-white font-bold text-sm">{{ $article->author_name }}</p>
                        <p class="text-xs text-white">{{ $waktuBaca }} · {{ $article->views }} x Dilihat</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-40 pb-24 relative z-10">

            {{-- Article Card --}}
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_80px_-20px_rgba(0,0,0,0.1)] border border-gray-100 overflow-hidden">

                {{-- Article Body --}}
                <div class="px-8 md:px-16 pt-12 pb-12">
                    {{-- Paragraphs --}}
                    <div class="trix-content prose prose-lg prose-primary max-w-none text-gray-600 leading-relaxed">
                        {!! $article->content !!}
                    </div>
                </div>

                {{-- Share --}}
                <div class="px-8 md:px-16 py-8 border-t border-gray-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-gray-100 hover:bg-primary-50 hover:text-primary-700 text-gray-600 text-xs font-bold rounded-xl cursor-pointer transition-colors">#{{ $label }}</span>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="w-8 h-8 rounded-xl bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white flex items-center justify-center transition-all duration-300" title="Facebook">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . request()->fullUrl()) }}" target="_blank" class="w-8 h-8 rounded-xl bg-green-50 hover:bg-green-600 text-green-600 hover:text-white flex items-center justify-center transition-all duration-300" title="WhatsApp">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Related Articles Area --}}
            @if($relatedArticles->count() > 0)
            <div class="mt-16">
                <h3 class="text-2xl font-black text-gray-900 mb-8">Artikel Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                    <a href="{{ route('informasi.berita-artikel.detail', $rel->slug) }}" class="group block bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="h-32 relative overflow-hidden bg-gray-100">
                            @if($rel->image_path)
                                <img src="{{ Storage::url($rel->image_path) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @endif
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-primary-600 transition-colors line-clamp-2 mb-2">{{ $rel->title }}</h4>
                            <p class="text-xs text-gray-400">{{ $rel->published_at ? $rel->published_at->format('d M Y') : '-' }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Back Button --}}
            <div class="flex justify-center pt-16">
                <a href="{{ route('informasi.berita-artikel') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold text-sm rounded-2xl hover:bg-primary-50 hover:border-primary-200 hover:text-primary-700 transition-all duration-300 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Daftar Artikel
                </a>
            </div>

        </div>
    </div>
</x-layouts.public>
