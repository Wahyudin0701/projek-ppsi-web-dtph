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
        <form method="GET" action="{{ route('admin.surat.index') }}" class="flex gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Surat</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition-colors"
                    placeholder="Cari jenis surat, nomor, atau kelompok...">
            </div>
            <div>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 font-medium transition-colors shadow-sm">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>Cari
                </button>
                @if(request()->has('search') && request('search') != '')
                    <a href="{{ route('admin.surat.index') }}" class="ml-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium transition-colors">
                        Reset
                    </a>
                @endif
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
                                <a href="{{ $letter['url'] }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition-colors" title="Lihat / Cetak PDF">
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
