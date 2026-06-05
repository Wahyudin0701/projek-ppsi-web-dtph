<x-layouts.public>
    <x-slot:title>Berita & Artikel - DTPH Muaro Jambi</x-slot:title>
    <x-slot:metaDescription>Baca berita terbaru, artikel informatif, dan pengumuman resmi seputar dunia pertanian dari Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi.</x-slot:metaDescription>

    <div class="bg-[#f8faf9] min-h-screen">

        {{-- Hero Header --}}
        <div class="bg-white pt-12 md:pt-16 pb-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Berita & Artikel</h1>
            <div class="mt-4 w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Informasi terkini seputar program pertanian, kegiatan dinas, dan artikel edukatif untuk petani Muaro Jambi.
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Articles are now passed from PublicInformationController --}}
            
            {{-- Category Filter Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-16">
                {{-- All Categories --}}
                <button @click="activeCategory = 'semua'" 
                        :class="activeCategory === 'semua' ? 'bg-primary-600 border-primary-600 shadow-lg shadow-primary-600/20' : 'bg-white border-gray-100 hover:border-primary-200 shadow-sm'"
                        class="p-5 rounded-3xl border transition-all duration-300 text-left group">
                    <div :class="activeCategory === 'semua' ? 'bg-white/20 text-white' : 'bg-primary-50 text-primary-600'" 
                         class="w-10 h-10 rounded-2xl flex items-center justify-center mb-4 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </div>
                    <p :class="activeCategory === 'semua' ? 'text-white' : 'text-gray-900'" class="font-bold text-sm">Semua</p>
                    <p :class="activeCategory === 'semua' ? 'text-primary-100' : 'text-gray-400'" class="text-[10px] font-medium uppercase tracking-wider mt-1">Total Artikel</p>
                </button>

                {{-- Berita --}}
                <button @click="activeCategory = 'berita'" 
                        :class="activeCategory === 'berita' ? 'bg-blue-600 border-blue-600 shadow-lg shadow-blue-600/20' : 'bg-white border-gray-100 hover:border-blue-200 shadow-sm'"
                        class="p-5 rounded-3xl border transition-all duration-300 text-left group">
                    <div :class="activeCategory === 'berita' ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-600'" 
                         class="w-10 h-10 rounded-2xl flex items-center justify-center mb-4 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <p :class="activeCategory === 'berita' ? 'text-white' : 'text-gray-900'" class="font-bold text-sm">Berita</p>
                    <p :class="activeCategory === 'berita' ? 'text-blue-100' : 'text-gray-400'" class="text-[10px] font-medium uppercase tracking-wider mt-1">Dinas & Publik</p>
                </button>

                {{-- Program --}}
                <button @click="activeCategory = 'program'" 
                        :class="activeCategory === 'program' ? 'bg-primary-600 border-primary-600 shadow-lg shadow-primary-600/20' : 'bg-white border-gray-100 hover:border-primary-200 shadow-sm'"
                        class="p-5 rounded-3xl border transition-all duration-300 text-left group">
                    <div :class="activeCategory === 'program' ? 'bg-white/20 text-white' : 'bg-primary-50 text-primary-600'" 
                         class="w-10 h-10 rounded-2xl flex items-center justify-center mb-4 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <p :class="activeCategory === 'program' ? 'text-white' : 'text-gray-900'" class="font-bold text-sm">Program</p>
                    <p :class="activeCategory === 'program' ? 'text-primary-100' : 'text-gray-400'" class="text-[10px] font-medium uppercase tracking-wider mt-1">Bantuan & Alsintan</p>
                </button>

                {{-- Artikel --}}
                <button @click="activeCategory = 'artikel'" 
                        :class="activeCategory === 'artikel' ? 'bg-amber-600 border-amber-600 shadow-lg shadow-amber-600/20' : 'bg-white border-gray-100 hover:border-amber-200 shadow-sm'"
                        class="p-5 rounded-3xl border transition-all duration-300 text-left group">
                    <div :class="activeCategory === 'artikel' ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-600'" 
                         class="w-10 h-10 rounded-2xl flex items-center justify-center mb-4 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <p :class="activeCategory === 'artikel' ? 'text-white' : 'text-gray-900'" class="font-bold text-sm">Artikel</p>
                    <p :class="activeCategory === 'artikel' ? 'text-amber-100' : 'text-gray-400'" class="text-[10px] font-medium uppercase tracking-wider mt-1">Edukasi & Tips</p>
                </button>

                {{-- Kegiatan --}}
                <button @click="activeCategory = 'kegiatan'" 
                        :class="activeCategory === 'kegiatan' ? 'bg-violet-600 border-violet-600 shadow-lg shadow-violet-600/20' : 'bg-white border-gray-100 hover:border-violet-200 shadow-sm'"
                        class="p-5 rounded-3xl border transition-all duration-300 text-left group">
                    <div :class="activeCategory === 'kegiatan' ? 'bg-white/20 text-white' : 'bg-violet-50 text-violet-600'" 
                         class="w-10 h-10 rounded-2xl flex items-center justify-center mb-4 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p :class="activeCategory === 'kegiatan' ? 'text-white' : 'text-gray-900'" class="font-bold text-sm">Kegiatan</p>
                    <p :class="activeCategory === 'kegiatan' ? 'text-violet-100' : 'text-gray-400'" class="text-[10px] font-medium uppercase tracking-wider mt-1">Dokumentasi Lapangan</p>
                </button>
            </div>

            {{-- Article Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
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
                <article x-show="activeCategory === 'semua' || activeCategory === '{{ $kategori }}'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="bg-white rounded-[2rem] overflow-hidden border border-gray-100 shadow-[0_6px_30px_-10px_rgba(0,0,0,0.06)] hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.1)] transition-all duration-500 group flex flex-col hover:-translate-y-1.5">

                    {{-- Image Area --}}
                    <a href="{{ route('informasi.berita-artikel.detail', $article->slug) }}" class="block">
                        <div class="h-48 relative overflow-hidden flex items-center justify-center">
                            {{-- Photo Background --}}
                            @if($article->image_path)
                                <img src="{{ Storage::url($article->image_path) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @endif
                            
                            {{-- Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-br {{ $accent }} {{ $article->image_path ? 'opacity-60' : 'opacity-100' }}"></div>

                            {{-- Abstract blob bg (only if no photo) --}}
                            @if(!$article->image_path)
                                <div class="absolute inset-0 opacity-20">
                                    <svg class="w-full h-full" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="white" d="M47.7,-62.3C59.5,-51.8,65.4,-34.4,67.9,-17.2C70.5,-0.1,69.6,16.8,62.4,29.7C55.2,42.6,41.7,51.5,27.2,58.1C12.6,64.7,-3,69.1,-17.8,65.8C-32.7,62.5,-46.9,51.6,-56.6,37.4C-66.4,23.2,-71.7,5.8,-69.3,-10.4C-66.9,-26.7,-56.7,-41.8,-43.8,-52.2C-30.9,-62.6,-15.5,-68.4,1.4,-70.1C18.3,-71.8,35.9,-72.8,47.7,-62.3Z" transform="translate(100 100)" />
                                    </svg>
                                </div>
                            @endif

                            <svg class="relative w-12 h-12 text-white/30 group-hover:text-white/50 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            {{-- Category label on image --}}
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-[10px] font-bold rounded-full uppercase tracking-wider border border-white/20">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>
                    </a>

                    {{-- Content --}}
                    <div class="p-7 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $labelColor }}">{{ $label }}</span>
                            <span class="text-[10px] text-gray-400 font-medium">{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</span>
                        </div>

                        <a href="{{ route('informasi.berita-artikel.detail', $article->slug) }}" class="block flex-1">
                            <h2 class="text-base font-bold text-gray-900 leading-snug mb-3 group-hover:text-primary-700 transition-colors line-clamp-2">
                                {{ $article->title }}
                            </h2>
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">{{ $article->summary }}</p>
                        </a>

                        <div class="flex items-center justify-between pt-5 mt-5 border-t border-gray-50">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-primary-50 flex items-center justify-center text-primary-700 font-bold text-[10px] flex-shrink-0">
                                    {{ strtoupper(substr($article->author_name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-800 leading-none">{{ $article->author_name }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $waktuBaca }}</p>
                                </div>
                            </div>
                            <a href="{{ route('informasi.berita-artikel.detail', $article->slug) }}" class="flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                Selengkapnya
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>

                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-16">
                {{ $articles->links() }}
            </div>

        </div>
    </div>
</x-layouts.public>
