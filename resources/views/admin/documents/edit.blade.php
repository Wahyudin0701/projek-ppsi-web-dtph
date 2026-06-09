<x-app-layout>
    <x-slot:title>Edit Dokumen</x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Edit Dokumen</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi atau file dokumen yang sudah ada.</p>
        </div>
        <a href="{{ route('admin.documents.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
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
        <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Left Column: Info Dokumen --}}
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Dokumen <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $document->title) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm">
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="category" id="category" value="{{ old('category', $document->category) }}" required list="category-list"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm">
                        <datalist id="category-list">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}"></option>
                            @endforeach
                            <option value="Peraturan Perundang-undangan"></option>
                            <option value="Petunjuk Teknis Bantuan & Pengelolaan"></option>
                            <option value="Standar Pelayanan Publik"></option>
                        </datalist>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Keterangan Singkat</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm">{{ old('description', $document->description) }}</textarea>
                    </div>

                </div>

                {{-- Right Column: Upload & Settings --}}
                <div class="space-y-6">
                    <div class="p-5 bg-blue-50 border border-blue-100 rounded-xl mb-4">
                        <h3 class="text-sm font-bold text-blue-900 mb-2">File Saat Ini</h3>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-lg {{ $document->file_format === 'PDF' ? 'text-red-500' : 'text-blue-500' }}">{{ $document->file_format }}</span>
                            <div class="text-sm">
                                <p class="text-blue-800 font-medium">Ukuran: {{ $document->file_size }}</p>
                                <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline mt-1 inline-block">Lihat / Unduh File</a>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ganti File (Opsional)</label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 hover:border-primary-300 transition-all group relative">
                            <div class="space-y-2 text-center relative z-10">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-primary-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="file" class="relative cursor-pointer bg-white rounded-md font-bold text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>Pilih File</span>
                                        <input id="file" name="file" type="file" class="sr-only" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOCX, XLSX, ZIP hingga 20MB. Biarkan kosong jika tidak ingin mengganti file.</p>
                                <p id="file-name-display" class="text-sm font-bold text-primary-700 mt-2 hidden"></p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-gray-50 border border-gray-100 rounded-xl">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">Pengaturan Visibilitas</h3>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_public" name="is_public" type="checkbox" value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }} class="focus:ring-primary-500 h-5 w-5 text-primary-600 border-gray-300 rounded cursor-pointer">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_public" class="font-bold text-gray-700 cursor-pointer">Tampilkan untuk Publik</label>
                                <p class="text-gray-500 mt-1">Jika dicentang, dokumen ini akan muncul di halaman Unduh Dokumen publik. Hilangkan centang jika dokumen ini masih draft atau rahasia.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
                <button type="button" onclick="window.history.back()" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">Batal</button>
                <button type="submit" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-md hover:shadow-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const display = document.getElementById('file-name-display');
            if (fileName) {
                display.textContent = 'File baru terpilih: ' + fileName;
                display.classList.remove('hidden');
            } else {
                display.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
