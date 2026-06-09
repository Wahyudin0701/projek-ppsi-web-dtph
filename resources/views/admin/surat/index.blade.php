<x-app-layout>
    <x-slot:title>Kelola Surat</x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Surat</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar semua dokumen surat (Surat Tugas, Surat Perjanjian, dll) yang dibuat oleh sistem.</p>
        </div>
    </div>

    <!-- Area Filter/Pencarian -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <form method="GET" action="{{ route('admin.surat.index') }}" class="flex flex-wrap gap-3 items-end" x-data x-ref="filterForm">
            <div class="relative flex-1 min-w-[200px] flex flex-col">
                <label class="text-xs font-bold text-gray-700 mb-1.5 ml-1">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari jenis surat, nomor, atau kelompok..."
                        x-on:search="$refs.filterForm.submit()"
                        class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all">
                </div>
            </div>

            <div class="flex flex-col">
                <label class="text-xs font-bold text-gray-700 mb-1.5 ml-1">Jenis Surat</label>
                <select name="jenis_surat" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all appearance-none bg-white pr-8"
                    style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                    <option value="">Semua Jenis Surat</option>
                    <option value="Surat Tugas Verifikasi" {{ request('jenis_surat') === 'Surat Tugas Verifikasi' ? 'selected' : '' }}>Surat Tugas Verifikasi</option>
                    <option value="Form CPCL (Kosong)" {{ request('jenis_surat') === 'Form CPCL (Kosong)' ? 'selected' : '' }}>Form CPCL (Kosong)</option>
                    <option value="Hasil CPCL" {{ request('jenis_surat') === 'Hasil CPCL' ? 'selected' : '' }}>Hasil CPCL</option>
                    <option value="Surat Perjanjian Pinjam Pakai" {{ request('jenis_surat') === 'Surat Perjanjian Pinjam Pakai' ? 'selected' : '' }}>Surat Perjanjian Pinjam Pakai</option>
                    <option value="Surat Keputusan Bantuan" {{ request('jenis_surat') === 'Surat Keputusan Bantuan' ? 'selected' : '' }}>Surat Keputusan Bantuan</option>
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-xs font-bold text-gray-700 mb-1.5 ml-1">Mulai Tgl</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all bg-white">
            </div>

            <div class="flex flex-col min-w-[150px]">
                <div class="flex justify-between items-center mb-1.5 min-h-[16px]">
                    <span class="text-xs font-bold text-gray-700 ml-1">Sampai Tgl</span>
                    @if(request()->anyFilled(['search', 'jenis_surat', 'start_date', 'end_date']))
                        <a href="{{ route('admin.surat.index') }}" class="text-xs font-bold text-green-600 hover:text-green-800 transition-colors">Reset Filter</a>
                    @endif
                </div>
                <input type="date" name="end_date" value="{{ request('end_date') }}" x-on:change="$refs.filterForm.submit()" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all bg-white">
            </div>
        </form>
    </div>

    <!-- Tabel Surat -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Jenis & Nomor Surat</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Kelompok Tani</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Terkait Program</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Tanggal Diterbitkan</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($letters as $letter)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-900">{{ $letter['jenis'] }}</div>
                                <div class="text-sm text-gray-500 mt-0.5">{{ $letter['nomor'] }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-900">{{ $letter['kelompok'] }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                    {{ $letter['perihal'] }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($letter['tanggal'])->translatedFormat('d F Y') }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ $letter['url'] }}" {{ $letter['jenis'] === 'Hasil CPCL' ? '' : 'target="_blank"' }} class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition-colors" title="{{ $letter['jenis'] === 'Hasil CPCL' ? 'Lihat / Proses' : 'Lihat / Cetak PDF' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Surat</h3>
                                <p class="text-gray-500">Belum ada dokumen surat yang ter-generate dari sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($letters->hasPages())
            <div class="p-6 border-t border-gray-100 bg-gray-50">
                {{ $letters->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
