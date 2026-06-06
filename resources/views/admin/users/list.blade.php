<x-app-layout>
    <x-slot name="header">Daftar User</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="mb-2 border-b border-gray-200">
            <nav class="-mb-px flex gap-8">
                <a href="{{ route('admin.users.list') }}" class="{{ request()->routeIs('admin.users.list') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-bold text-sm transition-colors">
                    Daftar Kelompok Tani
                </a>
                <a href="{{ route('admin.users.individuals') }}" class="{{ request()->routeIs('admin.users.individuals') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-bold text-sm transition-colors">
                    Daftar Petani Individu
                </a>
            </nav>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Header List & Filters --}}
            <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Semua Pengguna</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola dan pantau seluruh data kelompok tani binaan DTPH Muaro Jambi.</p>
                </div>

                <form action="{{ route('admin.users.list') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari kelompok tani..." 
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-blue-600 focus:border-blue-600 transition-all">
                    </div>

                    {{-- Dropdown Filter --}}
                    @php
                        $currentStatus = request('status', 'all');
                        $statuses = [
                            'all'      => 'Semua Status',
                            'menunggu' => 'Menunggu Verifikasi',
                            'reviewed' => 'Sedang Ditinjau',
                            'approved' => 'Disetujui',
                            'revisi'   => 'Revisi',
                            'pengajuan_revisi' => 'Ubah Data',
                            'rejected' => 'Ditolak',
                        ];
                    @endphp
                    <select name="status" onchange="this.form.submit()"
                            class="w-full sm:w-48 py-2.5 px-4 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-blue-600 focus:border-blue-600 cursor-pointer transition-all">
                        @foreach($statuses as $val => $label)
                            <option value="{{ $val }}" {{ $currentStatus === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="hidden"></button>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Informasi Kelompok</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Kontak & Lokasi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-lg shrink-0">
                                        {{ substr($user->farmerProfile->nama_kelompok, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $user->farmerProfile->nama_kelompok }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">Ketua: <span class="font-medium text-gray-700">{{ $user->farmerProfile->ketua }}</span></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-gray-700 font-medium">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $user->farmerProfile->kontak }}
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="truncate max-w-[200px]">{{ $user->farmerProfile->alamat }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusConfig = [
                                        'menunggu' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'label' => 'Menunggu'],
                                        'reviewed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'label' => 'Ditinjau'],
                                        'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200', 'label' => 'Disetujui'],
                                        'revisi'   => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'border' => 'border-orange-200', 'label' => 'Revisi'],
                                        'pengajuan_revisi' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'border' => 'border-purple-200', 'label' => 'Ubah Data'],
                                        'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'label' => 'Ditolak'],
                                    ];
                                    $conf = $statusConfig[$user->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'label' => 'Unknown'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $conf['bg'] }} {{ $conf['text'] }} {{ $conf['border'] }}">
                                    {{ $conf['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="inline-flex items-center justify-center bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-blue-600 px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">Belum Ada Pengguna</h3>
                                <p class="text-sm text-gray-500 mt-1">Belum ada kelompok tani yang terdaftar di dalam sistem.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($users, 'links') && $users->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

