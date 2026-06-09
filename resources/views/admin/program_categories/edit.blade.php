<x-app-layout>
    <x-slot name="header">Edit Jenis Program</x-slot>
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Edit Jenis Program</h2>
                <p class="text-gray-500 text-sm mt-1">Perbarui informasi jenis program bantuan.</p>
            </div>
            <a href="{{ route('admin.program-categories.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <form action="{{ route('admin.program-categories.update', $programCategory) }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    {{-- Nama Jenis --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Jenis Program <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $programCategory->name) }}" required
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                               placeholder="Contoh: Alsintan, Bantuan Benih, Pupuk, dll.">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                  placeholder="Deskripsi singkat mengenai jenis program ini...">{{ old('description', $programCategory->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                    <a href="{{ route('admin.program-categories.index') }}" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                        Perbarui Jenis Program
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
