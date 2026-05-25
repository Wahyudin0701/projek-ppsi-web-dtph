<x-app-layout>
    <x-slot name="header">Edit Hasil Verifikasi CPCL</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Edit Hasil Verifikasi CPCL</h2>
                <p class="text-gray-500 text-sm mt-1">Perbarui formulir komprehensif berdasarkan temuan tim di lapangan.</p>
            </div>
            <a href="{{ route('admin.proposals.show', $proposal) }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="bg-primary-50 rounded-2xl border border-primary-200 p-6 flex gap-4">
            <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-black text-primary-900">Edit Formulir Komprehensif CPCL</h3>
                <p class="text-sm text-primary-700 mt-1">Perbarui data berdasarkan perubahan temuan di lapangan. Kosongkan unggahan foto jika tidak ingin mengubah foto sebelumnya.</p>
            </div>
        </div>

        <form action="{{ route('admin.proposals.cpcl.update', $proposal) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            @csrf
            @method('PATCH')
            
            <div class="p-8 space-y-8">
                
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- A. Verifikasi Administrasi -->
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h4 class="text-lg font-bold text-gray-900">A. Hasil Verifikasi Administrasi</h4>
                    <p class="text-sm text-gray-500 mt-1">Sesuaikan dengan form Berita Acara Verifikasi CPCL</p>
                </div>

                @php
                    $checklist = [
                        ['field' => 'surat_permohonan', 'label' => '1. Surat Permohonan', 'input_name' => 'is_surat_permohonan_sesuai'],
                        ['field' => 'ktp', 'label' => '2. Fotocopy KTP Ketua Kelompok dan Seluruh Anggota', 'input_name' => 'is_ktp_sesuai'],
                        ['field' => 'sk_desa', 'label' => '3. Fotocopy SK Kelompok Tani yang ditandatangani Kepala Desa', 'input_name' => 'is_sk_desa_sesuai'],
                        ['field' => 'simluhtan', 'label' => '4. Fotocopy atau Printout data Kelompok Tani di Sistem Informasi Penyuluh Pertanian (Simluhtan)', 'input_name' => 'is_simluhtan_sesuai'],
                        ['field' => 'notula_rapat', 'label' => '5. Fotocopy Notula dan Daftar Hadir Rapat Kelompok Tani terkait permohonan bantuan', 'input_name' => 'is_notula_rapat_sesuai'],
                        ['field' => 'titik_koordinat', 'label' => '6. Titik Koordinat lokasi usaha tani', 'input_name' => 'is_titik_koordinat_sesuai'],
                        ['field' => 'tidak_menerima_bantuan_sama', 'label' => '7. Tidak menerima bantuan yang sama dalam satu musim tanam', 'input_name' => 'is_tidak_menerima_bantuan_sama'],
                    ];
                @endphp

                <div class="overflow-x-auto border border-gray-100 rounded-xl mb-8">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Uraian</th>
                                <th class="px-4 py-3 text-center">Sesuai</th>
                                <th class="px-4 py-3 text-center">Tidak Sesuai</th>
                                <th class="px-4 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($checklist as $item)
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">{{ $item['label'] }}</td>
                                <td class="px-4 py-3 text-center">
                                    <input type="radio" name="{{ $item['input_name'] }}" value="1" {{ old($item['input_name'], $cpcl->{$item['input_name']}) == '1' ? 'checked' : '' }} required class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="radio" name="{{ $item['input_name'] }}" value="0" {{ old($item['input_name'], $cpcl->{$item['input_name']}) == '0' ? 'checked' : '' }} required class="w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="ket_{{ $item['field'] }}" value="{{ old('ket_' . $item['field'], $cpcl->{'ket_' . $item['field']}) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" placeholder="Opsional">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- B. Aspek Teknis & Lahan -->
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h4 class="text-lg font-bold text-gray-900">B. Aspek Teknis & Lahan</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Status Kepemilikan Lahan *</label>
                        <select name="status_kepemilikan" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                            <option value="">-- Pilih Status --</option>
                            <option value="Milik Sendiri" {{ old('status_kepemilikan', $cpcl->status_kepemilikan) == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                            <option value="Sewa" {{ old('status_kepemilikan', $cpcl->status_kepemilikan) == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                            <option value="Bagi Hasil" {{ old('status_kepemilikan', $cpcl->status_kepemilikan) == 'Bagi Hasil' ? 'selected' : '' }}>Bagi Hasil</option>
                            <option value="N/A" {{ old('status_kepemilikan', $cpcl->status_kepemilikan) == 'N/A' ? 'selected' : '' }}>N/A (Tidak Relevan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Luas Lahan (Hektar) *</label>
                        <input type="number" step="0.01" name="luas_lahan" value="{{ old('luas_lahan', $cpcl->luas_lahan) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                        <p class="text-[10px] text-gray-400 mt-1">Isi 0 jika tidak relevan.</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Kondisi Lahan *</label>
                        <input type="text" name="kondisi_lahan" value="{{ old('kondisi_lahan', $cpcl->kondisi_lahan) }}" required placeholder="Contoh: Rata, Bebas Banjir / Terdapat saluran irigasi baik / N/A" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                    </div>
                </div>

                <div class="border-b border-gray-100 pb-4 mb-4 pt-4">
                    <h4 class="text-lg font-bold text-gray-900">C. Kesesuaian & Rekomendasi Lapangan</h4>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Kesesuaian Komoditas *</label>
                        <select name="kesesuaian_komoditas" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                            <option value="1" {{ old('kesesuaian_komoditas', $cpcl->kesesuaian_komoditas) == '1' ? 'selected' : '' }}>Sesuai (Layak)</option>
                            <option value="0" {{ old('kesesuaian_komoditas', $cpcl->kesesuaian_komoditas) == '0' ? 'selected' : '' }}>Tidak Sesuai</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Rekomendasi Tim Survei *</label>
                        <select name="rekomendasi_surveyor" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                            <option value="Direkomendasikan Penuh" {{ old('rekomendasi_surveyor', $cpcl->rekomendasi_surveyor) == 'Direkomendasikan Penuh' ? 'selected' : '' }}>Direkomendasikan Penuh</option>
                            <option value="Direkomendasikan dengan Catatan" {{ old('rekomendasi_surveyor', $cpcl->rekomendasi_surveyor) == 'Direkomendasikan dengan Catatan' ? 'selected' : '' }}>Direkomendasikan dengan Catatan</option>
                            <option value="Tidak Direkomendasikan" {{ old('rekomendasi_surveyor', $cpcl->rekomendasi_surveyor) == 'Tidak Direkomendasikan' ? 'selected' : '' }}>Tidak Direkomendasikan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Catatan Lapangan (Opsional)</label>
                        <textarea name="catatan" rows="4" placeholder="Temuan khusus di lapangan..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50 resize-none">{{ old('catatan', $cpcl->catatan) }}</textarea>
                    </div>
                </div>

                <div class="border-b border-gray-100 pb-4 mb-4 pt-4">
                    <h4 class="text-lg font-bold text-gray-900">D. Dokumentasi</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Foto Hasil Pemetaan Data (Update Opsional)</label>
                        <input type="file" name="foto_pemetaan_data" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors">
                        <p class="text-[10px] text-gray-400 mt-2">Biarkan kosong jika tidak ingin mengubah foto sebelumnya.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Foto Lahan / Bukti Survei (Update Opsional)</label>
                        <input type="file" name="foto_lahan" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors">
                        <p class="text-[10px] text-gray-400 mt-2">Biarkan kosong jika tidak ingin mengubah foto sebelumnya.</p>
                    </div>
                </div>
                
            </div>

            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.proposals.show', $proposal) }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">Batal</a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
