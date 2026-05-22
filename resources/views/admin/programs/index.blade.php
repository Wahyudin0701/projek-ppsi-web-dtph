<x-app-layout>
    <x-slot name="header">Manajemen Program</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

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
            $buka          = $programs->filter(fn($p) => $p->status === 'berjalan')->count();
            $belumBerjalan = $programs->filter(fn($p) => $p->status === 'belum_berjalan')->count();
            $selesai       = $programs->filter(fn($p) => $p->status === 'selesai')->count();
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
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Jenis</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Periode</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
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
                            <td class="px-6 py-4 flex justify-center">
                                @php
                                    $jenisLabels = ['alsintan'=>'Alsintan','benih'=>'Benih','pupuk'=>'Pupuk','infrastruktur'=>'Infrastruktur','pelatihan'=>'Pelatihan'];
                                    $jenisLabel = $jenisLabels[$program->jenis] ?? ucfirst($program->jenis ?? '-');
                                @endphp
                                <span class="inline-block px-2.5 py-1 bg-primary-50 text-primary-700 text-[11px] font-bold rounded-lg border border-primary-100">
                                    {{ $jenisLabel }}
                                </span>
                            </td>

                            {{-- Periode --}}
                            <td class="px-6 py-4 text-center">
                                <p class="text-sm font-semibold text-gray-800">{{ $program->open_date?->format('d M Y') ?? '-' }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">s/d {{ $program->close_date?->format('d M Y') ?? '-' }}</p>
                            </td>

                            {{-- Status Badge (auto) --}}
                            <td class="px-6 py-4 text-center">
                                @if($program->status === 'berjalan')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200 whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Pendaftaran Buka
                                    </span>
                                @elseif($program->status === 'belum_berjalan')
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
                            <td class="px-6 py-4 flex justify-center">
                                <div class="flex flex-col items-end gap-1.5">
                                    <a href="{{ route('admin.programs.show', $program) }}"
                                       class="inline-flex items-center gap-1.5 w-24 px-3 py-1.5 text-[11px] font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.programs.edit', $program) }}"
                                       class="inline-flex items-center gap-1.5 w-24 px-3 py-1.5 text-[11px] font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus program {{ $program->name }}?')" class="block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 w-24 px-3 py-1.5 text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg border border-red-100 transition-colors">
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
    </div>
</x-app-layout>
