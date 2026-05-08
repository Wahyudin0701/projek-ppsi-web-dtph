<x-app-layout>
    <x-slot name="header">{{ $title ?? 'Pilih Program Bantuan' }}</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        {{-- ===== HEADER SECTION ===== --}}
        <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm overflow-hidden relative">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <a href="{{ route('farmer.proposals.programs') }}" class="text-xs font-bold text-primary-600 hover:underline">Ajukan Proposal</a>
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        <span class="text-xs font-bold text-gray-400">{{ $category === 'alsintan' ? 'Alsintan' : 'Program Bantuan' }}</span>
                    </div>
                    <h2 class="text-2xl font-black text-gray-800 mb-1">{{ $title }}</h2>
                    <p class="text-gray-500 max-w-xl text-sm leading-relaxed font-medium">
                        Daftar program bantuan {{ strtolower($category === 'alsintan' ? 'alat mesin pertanian' : 'pertanian lainnya') }} yang sedang dibuka.
                    </p>
                </div>
                <a href="{{ route('farmer.proposals.programs') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                    Kembali
                </a>
            </div>
            {{-- Decorative element --}}
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary-50 rounded-full opacity-50"></div>
        </div>

        {{-- ===== PROGRAM LIST ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($programs as $program)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="mb-4 flex items-center justify-between">
                        <span class="inline-block rounded-lg bg-primary-50 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-primary-600">
                            {{ str_replace('_', ' ', $program->type) }}
                        </span>
                        <div class="h-8 w-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                    </div>
                    <h4 class="mb-2 font-black text-gray-800 text-lg leading-tight">{{ $program->name }}</h4>
                    <p class="mb-6 text-sm text-gray-500 leading-relaxed line-clamp-3">
                        {{ $program->description ?? 'Program bantuan distribusi untuk peningkatan produktivitas pertanian daerah.' }}
                    </p>
                </div>
                
                <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                    <div class="text-[11px] text-gray-400 font-medium">
                        Batas Akhir: <span class="font-bold text-gray-700 block text-xs">{{ $program->close_date?->format('d M Y') ?? 'Tanpa Batas' }}</span>
                    </div>
                    <a href="{{ route('farmer.proposals.create', $program) }}"
                       class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white transition-all duration-200 hover:bg-primary-600 hover:shadow-lg hover:shadow-primary-900/20">
                        Pilih Program
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-16 text-center rounded-2xl border border-dashed border-gray-200">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <p class="text-gray-500 font-bold">Saat ini belum ada program bantuan yang dibuka.</p>
                <p class="text-gray-400 text-sm mt-1">Silakan periksa kembali di lain waktu.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
