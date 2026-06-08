<x-app-layout>
    <x-slot name="header">Laporan & Rekapitulasi</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="mb-2 border-b border-gray-200">
            <nav class="-mb-px flex gap-8">
                <a href="{{ route('pimpinan.reports') }}" class="{{ request()->routeIs('pimpinan.reports') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-bold text-sm transition-colors">
                    Laporan Proposal
                </a>
                <a href="{{ route('pimpinan.reports.users') }}" class="{{ request()->routeIs('pimpinan.reports.users') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-bold text-sm transition-colors">
                    Laporan Pengguna Terdaftar
                </a>
            </nav>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-extrabold text-gray-800">Filter Laporan</h2>
                    <p class="text-sm text-gray-500">Sesuaikan kriteria data yang ingin Anda lihat dan cetak.</p>
                </div>
                <div>
                    <button onclick="window.open('{{ route('pimpinan.reports.print', request()->query()) }}', '_blank')" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm w-full md:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh Laporan
                    </button>
                </div>
            </div>

            <form action="{{ route('pimpinan.reports') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Pengajuan</label>
                    <select name="type" onchange="this.form.submit()" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Jenis</option>
                        <option value="alsintan" {{ request('type') == 'alsintan' ? 'selected' : '' }}>Alsintan</option>
                        <option value="program" {{ request('type') == 'program' ? 'selected' : '' }}>Program Bantuan</option>
                    </select>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-bold text-gray-700">Status</label>
                        @if(request()->anyFilled(['start_date', 'end_date', 'type', 'status']))
                            <a href="{{ route('pimpinan.reports') }}" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800">Reset Filter</a>
                        @endif
                    </div>
                    <select name="status" onchange="this.form.submit()" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Selesai (Dikembalikan)</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Keputusan</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-extrabold text-gray-800">Pratinjau Data</h3>
                <span class="text-xs font-medium text-gray-500">Menampilkan {{ $proposals->count() }} data pada halaman ini</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">No. Registrasi</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Pengaju</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Jenis & Objek</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Tgl. Pengajuan</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($proposals as $proposal)
                            @php $isAlsintan = $proposal->alsintan_id !== null; @endphp
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
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($proposal->status == 'disetujui')
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md">Disetujui</span>
                                    @elseif($proposal->status == 'ditolak')
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200 rounded-md">Ditolak</span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 rounded-md">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-medium">
                                    Tidak ada data proposal yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($proposals->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $proposals->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
