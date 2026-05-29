<x-app-layout>
    <x-slot name="header">Riwayat Usulan Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
            <div>
                <p class="text-gray-500 text-sm mt-1">Pantau status dan detail seluruh proposal yang pernah Anda ajukan.</p>
            </div>
            <a href="{{ route('farmer.proposals.pilih') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-[#19A148] text-white text-sm font-bold rounded-xl hover:bg-green-700 transition-all shadow-sm shadow-green-100 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Ajukan Proposal Baru
            </a>
        </div>

        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest whitespace-nowrap">No. Registrasi</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Objek Proposal</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($proposals as $proposal)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-900 text-sm">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-900">{{ $proposal->submission_date->translatedFormat('d M Y') }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $proposal->submission_date->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($proposal->alsintan)
                                        <p class="font-bold text-gray-900 text-sm">{{ $proposal->alsintan->name }}</p>
                                        <p class="text-[10px] text-primary-600 font-bold uppercase tracking-tighter">Peminjaman Alsintan</p>
                                    @elseif($proposal->program)
                                        <p class="font-bold text-gray-900 text-sm">{{ $proposal->program->name }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ str_replace('_', ' ', $proposal->program->type) }}</p>
                                    @else
                                        <p class="font-bold text-gray-900">-</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusColors = [
                                            'pending_verifikasi' => 'bg-yellow-100 text-yellow-700',
                                            'diteruskan_ke_pimpinan' => 'bg-indigo-100 text-indigo-700',
                                            'didisposisi_kabid' => 'bg-amber-100 text-amber-700',
                                            'surat_tugas_terbit' => 'bg-blue-100 text-blue-700',
                                            'survei_selesai' => 'bg-orange-100 text-orange-700',
                                            'menunggu_review_kabid' => 'bg-teal-100 text-teal-700',
                                            'menunggu_approval_ba' => 'bg-purple-100 text-purple-700',
                                            'disetujui'          => 'bg-green-100 text-green-700',
                                            'ditolak'            => 'bg-red-100 text-red-700',
                                        ];
                                        $color = $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-700';
                                        $statusLabel = match($proposal->status) {
                                            'pending_verifikasi' => 'Verifikasi',
                                            'diteruskan_ke_pimpinan'  => 'Pimpinan',
                                            'didisposisi_kabid'  => 'Di Kabid',
                                            'surat_tugas_terbit' => 'Survei',
                                            'survei_selesai' => 'Survei Selesai',
                                            'menunggu_review_kabid' => 'Review Kabid',
                                            'menunggu_approval_ba' => 'Keputusan',
                                            'disetujui'          => 'Disetujui',
                                            'ditolak'            => 'Ditolak',
                                            default              => $proposal->status,
                                        };
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest {{ $color }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('farmer.proposals.show', $proposal) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="text-gray-400 font-semibold text-lg italic">Anda belum pernah mengajukan proposal usulan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
