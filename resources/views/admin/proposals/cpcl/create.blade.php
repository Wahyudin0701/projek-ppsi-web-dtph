<x-app-layout>
    <x-slot name="header">Input Hasil Verifikasi CPCL</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('admin.proposals.show', $proposal) }}" class="hover:text-primary-600 transition-colors">Detail Proposal</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="font-semibold text-gray-700">Input CPCL</span>
        </div>

        <div class="bg-primary-50 rounded-2xl border border-primary-200 p-6 flex gap-4">
            <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-black text-primary-900">Formulir Komprehensif CPCL</h3>
                <p class="text-sm text-primary-700 mt-1">Isi data berdasarkan temuan tim di lapangan. Jika field tidak relevan dengan jenis bantuan (misal: alsintan), isi dengan "N/A" atau 0.</p>
            </div>
        </div>

        <form action="{{ route('admin.proposals.cpcl.store', $proposal) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            @csrf
            
            <div class="p-8 space-y-8">
                
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h4 class="text-lg font-bold text-gray-900">A. Aspek Teknis & Lahan</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Status Kepemilikan Lahan *</label>
                        <select name="status_kepemilikan" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                            <option value="">-- Pilih Status --</option>
                            <option value="Milik Sendiri">Milik Sendiri</option>
                            <option value="Sewa">Sewa</option>
                            <option value="Bagi Hasil">Bagi Hasil</option>
                            <option value="N/A">N/A (Tidak Relevan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Luas Lahan (Hektar) *</label>
                        <input type="number" step="0.01" name="luas_lahan" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                        <p class="text-[10px] text-gray-400 mt-1">Isi 0 jika tidak relevan.</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Kondisi Lahan *</label>
                        <input type="text" name="kondisi_lahan" required placeholder="Contoh: Rata, Bebas Banjir / Terdapat saluran irigasi baik / N/A" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                    </div>
                </div>

                <div class="border-b border-gray-100 pb-4 mb-4 pt-4">
                    <h4 class="text-lg font-bold text-gray-900">B. Kesesuaian & Rekomendasi Lapangan</h4>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Kesesuaian Komoditas *</label>
                        <select name="kesesuaian_komoditas" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                            <option value="1">Sesuai (Layak)</option>
                            <option value="0">Tidak Sesuai</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Rekomendasi Tim Survei *</label>
                        <select name="rekomendasi_surveyor" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50">
                            <option value="Direkomendasikan Penuh">Direkomendasikan Penuh</option>
                            <option value="Direkomendasikan dengan Catatan">Direkomendasikan dengan Catatan</option>
                            <option value="Tidak Direkomendasikan">Tidak Direkomendasikan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Catatan Lapangan (Opsional)</label>
                        <textarea name="catatan" rows="4" placeholder="Temuan khusus di lapangan..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-gray-50 resize-none"></textarea>
                    </div>
                </div>

                <div class="border-b border-gray-100 pb-4 mb-4 pt-4">
                    <h4 class="text-lg font-bold text-gray-900">C. Dokumentasi</h4>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Foto Lahan / Bukti Survei</label>
                    <input type="file" name="foto_lahan" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors">
                    <p class="text-xs text-gray-400 mt-2">Format: JPG/PNG, Maksimal: 5MB.</p>
                </div>
                
            </div>

            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.proposals.show', $proposal) }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">Batal</a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm">
                    Simpan Hasil Survei
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

