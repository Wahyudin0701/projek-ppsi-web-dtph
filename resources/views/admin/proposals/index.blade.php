<x-app-layout>
    <x-slot name="header">Kelola Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Header & Filter --}}
            <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col gap-5">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Daftar Proposal Masuk</h3>
                    <p class="text-sm text-gray-500 mt-1">Tinjau dan kelola semua proposal pengajuan bantuan atau peminjaman alsintan dari kelompok tani.</p>
                </div>
                
                <form method="GET" action="{{ route('admin.proposals.index') }}" class="flex flex-wrap gap-3 items-end" x-data x-ref="filterForm">
                    <div class="relative flex-1 min-w-[200px]">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama petani atau program..."
                            x-on:search="$refs.filterForm.submit()"
                            class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <select name="status" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all appearance-none bg-white pr-8"
                        style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="">Semua Status</option>
                        <option value="sedang_diverifikasi_admin" {{ request('status') === 'sedang_diverifikasi_admin' ? 'selected' : '' }}>Sedang Diverifikasi Admin</option>
                        <option value="sedang_diverifikasi_pimpinan" {{ request('status') === 'sedang_diverifikasi_pimpinan' ? 'selected' : '' }}>Sedang Diverifikasi Pimpinan</option>
                        <option value="persiapan_survei" {{ request('status') === 'persiapan_survei' ? 'selected' : '' }}>Persiapan Survei</option>
                        <option value="sedang_survei" {{ request('status') === 'sedang_survei' ? 'selected' : '' }}>Sedang Survei</option>
                        <option value="survei_selesai" {{ request('status') === 'survei_selesai' ? 'selected' : '' }}>Survei Selesai</option>
                        <option value="menunggu_keputusan_akhir" {{ request('status') === 'menunggu_keputusan_akhir' ? 'selected' : '' }}>Menunggu Keputusan Akhir</option>
                        <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <div class="flex flex-col">
                        <div class="flex justify-end mb-1.5 min-h-[16px]">
                            @if(request()->anyFilled(['search', 'status', 'type']))
                                <a href="{{ route('admin.proposals.index') }}" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider">Reset</a>
                            @endif
                        </div>
                        <select name="type" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all appearance-none bg-white pr-8"
                            style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                            <option value="">Semua Jenis</option>
                            <option value="alsintan" {{ request('type') === 'alsintan' ? 'selected' : '' }}>Peminjaman Alsintan</option>
                            <option value="bantuan" {{ request('type') === 'bantuan' ? 'selected' : '' }}>Program Bantuan</option>
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
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100" style="width: 30%">Pengaju</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100" style="width: 25%">Jenis & Objek</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center whitespace-nowrap" style="width: 15%">Tgl. Pengajuan</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center whitespace-nowrap" style="width: 5%">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center whitespace-nowrap" style="width: 10%">Aksi</th>
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
                                        'survei_selesai'           => ['bg' => 'bg-orange-100 text-orange-700',  'label' => 'Survei Selesai'],
                                        'verifikasi_cpcl'    => ['bg' => 'bg-teal-100 text-teal-700',      'label' => 'Verifikasi CPCL'],
                                        'menunggu_keputusan_akhir'     => ['bg' => 'bg-purple-100 text-purple-700',  'label' => 'Finalisasi'],
                                        'disetujui'                => ['bg' => 'bg-emerald-100 text-emerald-700',    'label' => 'Disetujui'],
                                        'ditolak'                  => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Ditolak'],
                                    ];
                                    $sc = $statusConfig[$proposal->status] ?? ['bg' => 'bg-gray-100 text-gray-600', 'label' => $proposal->statusLabel];
                                    $isAlsintan = $proposal->alsintan_id !== null;
                                @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-900 text-sm">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900 text-sm">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $proposal->user->name }}</p>
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
                                    <p class="text-sm font-bold text-gray-700">{{ $proposal->submission_date?->translatedFormat('d M Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $proposal->submission_date?->translatedFormat('H:i') }} WIB</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest border {{ $sc['bg'] }} {{ str_replace('bg-', 'border-', explode(' ', $sc['bg'])[0]) }}">
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($proposal->status === 'sedang_diverifikasi_admin')
                                        <a href="{{ route('admin.proposals.show', $proposal) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                            Tinjau
                                        </a>
                                    @else
                                        <a href="{{ route('admin.proposals.show', $proposal) }}"
                                           class="inline-flex items-center justify-center bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900">Tidak Ada Proposal</h3>
                                    <p class="text-gray-500 mt-1 text-sm">Belum ada data proposal ditemukan.</p>
                                    @if(request()->hasAny(['search', 'status', 'type']))
                                        <p class="text-gray-400 text-sm mt-1">Coba ubah atau reset filter pencarian Anda.</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($proposals, 'links') && $proposals->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $proposals->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

