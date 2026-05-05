<x-layouts.public>
    <x-slot:title>Tugas & Fungsi - DTPH Muaro Jambi</x-slot:title>

    <div class="bg-gray-50 min-h-screen">
        {{-- Hero Header --}}
        <div class="bg-white py-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight pb-6">Tugas & Fungsi</h1>
            <div class="w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi
            </p>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

            {{-- ============================================ --}}
            {{-- TUGAS POKOK --}}
            {{-- ============================================ --}}
            <section class="mb-16">
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-600/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Tugas Pokok</h2>
                </div>

                <div class="bg-gradient-to-br from-emerald-600 to-green-700 rounded-2xl p-7 md:p-10 shadow-lg shadow-emerald-600/20 relative overflow-hidden">
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full"></div>
                    <div class="absolute -bottom-10 -left-8 w-52 h-52 bg-white/5 rounded-full"></div>
                    <div class="relative z-10">
                        <p class="text-base md:text-lg text-white/80 italic mb-4">Berdasarkan Peraturan Bupati Muaro Jambi tentang Tugas Pokok dan Fungsi Dinas Tanaman Pangan dan Hortikultura:</p>
                        <p class="text-lg md:text-xl font-bold text-white leading-relaxed">
                            "Melaksanakan urusan pemerintahan daerah yang menjadi kewenangan daerah di bidang tanaman pangan dan hortikultura berdasarkan asas otonomi daerah dan tugas pembantuan."
                        </p>
                    </div>
                </div>
            </section>

            {{-- ============================================ --}}
            {{-- FUNGSI --}}
            {{-- ============================================ --}}
            <section class="mb-16">
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-600/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Fungsi</h2>
                </div>

                @php
                $fungsi = [
                    'Perumusan kebijakan teknis di bidang tanaman pangan dan hortikultura sesuai dengan kebijakan yang ditetapkan oleh Bupati.',
                    'Penyelenggaraan urusan pemerintahan dan pelayanan umum di bidang tanaman pangan dan hortikultura.',
                    'Pembinaan dan pelaksanaan tugas di bidang tanaman pangan dan hortikultura di wilayah Kabupaten Muaro Jambi.',
                    'Pengembangan dan pengelolaan sistem informasi pertanian tanaman pangan dan hortikultura di daerah.',
                    'Pelaksanaan evaluasi dan pelaporan di bidang tanaman pangan dan hortikultura kepada Bupati.',
                    'Pengelolaan administrasi umum meliputi ketatalaksanaan, keuangan, kepegawaian, dan perlengkapan dinas.',
                    'Pembinaan Unit Pelaksana Teknis (UPT) Dinas dan Balai Penyuluhan Pertanian (BPP) di tingkat kecamatan.',
                    'Pelaksanaan fungsi lain yang diberikan oleh Bupati terkait dengan tugas dan fungsi dinas.',
                ];
                @endphp

                <div class="space-y-4">
                    @foreach($fungsi as $index => $item)
                    <div class="flex gap-5 bg-white rounded-2xl border border-gray-100 p-5 hover:border-emerald-200 hover:shadow-md transition-all duration-200 group">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center group-hover:bg-emerald-600 group-hover:border-emerald-600 transition-all duration-200">
                            <span class="text-sm font-extrabold text-emerald-600 group-hover:text-white transition-colors duration-200">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <p class="text-gray-700 text-sm md:text-base leading-relaxed pt-1.5 text-justify">{{ $item }}</p>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- ============================================ --}}
            {{-- TUGAS PER BIDANG --}}
            {{-- ============================================ --}}
            <section>
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-600/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Tugas Per Bidang</h2>
                </div>

                @php
                $bidang = [
                    [
                        'name'  => 'Sekretariat',
                        'color' => ['bg' => 'bg-blue-600', 'light' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'badge' => 'bg-blue-100 text-blue-700'],
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                        'tugas' => [
                            'Mengelola administrasi umum, kepegawaian, keuangan, dan perlengkapan dinas.',
                            'Menyusun rencana kerja dan anggaran (RKA) tahunan dinas.',
                            'Mengkoordinasikan pelaporan kinerja dan laporan keuangan kepada instansi terkait.',
                            'Mengelola arsip dan dokumentasi dinas.',
                        ],
                    ],
                    [
                        'name'  => 'Bidang Tanaman Pangan',
                        'color' => ['bg' => 'bg-green-600', 'light' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-700', 'badge' => 'bg-green-100 text-green-700'],
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                        'tugas' => [
                            'Merumuskan dan melaksanakan kebijakan produksi tanaman pangan (padi, jagung, kedelai, dan palawija).',
                            'Melaksanakan pembinaan peningkatan produktivitas tanaman pangan melalui penerapan teknologi budidaya.',
                            'Memfasilitasi penyediaan benih unggul bermutu dan pupuk bersubsidi bagi petani.',
                            'Melaksanakan pengendalian serangan Organisme Pengganggu Tumbuhan (OPT) pada tanaman pangan.',
                            'Menyusun statistik dan laporan produksi tanaman pangan daerah.',
                        ],
                    ],
                    [
                        'name'  => 'Bidang Hortikultura',
                        'color' => ['bg' => 'bg-lime-600', 'light' => 'bg-lime-50', 'border' => 'border-lime-200', 'text' => 'text-lime-700', 'badge' => 'bg-lime-100 text-lime-700'],
                        'icon'  => '<circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z"/>',
                        'tugas' => [
                            'Merumuskan dan melaksanakan kebijakan produksi komoditas hortikultura (sayuran, buah-buahan, dan tanaman hias).',
                            'Membina dan mengembangkan agribisnis hortikultura yang berdaya saing dan berorientasi pasar.',
                            'Memfasilitasi penerapan Good Agricultural Practices (GAP) pada usaha hortikultura.',
                            'Melaksanakan pengendalian OPT pada tanaman hortikultura.',
                            'Mendorong sertifikasi produk hortikultura untuk peningkatan nilai jual.',
                        ],
                    ],
                    [
                        'name'  => 'Bidang Prasarana & Sarana Pertanian',
                        'color' => ['bg' => 'bg-teal-600', 'light' => 'bg-teal-50', 'border' => 'border-teal-200', 'text' => 'text-teal-700', 'badge' => 'bg-teal-100 text-teal-700'],
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
                        'tugas' => [
                            'Merencanakan, mengadakan, dan mendistribusikan bantuan Alat dan Mesin Pertanian (Alsintan).',
                            'Mengelola sistem pengajuan bantuan Alsintan melalui portal E-Proposal secara transparan dan akuntabel.',
                            'Mengembangkan jaringan irigasi pertanian dan infrastruktur lahan pertanian.',
                            'Memfasilitasi akses permodalan petani melalui program Kredit Usaha Rakyat (KUR) sektor pertanian.',
                            'Melaksanakan pembinaan dan pengawasan peredaran pupuk dan pestisida di tingkat pengecer dan petani.',
                        ],
                    ],
                    [
                        'name'  => 'Bidang Penyuluhan Pertanian',
                        'color' => ['bg' => 'bg-cyan-600', 'light' => 'bg-cyan-50', 'border' => 'border-cyan-200', 'text' => 'text-cyan-700', 'badge' => 'bg-cyan-100 text-cyan-700'],
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>',
                        'tugas' => [
                            'Menyusun program dan materi penyuluhan pertanian yang relevan dan berbasis kebutuhan petani.',
                            'Membina dan meningkatkan kapasitas Penyuluh Pertanian Lapangan (PPL) di setiap kecamatan.',
                            'Memfasilitasi penguatan kelembagaan petani (Kelompok Tani, Gapoktan, dan Poktan).',
                            'Mendorong penerapan teknologi informasi dan inovasi pertanian di tingkat petani.',
                            'Melaksanakan koordinasi dengan Balai Penyuluhan Pertanian (BPP) di seluruh kecamatan.',
                        ],
                    ],
                ];
                @endphp

                <div class="space-y-6" x-data="{ openBidang: null }">
                    @foreach($bidang as $i => $b)
                    <div class="bg-white rounded-2xl border {{ $b['color']['border'] }} overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        {{-- Header --}}
                        <button @click="openBidang = openBidang === {{ $i }} ? null : {{ $i }}"
                                class="w-full flex items-center justify-between px-6 py-5 text-left group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 {{ $b['color']['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $b['icon'] !!}
                                    </svg>
                                </div>
                                <span class="text-base font-bold {{ $b['color']['text'] }}">{{ $b['name'] }}</span>
                            </div>
                            <svg :class="openBidang === {{ $i }} ? 'rotate-180' : ''"
                                 class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Body --}}
                        <div x-show="openBidang === {{ $i }}" x-collapse.duration.500ms x-cloak class="{{ $b['color']['light'] }} border-t {{ $b['color']['border'] }}">
                            <ul class="px-6 py-5 space-y-3">
                                @foreach($b['tugas'] as $ti => $tugas)
                                <li class="flex gap-3 text-sm text-gray-700 text-justify">
                                    <span class="flex-shrink-0 w-5 h-5 rounded-full {{ $b['color']['bg'] }} text-white flex items-center justify-center text-[10px] font-bold mt-0.5">{{ $ti + 1 }}</span>
                                    <span>{{ $tugas }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
</x-layouts.public>
