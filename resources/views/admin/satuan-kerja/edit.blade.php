<x-app-layout>
    <x-slot:title>Edit Satuan Kerja</x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Edit Satuan Kerja</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi BPP atau Unit Pelaksana Teknis.</p>
        </div>
        <a href="{{ route('admin.satuan-kerja.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
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
        <form action="{{ route('admin.satuan-kerja.update', $satuan_kerja->id) }}" method="POST" class="p-6 md:p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Left Column --}}
                <div class="space-y-6">
                    <div>
                        <label for="nama" class="block text-sm font-bold text-gray-700 mb-2">Nama BPP / Unit <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $satuan_kerja->nama) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm">
                    </div>

                    <div>
                        <label for="koordinator" class="block text-sm font-bold text-gray-700 mb-2">Nama Koordinator <span class="text-red-500">*</span></label>
                        <input type="text" name="koordinator" id="koordinator" value="{{ old('koordinator', $satuan_kerja->koordinator) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm">
                    </div>

                    <div>
                        <label for="hp" class="block text-sm font-bold text-gray-700 mb-2">No HP / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="hp" id="hp" value="{{ old('hp', $satuan_kerja->hp) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm">
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                    <div>
                        <label for="alamat" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm">{{ old('alamat', $satuan_kerja->alamat) }}</textarea>
                    </div>

                    <div>
                        <label for="maps" class="block text-sm font-bold text-gray-700 mb-2">Link Google Maps (Opsional)</label>
                        <input type="url" name="maps" id="maps" value="{{ old('maps', $satuan_kerja->maps) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm">
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
                <button type="button" onclick="window.history.back()" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">Batal</button>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
