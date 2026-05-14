<x-app-layout>
    <x-slot name="header">Kelola Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Proposal</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-yellow-50 rounded-2xl p-5 border border-yellow-100 shadow-sm">
                <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider mb-1">Menunggu</p>
                <p class="text-3xl font-extrabold text-yellow-700">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 shadow-sm">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Disetujui</p>
                <p class="text-3xl font-extrabold text-emerald-700">{{ $stats['approved'] }}</p>
            </div>
            <div class="bg-red-50 rounded-2xl p-5 border border-red-100 shadow-sm">
                <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Ditolak</p>
                <p class="text-3xl font-extrabold text-red-700">{{ $stats['rejected'] }}</p>
            </div>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter Bar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.proposals.index') }}" class="flex flex-wrap gap-3 items-center">
                <div class="relative flex-1 min-w-[200px]">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari petani atau nama alat/program..."
                        class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                </div>
                <select name="status" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all appearance-none bg-white pr-8"
                    style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                    <option value="">Semua Status</option>
                    <option value="pending_verifikasi" {{ request('status') === 'pending_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <select name="type" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all appearance-none bg-white pr-8"
                    style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                    <option value="">Semua Jenis</option>
                    <option value="alsintan" {{ request('type') === 'alsintan' ? 'selected' : '' }}>Peminjaman Alsintan</option>
                    <option value="bantuan" {{ request('type') === 'bantuan' ? 'selected' : '' }}>Program Bantuan</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-[#19A148] text-white text-sm font-bold rounded-xl hover:bg-green-700 transition-colors shadow-sm">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'type']))
                    <a href="{{ route('admin.proposals.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">No. Registrasi</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Pengaju</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Jenis & Objek</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Tgl. Pengajuan</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($proposals as $proposal)
                            @php
                                $statusConfig = [
                                    'pending_verifikasi' => ['bg' => 'bg-yellow-100 text-yellow-700', 'label' => 'Menunggu'],
                                    'disetujui'          => ['bg' => 'bg-green-100 text-green-700', 'label' => 'Disetujui'],
                                    'ditolak'            => ['bg' => 'bg-red-100 text-red-700', 'label' => 'Ditolak'],
                                ];
                                $sc = $statusConfig[$proposal->status] ?? ['bg' => 'bg-gray-100 text-gray-600', 'label' => $proposal->status];
                                $isAlsintan = $proposal->alsintan_id !== null;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-900 text-sm">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900 text-sm">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $proposal->user->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md mb-1 {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                                        {{ $isAlsintan ? 'Alsintan' : 'Program Bantuan' }}
                                    </span>
                                    <p class="font-semibold text-gray-800 text-sm">
                                        {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="text-sm text-gray-700">{{ $proposal->submission_date?->translatedFormat('d M Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $proposal->submission_date?->translatedFormat('H:i') }} WIB</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest {{ $sc['bg'] }}">
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($proposal->status === 'pending_verifikasi')
                                        <a href="{{ route('admin.proposals.show', $proposal) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#19A148] hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm shadow-green-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                            Tinjau
                                        </a>
                                    @else
                                        <a href="{{ route('admin.proposals.show', $proposal) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="text-gray-400 font-semibold">Tidak ada proposal ditemukan.</p>
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
            @if($proposals->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $proposals->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
