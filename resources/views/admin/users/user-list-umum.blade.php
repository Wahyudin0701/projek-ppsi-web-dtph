<x-app-layout>
    <x-slot name="header">Daftar User</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="mb-2 border-b border-gray-200">
            <nav class="-mb-px flex gap-8">
                <a href="{{ route('admin.users.kelompok-tani') }}" class="{{ request()->routeIs('admin.users.kelompok-tani') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-bold text-sm transition-colors">
                    Daftar Kelompok Tani
                </a>
                <a href="{{ route('admin.users.umum') }}" class="{{ request()->routeIs('admin.users.umum') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-bold text-sm transition-colors">
                    Daftar User Umum
                </a>
            </nav>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Header List & Filters --}}
            <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-gray-900">User Umum</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            {{ method_exists($users, 'total') ? $users->total() : $users->count() }} Total
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Kelola dan pantau seluruh data user umum binaan DTPH Muaro Jambi.</p>
                </div>

                <form action="{{ route('admin.users.umum') }}" method="GET" class="flex flex-col gap-3 w-full lg:w-auto">
                    <div class="flex flex-col sm:flex-row gap-3 items-end">
                        {{-- Search Input --}}
                        <div class="w-full sm:w-auto flex flex-col">
                            <label class="text-xs font-bold text-gray-500 mb-1">Cari User Umum</label>
                            <div class="relative w-full sm:w-56">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Nama atau NIK..." 
                                    class="w-full pl-9 pr-3 py-2 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-blue-600 focus:border-blue-600 transition-all">
                            </div>
                        </div>

                        <div class="w-full sm:w-auto flex flex-col">
                            <label class="text-xs font-bold text-gray-500 mb-1">Mulai Tgl</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()"
                                class="w-full sm:w-36 py-2 px-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-blue-600 focus:border-blue-600 transition-all">
                        </div>

                        <div class="w-full sm:w-auto flex flex-col">
                            <label class="text-xs font-bold text-gray-500 mb-1">Sampai Tgl</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()"
                                class="w-full sm:w-36 py-2 px-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-blue-600 focus:border-blue-600 transition-all">
                        </div>

                        {{-- Dropdown Filter --}}
                        <div class="w-full sm:w-auto flex flex-col min-w-[150px]">
                            <div class="flex justify-between items-center mb-1 min-h-[16px]">
                                <span class="text-xs font-bold text-gray-500">Status</span>
                                @if(request()->anyFilled(['search', 'start_date', 'end_date', 'status']) && (request('status') !== 'all' || request()->anyFilled(['search', 'start_date', 'end_date'])))
                                    <a href="{{ route('admin.users.umum') }}" class="text-[10px] font-bold text-blue-600 hover:text-blue-800">Reset Filter</a>
                                @endif
                            </div>
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
                                    class="w-full py-2 px-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-blue-600 focus:border-blue-600 cursor-pointer transition-all">
                                @foreach($statuses as $val => $label)
                                    <option value="{{ $val }}" {{ $currentStatus === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hidden"></button>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Informasi User</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Kontak</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Tanggal Registrasi</th>
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
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">NIK: <span class="font-medium text-gray-700">{{ $user->umumProfile->nik ?? '-' }}</span></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-gray-700 font-medium">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $user->umumProfile->no_wa ?? '-' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $user->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $user->created_at->format('H:i') }} WIB</div>
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
                                    $status = $user->status ?? 'menunggu';
                                    $conf = $statusConfig[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'label' => 'Unknown'];
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
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">Belum Ada Pengguna</h3>
                                <p class="text-sm text-gray-500 mt-1">Belum ada user umum yang terdaftar di dalam sistem.</p>
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

