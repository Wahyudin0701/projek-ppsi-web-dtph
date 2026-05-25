<x-app-layout>
    <x-slot name="header">Kelola Disposisi Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Header & Filter --}}
            <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col gap-5">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Daftar Proposal Disposisi</h3>
                    <p class="text-sm text-gray-500 mt-1">Proposal yang didelegasikan kepada Anda untuk ditindaklanjuti, seperti pembentukan tim survei dan pembuatan berita acara.</p>
                </div>
                
                <form method="GET" action="{{ route('kabid.proposals.index') }}" class="flex flex-wrap gap-3 items-center" x-data x-ref="filterForm">
                    <div class="relative flex-1 min-w-[200px]">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari petani, kelompok, atau program..."
                            x-on:search="$refs.filterForm.submit()"
                            class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                    </div>

                    <select name="type" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all appearance-none bg-white pr-8"
                        style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="">Semua Jenis</option>
                        <option value="alsintan" {{ request('type') === 'alsintan' ? 'selected' : '' }}>Peminjaman Alsintan</option>
                        <option value="bantuan" {{ request('type') === 'bantuan' ? 'selected' : '' }}>Program Bantuan</option>
                    </select>

                    <select name="status" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all appearance-none bg-white pr-8"
                        style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="">Semua Status</option>
                        <option value="didisposisi_kabid" {{ request('status') === 'didisposisi_kabid' ? 'selected' : '' }}>Perlu Assign Tim</option>
                        <option value="surat_tugas_terbit" {{ request('status') === 'surat_tugas_terbit' ? 'selected' : '' }}>Surat Tugas Terbit</option>
                        <option value="survei_selesai" {{ request('status') === 'survei_selesai' ? 'selected' : '' }}>Menunggu Admin</option>
                        <option value="menunggu_approval_ba" {{ request('status') === 'menunggu_approval_ba' ? 'selected' : '' }}>Menunggu Keputusan</option>
                        <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">No. Registrasi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Pengaju</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Jenis & Objek</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($proposals as $proposal)
                            @php
                                $sc = match($proposal->status) {
                                    'didisposisi_kabid'        => ['bg' => 'bg-amber-100 text-amber-700',    'label' => 'Perlu Assign Tim'],
                                    'surat_tugas_terbit'       => ['bg' => 'bg-blue-100 text-blue-700',      'label' => 'Surat Tugas Terbit'],
                                    'survei_selesai'           => ['bg' => 'bg-orange-100 text-orange-700',  'label' => 'Menunggu Admin'],
                                    'menunggu_approval_ba'     => ['bg' => 'bg-purple-100 text-purple-700',  'label' => 'Menunggu Keputusan'],
                                    'disetujui'                => ['bg' => 'bg-green-100 text-green-700',    'label' => 'Disetujui'],
                                    'ditolak'                  => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Ditolak'],
                                    default                    => ['bg' => 'bg-gray-100 text-gray-600',       'label' => $proposal->statusLabel],
                                };
                                $isAlsintan = $proposal->alsintan_id !== null;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-900 text-sm">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $proposal->updated_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900 text-sm">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $proposal->user->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border mb-1 {{ $isAlsintan ? 'bg-sky-50 text-sky-600 border-sky-100' : 'bg-violet-50 text-violet-600 border-violet-100' }}">
                                        {{ $isAlsintan ? 'Alsintan' : 'Bantuan' }}
                                    </span>
                                    <p class="font-bold text-gray-800 text-sm">
                                        {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest {{ $sc['bg'] }}">
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kabid.proposals.show', $proposal) }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-all">
                                            Detail
                                        </a>
                                        @if($proposal->status === 'didisposisi_kabid')
                                            <a href="{{ route('kabid.proposals.assign-team.form', $proposal) }}"
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition-all shadow-sm shadow-amber-500/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                Bentuk Tim
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <p class="font-bold text-sm text-gray-500">Tidak ada proposal yang ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($proposals->hasPages())
            <div class="p-6 border-t border-gray-50 bg-gray-50/50">
                {{ $proposals->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
