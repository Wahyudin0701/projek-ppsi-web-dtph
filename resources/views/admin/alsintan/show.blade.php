<x-app-layout>
    <x-slot name="header">Manajemen Alsintan</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Page Header --}}
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900">Detail Alsintan</h2>
                    <p class="text-gray-500 text-sm mt-1">Dinas Tanaman Pangan dan Hortikultura</p>
                </div>
                <a href="{{ route('admin.alsintan.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    {{-- Image Side --}}
                    <div class="bg-gray-50 p-6 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                        @if($alsintan->image)
                            <img src="{{ asset('storage/' . $alsintan->image) }}" alt="{{ $alsintan->name }}" class="w-full max-w-sm rounded-2xl object-cover shadow-sm">
                        @else
                            <div class="w-full aspect-square max-w-xs rounded-2xl bg-gray-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="mt-6 text-center w-full">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ID Asset</p>
                            <p class="font-mono text-lg font-bold text-gray-800">#AST-{{ str_pad($alsintan->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>

                    {{-- Details Side --}}
                    <div class="p-8 md:col-span-2 flex flex-col">
                        <div class="mb-6 flex justify-between items-start gap-4">
                            <div>
                                @php
                                    $catLabel = $alsintan->category ? $alsintan->category->name : '-';
                                @endphp
                                <span class="px-3 py-1 bg-[#19A148]/10 text-[#19A148] text-sm font-bold rounded-full">
                                    {{ $catLabel }}
                                </span>
                                <h3 class="text-3xl font-black text-gray-900 leading-tight mb-2">{{ $alsintan->name }}</h3>
                            </div>
                            <a href="{{ route('admin.alsintan.edit', $alsintan) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl font-bold text-sm transition-colors border border-amber-200 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Alat
                            </a>
                        </div>
                        <p class="text-gray-500 line-clamp-3 mb-6">{{ $alsintan->description ?: 'Tidak ada deskripsi tersedia untuk alat ini.' }}</p>

                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 mb-8">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Merk / Tipe</p>
                                <p class="font-bold text-gray-900">{{ $alsintan->merk ?: '-' }}</p>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <h4 class="text-sm font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Status Distribusi Inventaris</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div class="bg-white border border-gray-200 rounded-xl p-4 text-center shadow-sm">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Total Dimiliki</p>
                                    <p class="text-2xl font-black text-gray-800">{{ $alsintan->stock }}</p>
                                </div>
                                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 text-center shadow-sm">
                                    <p class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Tersedia</p>
                                    <p class="text-2xl font-black text-emerald-700">{{ $alsintan->available_stock }}</p>
                                </div>
                                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-center shadow-sm">
                                    <p class="text-[10px] font-bold text-amber-600 uppercase mb-1">Dipinjam</p>
                                    <p class="text-2xl font-black text-amber-700">{{ $alsintan->borrowed_count }}</p>
                                </div>
                                <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center shadow-sm">
                                    <p class="text-[10px] font-bold text-red-600 uppercase mb-1">Rusak</p>
                                    <p class="text-2xl font-black text-red-700">{{ $alsintan->broken_count }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- INVENTORY SECTION --}}
        <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
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

    </div>
</x-app-layout>

