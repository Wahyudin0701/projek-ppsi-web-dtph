<x-app-layout>
    <x-slot name="header">Program Bantuan - Ajukan Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('farmer.proposals.pilih') }}" class="hover:text-primary-600 transition-colors">Ajukan Proposal</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-semibold text-gray-700">Program Bantuan</span>
                </div>
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

        <div class="space-y-4">
            @forelse($programs as $program)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row group">
                    {{-- Icon/Image Placeholder --}}
                    <div class="w-full sm:w-48 h-48 sm:h-auto bg-slate-50 flex-shrink-0 flex items-center justify-center border-r border-gray-50">
                        <div class="w-20 h-20 bg-white rounded-3xl shadow-sm border border-gray-100 flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>

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
                            <a href="{{ route('farmer.proposals.create', $program) }}"
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

    </div>
</x-app-layout>
