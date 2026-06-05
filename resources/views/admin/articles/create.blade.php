<x-app-layout>
    <x-slot:title>Tambah Artikel Baru</x-slot:title>
    <x-slot:header>Tambah Artikel Baru</x-slot:header>

    {{-- Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        trix-editor {
            min-height: 300px;
            background: white;
            border-radius: 0.75rem;
            border-color: #d1d5db;
        }
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>

    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 transition-colors font-bold text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-gray-100 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-800 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                </div>

                <!-- Ringkasan -->
                <div>
                    <label for="summary" class="block text-sm font-bold text-gray-800 mb-2">Ringkasan (Maks 500 karakter) <span class="text-red-500">*</span></label>
                    <textarea name="summary" id="summary" rows="3" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">{{ old('summary') }}</textarea>
                </div>

                <!-- Konten / Trix Editor -->
                <div>
                    <label for="content" class="block text-sm font-bold text-gray-800 mb-2">Isi Konten <span class="text-red-500">*</span></label>
                    <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                    <trix-editor input="content"></trix-editor>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-sm font-bold text-gray-800 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                        <option value="berita" {{ old('category') == 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="program" {{ old('category') == 'program' ? 'selected' : '' }}>Program</option>
                        <option value="artikel" {{ old('category') == 'artikel' ? 'selected' : '' }}>Artikel Edukasi</option>
                        <option value="kegiatan" {{ old('category') == 'kegiatan' ? 'selected' : '' }}>Kegiatan Lapangan</option>
                    </select>
                </div>

                <!-- Nama Penulis -->
                <div>
                    <label for="author_name" class="block text-sm font-bold text-gray-800 mb-2">Nama Penulis / Tim <span class="text-red-500">*</span></label>
                    <input type="text" name="author_name" id="author_name" value="{{ old('author_name', auth()->user()->name) }}" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                </div>

                <!-- Foto Thumbnail -->
                <div>
                    <label for="image" class="block text-sm font-bold text-gray-800 mb-2">Foto / Thumbnail <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-xl">
                    <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG. Maks: 2MB.</p>
                </div>

                <!-- Publish Status -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#19A148]"></div>
                        </div>
                        <span class="text-sm font-bold text-gray-900">Langsung Publikasikan</span>
                    </label>
                    <p class="mt-2 text-xs text-gray-500">Jika dimatikan, artikel akan disimpan sebagai draft.</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-gray-100">
                    <button type="submit" class="w-full bg-[#19A148] text-white px-6 py-3.5 rounded-xl font-bold hover:bg-[#158039] transition-all shadow-lg shadow-[#19A148]/20 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Artikel
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
