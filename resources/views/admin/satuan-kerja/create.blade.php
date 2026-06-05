<x-app-layout>
    <x-slot:title>Tambah Satuan Kerja</x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Satuan Kerja</h1>
            <p class="text-sm text-gray-500 mt-1">Tambahkan BPP atau UPT baru ke dalam direktori.</p>
        </div>
        <a href="{{ route('admin.satuan-kerja.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.satuan-kerja.store') }}" method="POST" class="p-6 md:p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Left Column --}}
                <div class="space-y-6">
                    <div>
                        <label for="nama" class="block text-sm font-bold text-gray-700 mb-2">Nama BPP / Unit <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm"
                               placeholder="Contoh: BPP Kec. Sekernan">
                    </div>

                    <div>
                        <label for="koordinator" class="block text-sm font-bold text-gray-700 mb-2">Nama Koordinator <span class="text-red-500">*</span></label>
                        <input type="text" name="koordinator" id="koordinator" value="{{ old('koordinator') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm"
                               placeholder="Nama lengkap beserta gelar">
                    </div>

                    <div>
                        <label for="hp" class="block text-sm font-bold text-gray-700 mb-2">No HP / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="hp" id="hp" value="{{ old('hp') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm"
                               placeholder="Contoh: 0812-3456-7890">
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                    <div>
                        <label for="alamat" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm"
                                  placeholder="Detail alamat kantor...">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label for="maps" class="block text-sm font-bold text-gray-700 mb-2">Link Google Maps (Opsional)</label>
                        <input type="url" name="maps" id="maps" value="{{ old('maps') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm"
                               placeholder="https://www.google.com/maps/...">
                        <p class="text-xs text-gray-500 mt-2">Salin tautan lokasi dari Google Maps untuk memudahkan pencarian arah.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
                <button type="button" onclick="window.history.back()" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">Batal</button>
                <button type="submit" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-md hover:shadow-lg">Simpan Data</button>
            </div>
        </form>
    </div>
</x-app-layout>
