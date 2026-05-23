<x-app-layout>
    <x-slot name="header">Dashboard Kepala Bidang — {{ auth()->user()->roleLabel }}</x-slot>

    <div class="space-y-6">

        {{-- Welcome --}}
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-3xl p-6 text-white">
            <p class="text-amber-100 text-sm font-semibold uppercase tracking-widest mb-1">Selamat Datang</p>
            <h2 class="text-2xl font-extrabold">{{ auth()->user()->name }}</h2>
            <p class="text-amber-100 mt-1 text-sm">{{ auth()->user()->roleLabel }} — Dinas Tanaman Pangan & Hortikultura</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            @php
                $statCards = [
                    ['label' => 'Total Disposisi', 'value' => $stats['total'],           'color' => 'bg-slate-100 text-slate-700', 'icon' => '<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                    ['label' => 'Perlu Assign Tim', 'value' => $stats['menunggu_survei'], 'color' => 'bg-amber-100 text-amber-700', 'icon' => '<path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>'],
                    ['label' => 'Dalam Survei',     'value' => $stats['dalam_survei'],    'color' => 'bg-blue-100 text-blue-700', 'icon' => '<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>'],
                    ['label' => 'Perlu Berita Acara','value' => $stats['survei_selesai'], 'color' => 'bg-orange-100 text-orange-700', 'icon' => '<path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>'],
                    ['label' => 'Selesai',           'value' => $stats['selesai'],         'color' => 'bg-green-100 text-green-700', 'icon' => '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                ];
            @endphp
            @foreach($statCards as $card)
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col xl:flex-row items-start xl:items-center gap-3 xl:gap-4 group">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full {{ $card['color'] }} flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">{!! $card['icon'] !!}</svg>
                </div>
                <div>
                    <p class="text-[10px] xl:text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-0.5 xl:mb-1">{{ $card['label'] }}</p>
                    <p class="text-2xl xl:text-3xl font-black {{ explode(' ', $card['color'])[1] }} leading-none tracking-tight">{{ $card['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Needs Action --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-gray-800">Membutuhkan Tindakan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Proposal yang perlu segera ditindaklanjuti</p>
                </div>
                <a href="{{ route('kabid.proposals.index') }}" class="text-xs font-bold text-amber-600 hover:underline">Lihat Semua →</a>
            </div>
            @forelse($pendingAction as $proposal)
            <a href="{{ route('kabid.proposals.show', $proposal) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-amber-50 transition-colors border-b border-gray-50 last:border-0">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                    {{ $proposal->status === 'didisposisi_kabid' ? 'bg-amber-100' : 'bg-orange-100' }}">
                    <svg class="w-5 h-5 {{ $proposal->status === 'didisposisi_kabid' ? 'text-amber-600' : 'text-orange-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-sm text-gray-800 truncate">
                        {{ $proposal->program?->name ?? $proposal->alsintan?->name ?? 'Proposal #'.$proposal->id }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $proposal->user->farmerProfile?->nama_kelompok ?? $proposal->user->name }}</p>
                </div>
                <div>
                    @if($proposal->status === 'didisposisi_kabid')
                        <span class="text-xs bg-amber-100 text-amber-700 font-bold px-3 py-1 rounded-full">Assign Tim</span>
                    @else
                        <span class="text-xs bg-orange-100 text-orange-700 font-bold px-3 py-1 rounded-full">Buat BA</span>
                    @endif
                </div>
            </a>
            @empty
            <div class="px-6 py-10 text-center text-gray-400">
                <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-semibold">Tidak ada proposal yang perlu ditindaklanjuti</p>
            </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
