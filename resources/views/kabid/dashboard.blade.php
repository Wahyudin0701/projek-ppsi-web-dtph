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
                    <h2 class="mb-2 text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->display_name }}</h2>
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
                    ['label' => 'Persiapan Survei', 'value' => $stats['menunggu_survei'], 'textColor' => 'text-amber-600'],
                    ['label' => 'Dalam Survei',     'value' => $stats['dalam_survei'],    'textColor' => 'text-blue-600'],
                    ['label' => 'Verifikasi CPCL','value' => $stats['verifikasi_cpcl'] ?? 0, 'textColor' => 'text-orange-600'],
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

        {{-- ===== CHARTS ===== --}}
        @include('components.dashboard-charts')

        {{-- ===== NEEDS ACTION ===== --}}
        <div>
            <div class="flex items-center justify-between mb-5 px-1">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Membutuhkan Tindakan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Proposal yang perlu segera ditindaklanjuti</p>
                </div>
                <a href="{{ route('kabid.proposals.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-bold text-amber-600 hover:underline whitespace-nowrap">
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
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-400 text-xs font-bold uppercase tracking-wider">
                                    <th class="px-6 py-4">No. Proposal</th>
                                    <th class="px-6 py-4">Kelompok Tani</th>
                                    <th class="px-6 py-4">Bantuan / Program</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($pendingAction as $proposal)
                                    @php 
                                        $isAlsintan = $proposal->alsintan_id !== null; 
                                        $sc = match($proposal->status) {
                                            'sedang_diverifikasi_admin' => ['bg' => 'bg-amber-100 text-amber-700', 'label' => 'Sedang Diverifikasi Admin'],
                                            'sedang_diverifikasi_pimpinan' => ['bg' => 'bg-purple-100 text-purple-700', 'label' => 'Review Pimpinan'],
                                            'persiapan_survei' => ['bg' => 'bg-blue-100 text-blue-700', 'label' => 'Persiapan Survei'],
                                            'survei_berlangsung' => ['bg' => 'bg-sky-100 text-sky-700', 'label' => 'Survei Berlangsung'],

                                            'verifikasi_cpcl' => ['bg' => 'bg-teal-100 text-teal-700', 'label' => 'Menunggu Keputusan Akhir'],
                                            'menunggu_keputusan_akhir' => ['bg' => 'bg-indigo-100 text-indigo-700', 'label' => 'Menunggu Keputusan Pimpinan'],
                                            'sedang_survei' => ['bg' => 'bg-blue-100 text-blue-700', 'label' => 'Sedang Survei'],
                                            'disetujui' => ['bg' => 'bg-green-100 text-green-700', 'label' => 'Disetujui'],
                                            'ditolak' => ['bg' => 'bg-red-100 text-red-700', 'label' => 'Ditolak'],
                                            default => ['bg' => 'bg-gray-100 text-gray-700', 'label' => ucfirst(str_replace('_', ' ', $proposal->status))]
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900 text-sm align-middle">
                                            #PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <p class="font-bold text-gray-900 text-sm leading-tight">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $proposal->user->farmerProfile->desa ?? 'N/A' }}, {{ $proposal->user->farmerProfile->kecamatan ?? 'N/A' }}</p>
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <div class="flex flex-col items-start gap-1">
                                                <span class="inline-block text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded-md {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                                                    {{ $isAlsintan ? 'Alsintan' : 'Bantuan' }}
                                                </span>
                                                <span class="text-xs text-gray-700 font-medium max-w-[200px] truncate">
                                                    {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md {{ $sc['bg'] }}">
                                                {{ $sc['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right align-middle">
                                            <div class="flex flex-col sm:flex-row items-end sm:items-center justify-end gap-2">
                                                @if($proposal->status === 'persiapan_survei')
                                                    <a href="{{ route('kabid.proposals.assign-team.form', $proposal) }}"
                                                       class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-xl transition-colors border border-amber-100 whitespace-nowrap">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                        Bentuk Tim
                                                    </a>
                                                @endif
                                                <a href="{{ route('kabid.proposals.show', $proposal) }}"
                                                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-bold rounded-xl transition-colors border border-gray-100 whitespace-nowrap">
                                                    Detail Proposal
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
