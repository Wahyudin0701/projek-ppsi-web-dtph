<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.alsintan.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Alsintan') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl">
            <div class="p-6 text-gray-900">
                <form action="{{ route('admin.alsintan.update', $alsintan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Foto / Gambar Alsintan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        @if($alsintan->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $alsintan->image) }}" alt="Preview" class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full rounded-xl border border-gray-300 p-2 text-sm focus:border-primary-500 focus:ring-primary-500 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Alat/Mesin</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $alsintan->name) }}" required
                               class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                        <select name="category" id="category" required
                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <option value="" disabled {{ old('category', $alsintan->category) ? '' : 'selected' }}>Pilih Kategori</option>
                            <option value="traktor" {{ old('category', $alsintan->category) == 'traktor' ? 'selected' : '' }}>Traktor</option>
                            <option value="pompa" {{ old('category', $alsintan->category) == 'pompa' ? 'selected' : '' }}>Pompa Air</option>
                            <option value="pascapanen" {{ old('category', $alsintan->category) == 'pascapanen' ? 'selected' : '' }}>Pasca Panen</option>
                            <option value="tanam" {{ old('category', $alsintan->category) == 'tanam' ? 'selected' : '' }}>Alat Tanam</option>
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="merk" class="block text-sm font-bold text-gray-700 mb-2">Merk / Tipe <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk', $alsintan->merk) }}" placeholder="Contoh: Kubota L1-24"
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                        </div>
                        <div>
                            <label for="capacity" class="block text-sm font-bold text-gray-700 mb-2">Kapasitas <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="capacity" id="capacity" value="{{ old('capacity', $alsintan->capacity) }}" placeholder="Contoh: 24 HP"
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">Jumlah Stok</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $alsintan->stock) }}" min="0" required
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" required
                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                                <option value="tersedia" {{ old('status', $alsintan->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="tidak_tersedia" {{ old('status', $alsintan->status) === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                <option value="rusak" {{ old('status', $alsintan->status) === 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Spesifikasi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">{{ old('description', $alsintan->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('admin.alsintan.index') }}" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 rounded-xl transition-colors shadow-sm">
                            Perbarui Alsintan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
