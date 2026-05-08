<x-app-layout>
    <x-slot name="header">Manajemen Program</x-slot>

    <div class="max-w-7xl mx-auto space-y-6" x-data="{ 
        showDetail: false, 
        selectedProgram: null,
        openDetail(program) {
            this.selectedProgram = program;
            this.showDetail = true;
        }
    }">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Program Bantuan</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola daftar program bantuan. Status ditentukan otomatis dari tanggal buka dan tutup.</p>
            </div>
            <a href="{{ route('admin.programs.create') }}"
               class="inline-flex items-center gap-2 bg-[#19A148] text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-green-700 transition-colors shadow-sm shadow-green-200 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Program
            </a>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Stats --}}
        @php
            $total         = $programs->count();
            $buka          = $programs->filter(fn($p) => $p->farmerProfile->status === 'berjalan')->count();
            $belumBerjalan = $programs->filter(fn($p) => $p->farmerProfile->status === 'belum_berjalan')->count();
            $selesai       = $programs->filter(fn($p) => $p->farmerProfile->status === 'selesai')->count();
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Program</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $total }}</p>
            </div>
            <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 shadow-sm">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Pendaftaran Buka</p>
                <p class="text-3xl font-extrabold text-emerald-700">{{ $buka }}</p>
            </div>
            <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100 shadow-sm">
                <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Belum Dibuka</p>
                <p class="text-3xl font-extrabold text-amber-700">{{ $belumBerjalan }}</p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 shadow-sm">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Program Selesai</p>
                <p class="text-3xl font-extrabold text-gray-700">{{ $selesai }}</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/80">
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Nama Program</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Jenis</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Periode</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($programs as $program)
                        <tr class="hover:bg-gray-50/60 transition-colors">

                            {{-- Name --}}
                            <td class="px-6 py-4">
                                <p class="font-bold text-sm text-gray-900 leading-tight">{{ $program->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 capitalize">{{ str_replace('_', ' ', $program->type) }}</p>
                            </td>

                            {{-- Jenis --}}
                            <td class="px-6 py-4">
                                @php
                                    $jenisLabels = ['alsintan'=>'Alsintan','benih'=>'Benih','pupuk'=>'Pupuk','infrastruktur'=>'Infrastruktur','pelatihan'=>'Pelatihan'];
                                    $jenisLabel = $jenisLabels[$program->jenis] ?? ucfirst($program->jenis ?? '-');
                                @endphp
                                <span class="inline-block px-2.5 py-1 bg-primary-50 text-primary-700 text-[11px] font-bold rounded-lg border border-primary-100">
                                    {{ $jenisLabel }}
                                </span>
                            </td>

                            {{-- Periode --}}
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-gray-800">{{ $program->open_date?->format('d M Y') ?? '-' }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">s/d {{ $program->close_date?->format('d M Y') ?? '-' }}</p>
                            </td>

                            {{-- Status Badge (auto) --}}
                            <td class="px-6 py-4 text-center">
                                @if($program->farmerProfile->status === 'berjalan')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200 whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Pendaftaran Buka
                                    </span>
                                @elseif($program->farmerProfile->status === 'belum_berjalan')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 text-[11px] font-bold rounded-full border border-amber-200 whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Belum Dibuka
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-500 text-[11px] font-bold rounded-full border border-gray-200 whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openDetail({
                                                name: '{{ $program->name }}',
                                                type_label: '{{ str_replace('_', ' ', $program->type) }}',
                                                jenis: '{{ $program->jenis }}',
                                                description: '{{ addslashes($program->description) }}',
                                                sasaran: '{{ $program->sasaran ?? '-' }}',
                                                kuota: '{{ $program->kuota ?? '-' }}',
                                                open_date: '{{ $program->open_date?->translatedFormat('d F Y') ?? '-' }}',
                                                close_date: '{{ $program->close_date?->translatedFormat('d F Y') ?? '-' }}',
                                                status: '{{ $program->farmerProfile->status }}',
                                                requirements: {{ json_encode($program->requirements ?? []) }},
                                                sop_description: '{{ addslashes($program->sop_description) }}'
                                            })"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </button>
                                    <a href="{{ route('admin.programs.edit', $program) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus program {{ $program->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg border border-red-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <p class="font-bold text-gray-800">Belum ada program bantuan</p>
                                    <p class="text-sm text-gray-400">Mulai buat program bantuan pertanian pertama.</p>
                                    <a href="{{ route('admin.programs.create') }}"
                                       class="mt-2 inline-flex items-center gap-2 bg-[#19A148] text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-green-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah Program
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Detail Modal --}}
        <div x-show="showDetail" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showDetail = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-100 text-primary-700 uppercase tracking-wider mb-2" x-text="selectedProgram?.type_label"></span>
                                <h3 class="text-xl font-extrabold text-gray-900" x-text="selectedProgram?.name"></h3>
                            </div>
                            <button @click="showDetail = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6 text-sm">
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi</h4>
                                <p class="text-gray-600 leading-relaxed" x-text="selectedProgram?.description || 'Tidak ada deskripsi.'"></p>
                            </div>

                            <div x-show="selectedProgram?.sop_description">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Alur / SOP Program</h4>
                                <p class="text-gray-600 leading-relaxed" x-text="selectedProgram?.sop_description"></p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Sasaran</h4>
                                    <p class="font-bold text-gray-900" x-text="selectedProgram?.sasaran"></p>
                                </div>
                                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kuota</h4>
                                    <p class="font-bold text-gray-900" x-text="selectedProgram?.kuota"></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Jadwal Buka</h4>
                                    <p class="font-bold text-gray-900" x-text="selectedProgram?.open_date"></p>
                                </div>
                                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 text-red-400">Jadwal Tutup</h4>
                                    <p class="font-bold text-red-600" x-text="selectedProgram?.close_date"></p>
                                </div>
                            </div>

                            <div x-show="selectedProgram?.requirements && selectedProgram?.requirements.length > 0">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Persyaratan Khusus</h4>
                                <ul class="space-y-2">
                                    <template x-for="req in selectedProgram?.requirements" :key="req">
                                        <li class="flex items-start gap-2.5 text-gray-600">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span x-text="req"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse">
                        <button type="button" 
                                class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm"
                                @click="showDetail = false">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
