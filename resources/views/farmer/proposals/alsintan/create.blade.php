<x-app-layout>
    <x-slot name="header">Katalog Alsintan - Ajukan Peminjaman</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Form Peminjaman Alat</h2>
                <p class="text-gray-500 text-sm mt-1">Lengkapi data untuk mengajukan peminjaman alat {{ $alsintan->name }}.</p>
            </div>
            <a href="{{ route('farmer.proposals.alsintan') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            {{-- Left Column: Summaries --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Alat Detail Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden relative">
                    <div class="w-full aspect-video bg-gray-50 relative flex items-center justify-center">
                        @if($alsintan->image)
                            <img src="{{ Storage::url($alsintan->image) }}" alt="{{ $alsintan->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="inline-block rounded-xl bg-white/95 backdrop-blur-sm px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-widest text-[#19A148] shadow-sm">Alsintan</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-black text-gray-900 mb-5">{{ $alsintan->name }}</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-3">
                                <span class="text-gray-500 font-medium">Merk</span>
                                <span class="font-bold text-gray-800">{{ $alsintan->merk ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-3">
                                <span class="text-gray-500 font-medium">Kapasitas</span>
                                <span class="font-bold text-gray-800">{{ $alsintan->capacity ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 font-medium">Stok Tersedia</span>
                                <span class="font-black text-[#19A148]">{{ $alsintan->available_stock }} Unit</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Profile Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#19A148]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Pemohon Terdaftar
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Nama Kelompok Tani</p>
                            <p class="font-bold text-gray-800 text-sm">{{ auth()->user()->farmerProfile->nama_kelompok ?? '-' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Ketua</p>
                                <p class="font-bold text-gray-800 text-sm">{{ auth()->user()->farmerProfile->ketua ?? auth()->user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Telepon</p>
                                <p class="font-bold text-gray-800 text-sm">{{ auth()->user()->farmerProfile->kontak ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Alamat Kelompok</p>
                            <p class="text-sm font-medium text-gray-700 leading-relaxed">{{ auth()->user()->farmerProfile->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column: Form --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 sm:p-10" x-data="{ showConfirm: false, agreed: false, durasi: '{{ old('rencana_durasi_hari', '') }}' }">
                    <h3 class="text-2xl font-black text-gray-900 mb-8">Formulir Pengajuan</h3>

                    <form id="proposalForm" x-ref="proposalForm" action="{{ route('farmer.proposals.alsintan.store', $alsintan->id) }}" method="POST" @submit.prevent="showConfirm = true">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="lokasi_lahan" class="block text-sm font-bold text-gray-700 mb-2">
                                    Lokasi Lahan / Penggunaan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="lokasi_lahan" id="lokasi_lahan" rows="4" required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all text-sm resize-none @error('lokasi_lahan') border-red-400 bg-red-50 @enderror"
                                    placeholder="Tuliskan alamat lengkap atau koordinat lokasi lahan tempat alat ini akan digunakan...">{{ old('lokasi_lahan') }}</textarea>
                                @error('lokasi_lahan')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="rencana_durasi_hari" class="block text-sm font-bold text-gray-700 mb-2">
                                    Rencana Durasi Pemakaian (Hari) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative max-w-sm">
                                    <input type="number" name="rencana_durasi_hari" id="rencana_durasi_hari" min="1" max="365" required x-model="durasi"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-5 pr-16 py-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all text-sm @error('rencana_durasi_hari') border-red-400 bg-red-50 @enderror"
                                        placeholder="Misal: 7">
                                    <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">
                                        <span class="text-sm font-bold text-gray-400">Hari</span>
                                    </div>
                                </div>
                                @error('rencana_durasi_hari')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-10 p-5 bg-[#19A148]/5 rounded-2xl border border-[#19A148]/10 flex items-start gap-4">
                            <svg class="w-6 h-6 text-[#19A148] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <div>
                                <h4 class="font-bold text-[#19A148] text-sm mb-1.5">Pernyataan Komitmen</h4>
                                <p class="text-sm text-[#19A148]/80 leading-relaxed">
                                    Dengan mengajukan proposal ini, Anda menyatakan permohonan sah atas nama kelompok tani terdaftar dan <strong class="text-[#19A148]">tidak dipungut biaya apapun (GRATIS)</strong>.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-start gap-3">
                            <div class="flex items-center h-5 mt-1">
                                <input id="agreement" type="checkbox" x-model="agreed" required
                                    class="w-5 h-5 text-[#19A148] border-gray-300 rounded focus:ring-[#19A148] cursor-pointer">
                            </div>
                            <label for="agreement" class="text-sm text-gray-600 leading-relaxed cursor-pointer select-none">
                                Saya bertanggung jawab penuh atas kebenaran data dan berkomitmen menjaga serta menggunakan alat bantuan sesuai ketentuan yang berlaku.
                            </label>
                        </div>

                        <div class="mt-10 flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('farmer.proposals.alsintan') }}" class="px-6 py-3.5 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                                Batal
                            </a>
                            <button type="submit" :disabled="!agreed" :class="agreed ? 'bg-[#19A148] text-white hover:bg-green-700 hover:shadow-xl hover:shadow-green-900/20 hover:-translate-y-1' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                                class="px-8 py-3.5 font-bold rounded-2xl transition-all duration-300">
                                Kirim Proposal
                            </button>
                        </div>
                    </form>

                    {{-- Confirmation Modal --}}
                    <template x-if="showConfirm">
                        <div class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                {{-- Backdrop --}}
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="showConfirm = false"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                                    <div class="bg-white p-8 sm:p-10">
                                        <div class="flex items-center gap-5 mb-8">
                                            <div class="w-14 h-14 bg-[#19A148]/10 rounded-2xl flex items-center justify-center shrink-0">
                                                <svg class="w-7 h-7 text-[#19A148]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-black text-gray-900">Konfirmasi Pengajuan</h3>
                                                <p class="text-sm text-gray-500 mt-1">Apakah Anda yakin data sudah benar?</p>
                                            </div>
                                        </div>
                                        <div class="space-y-4">
                                            <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-between">
                                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Alat Dipinjam</span>
                                                <span class="font-bold text-gray-900">{{ $alsintan->name }}</span>
                                            </div>
                                            <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-between">
                                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Durasi</span>
                                                <span class="font-bold text-[#19A148] text-lg"><span x-text="durasi || '-'"></span> Hari</span>
                                            </div>
                                            <p class="text-sm text-gray-500 leading-relaxed text-center mt-6">
                                                Setelah dikirim, proposal Anda akan masuk ke tahap verifikasi oleh Admin DTPH.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-8 py-6 sm:px-10 flex flex-col-reverse sm:flex-row gap-3 sm:justify-end">
                                        <button type="button" @click="showConfirm = false"
                                            class="w-full sm:w-auto px-8 py-3.5 bg-white text-gray-600 font-bold rounded-2xl border border-gray-200 hover:bg-gray-100 transition-colors">
                                            Periksa Kembali
                                        </button>
                                        <button type="button" @click="$refs.proposalForm.submit()"
                                            class="w-full sm:w-auto px-8 py-3.5 bg-[#19A148] text-white font-bold rounded-2xl hover:bg-green-700 hover:shadow-lg hover:shadow-green-900/20 hover:-translate-y-0.5 transition-all">
                                            Ya, Kirim Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
