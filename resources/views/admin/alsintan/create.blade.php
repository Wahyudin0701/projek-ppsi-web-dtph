<x-app-layout>
    <x-slot name="header">Manajemen Alsintan</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Tambah Alsintan Baru</h2>
                <p class="text-gray-500 text-sm mt-1">Masukkan detail spesifikasi alat dan mesin pertanian.</p>
            </div>
            <a href="{{ route('admin.alsintan.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="p-6 text-gray-900">
                <form action="{{ route('admin.alsintan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Alat/Mesin</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Foto / Gambar Alsintan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="w-full rounded-xl border border-gray-300 p-2 text-sm focus:border-primary-500 focus:ring-primary-500 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="alsintan_category_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="alsintan_category_id" id="alsintan_category_id" required
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                <option value="" disabled {{ old('alsintan_category_id') ? '' : 'selected' }}>Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('alsintan_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('alsintan_category_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="merk" class="block text-sm font-bold text-gray-700 mb-2">Merk / Tipe <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk') }}" placeholder="Contoh: Kubota L1-24"
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Spesifikasi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('admin.alsintan.index') }}" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                            Simpan Alsintan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

