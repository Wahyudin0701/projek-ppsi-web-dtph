<x-app-layout>
    <x-slot name="header">Program Bantuan</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Pilih Program Bantuan</h2>
                <p class="text-gray-500 text-sm mt-1">Pilih program yang sedang dibuka untuk mengajukan proposal bantuan.</p>
            </div>
            <a href="{{ route('farmer.proposals.pilih') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        @if(session('error'))
            <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-sm font-medium">{{ session('error') }}</div>
        @endif

        {{-- ===== PROGRAM YANG BISA DIAJUKAN ===== --}}
        <div class="space-y-4">
            @forelse($programs as $program)
                <div onclick="window.location.href='{{ route('farmer.proposals.bantuan.show', $program) }}'" class="cursor-pointer bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col sm:flex-row group">


                    {{-- Info --}}
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="font-extrabold text-gray-900 text-xl">{{ $program->name }}</h3>
                                <span class="text-[10px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full bg-primary-100 text-primary-700">
                                    {{ str_replace('_', ' ', $program->type) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4 items-center">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Sasaran</p>
                                    <p class="font-bold text-gray-800 truncate">{{ $program->sasaran ?? 'Umum / Kelompok Tani' }}</p>
                                </div>
                                <div class="px-3 py-1.5 bg-emerald-50 rounded-xl border border-emerald-100 text-center">
                                    <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-0.5">Kuota</p>
                                    <p class="font-bold text-emerald-700">{{ $program->kuota ?? '-' }}</p>
                                </div>
                                <div class="px-3 py-1.5 bg-amber-50 rounded-xl border border-amber-100 text-center">
                                    <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mb-0.5">Terdaftar</p>
                                    <p class="font-bold text-amber-700">{{ $program->proposals_count ?? '0' }}</p>
                                </div>
                                <div class="px-3 py-1.5 bg-blue-50 rounded-xl border border-blue-100 text-center">
                                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">Batas Akhir</p>
                                    <p class="font-bold text-blue-700">{{ $program->close_date?->format('d M Y') ?? 'Tanpa Batas' }}</p>
                                </div>
                            </div>

                            @if($program->description)
                                <p class="text-sm text-gray-500 leading-relaxed line-clamp-2">{{ $program->description }}</p>
                            @endif
                        </div>

                        <div class="mt-5 pt-4 border-t border-gray-50">
                            <a href="{{ route('farmer.proposals.create', $program) }}" onclick="event.stopPropagation()"
                               class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold text-sm rounded-xl shadow-sm hover:bg-primary-700 hover:shadow-md transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Ajukan Proposal
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-16 text-center">
                    <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p class="text-gray-500 font-medium">Saat ini belum ada program bantuan yang sedang dibuka.</p>
                </div>
            @endforelse
        </div>

        {{-- ===== PROGRAM YANG SUDAH DITUTUP ===== --}}
        @if($closedPrograms->isNotEmpty())
            <div class="mt-8">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-black text-gray-800 text-lg">Pendaftaran Sudah Ditutup</h2>
                        <p class="text-sm text-gray-500">Program di bawah ini sudah tidak menerima pengajuan proposal.</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 overflow-hidden divide-y divide-gray-100 bg-white shadow-sm">
                    @foreach($closedPrograms as $program)
                        <div onclick="window.location.href='{{ route('farmer.proposals.bantuan.show', $program) }}'" class="group cursor-pointer flex flex-col sm:flex-row hover:bg-gray-50 transition-colors">


                            {{-- Info --}}
                            <div class="flex-1 p-5 flex flex-col justify-between opacity-80 group-hover:opacity-100 transition-opacity">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-bold text-gray-700 text-base">{{ $program->name }}</h3>
                                        <span class="text-[10px] font-bold uppercase tracking-wide px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">
                                            {{ str_replace('_', ' ', $program->type) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 text-xs text-gray-500 mb-2">
                                        <span>Batas Akhir: <span class="font-bold text-gray-700">{{ $program->close_date?->format('d M Y') ?? 'Tanpa Batas' }}</span></span>
                                        <span>Terdaftar: <span class="font-bold text-gray-700">{{ $program->proposals_count ?? '0' }}</span></span>
                                    </div>
                                    @if($program->description)
                                        <p class="text-sm text-gray-400 leading-relaxed line-clamp-1">{{ $program->description }}</p>
                                    @endif
                                </div>

                                <div class="mt-3 pt-3 border-t border-gray-50">
                                    <span class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-gray-400 font-bold text-xs rounded-xl cursor-not-allowed">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Pendaftaran Ditutup
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
