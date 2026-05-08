<x-app-layout>
    <x-slot name="header">Daftar Semua Kelompok Tani</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                {{-- Header List & Professional Filters (Referensi Katalog Alsintan) --}}
                <div class="px-8 pt-10 pb-8 bg-white border-b border-gray-50">
                    <div class="mb-10">
                        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Data Seluruh Pengguna</h3>
                        <div class="w-12 h-1.5 bg-[#19A148] mt-4 rounded-full"></div>
                        <p class="text-sm text-gray-500 font-medium mt-6 leading-relaxed max-w-2xl">
                            Kelola dan pantau seluruh basis data kelompok tani binaan DTPH Muaro Jambi. Gunakan fitur pencarian dan filter untuk menemukan data spesifik.
                        </p>
                    </div>

                    <form action="{{ route('admin.users.list') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4 max-w-4xl">
                        {{-- Search Input (Style referensi Katalog) --}}
                        <div class="flex-1 w-full group relative">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Cari Kelompok Tani</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Ketik nama kelompok tani..." 
                                    class="w-full pl-5 pr-12 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-bold focus:ring-[#19A148] focus:border-[#19A148] focus:bg-white transition-all shadow-sm group-hover:shadow-md">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Dropdown Filter (Style referensi Katalog) --}}
                        <div class="w-full md:w-72 group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Filter Status Akun</label>
                            @php
                                $currentStatus = request('status', 'all');
                                $statuses = [
                                    'all'      => 'Semua Pengguna',
                                    'menunggu' => 'Menunggu Verifikasi',
                                    'reviewed' => 'Sudah Dilihat',
                                    'approved' => 'Aktif / Disetujui',
                                    'rejected' => 'Ditolak / Blokir',
                                ];
                            @endphp
                            <div class="relative">
                                <select name="status" onchange="this.form.submit()"
                                        class="w-full pl-5 pr-12 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-bold focus:ring-[#19A148] focus:border-[#19A148] focus:bg-white appearance-none !bg-none shadow-sm cursor-pointer transition-all hover:border-gray-200">
                                    @foreach($statuses as $val => $label)
                                        <option value="{{ $val }}" {{ $currentStatus === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Hidden Search submit button (optional since enter works, but good for accessibility) --}}
                        <button type="submit" class="hidden"></button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white">
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50">Informasi Kelompok</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50">Kontak & Lokasi</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50 text-center">Status Akun</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-[#19A148] font-black text-lg shadow-sm group-hover:scale-110 transition-transform">
                                            {{ substr($user->farmerProfile->nama_kelompok, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900 text-sm leading-tight mb-1">{{ $user->farmerProfile->nama_kelompok }}</div>
                                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Ketua: {{ $user->farmerProfile->ketua }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2 text-xs font-bold text-gray-600">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $user->farmerProfile->kontak }}
                                        </div>
                                        <div class="flex items-center gap-2 text-[11px] font-medium text-gray-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="truncate max-w-[150px]">{{ $user->farmerProfile->alamat }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusConfig = [
                                            'menunggu' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'label' => 'Menunggu'],
                                            'reviewed' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'label' => 'Dilihat'],
                                            'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'label' => 'Aktif'],
                                            'rejected' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'label' => 'Ditolak'],
                                        ];
                                        $conf = $statusConfig[$user->farmerProfile->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-500', 'label' => 'Unknown'];
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $conf['bg'] }} {{ $conf['text'] }}">
                                        {{ $conf['label'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="inline-flex items-center justify-center bg-slate-100 text-slate-600 hover:bg-[#19A148] hover:text-white px-4 py-2 rounded-xl text-[11px] font-black transition-all shadow-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <p class="text-gray-400 font-bold">Belum ada user yang terdaftar.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</x-app-layout>
