<x-app-layout>
    <x-slot name="header">Input Hasil Verifikasi CPCL</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Input Hasil Verifikasi CPCL</h2>
                <p class="text-gray-500 text-sm mt-1">Isi formulir komprehensif berdasarkan temuan tim di lapangan.</p>
            </div>
            <a href="{{ route('kabid.proposals.show', $proposal) }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="bg-primary-50 rounded-2xl border border-primary-200 p-6 flex gap-4">
            <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-black text-primary-900">Formulir Komprehensif CPCL</h3>
                <p class="text-sm text-primary-700 mt-1">Isi data berdasarkan temuan tim di lapangan. Beri tanda strip (-) atau angka 0 jika data tidak relevan. <br><span class="text-xs text-primary-600 font-medium">* Tanda bintang merah menandakan kolom wajib diisi.</span></p>
            </div>
        </div>

        <form action="{{ route('kabid.proposals.cpcl.store', $proposal) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            @csrf
            
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
                                <td class="px-4 py-3 text-gray-900 font-medium">{{ $item['label'] }} <span class="text-red-500">*</span></td>
                                <td class="px-4 py-3 text-center">
                                    <input type="radio" name="{{ $item['input_name'] }}" value="1" required class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="radio" name="{{ $item['input_name'] }}" value="0" required class="w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="ket_{{ $item['field'] }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" placeholder="Opsional">
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

                <div class="overflow-x-auto border border-gray-100 rounded-xl mb-8">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 w-1/3">Uraian Teknis & Lahan</th>
                                <th class="px-4 py-3">Keterangan / Isian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-4 py-4 text-gray-900 font-medium align-middle">Status Kepemilikan Lahan <span class="text-red-500">*</span></td>
                                <td class="px-4 py-4">
                                    <select name="status_kepemilikan" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Milik Sendiri">Milik Sendiri</option>
                                        <option value="Sewa">Sewa</option>
                                        <option value="Bagi Hasil">Bagi Hasil</option>
                                        <option value="-">- (Tidak Relevan)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 text-gray-900 font-medium align-middle">Luas Lahan (Hektar) <span class="text-red-500">*</span></td>
                                <td class="px-4 py-4">
                                    <input type="number" step="0.01" name="luas_lahan" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" placeholder="Contoh: 1.5">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 text-gray-900 font-medium align-middle">Jenis Tanah <span class="text-red-500">*</span></td>
                                <td class="px-4 py-4">
                                    <input type="text" name="jenis_tanah" required placeholder="Contoh: Gambut / Mineral / -" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 text-gray-900 font-medium align-middle">Sumber Air Budidaya <span class="text-red-500">*</span></td>
                                <td class="px-4 py-4">
                                    <input type="text" name="sumber_air" required placeholder="Contoh: Sungai / Sumur Bor / Tadah Hujan / -" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 text-gray-900 font-medium align-middle">Kondisi Lahan <span class="text-red-500">*</span></td>
                                <td class="px-4 py-4">
                                    <input type="text" name="kondisi_lahan" required placeholder="Contoh: Rata, Bebas Banjir / Terdapat saluran irigasi baik / -" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 text-gray-900 font-medium align-middle">Rawan Bencana <span class="text-red-500">*</span></td>
                                <td class="px-4 py-4">
                                    <input type="text" name="rawan_bencana" required placeholder="Contoh: Banjir / Karhutla / Aman / -" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 text-gray-900 font-medium align-middle">Pemanfaatan Lahan Sebelumnya <span class="text-red-500">*</span></td>
                                <td class="px-4 py-4">
                                    <input type="text" name="pemanfaatan_lahan_sebelumnya" required placeholder="Contoh: Belukar / Kebun Sawit / -" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 text-gray-900 font-medium align-middle">Pengalaman Budidaya <span class="text-red-500">*</span></td>
                                <td class="px-4 py-4">
                                    <input type="text" name="pengalaman_budidaya" required placeholder="Contoh: 5 Tahun bertani padi / -" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="border-b border-gray-100 pb-4 mb-4 pt-4">
                    <h4 class="text-lg font-bold text-gray-900">C. Kesesuaian & Rekomendasi Lapangan</h4>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Kesesuaian Komoditas <span class="text-red-500">*</span></label>
                        <select name="kesesuaian_komoditas" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                            <option value="1">Sesuai (Layak)</option>
                            <option value="0">Tidak Sesuai</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Rekomendasi Tim Survei <span class="text-red-500">*</span></label>
                        <select name="rekomendasi_surveyor" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                            <option value="Direkomendasikan Penuh">Direkomendasikan Penuh</option>
                            <option value="Direkomendasikan dengan Catatan">Direkomendasikan dengan Catatan</option>
                            <option value="Tidak Direkomendasikan">Tidak Direkomendasikan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Informasi Lainnya (Opsional)</label>
                        <textarea name="catatan" rows="4" placeholder="Temuan khusus di lapangan..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50 resize-none"></textarea>
                    </div>
                </div>

                <div class="border-b border-gray-100 pb-4 mb-4 pt-4">
                    <h4 class="text-lg font-bold text-gray-900">D. Dokumentasi Lapangan</h4>
                </div>
                

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Foto Hasil Pemetaan Data <span class="text-red-500">*</span></label>
                        <input type="file" name="foto_pemetaan_data" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors">
                        <p class="text-[10px] text-gray-400 mt-2">Format: JPG/PNG, Maksimal: 5MB.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Foto Lahan / Bukti Survei <span class="text-red-500">*</span></label>
                        <input type="file" name="foto_lahan" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors">
                        <p class="text-[10px] text-gray-400 mt-2">Format: JPG/PNG, Maksimal: 5MB.</p>
                    </div>
                    
                    <div class="sm:col-span-2 mt-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Upload Dokumen Fisik CPCL (Sudah Di-TTD) <span class="text-red-500">*</span></label>
                        <input type="file" name="dokumen_fisik" required accept=".pdf,image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors">
                        <p class="text-[10px] text-gray-400 mt-2">Format: PDF/JPG/PNG, Maksimal: 5MB. Unggah scan/foto dari form Berita Acara CPCL yang telah ditandatangani basah oleh Petugas, PPL, dan Pengurus Poktan.</p>
                    </div>
                </div>


                
            </div>

            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('kabid.proposals.show', $proposal) }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">Batal</a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm">
                    Simpan Hasil Survei
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

