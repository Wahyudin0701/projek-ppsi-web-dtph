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

        <div x-data="{ 
            activeCategory: 'semua', 
            searchQuery: '',
            articles: [
                @foreach($articles as $a)
                { category: '{{ $a->category }}', title: '{{ addslashes(strtolower($a->title)) }}' },
                @endforeach
            ],
            get hasResults() {
                if (this.articles.length === 0) return false;
                return this.articles.some(a => 
                    (this.activeCategory === 'semua' || this.activeCategory === a.category) && 
                    (this.searchQuery === '' || a.title.includes(this.searchQuery.toLowerCase()))
                );
            }
        }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Articles are now passed from PublicInformationController --}}
            
            {{-- Category Filter & Search Bar --}}
            <div class="mb-12">
                <div class="flex flex-col md:flex-row gap-6 justify-between items-center bg-white p-4 rounded-[2rem] border border-gray-100 shadow-sm">
                    
                    {{-- Category Pills --}}
                    <div class="flex overflow-x-auto pb-2 md:pb-0 md:flex-wrap gap-2 md:gap-3 w-full md:w-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] snap-x">
                        <button @click="activeCategory = 'semua'" 
                                :class="activeCategory === 'semua' ? 'bg-primary-600 text-white shadow-md shadow-primary-600/20' : 'bg-gray-50 text-gray-600 hover:bg-primary-50 hover:text-primary-600 border border-transparent hover:border-primary-100'" 
                                class="shrink-0 snap-start px-5 py-2 md:px-6 md:py-2.5 rounded-full text-xs md:text-sm font-bold transition-all duration-300">
                            Semua
                        </button>
                        <button @click="activeCategory = 'berita'" 
                                :class="activeCategory === 'berita' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'bg-gray-50 text-gray-600 hover:bg-blue-50 hover:text-blue-600 border border-transparent hover:border-blue-100'" 
                                class="shrink-0 snap-start px-5 py-2 md:px-6 md:py-2.5 rounded-full text-xs md:text-sm font-bold transition-all duration-300">
                            Berita
                        </button>
                        <button @click="activeCategory = 'program'" 
                                :class="activeCategory === 'program' ? 'bg-primary-600 text-white shadow-md shadow-primary-600/20' : 'bg-gray-50 text-gray-600 hover:bg-primary-50 hover:text-primary-600 border border-transparent hover:border-primary-100'" 
                                class="shrink-0 snap-start px-5 py-2 md:px-6 md:py-2.5 rounded-full text-xs md:text-sm font-bold transition-all duration-300">
                            Program
                        </button>
                        <button @click="activeCategory = 'artikel'" 
                                :class="activeCategory === 'artikel' ? 'bg-amber-600 text-white shadow-md shadow-amber-600/20' : 'bg-gray-50 text-gray-600 hover:bg-amber-50 hover:text-amber-600 border border-transparent hover:border-amber-100'" 
                                class="shrink-0 snap-start px-5 py-2 md:px-6 md:py-2.5 rounded-full text-xs md:text-sm font-bold transition-all duration-300">
                            Artikel
                        </button>
                        <button @click="activeCategory = 'kegiatan'" 
                                :class="activeCategory === 'kegiatan' ? 'bg-violet-600 text-white shadow-md shadow-violet-600/20' : 'bg-gray-50 text-gray-600 hover:bg-violet-50 hover:text-violet-600 border border-transparent hover:border-violet-100'" 
                                class="shrink-0 snap-start px-5 py-2 md:px-6 md:py-2.5 rounded-full text-xs md:text-sm font-bold transition-all duration-300">
                            Kegiatan
                        </button>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative w-full md:w-80">
                        <input type="text" x-model="searchQuery" placeholder="Cari judul artikel..." 
                               class="w-full pl-12 pr-10 py-3 bg-gray-50 border border-transparent hover:border-gray-200 focus:border-primary-500 rounded-full text-sm font-medium focus:ring-4 focus:ring-primary-500/10 transition-all outline-none text-gray-700">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        {{-- Clear Button --}}
                        <button x-show="searchQuery.length > 0" @click="searchQuery = ''" style="display: none;" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Empty State (if search no results) --}}
            <div x-show="!hasResults" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="text-center py-24 bg-white rounded-[2rem] border border-gray-100 shadow-sm mb-16">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Informasi Tidak Tersedia</h3>
                <p class="text-gray-500">Belum ada berita atau artikel untuk kategori atau pencarian ini.</p>
                <button @click="activeCategory = 'semua'; searchQuery = ''" class="mt-6 px-6 py-2.5 bg-primary-50 text-primary-600 hover:bg-primary-100 rounded-full text-sm font-bold transition-colors">
                    Kembali ke Semua
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
                @endphp
                <article x-data="{ title: '{{ addslashes(strtolower($article->title)) }}' }"
                         x-show="(activeCategory === 'semua' || activeCategory === '{{ $kategori }}') && (searchQuery === '' || title.includes(searchQuery.toLowerCase()))"
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
                            @if(!$article->image_path)
                            <div class="absolute inset-0 bg-gradient-to-br {{ $accent }} opacity-100"></div>

                            {{-- Abstract blob bg (only if no photo) --}}
                            <div class="absolute inset-0 opacity-20">
                                <svg class="w-full h-full" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="white" d="M47.7,-62.3C59.5,-51.8,65.4,-34.4,67.9,-17.2C70.5,-0.1,69.6,16.8,62.4,29.7C55.2,42.6,41.7,51.5,27.2,58.1C12.6,64.7,-3,69.1,-17.8,65.8C-32.7,62.5,-46.9,51.6,-56.6,37.4C-66.4,23.2,-71.7,5.8,-69.3,-10.4C-66.9,-26.7,-56.7,-41.8,-43.8,-52.2C-30.9,-62.6,-15.5,-68.4,1.4,-70.1C18.3,-71.8,35.9,-72.8,47.7,-62.3Z" transform="translate(100 100)" />
                                </svg>
                            </div>

                            <svg class="relative w-12 h-12 text-white/30 group-hover:text-white/50 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            @endif
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
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ number_format($article->views, 0, ',', '.') }} x Dilihat</p>
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
