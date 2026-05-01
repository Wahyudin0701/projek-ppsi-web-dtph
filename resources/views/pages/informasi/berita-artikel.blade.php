<x-layouts.public>
    <x-slot:title>Berita & Artikel - DTPH Muaro Jambi</x-slot:title>
    <x-slot:metaDescription>Baca berita terbaru, artikel informatif, dan pengumuman resmi seputar dunia pertanian dari Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi.</x-slot:metaDescription>

    <div class="bg-[#f8faf9] min-h-screen">

        {{-- Hero Header --}}
        <div class="bg-white pt-8 md:pt-12 pb-10 text-center border-b border-gray-100">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Berita & Artikel</h1>
            <div class="mt-4 w-16 h-1 bg-emerald-500 mx-auto rounded-full"></div>
            <p class="mt-4 text-gray-500 max-w-xl mx-auto text-sm md:text-base px-4">
                Informasi terkini seputar program pertanian, kegiatan dinas, dan artikel edukatif untuk petani Muaro Jambi.
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            @php
            $articles = [
                [
                    'slug'      => 'penyerahan-bantuan-alsintan-45-kelompok-tani',
                    'kategori'  => 'berita',
                    'label'     => 'Berita',
                    'labelColor'=> 'bg-blue-100 text-blue-700',
                    'accent'    => 'from-blue-800 to-blue-950',
                    'foto'      => 'https://picsum.photos/seed/farming1/800/600',
                    'judul'     => 'Penyerahan Bantuan Alsintan kepada 45 Kelompok Tani se-Muaro Jambi',
                    'ringkasan' => 'Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi secara resmi menyerahkan bantuan alat dan mesin pertanian (Alsintan) kepada 45 kelompok tani di 11 kecamatan.',
                    'tanggal'   => '28 April 2025',
                    'penulis'   => 'Tim Humas DTPH',
                    'waktu'     => '5 menit baca',
                ],
                [
                    'slug'      => 'pendaftaran-e-proposal-alsintan-tahap-2',
                    'kategori'  => 'program',
                    'label'     => 'Program',
                    'labelColor'=> 'bg-emerald-100 text-emerald-700',
                    'accent'    => 'from-emerald-700 to-emerald-950',
                    'foto'      => 'https://picsum.photos/seed/agriculture2/800/600',
                    'judul'     => 'Pendaftaran E-Proposal Alsintan Tahap II Resmi Dibuka',
                    'ringkasan' => 'Petani dan kelompok tani di wilayah Kabupaten Muaro Jambi kini dapat mengajukan proposal bantuan alsintan secara digital melalui portal E-Proposal DTPH.',
                    'tanggal'   => '22 April 2025',
                    'penulis'   => 'Admin DTPH',
                    'waktu'     => '3 menit baca',
                ],
                [
                    'slug'      => 'cara-merawat-traktor-tangan',
                    'kategori'  => 'artikel',
                    'label'     => 'Artikel',
                    'labelColor'=> 'bg-amber-100 text-amber-700',
                    'accent'    => 'from-amber-700 to-amber-950',
                    'foto'      => 'https://picsum.photos/seed/tractor3/800/600',
                    'judul'     => 'Cara Merawat Traktor Tangan agar Awet dan Produktif',
                    'ringkasan' => 'Perawatan rutin alsintan merupakan kunci utama untuk memastikan mesin pertanian tetap bekerja optimal sepanjang musim tanam. Simak panduan lengkapnya.',
                    'tanggal'   => '15 April 2025',
                    'penulis'   => 'Penyuluh Pertanian',
                    'waktu'     => '7 menit baca',
                ],
                [
                    'slug'      => 'bimtek-drone-pertanian-penyuluh-bpp',
                    'kategori'  => 'kegiatan',
                    'label'     => 'Kegiatan',
                    'labelColor'=> 'bg-violet-100 text-violet-700',
                    'accent'    => 'from-violet-800 to-violet-950',
                    'foto'      => 'https://picsum.photos/seed/drone4/800/600',
                    'judul'     => 'Bimtek Penggunaan Drone Pertanian untuk Penyuluh BPP',
                    'ringkasan' => 'Sebanyak 24 penyuluh pertanian lapangan dari seluruh BPP se-Kabupaten Muaro Jambi mengikuti bimbingan teknis penggunaan drone untuk pemantauan lahan.',
                    'tanggal'   => '10 April 2025',
                    'penulis'   => 'Bidang Penyuluhan',
                    'waktu'     => '4 menit baca',
                ],
                [
                    'slug'      => 'varietas-padi-unggul-lahan-gambut',
                    'kategori'  => 'artikel',
                    'label'     => 'Artikel',
                    'labelColor'=> 'bg-amber-100 text-amber-700',
                    'accent'    => 'from-amber-700 to-amber-950',
                    'foto'      => 'https://picsum.photos/seed/paddy5/800/600',
                    'judul'     => 'Mengenal Varietas Padi Unggul yang Cocok untuk Lahan Gambut',
                    'ringkasan' => 'Lahan gambut menjadi tantangan tersendiri bagi petani padi. Berikut varietas-varietas padi yang terbukti adaptif dan berdaya hasil tinggi di lahan gambut tropis.',
                    'tanggal'   => '05 April 2025',
                    'penulis'   => 'Kabid Tanaman Pangan',
                    'waktu'     => '6 menit baca',
                ],
                [
                    'slug'      => 'dtph-raih-penghargaan-inovasi-pelayanan-publik',
                    'kategori'  => 'berita',
                    'label'     => 'Berita',
                    'labelColor'=> 'bg-blue-100 text-blue-700',
                    'accent'    => 'from-blue-800 to-blue-950',
                    'foto'      => 'https://picsum.photos/seed/award6/800/600',
                    'judul'     => 'DTPH Raih Penghargaan Inovasi Pelayanan Publik Tingkat Provinsi',
                    'ringkasan' => 'Melalui program E-Proposal Alsintan, DTPH Muaro Jambi berhasil meraih penghargaan inovasi pelayanan publik terbaik di tingkat Provinsi Jambi tahun 2025.',
                    'tanggal'   => '01 April 2025',
                    'penulis'   => 'Tim Humas DTPH',
                    'waktu'     => '4 menit baca',
                ],
            ];
            @endphp

            {{-- Article Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                <article class="bg-white rounded-[2rem] overflow-hidden border border-gray-100 shadow-[0_6px_30px_-10px_rgba(0,0,0,0.06)] hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.1)] transition-all duration-500 group flex flex-col hover:-translate-y-1.5">

                    {{-- Image Area --}}
                    <a href="{{ route('informasi.berita-artikel.detail', $article['slug']) }}" class="block">
                        <div class="h-48 relative overflow-hidden flex items-center justify-center">
                            {{-- Photo Background --}}
                            @if(!empty($article['foto']))
                                <img src="{{ $article['foto'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @endif
                            
                            {{-- Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-br {{ $article['accent'] }} {{ !empty($article['foto']) ? 'opacity-60' : 'opacity-100' }}"></div>

                            {{-- Abstract blob bg (only if no photo) --}}
                            @if(empty($article['foto']))
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
                                    {{ $article['label'] }}
                                </span>
                            </div>
                        </div>
                    </a>

                    {{-- Content --}}
                    <div class="p-7 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $article['labelColor'] }}">{{ $article['label'] }}</span>
                            <span class="text-[10px] text-gray-400 font-medium">{{ $article['tanggal'] }}</span>
                        </div>

                        <a href="{{ route('informasi.berita-artikel.detail', $article['slug']) }}" class="block flex-1">
                            <h2 class="text-base font-bold text-gray-900 leading-snug mb-3 group-hover:text-emerald-700 transition-colors line-clamp-2">
                                {{ $article['judul'] }}
                            </h2>
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">{{ $article['ringkasan'] }}</p>
                        </a>

                        <div class="flex items-center justify-between pt-5 mt-5 border-t border-gray-50">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700 font-bold text-[10px] flex-shrink-0">
                                    {{ strtoupper(substr($article['penulis'], 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-800 leading-none">{{ $article['penulis'] }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $article['waktu'] }}</p>
                                </div>
                            </div>
                            <a href="{{ route('informasi.berita-artikel.detail', $article['slug']) }}" class="flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-all hover:translate-x-0.5">
                                Selengkapnya
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>

                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-16 flex justify-center items-center gap-2">
                <button class="w-10 h-10 rounded-2xl bg-white border border-gray-100 text-gray-400 hover:bg-gray-50 transition-colors shadow-sm flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-600/20">1</button>
                <button class="w-10 h-10 rounded-2xl bg-white border border-gray-100 text-gray-600 font-bold text-sm hover:bg-gray-50 transition-colors shadow-sm">2</button>
                <button class="w-10 h-10 rounded-2xl bg-white border border-gray-100 text-gray-600 font-bold text-sm hover:bg-gray-50 transition-colors shadow-sm">3</button>
                <button class="w-10 h-10 rounded-2xl bg-white border border-gray-100 text-gray-400 hover:bg-gray-50 transition-colors shadow-sm flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

        </div>
    </div>
</x-layouts.public>
