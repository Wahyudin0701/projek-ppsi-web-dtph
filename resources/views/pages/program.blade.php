<x-layouts.public>
    <x-slot:title>Program Bantuan Alsintan - DTPH Muaro Jambi</x-slot:title>
    <x-slot:metaDescription>Lihat daftar program bantuan pertanian dari Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi yang terbuka untuk pengajuan proposal oleh kelompok tani.</x-slot:metaDescription>

    <div class="bg-[#f8faf9] min-h-screen" x-data="programPage()" @keydown.escape.window="drawer = false">

        {{-- Hero Section --}}
        <div class="bg-white py-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight pb-6">Program Bantuan</h1>
            <div class="w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Daftar program bantuan pertanian yang dikelola oleh DTPH Muaro Jambi. Daftarkan kelompok tani Anda dan ajukan proposal melalui sistem E-Proposal.
            </p>
        </div>

        @php
        $programs = [
            [
                'id'          => 7,
                'status_waktu'=> 'belum_berjalan',
                'status_pendaftaran' => 'segera',
                'label'       => 'Segera Dibuka',
                'labelColor'  => 'bg-amber-100 text-amber-700',
                'dotColor'    => 'bg-amber-500',
                'jenis'       => 'alsintan',
                'judul'       => 'Bantuan Alat Mesin Pertanian (Alsintan) Tahap III',
                'deskripsi'   => 'Program bantuan alsintan tahap ketiga yang akan segera dibuka. Siapkan kelompok tani Anda untuk mengikuti program ini.',
                'sasaran'     => 'Kelompok Tani Padi',
                'kuota'       => '50 Kelompok Tani',
                'jadwal_buka' => '01 Juli 2025',
                'jadwal_tutup'=> '31 Juli 2025',
                'tahap'       => 'Tahap III — 2026',
                'icon_path'   => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                'icon_color'  => 'text-amber-600',
                'icon_bg'     => 'bg-amber-50',
            ],
            [
                'id'          => 1,
                'status_waktu'=> 'sedang_berjalan',
                'status_pendaftaran' => 'buka',
                'label'       => 'Pendaftaran Buka',
                'labelColor'  => 'bg-emerald-100 text-emerald-700',
                'dotColor'    => 'bg-emerald-500',
                'jenis'       => 'alsintan',
                'judul'       => 'Bantuan Alat dan Mesin Pertanian (Alsintan) Tahap II',
                'deskripsi'   => 'Program bantuan alsintan berupa traktor tangan, pompa air, dan combine harvester mini untuk meningkatkan efisiensi pengolahan lahan dan panen padi bagi kelompok tani aktif.',
                'sasaran'     => 'Kelompok Tani Padi',
                'kuota'       => '45 Kelompok Tani',
                'jadwal_buka' => '01 Mei 2025',
                'jadwal_tutup'=> '31 Mei 2025',
                'tahap'       => 'Tahap II — 2025',
                'icon_path'   => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                'icon_color'  => 'text-primary-600',
                'icon_bg'     => 'bg-primary-50',
            ],
            [
                'id'          => 2,
                'status_waktu'=> 'sedang_berjalan',
                'status_pendaftaran' => 'buka',
                'label'       => 'Pendaftaran Buka',
                'labelColor'  => 'bg-emerald-100 text-emerald-700',
                'dotColor'    => 'bg-emerald-500',
                'jenis'       => 'benih',
                'judul'       => 'Bantuan Benih Padi Unggul Berlabel',
                'deskripsi'   => 'Penyediaan benih padi varietas unggul bersertifikat yang adaptif terhadap lahan gambut dan lahan kering di Kabupaten Muaro Jambi untuk meningkatkan produktivitas.',
                'sasaran'     => 'Petani Individu & Kelompok Tani',
                'kuota'       => '500 Ha lahan',
                'jadwal_buka' => '15 Mei 2025',
                'jadwal_tutup'=> '15 Juni 2025',
                'tahap'       => 'Musim Tanam 2025',
                'icon_path'   => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'icon_color'  => 'text-green-600',
                'icon_bg'     => 'bg-green-50',
            ],
            [
                'id'          => 3,
                'status_waktu'=> 'sedang_berjalan',
                'status_pendaftaran' => 'tutup',
                'label'       => 'Pendaftaran Tutup',
                'labelColor'  => 'bg-red-100 text-red-700',
                'dotColor'    => 'bg-red-500',
                'jenis'       => 'infrastruktur',
                'judul'       => 'Program Optimasi Lahan Rawa (OPLAH)',
                'deskripsi'   => 'Program perbaikan infrastruktur pertanian pada lahan rawa lebak dan pasang surut melalui kegiatan cetak sawah baru dan rehabilitasi jaringan irigasi tersier.',
                'sasaran'     => 'Kelompok Tani Lahan Rawa',
                'kuota'       => '200 Ha',
                'jadwal_buka' => '01 April 2025',
                'jadwal_tutup'=> '30 April 2025',
                'tahap'       => 'TA 2025',
                'icon_path'   => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
                'icon_color'  => 'text-blue-600',
                'icon_bg'     => 'bg-blue-50',
            ],
            [
                'id'          => 4,
                'status_waktu'=> 'berakhir',
                'status_pendaftaran' => 'tutup',
                'label'       => 'Program Selesai',
                'labelColor'  => 'bg-gray-100 text-gray-500',
                'dotColor'    => 'bg-gray-400',
                'jenis'       => 'alsintan',
                'judul'       => 'Bantuan Alsintan Tahap I — 2024',
                'deskripsi'   => 'Program bantuan alsintan tahap pertama yang telah berhasil mendistribusikan alat pertanian kepada 30 kelompok tani di 8 kecamatan pada tahun anggaran 2024.',
                'sasaran'     => 'Kelompok Tani Padi',
                'kuota'       => '30 Kelompok Tani',
                'jadwal_buka' => '01 November 2024',
                'jadwal_tutup'=> '31 Desember 2024',
                'tahap'       => 'Tahap I — 2024',
                'icon_path'   => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                'icon_color'  => 'text-gray-400',
                'icon_bg'     => 'bg-gray-50',
            ],
            [
                'id'          => 5,
                'status_waktu'=> 'berakhir',
                'status_pendaftaran' => 'tutup',
                'label'       => 'Program Selesai',
                'labelColor'  => 'bg-gray-100 text-gray-500',
                'dotColor'    => 'bg-gray-400',
                'jenis'       => 'pelatihan',
                'judul'       => 'Gerakan Penerapan Pengelolaan Tanaman Terpadu (GP-PTT)',
                'deskripsi'   => 'Program pelatihan dan pendampingan petani dalam penerapan teknologi budidaya padi terpadu dengan target peningkatan produktivitas minimal 20% dari rata-rata nasional.',
                'sasaran'     => 'Petani & Penyuluh BPP',
                'kuota'       => '10 Kecamatan',
                'jadwal_buka' => '01 Februari 2025',
                'jadwal_tutup'=> '31 Maret 2025',
                'tahap'       => 'TA 2024/2025',
                'icon_path'   => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'icon_color'  => 'text-gray-400',
                'icon_bg'     => 'bg-gray-50',
            ],
            [
                'id'          => 6,
                'status_waktu'=> 'berakhir',
                'status_pendaftaran' => 'tutup',
                'label'       => 'Program Selesai',
                'labelColor'  => 'bg-gray-100 text-gray-500',
                'dotColor'    => 'bg-gray-400',
                'jenis'       => 'pupuk',
                'judul'       => 'Bantuan Pupuk Organik Bersubsidi',
                'deskripsi'   => 'Program penyaluran pupuk organik bersubsidi untuk menunjang pertanian berkelanjutan pada lahan pertanian yang terdaftar dalam Sistem Informasi Manajemen Penyuluhan Pertanian (SIMLUHTAN).',
                'sasaran'     => 'Petani Terdaftar SIMLUHTAN',
                'kuota'       => '1.000 Ha lahan',
                'jadwal_buka' => '01 Januari 2025',
                'jadwal_tutup'=> '28 Februari 2025',
                'tahap'       => 'TA 2024',
                'icon_path'   => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                'icon_color'  => 'text-gray-400',
                'icon_bg'     => 'bg-gray-50',
            ],
        ];
        @endphp

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Search Bar --}}
            <div class="max-w-xl mx-auto mb-8 group">
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" x-model="searchQuery"
                        placeholder="Cari nama program, sasaran..."
                        class="w-full pl-5 pr-12 py-3.5 rounded-2xl border border-gray-200 bg-white text-gray-800 placeholder-gray-400 focus:border-primary-400 focus:ring-4 focus:ring-primary-400/10 transition-all shadow-sm text-sm font-medium">
                </div>
            </div>

            {{-- Filter Row --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-10">
                {{-- Dropdown Filter Kategori --}}
                <div class="relative">
                    <label class="sr-only">Filter Jenis Program</label>
                    <select x-model="activeCategory"
                        class="bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl pl-4 pr-10 py-2.5 shadow-sm focus:border-primary-400 focus:ring-2 focus:ring-primary-400/10 transition-all cursor-pointer">
                        <template x-for="category in categories" :key="category.id">
                            <option :value="category.id" x-text="category.name"></option>
                        </template>
                    </select>
                </div>
            </div>

            {{-- Section: Upcoming Programs --}}
            @php $belum = array_filter($programs, fn($p) => $p['status_waktu'] === 'belum_berjalan'); @endphp
            @if(count($belum) > 0)
            <div class="mb-24" x-show="hasVisiblePrograms('belum_berjalan')" x-cloak>
                <div class="flex items-center gap-3 mb-6">
                    <span class="flex items-center gap-1.5 text-sm font-bold text-amber-600">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Program Belum Berjalan
                    </span>
                    <span class="text-xs text-gray-400 font-medium"><span x-text="countVisible('belum_berjalan')"></span> program akan datang</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($belum as $program)
                    <div x-show="matchesFilterById({{ $program['id'] }})" x-transition @click="openDrawer({{ $program['id'] }})" class="cursor-pointer bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-[0_6px_30px_-10px_rgba(0,0,0,0.06)] hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.10)] transition-all duration-500 group flex flex-col hover:-translate-y-1.5">
                        {{-- Card Header --}}
                        <div class="p-6 sm:p-7 pb-4 flex items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $program['labelColor'] }} mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $program['dotColor'] }} animate-pulse"></span>
                                    {{ $program['label'] }}
                                </span>
                                <h2 class="text-base font-bold text-gray-900 leading-snug group-hover:text-primary-600 transition-colors">{{ $program['judul'] }}</h2>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="px-6 sm:px-7 pb-4">
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">{{ $program['deskripsi'] }}</p>
                        </div>

                        {{-- Meta --}}
                        <div class="px-6 sm:px-7 pb-4 grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Sasaran</p>
                                <p class="text-xs font-bold text-gray-800 leading-snug">{{ $program['sasaran'] }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Kuota</p>
                                <p class="text-xs font-bold text-gray-800 leading-snug">{{ $program['kuota'] }}</p>
                            </div>
                        </div>

                        {{-- Jadwal --}}
                        <div class="px-6 sm:px-7 pb-6 grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Jadwal Buka</p>
                                <p class="text-xs font-bold text-gray-800 leading-snug">{{ $program['jadwal_buka'] }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Jadwal Tutup</p>
                                <p class="text-xs font-bold text-gray-800 leading-snug">{{ $program['jadwal_tutup'] }}</p>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="px-6 sm:px-7 py-4 mt-auto border-t border-gray-50 flex items-center justify-between">
                            <span class="text-xs text-gray-400 font-medium">{{ $program['tahap'] }}</span>
                            <span class="text-xs font-bold text-amber-600">Segera Dibuka</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Section: Active Programs --}}
            @php $aktif = array_filter($programs, fn($p) => $p['status_waktu'] === 'sedang_berjalan'); @endphp
            @if(count($aktif) > 0)
            <div class="mb-24" x-show="hasVisiblePrograms('sedang_berjalan')" x-cloak>
                <div class="flex items-center gap-3 mb-6">
                    <span class="flex items-center gap-1.5 text-sm font-bold text-emerald-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Program Sedang Berjalan
                    </span>
                    <span class="text-xs text-gray-400 font-medium"><span x-text="countVisible('sedang_berjalan')"></span> program berjalan</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($aktif as $program)
                    <div x-show="matchesFilterById({{ $program['id'] }})" x-transition @click="openDrawer({{ $program['id'] }})" class="cursor-pointer bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-[0_6px_30px_-10px_rgba(0,0,0,0.06)] hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.10)] transition-all duration-500 group flex flex-col hover:-translate-y-1.5">
                        {{-- Card Header --}}
                        <div class="p-6 sm:p-7 pb-4 flex items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $program['labelColor'] }} mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $program['dotColor'] }} animate-pulse"></span>
                                    {{ $program['label'] }}
                                </span>
                                <h2 class="text-base font-bold text-gray-900 leading-snug group-hover:text-primary-600 transition-colors">{{ $program['judul'] }}</h2>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="px-6 sm:px-7 pb-5">
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">{{ $program['deskripsi'] }}</p>
                        </div>

                        {{-- Meta --}}
                        <div class="px-6 sm:px-7 pb-4 grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Sasaran</p>
                                <p class="text-xs font-bold text-gray-800 leading-snug">{{ $program['sasaran'] }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Kuota</p>
                                <p class="text-xs font-bold text-gray-800 leading-snug">{{ $program['kuota'] }}</p>
                            </div>
                        </div>

                        {{-- Jadwal --}}
                        <div class="px-6 sm:px-7 pb-6 grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Jadwal Buka</p>
                                <p class="text-xs font-bold text-emerald-600 leading-snug">{{ $program['jadwal_buka'] }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Jadwal Tutup</p>
                                <p class="text-xs font-bold text-red-600 leading-snug">{{ $program['jadwal_tutup'] }}</p>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="px-6 sm:px-7 py-4 mt-auto border-t border-gray-50 flex items-center justify-between">
                            <span class="text-xs text-gray-400 font-medium">{{ $program['tahap'] }}</span>
                            @if($program['status_pendaftaran'] === 'buka')
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                    Ajukan Proposal
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            @else
                                <span class="text-xs font-bold text-gray-400">Pendaftaran Ditutup</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Section: Closed Programs --}}
            @php $tutup = array_filter($programs, fn($p) => $p['status_waktu'] === 'berakhir'); @endphp
            @if(count($tutup) > 0)
            <div class="mb-24" x-show="hasVisiblePrograms('berakhir')" x-cloak>
                <div class="flex items-center gap-3 mb-6">
                    <span class="flex items-center gap-1.5 text-sm font-bold text-gray-500">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                        Program Berakhir
                    </span>
                    <span class="text-xs text-gray-400 font-medium"><span x-text="countVisible('berakhir')"></span> program telah berakhir</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tutup as $program)
                    <div x-show="matchesFilterById({{ $program['id'] }})" x-transition @click="openDrawer({{ $program['id'] }})" class="cursor-pointer bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-[0_4px_20px_-8px_rgba(0,0,0,0.04)] flex flex-col opacity-80">
                        {{-- Card Header --}}
                        <div class="p-6 sm:p-7 pb-4 flex items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $program['labelColor'] }} mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $program['dotColor'] }}"></span>
                                    {{ $program['label'] }}
                                </span>
                                <h2 class="text-base font-bold text-gray-700 leading-snug">{{ $program['judul'] }}</h2>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="px-6 sm:px-7 pb-5">
                            <p class="text-sm text-gray-400 leading-relaxed line-clamp-3">{{ $program['deskripsi'] }}</p>
                        </div>

                        {{-- Meta --}}
                        <div class="px-6 sm:px-7 pb-4 grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Sasaran</p>
                                <p class="text-xs font-bold text-gray-600 leading-snug">{{ $program['sasaran'] }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Kuota</p>
                                <p class="text-xs font-bold text-gray-600 leading-snug">{{ $program['kuota'] }}</p>
                            </div>
                        </div>

                        {{-- Jadwal --}}
                        <div class="px-6 sm:px-7 pb-6 grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 opacity-70">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Jadwal Buka</p>
                                <p class="text-xs font-bold text-gray-500 leading-snug">{{ $program['jadwal_buka'] }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 opacity-70">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Jadwal Tutup</p>
                                <p class="text-xs font-bold text-gray-500 leading-snug">{{ $program['jadwal_tutup'] }}</p>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="px-6 sm:px-7 py-4 mt-auto border-t border-gray-50 flex items-center justify-between">
                            <span class="text-xs text-gray-400 font-medium">{{ $program['tahap'] }}</span>
                            <span class="text-xs font-bold text-gray-400">Pendaftaran Ditutup</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Info Banner --}}
            <div class="bg-primary-600 rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 overflow-hidden shadow-xl shadow-primary-600/20">
                <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2">Siap Mengajukan Proposal?</h3>
                        <p class="text-white/90 text-sm md:text-base max-w-lg leading-relaxed font-medium">
                            Daftarkan akun kelompok tani Anda dan ajukan proposal bantuan secara digital melalui sistem E-Proposal DTPH Muaro Jambi.
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 w-full md:w-auto flex flex-col sm:flex-row md:flex-col gap-3">
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center gap-2 px-8 py-4 bg-white text-primary-600 hover:bg-primary-50 font-bold text-sm rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-xl">
                        Daftar Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center gap-2 px-8 py-4 bg-white/10 text-white hover:bg-white/20 border border-white/30 font-bold text-sm rounded-2xl transition-all active:scale-95">
                        Sudah Punya Akun
                    </a>
                </div>
            </div>

        </div>

    {{-- Slide-over Drawer (inside x-data scope) --}}
    <div x-show="drawer" x-cloak class="fixed inset-0 z-50 flex justify-start" @click.self="drawer = false">
        {{-- Backdrop --}}
        <div x-show="drawer" x-transition.opacity.duration.300ms class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="drawer = false"></div>

        {{-- Panel --}}
        <div x-show="drawer"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-250 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="drawer-panel relative w-full max-w-lg bg-white h-full overflow-y-auto shadow-2xl flex flex-col"
             style="scrollbar-width: none; -ms-overflow-style: none;">

            {{-- Drawer Header --}}
            <div class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-100 px-6 py-4 flex items-center justify-between z-10">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Detail Program</span>
                <button @click="drawer = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-red-100 hover:text-red-500 text-gray-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Drawer Body --}}
            <template x-if="selected">
                <div class="flex-1 p-6">
                    {{-- Status --}}
                    <div class="mb-5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold"
                              :class="selected.labelColor">
                            <span class="w-1.5 h-1.5 rounded-full"
                                  :class="selected.dotColor + (selected.status_waktu === 'sedang_berjalan' ? ' animate-pulse' : '')"></span>
                            <span x-text="selected.label"></span>
                        </span>
                    </div>

                    {{-- Title --}}
                    <h2 class="text-2xl font-black text-gray-900 leading-tight mb-4" x-text="selected.judul"></h2>

                    {{-- Description --}}
                    <p class="text-gray-500 leading-relaxed text-sm mb-8" x-text="selected.deskripsi"></p>

                    {{-- Info Grid --}}
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Sasaran</p>
                            <p class="text-sm font-bold text-gray-900" x-text="selected.sasaran"></p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Kuota</p>
                            <p class="text-sm font-bold text-gray-900" x-text="selected.kuota"></p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 col-span-2">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Tahap</p>
                            <p class="text-sm font-bold text-gray-900" x-text="selected.tahap"></p>
                        </div>
                    </div>

                    {{-- Jadwal Grid --}}
                    <div class="grid grid-cols-2 gap-3 mb-8">
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Jadwal Buka</p>
                            <p class="text-sm font-bold text-gray-900" x-text="selected.jadwal_buka"></p>
                        </div>
                        <div class="rounded-2xl p-4" :class="selected.status_pendaftaran === 'buka' ? 'bg-red-50 border border-red-100' : 'bg-gray-50 border border-gray-100'">
                            <p class="text-[10px] font-bold uppercase tracking-wider mb-1" :class="selected.status_pendaftaran === 'buka' ? 'text-red-400' : 'text-gray-400'">Jadwal Tutup</p>
                            <p class="text-sm font-bold" :class="selected.status_pendaftaran === 'buka' ? 'text-red-600' : 'text-gray-600'" x-text="selected.jadwal_tutup"></p>
                        </div>
                    </div>

                    {{-- Persyaratan Umum --}}
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Persyaratan Umum</h3>
                        <ul class="space-y-2">
                            <template x-for="syarat in (selected.syarat || defaultSyarat)" :key="syarat">
                                <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-primary-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span x-text="syarat"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </template>

            {{-- Drawer Footer --}}
            <div class="sticky bottom-0 bg-white border-t border-gray-100 p-5 flex gap-3">
                <template x-if="selected && selected.status_pendaftaran === 'buka'">
                    <a href="{{ route('login') }}" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-2xl text-sm font-bold text-center transition-colors shadow-lg shadow-primary-600/20">
                        Ajukan Proposal Sekarang
                    </a>
                </template>
                <template x-if="selected && selected.status_pendaftaran === 'segera'">
                    <div class="flex-1 bg-amber-100 text-amber-600 py-3.5 rounded-2xl text-sm font-bold text-center cursor-not-allowed">
                        Pendaftaran Segera Dibuka
                    </div>
                </template>
                <template x-if="selected && selected.status_pendaftaran === 'tutup'">
                    <div class="flex-1 bg-gray-100 text-gray-400 py-3.5 rounded-2xl text-sm font-bold text-center cursor-not-allowed">
                        Pendaftaran Telah Ditutup
                    </div>
                </template>
                <button @click="drawer = false" class="px-5 py-3.5 border border-gray-200 rounded-2xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    {{-- End x-data wrapper --}}
    </div>

    <style>
        [data-drawer-panel]::-webkit-scrollbar { display: none; }
        .drawer-panel::-webkit-scrollbar { display: none; }
    </style>

    <script>
        const programsData = @json($programs);

        document.addEventListener('alpine:init', () => {
            Alpine.data('programPage', () => ({
                drawer: false,
                selected: null,
                searchQuery: '',
                activeCategory: 'semua',
                categories: [
                    { id: 'semua', name: 'Semua Jenis Program' },
                    { id: 'alsintan', name: 'Alsintan' },
                    { id: 'benih', name: 'Benih' },
                    { id: 'pupuk', name: 'Pupuk' },
                    { id: 'infrastruktur', name: 'Infrastruktur' },
                    { id: 'pelatihan', name: 'Pelatihan & Pendampingan' },
                ],
                matchesFilterById(id) {
                    const p = programsData.find(p => p.id === id);
                    if(!p) return false;

                    const query = this.searchQuery.toLowerCase();
                    const matchSearch = p.judul.toLowerCase().includes(query) || 
                                        p.deskripsi.toLowerCase().includes(query) ||
                                        p.sasaran.toLowerCase().includes(query);

                    const matchCategory = this.activeCategory === 'semua' || p.jenis === this.activeCategory;
                    
                    return matchSearch && matchCategory;
                },
                hasVisiblePrograms(status_waktu) {
                    return this.countVisible(status_waktu) > 0;
                },
                countVisible(status_waktu) {
                    return programsData.filter(p => p.status_waktu === status_waktu && this.matchesFilterById(p.id)).length;
                },
                defaultSyarat: [
                    'Terdaftar sebagai anggota kelompok tani aktif',
                    'Memiliki lahan pertanian yang sah (dibuktikan dengan surat kepemilikan)',
                    'Mengisi formulir pengajuan proposal secara lengkap melalui sistem E-Proposal',
                    'Melampirkan surat rekomendasi dari PPL/BPP setempat',
                    'Bersedia mengikuti pelatihan penggunaan dan perawatan alat',
                ],
                openDrawer(id) {
                    this.selected = programsData.find(p => p.id === id) || null;
                    this.drawer = true;
                    document.body.style.overflow = 'hidden';
                },
                init() {
                    this.$watch('drawer', val => {
                        document.body.style.overflow = val ? 'hidden' : '';
                    });
                }
            }));
        });
    </script>
</x-layouts.public>
