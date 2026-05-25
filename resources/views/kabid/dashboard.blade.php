<x-app-layout>
    <x-slot name="header">Dashboard Kabid</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">

        {{-- ===== WELCOME BANNER ===== --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-900 via-amber-800 to-orange-950 p-7 text-white shadow-lg shadow-orange-900/20">
            <div class="pointer-events-none absolute -right-10 -top-10 h-56 w-56 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute -bottom-8 right-32 h-36 w-36 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute right-20 top-4 h-24 w-24 rounded-full bg-white/8"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-1 text-xs font-bold text-amber-200 mb-3 border border-white/10">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Panel Kepala Bidang
                    </div>
                    <h2 class="mb-2 text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}</h2>
                    <p class="max-w-lg text-sm text-amber-200 leading-relaxed hidden sm:block">
                        {{ auth()->user()->roleLabel }} — Dinas Tanaman Pangan & Hortikultura
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-[11px] text-amber-300 font-medium text-right">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS (WITHOUT ICONS) ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-5">
            @php
                $statCards = [
                    ['label' => 'Total Disposisi', 'value' => $stats['total'],           'textColor' => 'text-slate-700'],
                    ['label' => 'Perlu Assign Tim', 'value' => $stats['menunggu_survei'], 'textColor' => 'text-amber-600'],
                    ['label' => 'Dalam Survei',     'value' => $stats['dalam_survei'],    'textColor' => 'text-blue-600'],
                    ['label' => 'Perlu Berita Acara','value' => $stats['survei_selesai'], 'textColor' => 'text-orange-600'],
                    ['label' => 'Selesai',           'value' => $stats['selesai'],         'textColor' => 'text-green-600'],
                ];
            @endphp
            @foreach($statCards as $card)
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 group">
                <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-1 uppercase tracking-widest">{{ $card['label'] }}</p>
                <p class="text-2xl sm:text-3xl font-black {{ $card['textColor'] }} leading-none tracking-tight">{{ $card['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- ===== NEEDS ACTION ===== --}}
        <div>
            <div class="flex items-center justify-between mb-5 px-1">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Membutuhkan Tindakan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Proposal yang perlu segera ditindaklanjuti</p>
                </div>
                <a href="{{ route('kabid.proposals.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-bold text-amber-600 hover:underline">
                    Lihat Semua
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if(empty($pendingAction) || count($pendingAction) === 0)
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-16 text-center">
                    <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-gray-400 font-semibold">Tidak ada proposal yang perlu ditindaklanjuti.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="divide-y divide-gray-50">
                        @foreach($pendingAction as $proposal)
                        <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0 border border-amber-100 transition-colors">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-sm text-gray-900 truncate">
                                    {{ $proposal->program?->name ?? $proposal->alsintan?->name ?? 'Proposal #'.$proposal->id }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $proposal->user->farmerProfile?->nama_kelompok ?? $proposal->user->name }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 flex items-center gap-2">
                                @if($proposal->status === 'didisposisi_kabid')
                                    <a href="{{ route('kabid.proposals.assign-team.form', $proposal) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 text-amber-700 text-xs font-bold rounded-lg hover:bg-amber-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Bentuk Tim
                                    </a>
                                @endif
                                <a href="{{ route('kabid.proposals.show', $proposal) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-200 transition-colors">
                                    Detail Proposal
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
