<x-layouts.app>
    <x-slot:title>Katalog Alsintan</x-slot:title>
    <x-slot:pageTitle>Katalog Alsintan</x-slot:pageTitle>
    <x-slot:pageSubtitle>Daftar alat dan mesin pertanian yang tersedia untuk dipinjam</x-slot:pageSubtitle>

    @php
        // ============================================================
        // DATA DUMMY ALSINTAN
        // ============================================================
        $alsintan = [
            ['id' => 1, 'nama' => 'Traktor Roda 2 — 8.5 PK',       'kategori' => 'traktor',  'status' => 'tersedia', 'stok' => 5, 'spek' => '8.5 PK, Bensin',     'unit' => 'UPTD Kec. Ciawi'],
            ['id' => 2, 'nama' => 'Traktor Roda 4 — 45 PK',         'kategori' => 'traktor',  'status' => 'dipinjam', 'stok' => 0, 'spek' => '45 PK, Solar',        'unit' => 'UPTD Kec. Sukaraja'],
            ['id' => 3, 'nama' => 'Pompa Air Centrifugal 3"',        'kategori' => 'pompa',    'status' => 'tersedia', 'stok' => 8, 'spek' => '3 Inch, 5.5 PK',      'unit' => 'UPTD Kec. Ciawi'],
            ['id' => 4, 'nama' => 'Pompa Air Submersible',           'kategori' => 'pompa',    'status' => 'tersedia', 'stok' => 3, 'spek' => '0.5 HP, Listrik',     'unit' => 'UPTD Kec. Cisarua'],
            ['id' => 5, 'nama' => 'Cultivator / Hand Tractor',       'kategori' => 'cultivator','status'=> 'tersedia', 'stok' => 6, 'spek' => '5 PK, Bensin',        'unit' => 'UPTD Kec. Ciawi'],
            ['id' => 6, 'nama' => 'Mesin Tanam Padi (Rice Transplanter)', 'kategori' => 'tanam', 'status' => 'dipinjam', 'stok' => 0, 'spek' => 'Riding Type, 4 row','unit' => 'UPTD Kec. Megamendung'],
            ['id' => 7, 'nama' => 'Sprayer Gendong Elektrik',        'kategori' => 'sprayer',  'status' => 'tersedia', 'stok' => 12,'spek' => '16L, Baterai 12V',    'unit' => 'UPTD Kec. Ciawi'],
            ['id' => 8, 'nama' => 'Mesin Panen Padi (Combine Harvester)', 'kategori' => 'panen', 'status' => 'tersedia', 'stok' => 2, 'spek' => 'Mini Combine, Solar','unit' => 'UPTD Kec. Sukaraja'],
            ['id' => 9, 'nama' => 'Power Thresher (Perontok Padi)', 'kategori' => 'panen',    'status' => 'dipinjam', 'stok' => 0, 'spek' => '7 PK, Bensin',        'unit' => 'UPTD Kec. Cisarua'],
            ['id' => 10,'nama' => 'Dryer Padi Kapasitas 4 Ton',     'kategori' => 'pasca',    'status' => 'tersedia', 'stok' => 1, 'spek' => '4 Ton/proses, Solar', 'unit' => 'UPTD Kec. Ciawi'],
            ['id' => 11,'nama' => 'Mesin Penggilingan Padi',        'kategori' => 'pasca',    'status' => 'tersedia', 'stok' => 2, 'spek' => 'Kapasitas 500 kg/jam', 'unit' => 'UPTD Kec. Sukaraja'],
            ['id' => 12,'nama' => 'Chopper Rumput Ternak',          'kategori' => 'lainnya',  'status' => 'tersedia', 'stok' => 4, 'spek' => '5 PK, Bensin',        'unit' => 'UPTD Kec. Megamendung'],
        ];

        $kategoriList = [
            ''          => 'Semua Kategori',
            'traktor'   => 'Traktor',
            'pompa'     => 'Pompa Air',
            'cultivator'=> 'Cultivator',
            'sprayer'   => 'Sprayer',
            'tanam'     => 'Alat Tanam',
            'panen'     => 'Alat Panen',
            'pasca'     => 'Pasca Panen',
            'lainnya'   => 'Lainnya',
        ];

        $ikonAlat = [
            'traktor'    => '🚜',
            'pompa'      => '💧',
            'cultivator' => '⚙️',
            'sprayer'    => '🌿',
            'tanam'      => '🌱',
            'panen'      => '🌾',
            'pasca'      => '🏭',
            'lainnya'    => '🔧',
        ];
    @endphp

    {{-- ============================================================
         SEARCH & FILTER BAR
         ============================================================ --}}
    <div class="card p-4 mb-6 animate-fade-in-down"
         x-data="{
             search: '',
             kategori: '',
             statusFilter: '',
             get filtered() {
                 const alat = {{ Js::from($alsintan) }};
                 return alat.filter(a => {
                     const matchSearch   = !this.search   || a.nama.toLowerCase().includes(this.search.toLowerCase());
                     const matchKategori = !this.kategori || a.kategori === this.kategori;
                     const matchStatus   = !this.statusFilter || a.status === this.statusFilter;
                     return matchSearch && matchKategori && matchStatus;
                 });
             }
         }">

        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" x-model="search" placeholder="Cari alat pertanian..."
                       id="searchAlat"
                       class="form-input pl-11">
            </div>

            {{-- Filter Kategori --}}
            <div class="relative">
                <select x-model="kategori" id="filterKategori" class="form-select w-full sm:w-48">
                    @foreach($kategoriList as $val => $label)
                        <option value="{{ $val }}">{{ $label }}</option>
                    @endforeach
                </select>
                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            {{-- Filter Status --}}
            <div class="relative">
                <select x-model="statusFilter" id="filterStatus" class="form-select w-full sm:w-44">
                    <option value="">Semua Status</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="dipinjam">Sedang Dipinjam</option>
                </select>
                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        {{-- Result count --}}
        <p class="text-xs text-gray-400 mt-3">
            Menampilkan <span x-text="filtered.length" class="font-semibold text-gray-600"></span> alat
        </p>

        {{-- ============================================================
             GRID KATALOG
             ============================================================ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-5"
             id="gridAlsintan">

            <template x-for="alat in filtered" :key="alat.id">
                <div class="card-hover group cursor-pointer animate-fade-in-up">

                    {{-- Emoji / Illustration Area --}}
                    <div class="relative h-36 flex items-center justify-center"
                         :class="alat.status === 'tersedia' ? 'bg-gradient-to-br from-primary-50 to-emerald-100' : 'bg-gradient-to-br from-gray-50 to-orange-50'">

                        <span class="text-6xl select-none group-hover:scale-110 transition-transform duration-300"
                              x-text="{{ Js::from($ikonAlat) }}[alat.kategori] || '🔧'">
                        </span>

                        {{-- Availability badge --}}
                        <div class="absolute top-3 right-3">
                            <span x-show="alat.status === 'tersedia'"
                                  class="badge badge-tersedia shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse-soft"></span>
                                Tersedia
                            </span>
                            <span x-show="alat.status === 'dipinjam'"
                                  class="badge badge-dipinjam shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                Dipinjam
                            </span>
                        </div>

                        {{-- Stok --}}
                        <div class="absolute bottom-3 left-3" x-show="alat.status === 'tersedia'">
                            <span class="text-[10px] font-semibold text-primary-700 bg-white/80 backdrop-blur-sm px-2 py-0.5 rounded-full border border-primary-100">
                                Stok: <span x-text="alat.stok"></span> unit
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2" x-text="alat.nama"></h3>
                        <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                            <span x-text="alat.spek"></span>
                        </p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span x-text="alat.unit"></span>
                        </p>

                        <div class="mt-4">
                            <template x-if="alat.status === 'tersedia'">
                                <a :href="`/proposal/create?alat=${alat.id}`"
                                   class="btn-primary w-full text-xs py-2.5 justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Ajukan Pinjaman
                                </a>
                            </template>
                            <template x-if="alat.status === 'dipinjam'">
                                <button disabled class="w-full py-2.5 px-4 rounded-xl bg-gray-100 text-gray-400 text-xs font-semibold cursor-not-allowed">
                                    Sedang Tidak Tersedia
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Empty state --}}
            <template x-if="filtered.length === 0">
                <div class="col-span-full text-center py-16">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-600">Tidak ada alat ditemukan</p>
                    <p class="text-sm text-gray-400 mt-1">Coba ubah kata kunci atau filter pencarian Anda.</p>
                </div>
            </template>
        </div>

    </div>{{-- end x-data --}}

</x-layouts.app>
