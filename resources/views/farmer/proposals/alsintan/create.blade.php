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
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 sm:p-10" x-data="{ showConfirm: false, agreed: false }">
                    <h3 class="text-2xl font-black text-gray-900 mb-8">Formulir Pengajuan</h3>

                    <form id="proposalForm" x-ref="proposalForm" action="{{ route('farmer.proposals.alsintan.store', $alsintan->id) }}" method="POST" enctype="multipart/form-data" @submit.prevent="showConfirm = true">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="file_proposal" class="block text-sm font-bold text-gray-700 mb-2">
                                    Dokumen Proposal (PDF/Word) <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="file_proposal" id="file_proposal" accept=".pdf,.doc,.docx" required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3 text-gray-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#19A148]/10 file:text-[#19A148] hover:file:bg-[#19A148]/20 @error('file_proposal') border-red-400 bg-red-50 @enderror">
                                <p class="mt-2 text-[11px] text-gray-500 font-medium">Upload file proposal resmi Anda. Maksimal 5MB.</p>
                                @error('file_proposal')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="no_surat_pengajuan" class="block text-sm font-bold text-gray-700 mb-2">
                                    No. Surat Pengajuan Proposal <span class="text-gray-400 font-normal">(Opsional)</span>
                                </label>
                                <input type="text" name="no_surat_pengajuan" id="no_surat_pengajuan" value="{{ old('no_surat_pengajuan') }}"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all text-sm @error('no_surat_pengajuan') border-red-400 bg-red-50 @enderror"
                                    placeholder="Contoh: 123/SP/2026">
                                <p class="mt-2 text-[11px] text-gray-500 font-medium">Nomor surat yang tertera pada dokumen proposal Anda.</p>
                                @error('no_surat_pengajuan')
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
                    <template x-teleport="body">
                        <div x-show="showConfirm" x-cloak class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                {{-- Backdrop --}}
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
                                     x-show="showConfirm" x-transition.opacity @click="showConfirm = false"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100"
                                     x-show="showConfirm" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
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
                                        <button type="button" @click="document.getElementById('proposalForm').submit()"
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
