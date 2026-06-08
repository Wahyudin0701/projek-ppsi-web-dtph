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

            {{-- Search Bar --}}
            <div class="mt-8 max-w-xl mx-auto px-4 group">
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" x-model="searchQuery"
                        placeholder="Cari nama program, sasaran..."
                        class="w-full pl-5 pr-12 py-3.5 rounded-2xl border border-gray-200 bg-white text-gray-800 placeholder-gray-400 focus:border-primary-400 focus:ring-4 focus:ring-primary-400/10 transition-all shadow-sm text-sm font-medium">
                </div>
            </div>
        </div>

        @php
        // Transform Eloquent models into the format the view expects
        $jenisIconMap = [
            'alsintan'      => ['path' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'color' => 'text-primary-600',  'bg' => 'bg-primary-50'],
            'benih'         => ['path' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-green-600',   'bg' => 'bg-green-50'],
            'pupuk'         => ['path' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',                                                                                                                                                                                   'color' => 'text-lime-600',    'bg' => 'bg-lime-50'],
            'infrastruktur' => ['path' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',                                                                                  'color' => 'text-blue-600',    'bg' => 'bg-blue-50'],
            'pelatihan'     => ['path' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'text-violet-600',  'bg' => 'bg-violet-50'],
        ];        $programsData = $programs->map(function ($p) use ($jenisIconMap) {
            // Use the model's computed status accessor (single source of truth)
            $status = $p->status; // 'belum_berjalan' | 'berjalan' | 'selesai'

            $status_waktu       = $status === 'berjalan' ? 'sedang_berjalan' : ($status === 'belum_berjalan' ? 'belum_berjalan' : 'berakhir');
            $status_pendaftaran = $status === 'berjalan' ? 'buka' : ($status === 'belum_berjalan' ? 'belum_dibuka' : 'tutup');

            $labelMap = [
                'berjalan'       => ['label' => 'Pendaftaran Buka', 'labelColor' => 'bg-primary-100 text-primary-700', 'dotColor' => 'bg-primary-500'],
                'belum_berjalan' => ['label' => 'Belum Dibuka',     'labelColor' => 'bg-amber-100 text-amber-700',    'dotColor' => 'bg-amber-500'],
                'selesai'        => ['label' => 'Program Selesai',  'labelColor' => 'bg-gray-100 text-gray-500',      'dotColor' => 'bg-gray-400'],
            ];
            $meta = $labelMap[$status] ?? $labelMap['selesai'];

            $icon = $jenisIconMap[$p->jenis] ?? $jenisIconMap['alsintan'];

            return [
                'id'                  => $p->id,
                'status_waktu'        => $status_waktu,
                'status_pendaftaran'  => $status_pendaftaran,
                'label'               => $meta['label'],
                'labelColor'          => $meta['labelColor'],
                'dotColor'            => $meta['dotColor'],
                'jenis'               => $p->jenis ?? 'alsintan',
                'judul'               => $p->name,
                'deskripsi'           => $p->description ?? '',
                'sasaran'             => $p->sasaran ?? '-',
                'kuota'               => $p->kuota ?? '-',
                'jadwal_buka'         => $p->open_date?->translatedFormat('d F Y') ?? '-',
                'jadwal_tutup'        => $p->close_date?->translatedFormat('d F Y') ?? '-',
                'tahap'               => str_replace('_', ' ', ucfirst($p->type ?? '')),
                'icon_path'           => $icon['path'],
                'icon_color'          => $icon['color'],
                'icon_bg'             => $icon['bg'],
                'syarat'              => $p->requirements ?? [],
                'sop'                 => $p->sop_description ?? '',
            ];
        })->toArray();

        // Replace $programs variable with our transformed array for the template
        $programs = $programsData;
        @endphp

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

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

                {{-- Result count --}}
                <span class="text-sm text-gray-400 font-medium" x-show="countTotalVisible() > 0">
                    Menampilkan <strong class="text-gray-700" x-text="countTotalVisible()"></strong> program bantuan
                </span>
            </div>

            {{-- Section: Upcoming Programs --}}
            @php $belum = array_filter($programs, fn($p) => $p['status_waktu'] === 'belum_berjalan'); @endphp
            @if(count($belum) > 0)
            <div class="mb-24" x-show="hasVisiblePrograms('belum_berjalan')" x-cloak>
                <div class="flex items-center justify-between mb-6 group cursor-pointer select-none" @click="expandBelum = !expandBelum">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1.5 text-sm font-bold text-amber-600">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            Program Belum Berjalan
                        </span>
                        <span class="text-xs text-gray-400 font-medium"><span x-text="countVisible('belum_berjalan')"></span> program akan datang</span>
                    </div>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-100 group-hover:bg-amber-50 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-amber-600 transition-transform duration-300" :class="expandBelum ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="expandBelum" x-collapse.duration.300ms>
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
                            <span class="text-xs font-bold text-amber-600">Belum Dibuka</span>
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
                <div class="flex items-center justify-between mb-6 group cursor-pointer select-none" @click="expandAktif = !expandAktif">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1.5 text-sm font-bold text-primary-700">
                            <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                            Program Sedang Berjalan
                        </span>
                        <span class="text-xs text-gray-400 font-medium"><span x-text="countVisible('sedang_berjalan')"></span> program berjalan</span>
                    </div>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-100 group-hover:bg-primary-50 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-primary-700 transition-transform duration-300" :class="expandAktif ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="expandAktif" x-collapse.duration.300ms>
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
                                <p class="text-xs font-bold text-primary-600 leading-snug">{{ $program['jadwal_buka'] }}</p>
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
                                @auth
                                    @if(auth()->user()->hasRole(['petani', 'umum']))
                                        @if(auth()->user()->isApproved())
                                            <a href="{{ route('farmer.proposals.create', $program['id']) }}" @click.stop class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                                Ajukan Proposal
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </a>
                                        @else
                                            <a href="{{ route('dashboard') }}" @click.stop class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                                Lengkapi Profil
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </a>
                                        @endif
                                    @else
                                        <span @click.stop class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 cursor-not-allowed">
                                            Khusus Petani / Umum
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" @click.stop class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                        Ajukan Proposal
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                @endauth
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
                <div class="flex items-center justify-between mb-6 group cursor-pointer select-none" @click="expandTutup = !expandTutup">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1.5 text-sm font-bold text-gray-500">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                            Program Berakhir
                        </span>
                        <span class="text-xs text-gray-400 font-medium"><span x-text="countVisible('berakhir')"></span> program telah berakhir</span>
                    </div>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-100 group-hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-300" :class="expandTutup ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="expandTutup" x-collapse.duration.300ms>
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

            {{-- Empty State --}}
            <div x-show="countTotalVisible() === 0" x-cloak class="text-center py-24">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center mb-5 border border-gray-200 shadow-sm">
                    <svg class="w-9 h-9 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ditemukan</h3>
                <p class="text-gray-400 text-sm mb-5">Program bantuan yang Anda cari tidak tersedia saat ini.</p>
                <button @click="searchQuery = ''; activeCategory = 'semua'" class="text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors">
                    Tampilkan Semua
                </button>
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
                            <template x-for="syaratItem in (selected.syarat && selected.syarat.length > 0 ? selected.syarat : defaultSyarat)" :key="syaratItem">
                                <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-primary-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span x-text="syaratItem"></span>
                                </li>
                            </template>
                        </ul>
                    </div>

                    {{-- SOP Section (Relocated & Styled) --}}
                    <div class="mb-8 bg-blue-50/50 border border-blue-100 rounded-2xl p-5" x-show="selected.sop">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-blue-900">Alur / SOP Pengajuan</h3>
                        </div>
                        <div class="text-sm text-blue-800/80 leading-relaxed space-y-2 whitespace-pre-line" x-text="selected.sop"></div>
                    </div>
                </div>
            </template>

            {{-- Drawer Footer --}}
            <div class="sticky bottom-0 bg-white border-t border-gray-100 p-5 flex gap-3">
                <template x-if="selected && selected.status_pendaftaran === 'buka'">
                    @auth
                        @if(auth()->user()->hasRole(['petani', 'umum']))
                            @if(auth()->user()->isApproved())
                                <a :href="'{{ url('farmer/proposals/bantuan') }}/' + selected.id" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-2xl text-sm font-bold text-center transition-colors shadow-lg shadow-primary-600/20">
                                    Ajukan Proposal Sekarang
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-2xl text-sm font-bold text-center transition-colors shadow-lg shadow-primary-600/20">
                                    Lengkapi Profil Untuk Mengajukan
                                </a>
                            @endif
                        @else
                            <div class="flex-1 bg-gray-100 text-gray-500 py-3.5 rounded-2xl text-sm font-bold text-center border border-gray-200 cursor-not-allowed">
                                Khusus Petani / Umum
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-2xl text-sm font-bold text-center transition-colors shadow-lg shadow-primary-600/20">
                            Ajukan Proposal Sekarang
                        </a>
                    @endauth
                </template>
                <template x-if="selected && selected.status_pendaftaran === 'belum_dibuka'">
                    <div class="flex-1 bg-amber-100 text-amber-600 py-3.5 rounded-2xl text-sm font-bold text-center cursor-not-allowed">
                        Pendaftaran Belum Dibuka
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
                expandBelum: true,
                expandAktif: true,
                expandTutup: true,
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
                countTotalVisible() {
                    return programsData.filter(p => this.matchesFilterById(p.id)).length;
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
