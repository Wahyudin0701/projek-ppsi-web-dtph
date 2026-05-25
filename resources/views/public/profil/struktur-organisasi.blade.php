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
            $getEmp = function($roleTitle) use ($employees) {
                $normalizedSearch = strtolower(str_replace(['.', ' '], '', $roleTitle));
                return $employees->first(function($employee) use ($normalizedSearch) {
                    $normalizedRole = strtolower(str_replace(['.', ' '], '', $employee->role));
                    return $normalizedRole === $normalizedSearch || 
                           str_contains($normalizedRole, $normalizedSearch) || 
                           str_contains($normalizedSearch, $normalizedRole);
                });
            };

            $persons = [
                'kepala' => [
                    'jabatan' => 'Kepala Dinas',
                    'nama'    => $getEmp('Kepala Dinas')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Kepala Dinas')?->nip ?? '',
                    'photo'   => $getEmp('Kepala Dinas')?->foto ? 'storage/' . $getEmp('Kepala Dinas')->foto : null,
                    'color'   => ['bg' => 'bg-primary-600', 'ring' => 'ring-primary-400', 'badge' => 'bg-primary-100 text-primary-800'],
                    'initials'=> 'KD',
                ],
                'sekretaris' => [
                    'jabatan' => 'Sekretaris',
                    'nama'    => $getEmp('Sekretaris')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Sekretaris')?->nip ?? '',
                    'photo'   => $getEmp('Sekretaris')?->foto ? 'storage/' . $getEmp('Sekretaris')->foto : null,
                    'color'   => ['bg' => 'bg-blue-600', 'ring' => 'ring-blue-400', 'badge' => 'bg-blue-100 text-blue-800'],
                    'initials'=> 'SK',
                ],
                'sub_umum' => [
                    'jabatan' => 'Kasubbag Umum Kepegawaian',
                    'nama'    => $getEmp('Kasubbag Umum Kepegawaian')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Kasubbag Umum Kepegawaian')?->nip ?? '',
                    'photo'   => $getEmp('Kasubbag Umum Kepegawaian')?->foto ? 'storage/' . $getEmp('Kasubbag Umum Kepegawaian')->foto : null,
                    'color'   => ['bg' => 'bg-violet-500', 'ring' => 'ring-violet-300', 'badge' => 'bg-violet-100 text-violet-800'],
                    'initials'=> 'KU',
                ],
                'fungsional_perencanaan' => [
                    'jabatan' => 'Fungsional Perencanaan',
                    'nama'    => $getEmp('Fungsional Perencanaan')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Fungsional Perencanaan')?->nip ?? '',
                    'photo'   => $getEmp('Fungsional Perencanaan')?->foto ? 'storage/' . $getEmp('Fungsional Perencanaan')->foto : null,
                    'color'   => ['bg' => 'bg-indigo-500', 'ring' => 'ring-indigo-300', 'badge' => 'bg-indigo-100 text-indigo-800'],
                    'initials'=> 'FP',
                ],
                'analisis_keuangan' => [
                    'jabatan' => 'Fungsional Analisis Keuangan Pusat dan Daerah',
                    'nama'    => $getEmp('Fungsional Analisis Keuangan Pusat dan Daerah')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Fungsional Analisis Keuangan Pusat dan Daerah')?->nip ?? '',
                    'photo'   => $getEmp('Fungsional Analisis Keuangan Pusat dan Daerah')?->foto ? 'storage/' . $getEmp('Fungsional Analisis Keuangan Pusat dan Daerah')->foto : null,
                    'color'   => ['bg' => 'bg-sky-500', 'ring' => 'ring-sky-300', 'badge' => 'bg-sky-100 text-sky-800'],
                    'initials'=> 'AK',
                ],
                'bidang_pangan' => [
                    'jabatan' => 'Kabid. Tanaman Pangan',
                    'nama'    => $getEmp('Kabid. Tanaman Pangan')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Kabid. Tanaman Pangan')?->nip ?? '',
                    'photo'   => $getEmp('Kabid. Tanaman Pangan')?->foto ? 'storage/' . $getEmp('Kabid. Tanaman Pangan')->foto : null,
                    'color'   => ['bg' => 'bg-primary-600', 'ring' => 'ring-primary-400', 'badge' => 'bg-primary-100 text-primary-800'],
                    'initials'=> 'TP',
                ],
                'bidang_horti' => [
                    'jabatan' => 'Kabid. Hortikultura',
                    'nama'    => $getEmp('Kabid. Hortikultura')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Kabid. Hortikultura')?->nip ?? '',
                    'photo'   => $getEmp('Kabid. Hortikultura')?->foto ? 'storage/' . $getEmp('Kabid. Hortikultura')->foto : null,
                    'color'   => ['bg' => 'bg-lime-600', 'ring' => 'ring-lime-400', 'badge' => 'bg-lime-100 text-lime-800'],
                    'initials'=> 'HT',
                ],
                'bidang_psp' => [
                    'jabatan' => 'Kabid. PSP',
                    'nama'    => $getEmp('Kabid. PSP')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Kabid. PSP')?->nip ?? '',
                    'photo'   => $getEmp('Kabid. PSP')?->foto ? 'storage/' . $getEmp('Kabid. PSP')->foto : null,
                    'color'   => ['bg' => 'bg-teal-600', 'ring' => 'ring-teal-400', 'badge' => 'bg-teal-100 text-teal-800'],
                    'initials'=> 'PS',
                ],
                'bidang_penyuluhan' => [
                    'jabatan' => 'Kabid. Penyuluhan',
                    'nama'    => $getEmp('Kabid. Penyuluhan')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('Kabid. Penyuluhan')?->nip ?? '',
                    'photo'   => $getEmp('Kabid. Penyuluhan')?->foto ? 'storage/' . $getEmp('Kabid. Penyuluhan')->foto : null,
                    'color'   => ['bg' => 'bg-cyan-600', 'ring' => 'ring-cyan-400', 'badge' => 'bg-cyan-100 text-cyan-800'],
                    'initials'=> 'PN',
                ],
                'uptd' => [
                    'jabatan' => 'UPTD Balai Benih Utama Arang Arang',
                    'nama'    => $getEmp('UPTD Balai Benih Utama Arang Arang')?->name ?? 'Belum Diisi',
                    'nip'     => $getEmp('UPTD Balai Benih Utama Arang Arang')?->nip ?? '',
                    'photo'   => $getEmp('UPTD Balai Benih Utama Arang Arang')?->foto ? 'storage/' . $getEmp('UPTD Balai Benih Utama Arang Arang')->foto : null,
                    'color'   => ['bg' => 'bg-amber-500', 'ring' => 'ring-amber-300', 'badge' => 'bg-amber-100 text-amber-800'],
                    'initials'=> 'UP',
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
                <div class="w-0.5 h-10 bg-primary-300"></div>
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

            {{-- Sub Bagian: Kasubbag Umum + Fungsional Perencanaan + Analisis Keuangan --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-8 max-w-4xl mx-auto mb-2">
                <x-profil.person-card :person="$persons['sub_umum']" size="sm" />
                <x-profil.person-card :person="$persons['fungsional_perencanaan']" size="sm" />
                <x-profil.person-card :person="$persons['analisis_keuangan']" size="sm" />
            </div>

            {{-- Divider --}}
            <div class="relative my-8 flex items-center justify-center">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="mx-4 text-xs font-bold uppercase tracking-widest text-gray-400 whitespace-nowrap px-2">Bidang-Bidang</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Connector down to Bidang --}}
            <div class="flex justify-center mb-0">
                <div class="w-0.5 h-4 bg-primary-300"></div>
            </div>
            <div class="relative mb-0">
                <div class="absolute top-0 left-[12.5%] right-[12.5%] h-0.5 bg-primary-200"></div>
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
            {{-- UPTD --}}
            {{-- ========================================== --}}
            <div class="mt-12 flex justify-center">
                <div class="w-0.5 h-8 bg-amber-300"></div>
            </div>
            <div class="flex flex-col items-center mb-0">
                <div class="w-full max-w-sm">
                    <x-profil.person-card :person="$persons['uptd']" size="md" />
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- Kelompok Jabatan Fungsional --}}
            {{-- ========================================== --}}
            <div class="mt-16 border-t border-dashed border-gray-200 pt-14">
                <p class="text-center text-xs font-bold uppercase tracking-widest text-gray-400 mb-8">
                    Kelompok Jabatan Fungsional — Per Bidang
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach([
                        ['label' => 'Kabid. Tanaman Pangan'],
                        ['label' => 'Kabid. Hortikultura'],
                        ['label' => 'Kabid. PSP'],
                        ['label' => 'Kabid. Penyuluhan'],
                    ] as $kelompok)
                    <div class="bg-white border border-gray-100 rounded-xl p-4 hover:border-primary-300 hover:shadow-md transition-all duration-200 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full bg-primary-500 group-hover:scale-110 transition-transform"></div>
                            <p class="text-xs font-bold text-gray-800 group-hover:text-primary-700 transition-colors">Kelompok Jabatan Fungsional</p>
                        </div>
                        <p class="text-xs text-gray-500 pl-4">{{ $kelompok['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-layouts.public>
