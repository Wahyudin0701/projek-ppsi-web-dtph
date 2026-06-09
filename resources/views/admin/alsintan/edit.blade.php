<x-app-layout>
    <x-slot name="header">Manajemen Alsintan</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Edit Data Alat</h2>
                <p class="text-gray-500 text-sm mt-1">Perbarui detail spesifikasi atau status inventaris alat ini.</p>
            </div>
            <a href="{{ route('admin.alsintan.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="p-6 text-gray-900">
                <form action="{{ route('admin.alsintan.update', $alsintan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Alat/Mesin</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $alsintan->name) }}" required
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Foto / Gambar Alsintan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            @if($alsintan->image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $alsintan->image) }}" alt="Preview" class="w-16 h-16 object-cover rounded-xl border border-gray-200">
                                </div>
                            @endif
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="w-full rounded-xl border border-gray-300 p-2 text-sm focus:border-primary-500 focus:ring-primary-500 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="alsintan_category_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="alsintan_category_id" id="alsintan_category_id" required
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                <option value="" disabled {{ old('alsintan_category_id', $alsintan->alsintan_category_id) ? '' : 'selected' }}>Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('alsintan_category_id', $alsintan->alsintan_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('alsintan_category_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="merk" class="block text-sm font-bold text-gray-700 mb-2">Merk / Tipe <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk', $alsintan->merk) }}" placeholder="Contoh: Kubota L1-24"
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('merk')" class="mt-2" />
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
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                            Perbarui Alsintan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- INVENTORY SECTION --}}
    <div class="max-w-5xl mx-auto mt-8 bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Data Unit Inventaris Fisik</h3>
                <p class="text-sm text-gray-500">Kelola nomor rangka, mesin, dan status per unit alat.</p>
            </div>
            <button type="button" x-data @click="$dispatch('open-modal', 'add-inventory')" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Unit
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">No. Rangka / Mesin</th>
                        <th class="px-6 py-4">Sumber Dana / Tahun</th>
                        <th class="px-6 py-4">Lokasi (Lat, Long)</th>
                        <th class="px-6 py-4">Ketersediaan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($alsintan->inventories as $inv)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">{{ $inv->nomor_rangka ?: '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $inv->nomor_mesin ?: '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $inv->sumber_dana ?: '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $inv->tahun_pengadaan ?: '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($inv->latitude && $inv->longitude)
                                    <div class="text-sm text-gray-900">{{ $inv->latitude }},</div>
                                    <div class="text-xs text-gray-500">{{ $inv->longitude }}</div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum diset</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($inv->status_ketersediaan === 'Tersedia')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-xs font-bold text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tersedia
                                    </span>
                                @elseif($inv->status_ketersediaan === 'Dipinjam')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-xs font-bold text-blue-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Dipinjam
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-xs font-bold text-red-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Sedang Rusak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" x-data @click="$dispatch('open-modal', 'edit-inventory-{{ $inv->id }}')" class="text-blue-500 hover:text-blue-700 font-bold text-sm">Edit</button>
                                    <form action="{{ route('admin.alsintan.inventories.destroy', [$alsintan, $inv]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus unit inventaris ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                                    </form>
                                </div>

                                {{-- Edit Inventory Modal --}}
                                <x-modal name="edit-inventory-{{ $inv->id }}" focusable>
                                    <form method="post" action="{{ route('admin.alsintan.inventories.update', [$alsintan, $inv]) }}" class="p-6 text-left">
                                        @csrf
                                        @method('PUT')
                                        <h2 class="text-lg font-bold text-gray-900 mb-4">Edit Unit Inventaris Fisik</h2>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <x-input-label for="nomor_rangka_{{ $inv->id }}" value="Nomor Rangka" />
                                                <x-text-input id="nomor_rangka_{{ $inv->id }}" name="nomor_rangka" type="text" class="mt-1 block w-full" :value="old('nomor_rangka', $inv->nomor_rangka)" />
                                            </div>
                                            <div>
                                                <x-input-label for="nomor_mesin_{{ $inv->id }}" value="Nomor Mesin" />
                                                <x-text-input id="nomor_mesin_{{ $inv->id }}" name="nomor_mesin" type="text" class="mt-1 block w-full" :value="old('nomor_mesin', $inv->nomor_mesin)" />
                                            </div>
                                            <div>
                                                <x-input-label for="sumber_dana_{{ $inv->id }}" value="Sumber Dana" />
                                                <select id="sumber_dana_{{ $inv->id }}" name="sumber_dana" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                                    <option value="">Pilih Sumber</option>
                                                    <option value="APBD" {{ old('sumber_dana', $inv->sumber_dana) == 'APBD' ? 'selected' : '' }}>APBD</option>
                                                    <option value="APBN" {{ old('sumber_dana', $inv->sumber_dana) == 'APBN' ? 'selected' : '' }}>APBN</option>
                                                    <option value="Lainnya" {{ old('sumber_dana', $inv->sumber_dana) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                </select>
                                            </div>
                                            <div>
                                                <x-input-label for="tahun_pengadaan_{{ $inv->id }}" value="Tahun Pengadaan" />
                                                <x-text-input id="tahun_pengadaan_{{ $inv->id }}" name="tahun_pengadaan" type="number" class="mt-1 block w-full" :value="old('tahun_pengadaan', $inv->tahun_pengadaan)" />
                                            </div>
                                            <div class="md:col-span-2">
                                                <x-input-label for="status_ketersediaan_{{ $inv->id }}" value="Status Ketersediaan" />
                                                <select id="status_ketersediaan_{{ $inv->id }}" name="status_ketersediaan" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                                    <option value="Tersedia" {{ old('status_ketersediaan', $inv->status_ketersediaan) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                    <option value="Dipinjam" {{ old('status_ketersediaan', $inv->status_ketersediaan) == 'Dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                                    <option value="Sedang Rusak" {{ old('status_ketersediaan', $inv->status_ketersediaan) == 'Sedang Rusak' ? 'selected' : '' }}>Sedang Rusak</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-2 grid grid-cols-2 gap-4">
                                                <div>
                                                    <x-input-label for="latitude_{{ $inv->id }}" value="Latitude (Opsional)" />
                                                    <x-text-input id="latitude_{{ $inv->id }}" name="latitude" type="number" step="any" class="mt-1 block w-full" :value="old('latitude', $inv->latitude)" />
                                                </div>
                                                <div>
                                                    <x-input-label for="longitude_{{ $inv->id }}" value="Longitude (Opsional)" />
                                                    <x-text-input id="longitude_{{ $inv->id }}" name="longitude" type="number" step="any" class="mt-1 block w-full" :value="old('longitude', $inv->longitude)" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-6 flex justify-end gap-3">
                                            <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                                                Batal
                                            </button>
                                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                                                Perbarui Unit
                                            </button>
                                        </div>
                                    </form>
                                </x-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data unit inventaris fisik yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Inventory Modal --}}
    <x-modal name="add-inventory" :show="$errors->any()" focusable>
        <form method="post" action="{{ route('admin.alsintan.inventories.store', $alsintan) }}" class="p-6">
            @csrf
            <h2 class="text-lg font-bold text-gray-900 mb-4">Tambah Unit Inventaris Fisik</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="nomor_rangka" value="Nomor Rangka" />
                    <x-text-input id="nomor_rangka" name="nomor_rangka" type="text" class="mt-1 block w-full" :value="old('nomor_rangka')" />
                </div>
                <div>
                    <x-input-label for="nomor_mesin" value="Nomor Mesin" />
                    <x-text-input id="nomor_mesin" name="nomor_mesin" type="text" class="mt-1 block w-full" :value="old('nomor_mesin')" />
                </div>
                <div>
                    <x-input-label for="sumber_dana" value="Sumber Dana" />
                    <select id="sumber_dana" name="sumber_dana" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                        <option value="">Pilih Sumber</option>
                        <option value="APBD" {{ old('sumber_dana') == 'APBD' ? 'selected' : '' }}>APBD</option>
                        <option value="APBN" {{ old('sumber_dana') == 'APBN' ? 'selected' : '' }}>APBN</option>
                        <option value="Lainnya" {{ old('sumber_dana') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="tahun_pengadaan" value="Tahun Pengadaan" />
                    <x-text-input id="tahun_pengadaan" name="tahun_pengadaan" type="number" class="mt-1 block w-full" :value="old('tahun_pengadaan', date('Y'))" />
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="status_ketersediaan" value="Status Ketersediaan" />
                    <select id="status_ketersediaan" name="status_ketersediaan" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                        <option value="Tersedia" {{ old('status_ketersediaan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Dipinjam" {{ old('status_ketersediaan') == 'Dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                        <option value="Sedang Rusak" {{ old('status_ketersediaan') == 'Sedang Rusak' ? 'selected' : '' }}>Sedang Rusak</option>
                    </select>
                </div>
                <div class="md:col-span-2 grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="latitude" value="Latitude (Opsional)" />
                        <x-text-input id="latitude" name="latitude" type="number" step="any" class="mt-1 block w-full" :value="old('latitude')" />
                    </div>
                    <div>
                        <x-input-label for="longitude" value="Longitude (Opsional)" />
                        <x-text-input id="longitude" name="longitude" type="number" step="any" class="mt-1 block w-full" :value="old('longitude')" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                    Simpan Unit
                </button>
            </div>
        </form>
    </x-modal>

</x-app-layout>
