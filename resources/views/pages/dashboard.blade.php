<x-layouts.app>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:pageTitle>Dashboard</x-slot:pageTitle>
    <x-slot:pageSubtitle>Selamat datang kembali, Bapak/Ibu Petani</x-slot:pageSubtitle>

    @php
        // ============================================================
        // DATA DUMMY — Ganti dengan data dari Controller/Model nanti
        // ============================================================
        $user = [
            'name'  => 'Ahmad Sugiarto',
            'peran' => 'Petani Individu',
            'desa'  => 'Desa Sukamaju, Kec. Ciawi',
        ];

        $stats = [
            ['label' => 'Total Pengajuan', 'value' => '8',  'icon' => 'document', 'color' => 'green', 'trend' => '+2',  'trendUp' => true],
            ['label' => 'Sedang Diproses', 'value' => '3',  'icon' => 'clock',    'color' => 'blue',  'trend' => null,  'trendUp' => true],
            ['label' => 'Selesai',         'value' => '4',  'icon' => 'check',    'color' => 'amber', 'trend' => '+1',  'trendUp' => true],
        ];

        $pengajuan = [
            ['id' => 'PROP-2025-008', 'alat' => 'Traktor Roda 2 — 8.5 PK',  'tanggal' => '20 Apr 2025', 'lahan' => '1.5 Ha', 'status' => 'menunggu'],
            ['id' => 'PROP-2025-007', 'alat' => 'Pompa Air Centrifugal 3"', 'tanggal' => '15 Apr 2025', 'lahan' => '0.8 Ha', 'status' => 'survei'],
            ['id' => 'PROP-2025-006', 'alat' => 'Cultivator / Hand Tractor', 'tanggal' => '10 Apr 2025', 'lahan' => '2.0 Ha', 'status' => 'diterima'],
            ['id' => 'PROP-2025-005', 'alat' => 'Sprayer Gendong Elektrik',  'tanggal' => '01 Apr 2025', 'lahan' => '0.5 Ha', 'status' => 'ditolak'],
            ['id' => 'PROP-2025-004', 'alat' => 'Traktor Roda 4 — 45 PK',   'tanggal' => '22 Mar 2025', 'lahan' => '3.0 Ha', 'status' => 'diterima'],
        ];
    @endphp

    {{-- ============================================================
         WELCOME BANNER
         ============================================================ --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-600 via-primary-700 to-emerald-800 p-6 md:p-8 mb-6 shadow-xl shadow-primary-700/30 animate-fade-in-down">

        {{-- Background decoration --}}
        <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-8 right-16 w-32 h-32 rounded-full bg-white/5"></div>
        <div class="absolute top-0 right-0 opacity-20">
            <svg viewBox="0 0 200 150" class="w-48 h-auto" fill="white">
                <path d="M140 130 Q145 100 155 95 Q162 100 155 130 Z"/>
                <path d="M150 130 Q160 108 165 95 Q172 105 162 130 Z"/>
                <path d="M160 130 Q155 105 165 82 Q178 95 165 130 Z"/>
                <circle cx="50" cy="40" r="22" opacity="0.6"/>
                <line x1="50" y1="10" x2="50" y2="2" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                <line x1="50" y1="70" x2="50" y2="78" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                <line x1="20" y1="40" x2="12" y2="40" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                <line x1="80" y1="40" x2="88" y2="40" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                <line x1="29" y1="19" x2="23" y2="13" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                <line x1="71" y1="61" x2="77" y2="67" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </div>

        <div class="relative z-10 flex items-start justify-between gap-4">
            <div>
                <p class="text-primary-200 text-sm font-medium">Halo, selamat datang! 👋</p>
                <h2 class="text-2xl md:text-3xl font-extrabold text-white mt-1">{{ $user['name'] }}</h2>
                <div class="flex flex-wrap items-center gap-2 mt-2.5">
                    <span class="inline-flex items-center gap-1.5 bg-white/15 text-white text-xs font-medium px-3 py-1 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $user['peran'] }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-white/15 text-white text-xs font-medium px-3 py-1 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $user['desa'] }}
                    </span>
                </div>
                <p class="text-primary-100 text-xs mt-3 leading-relaxed max-w-md">
                    Anda dapat mengajukan proposal peminjaman alat pertanian kapan saja. Tim kami siap membantu.
                </p>
            </div>

            {{-- CTA Button Desktop --}}
            <a href="{{ route('proposal.create') }}"
               class="hidden md:inline-flex flex-shrink-0 items-center gap-2 bg-white text-primary-700 font-bold
                      px-5 py-3 rounded-xl shadow-md hover:shadow-lg hover:bg-primary-50 hover:-translate-y-0.5
                      active:scale-95 transition-all duration-200 text-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Ajukan Proposal
            </a>
        </div>
    </div>

    {{-- ============================================================
         STAT CARDS
         ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        @foreach($stats as $i => $stat)
            <div class="animate-fade-in-up delay-{{ ($i + 1) * 100 }}">
                <x-stat-card
                    :label="$stat['label']"
                    :value="$stat['value']"
                    :icon="$stat['icon']"
                    :color="$stat['color']"
                    :trend="$stat['trend']"
                    :trendUp="$stat['trendUp']"
                />
            </div>
        @endforeach
    </div>

    {{-- ============================================================
         PENGAJUAN TERAKHIR
         ============================================================ --}}
    <div class="card animate-fade-in-up delay-400">
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
            <div>
                <h3 class="font-bold text-gray-900">Pengajuan Terakhir</h3>
                <p class="text-xs text-gray-500 mt-0.5">Daftar proposal yang telah Anda ajukan</p>
            </div>
            <a href="#" class="text-xs font-semibold text-primary-600 hover:text-primary-800 transition flex items-center gap-1">
                Lihat Semua
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden md:block">
            <table class="table-base">
                <thead>
                    <tr>
                        <th>No. Proposal</th>
                        <th>Alat yang Dipinjam</th>
                        <th>Luas Lahan</th>
                        <th>Tanggal Ajuan</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan as $p)
                    <tr class="group">
                        <td>
                            <span class="font-mono text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">{{ $p['id'] }}</span>
                        </td>
                        <td>
                            <p class="font-semibold text-gray-800 text-sm">{{ $p['alat'] }}</p>
                        </td>
                        <td class="text-gray-600 text-sm">{{ $p['lahan'] }}</td>
                        <td class="text-gray-500 text-sm">{{ $p['tanggal'] }}</td>
                        <td><x-badge-status :status="$p['status']" /></td>
                        <td class="text-right">
                            <a href="#" class="btn-ghost text-xs py-1.5 px-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                Detail
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="md:hidden divide-y divide-gray-50">
            @foreach($pengajuan as $p)
            <div class="px-5 py-4 hover:bg-gray-50/60 transition cursor-pointer">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm truncate">{{ $p['alat'] }}</p>
                        <p class="text-xs text-gray-500 mt-0.5 font-mono">{{ $p['id'] }}</p>
                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $p['tanggal'] }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                {{ $p['lahan'] }}
                            </span>
                        </div>
                    </div>
                    <x-badge-status :status="$p['status']" />
                </div>
            </div>
            @endforeach
        </div>

        {{-- Empty State (jika tidak ada data) --}}
        @if(count($pengajuan) === 0)
        <div class="text-center py-16 px-6">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada pengajuan</p>
            <p class="text-gray-400 text-sm mt-1">Mulai ajukan proposal peminjaman alsintan pertama Anda!</p>
            <a href="{{ route('proposal.create') }}" class="btn-primary mt-4 inline-flex">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Ajukan Sekarang
            </a>
        </div>
        @endif
    </div>

    {{-- ============================================================
         FAB (Mobile Only) — Floating Action Button
         ============================================================ --}}
    <a href="{{ route('proposal.create') }}" class="fab" id="fabAjukan">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Ajukan Proposal
    </a>

</x-layouts.app>
