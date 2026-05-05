<x-layouts.public>
    <x-slot:title>Struktur Organisasi - DTPH Muaro Jambi</x-slot:title>

    <div class="bg-gray-50 min-h-screen">
        {{-- Hero Header / Title --}}
        <div class="bg-white py-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight pb-6">Struktur Organisasi</h1>
            <div class="w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi
            </p>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

            @php
            $persons = [
                'kepala' => [
                    'jabatan' => 'Kepala Dinas',
                    'nama'    => 'Ir. H. Ahmad Fauzi, M.Si.',
                    'nip'     => 'NIP. 19700101 199903 1 001',
                    'color'   => ['bg' => 'bg-emerald-600', 'ring' => 'ring-emerald-400', 'badge' => 'bg-emerald-100 text-emerald-800'],
                    'initials'=> 'AF',
                ],
                'sekretaris' => [
                    'jabatan' => 'Sekretaris',
                    'nama'    => 'Hj. Sri Wahyuni, S.P., M.M.',
                    'nip'     => 'NIP. 19750505 200003 2 002',
                    'color'   => ['bg' => 'bg-blue-600', 'ring' => 'ring-blue-400', 'badge' => 'bg-blue-100 text-blue-800'],
                    'initials'=> 'SW',
                ],
                'sub_perencanaan' => [
                    'jabatan' => 'Kasubbag Perencanaan & Keuangan',
                    'nama'    => 'Drs. Bambang Susilo, M.Ak.',
                    'nip'     => 'NIP. 19800312 200604 1 003',
                    'color'   => ['bg' => 'bg-indigo-500', 'ring' => 'ring-indigo-300', 'badge' => 'bg-indigo-100 text-indigo-800'],
                    'initials'=> 'BS',
                ],
                'sub_umum' => [
                    'jabatan' => 'Kasubbag Umum & Kepegawaian',
                    'nama'    => 'Rizki Andika, S.E.',
                    'nip'     => 'NIP. 19850818 200904 1 004',
                    'color'   => ['bg' => 'bg-violet-500', 'ring' => 'ring-violet-300', 'badge' => 'bg-violet-100 text-violet-800'],
                    'initials'=> 'RA',
                ],
                'bidang_pangan' => [
                    'jabatan' => 'Kabid Tanaman Pangan',
                    'nama'    => 'Ir. Siti Nurhaliza, M.P.',
                    'nip'     => 'NIP. 19770220 200312 2 005',
                    'color'   => ['bg' => 'bg-green-600', 'ring' => 'ring-green-400', 'badge' => 'bg-green-100 text-green-800'],
                    'initials'=> 'SN',
                ],
                'bidang_horti' => [
                    'jabatan' => 'Kabid Hortikultura',
                    'nama'    => 'Agus Prayitno, S.P., M.Si.',
                    'nip'     => 'NIP. 19781005 200312 1 006',
                    'color'   => ['bg' => 'bg-lime-600', 'ring' => 'ring-lime-400', 'badge' => 'bg-lime-100 text-lime-800'],
                    'initials'=> 'AP',
                ],
                'bidang_psp' => [
                    'jabatan' => 'Kabid Prasarana & Sarana Pertanian',
                    'nama'    => 'Drs. Hendra Gunawan, M.T.',
                    'nip'     => 'NIP. 19800601 200604 1 007',
                    'color'   => ['bg' => 'bg-teal-600', 'ring' => 'ring-teal-400', 'badge' => 'bg-teal-100 text-teal-800'],
                    'initials'=> 'HG',
                ],
                'bidang_penyuluhan' => [
                    'jabatan' => 'Kabid Penyuluhan Pertanian',
                    'nama'    => 'Yulia Rahmawati, S.P., M.P.',
                    'nip'     => 'NIP. 19820714 200604 2 008',
                    'color'   => ['bg' => 'bg-cyan-600', 'ring' => 'ring-cyan-400', 'badge' => 'bg-cyan-100 text-cyan-800'],
                    'initials'=> 'YR',
                ],
            ];
            @endphp

            {{-- ========================================== --}}
            {{-- KEPALA DINAS --}}
            {{-- ========================================== --}}
            <div class="flex flex-col items-center mb-0">
                <div class="w-full max-w-md">
                    <x-profil.person-card :person="$persons['kepala']" size="lg" />
                </div>
            </div>

            {{-- Connector --}}
            <div class="flex justify-center">
                <div class="w-0.5 h-10 bg-emerald-300"></div>
            </div>

            {{-- ========================================== --}}
            {{-- SEKRETARIAT --}}
            {{-- ========================================== --}}
            <div class="flex flex-col items-center mb-0">
                <div class="w-full max-w-sm">
                    <x-profil.person-card :person="$persons['sekretaris']" size="md" />
                </div>
            </div>

            {{-- Connector down to sub bagian --}}
            <div class="flex justify-center">
                <div class="w-0.5 h-8 bg-blue-300"></div>
            </div>

            {{-- Horizontal line --}}
            <div class="relative">
                <div class="absolute top-0 left-1/4 right-1/4 h-0.5 bg-blue-200"></div>
            </div>

            {{-- Sub Bagian --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-8 max-w-2xl mx-auto mb-2">
                <x-profil.person-card :person="$persons['sub_perencanaan']" size="sm" />
                <x-profil.person-card :person="$persons['sub_umum']" size="sm" />
            </div>

            {{-- Divider --}}
            <div class="relative my-8 flex items-center justify-center">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="mx-4 text-xs font-bold uppercase tracking-widest text-gray-400 whitespace-nowrap px-2">Bidang-Bidang</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Connector down to Bidang --}}
            <div class="flex justify-center mb-0">
                <div class="w-0.5 h-4 bg-emerald-300"></div>
            </div>
            <div class="relative mb-0">
                <div class="absolute top-0 left-[12.5%] right-[12.5%] h-0.5 bg-emerald-200"></div>
            </div>

            {{-- ========================================== --}}
            {{-- BIDANG-BIDANG --}}
            {{-- ========================================== --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 pt-8">
                <x-profil.person-card :person="$persons['bidang_pangan']" size="sm" />
                <x-profil.person-card :person="$persons['bidang_horti']" size="sm" />
                <x-profil.person-card :person="$persons['bidang_psp']" size="sm" />
                <x-profil.person-card :person="$persons['bidang_penyuluhan']" size="sm" />
            </div>

            {{-- ========================================== --}}
            {{-- UPT/BPP Section --}}
            {{-- ========================================== --}}
            <div class="mt-16 border-t border-dashed border-gray-200 pt-14">
                <p class="text-center text-xs font-bold uppercase tracking-widest text-gray-400 mb-8">
                    Unit Pelaksana Teknis — Balai Penyuluhan Pertanian (BPP)
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach([
                        ['kec' => 'Sekernan',         'koordinator' => 'Eko Prasetyo, S.P.'],
                        ['kec' => 'Sungai Gelam',     'koordinator' => 'Dewi Lestari, S.P.'],
                        ['kec' => 'Kumpeh',           'koordinator' => 'M. Ridwan, S.P.'],
                        ['kec' => 'Kumpeh Ulu',       'koordinator' => 'Fitriani, S.P.'],
                        ['kec' => 'Mestong',          'koordinator' => 'Heri Susanto, S.P.'],
                        ['kec' => 'Jambi Luar Kota',  'koordinator' => 'Ani Maryani, S.P.'],
                        ['kec' => 'Bahar Selatan',    'koordinator' => 'Supriadi, S.P.'],
                        ['kec' => 'Bahar Utara',      'koordinator' => 'Yuni Astuti, S.P.'],
                        ['kec' => 'Taman Rajo',       'koordinator' => 'Darmawan, S.P.'],
                        ['kec' => 'Sungai Bahar',     'koordinator' => 'Ratna Wulan, S.P.'],
                        ['kec' => 'Maro Sebo',        'koordinator' => 'Junaidi, S.P.'],
                        ['kec' => 'Dendang',          'koordinator' => 'Sari Indah, S.P.'],
                    ] as $upt)
                    <div class="bg-white border border-gray-100 rounded-xl p-4 hover:border-emerald-300 hover:shadow-md transition-all duration-200 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 group-hover:scale-110 transition-transform"></div>
                            <p class="text-xs font-bold text-gray-800 group-hover:text-emerald-700 transition-colors">BPP Kec. {{ $upt['kec'] }}</p>
                        </div>
                        <p class="text-xs text-gray-500 pl-4">{{ $upt['koordinator'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Note --}}
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400 italic">* Data nama dan foto bersifat sementara (dummy). Akan diperbarui sesuai data resmi.</p>
            </div>

        </div>
    </div>
</x-layouts.public>
