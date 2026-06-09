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
                    <div class="relative flex-1 min-w-[200px] flex flex-col">
                        <label class="text-xs font-bold text-gray-700 mb-1.5 ml-1">Pencarian</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari petani, kelompok..."
                                x-on:search="$refs.filterForm.submit()"
                                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-700 mb-1.5 ml-1">Jenis</label>
                        <select name="type" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all appearance-none bg-white pr-8"
                            style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                            <option value="">Semua</option>
                            <option value="alsintan" {{ request('type') === 'alsintan' ? 'selected' : '' }}>Alsintan</option>
                            <option value="bantuan" {{ request('type') === 'bantuan' ? 'selected' : '' }}>Bantuan</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-700 mb-1.5 ml-1">Mulai Tgl</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all bg-white">
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-700 mb-1.5 ml-1">Sampai Tgl</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all bg-white">
                    </div>

                    <div class="flex flex-col min-w-[180px]">
                        <div class="flex justify-between items-center mb-1.5 min-h-[16px]">
                            <span class="text-xs font-bold text-gray-700 ml-1">Status</span>
                            @if(request()->anyFilled(['search', 'status', 'type', 'start_date', 'end_date']))
                                <a href="{{ route('kabid.proposals.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-800 transition-colors">Reset Filter</a>
                            @endif
                        </div>
                        <select name="status" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all appearance-none bg-white pr-8"
                            style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                            <option value="">Semua Status</option>
                            <option value="persiapan_survei" {{ request('status') === 'persiapan_survei' ? 'selected' : '' }}>Persiapan Survei</option>
                            <option value="sedang_survei" {{ request('status') === 'sedang_survei' ? 'selected' : '' }}>Sedang Survei</option>
                            <option value="verifikasi_cpcl" {{ request('status') === 'verifikasi_cpcl' ? 'selected' : '' }}>Verifikasi CPCL</option>
                            <option value="selesai_kabid" {{ request('status') === 'selesai_kabid' ? 'selected' : '' }}>Selesai di Kabid</option>
                        </select>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[950px] text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap" style="width: 15%">No. Registrasi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100" style="width: 35%">Pengaju</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100" style="width: 20%">Jenis & Objek</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center whitespace-nowrap" style="width: 15%">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center whitespace-nowrap" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($proposals as $proposal)
                            @php
                                $statusConfig = [
                                    'sedang_diverifikasi_admin'       => ['bg' => 'bg-yellow-100 text-yellow-700',  'label' => 'Di Admin'],
                                    'sedang_diverifikasi_pimpinan'   => ['bg' => 'bg-indigo-100 text-indigo-700',  'label' => 'Di Pimpinan'],
                                    'persiapan_survei'        => ['bg' => 'bg-amber-100 text-amber-700',    'label' => 'Di Kabid'],
                                    'sedang_survei'       => ['bg' => 'bg-blue-100 text-blue-700',      'label' => 'Sedang Survei'],

                                    'verifikasi_cpcl'    => ['bg' => 'bg-teal-100 text-teal-700',      'label' => 'Verifikasi CPCL'],
                                    'menunggu_keputusan_akhir'     => ['bg' => 'bg-purple-100 text-purple-700',  'label' => 'Finalisasi'],
                                    'direkomendasikan'             => ['bg' => 'bg-emerald-100 text-emerald-700','label' => 'Di Pusat'],
                                    'disetujui'                => ['bg' => 'bg-green-100 text-green-700',    'label' => 'Disetujui'],
                                    'dikembalikan'             => ['bg' => 'bg-gray-100 text-gray-700',      'label' => 'Selesai'],
                                    'ditolak'                  => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Di Tolak'],
                                    'ditolak_pusat'            => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Di Tolak'],
                                ];
                                $sc = $statusConfig[$proposal->status] ?? ['bg' => 'bg-gray-100 text-gray-600', 'label' => $proposal->statusLabel];
                                $isAlsintan = $proposal->alsintan_id !== null;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-900 text-sm">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $proposal->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $namaUtama = $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name;
                                        $idPoktan = $proposal->user->farmerProfile->id_poktan ?? null;
                                    @endphp
                                    <p class="font-bold text-gray-900 text-sm">{{ $namaUtama }}</p>
                                    @if($idPoktan)
                                        <p class="text-xs text-gray-400 mt-0.5 font-mono">ID: {{ $idPoktan }}</p>
                                    @endif
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
                                    <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest border {{ $sc['bg'] }} {{ str_replace('bg-', 'border-', explode(' ', $sc['bg'])[0]) }}">
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-left whitespace-nowrap">
                                    <div class="flex flex-col xl:flex-row items-stretch xl:items-center justify-start gap-2">
                                        <a href="{{ route('kabid.proposals.show', $proposal) }}"
                                           class="inline-flex items-center justify-center xl:justify-start gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-all whitespace-nowrap">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>

                                        @if($proposal->status === 'persiapan_survei')
                                            <a href="{{ route('kabid.proposals.assign-team.form', $proposal) }}"
                                               class="inline-flex items-center justify-center xl:justify-start gap-1 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition-all shadow-sm shadow-amber-500/20 whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                Bentuk Tim
                                            </a>

                                        @elseif($proposal->status === 'sedang_survei')
                                            <a href="{{ route('documents.surat-tugas', $proposal) }}" target="_blank"
                                               class="inline-flex items-center justify-center xl:justify-start gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-xl transition-all border border-blue-100 whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                Surat Tugas
                                            </a>
                                            <a href="{{ route('documents.form-cpcl-blank', $proposal) }}" target="_blank"
                                               class="inline-flex items-center justify-center xl:justify-start gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-bold rounded-xl transition-all border border-indigo-100 whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                Form CPCL
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
