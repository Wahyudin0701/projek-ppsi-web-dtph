<x-app-layout>
    <x-slot name="header">Kelola Disposisi Proposal</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Daftar Proposal Disposisi</h2>
                <p class="text-gray-500 text-sm mt-1">Proposal yang didelegasikan kepada Anda untuk ditindaklanjuti.</p>
            </div>
        </div>

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

        {{-- Filter Bar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <form method="GET" class="flex flex-wrap gap-3 items-center">
                <select name="status" onchange="this.form.submit()" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 font-semibold text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">Semua Status</option>
                    <option value="didisposisi_kabid" {{ request('status') === 'didisposisi_kabid' ? 'selected' : '' }}>Perlu Assign Tim</option>
                    <option value="surat_tugas_terbit" {{ request('status') === 'surat_tugas_terbit' ? 'selected' : '' }}>Surat Tugas Terbit</option>
                    <option value="survei_selesai" {{ request('status') === 'survei_selesai' ? 'selected' : '' }}>Perlu Berita Acara</option>
                    <option value="menunggu_approval_ba" {{ request('status') === 'menunggu_approval_ba' ? 'selected' : '' }}>Menunggu Keputusan</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            @forelse($proposals as $proposal)
            <a href="{{ route('kabid.proposals.show', $proposal) }}"
               class="flex items-center gap-4 px-6 py-4 hover:bg-amber-50/50 transition-colors border-b border-gray-50 last:border-0">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <span class="text-xs font-extrabold text-amber-600">#{{ str_pad($proposal->id, 3, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-sm text-gray-800 truncate">
                        {{ $proposal->program?->name ?? $proposal->alsintan?->name ?? 'Proposal Tidak Diketahui' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $proposal->user->farmerProfile?->nama_kelompok ?? $proposal->user->name }}
                        &bull; {{ $proposal->submission_date?->format('d M Y') }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    @php
                        $badge = match($proposal->status) {
                            'didisposisi_kabid'        => ['bg-amber-100 text-amber-700', 'Perlu Assign Tim'],
                            'surat_tugas_terbit'       => ['bg-blue-100 text-blue-700',   'Surat Tugas Terbit'],
                            'survei_selesai'           => ['bg-orange-100 text-orange-700','Perlu Berita Acara'],
                            'menunggu_approval_ba'     => ['bg-purple-100 text-purple-700','Menunggu Keputusan'],
                            'disetujui'                => ['bg-green-100 text-green-700',  'Disetujui'],
                            'ditolak'                  => ['bg-red-100 text-red-700',      'Ditolak'],
                            default                    => ['bg-gray-100 text-gray-600',    ucfirst($proposal->status)],
                        };
                    @endphp
                    <span class="text-xs font-bold px-3 py-1 rounded-full {{ $badge[0] }}">{{ $badge[1] }}</span>
                </div>
                <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @empty
            <div class="py-16 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="font-bold text-sm">Belum ada proposal yang didisposisi</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
