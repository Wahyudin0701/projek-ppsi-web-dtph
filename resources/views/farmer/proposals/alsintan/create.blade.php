<x-app-layout>
    <x-slot name="header">Katalog Alsintan - Ajukan Peminjaman</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('farmer.proposals.pilih') }}" class="hover:text-primary-600 transition-colors">Ajukan Proposal</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('farmer.proposals.alsintan') }}" class="hover:text-primary-600 transition-colors">Peminjaman Alsintan</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-semibold text-gray-700">Form Pengajuan</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900">Form Peminjaman Alsintan</h2>
                <p class="text-gray-500 text-sm mt-1">Lengkapi data untuk mengajukan peminjaman alat {{ $alsintan->name }}.</p>
            </div>
            <a href="{{ route('farmer.proposals.alsintan') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        {{-- Alat Detail Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col sm:flex-row">
            <div class="w-full sm:w-44 h-44 sm:h-auto bg-gray-100 flex-shrink-0">
                @if($alsintan->image)
                    <img src="{{ Storage::url($alsintan->image) }}" alt="{{ $alsintan->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </div>
            <div class="p-6 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-widest text-primary-600 bg-primary-50 px-2.5 py-1 rounded-full">Peminjaman Alsintan</span>
                <h2 class="text-xl font-extrabold text-gray-900 mt-3 mb-3">{{ $alsintan->name }}</h2>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Merk</p>
                        <p class="font-bold text-gray-800">{{ $alsintan->merk ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Kapasitas</p>
                        <p class="font-bold text-gray-800">{{ $alsintan->capacity ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8" x-data="{ showConfirm: false, agreed: false }">
            <h3 class="text-lg font-extrabold text-gray-900 mb-6">Lengkapi Data Pengajuan</h3>

            <form id="proposalForm" x-ref="proposalForm" action="{{ route('farmer.proposals.alsintan.store', $alsintan->id) }}" method="POST" class="space-y-6" @submit.prevent="showConfirm = true">
                @csrf

                <div>
                    <label for="lokasi_lahan" class="block text-sm font-bold text-gray-700 mb-2">
                        Lokasi Lahan / Penggunaan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-3.5 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <textarea name="lokasi_lahan" id="lokasi_lahan" rows="4" required
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all sm:text-sm resize-none @error('lokasi_lahan') border-red-400 @enderror"
                            placeholder="Tuliskan alamat lengkap atau koordinat lokasi lahan yang akan menggunakan alat ini...">{{ old('lokasi_lahan') }}</textarea>
                    </div>
                    @error('lokasi_lahan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100 flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm text-blue-900 leading-relaxed">
                        Dengan mengajukan proposal ini, Anda menyatakan bahwa permohonan ini sah atas nama 
                        <strong>{{ auth()->user()->farmerProfile->nama_kelompok ?? auth()->user()->name }}</strong> 
                        dan <strong>tidak dipungut biaya apapun (GRATIS)</strong>.
                    </p>
                </div>

                <div class="flex items-start gap-3 py-2">
                    <div class="flex items-center h-5">
                        <input id="agreement" type="checkbox" x-model="agreed" required
                            class="w-5 h-5 text-primary-600 border-gray-300 rounded-lg focus:ring-primary-500 cursor-pointer">
                    </div>
                    <label for="agreement" class="text-sm text-gray-600 leading-snug cursor-pointer select-none">
                        Saya menyatakan bertanggung jawab penuh atas kebenaran data yang diajukan dan berkomitmen untuk menjaga serta menggunakan alat bantuan sesuai ketentuan yang berlaku.
                    </label>
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" :disabled="!agreed" :class="agreed ? 'bg-primary-600 hover:bg-primary-700' : 'bg-gray-300 cursor-not-allowed'"
                        class="px-8 py-3.5 text-white font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
                        Kirim Proposal
                    </button>
                    <a href="{{ route('farmer.proposals.alsintan') }}" class="text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                        Batal
                    </a>
                </div>
            </form>

            {{-- Confirmation Modal --}}
            <template x-if="showConfirm">
                <div class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        {{-- Backdrop --}}
                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="showConfirm = false"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                            <div class="bg-white p-8">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 bg-primary-50 rounded-2xl flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-gray-900">Konfirmasi Pengajuan</h3>
                                        <p class="text-sm text-gray-500">Apakah Anda yakin data sudah benar?</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Alat yang Dipinjam</p>
                                        <p class="font-bold text-gray-900 text-lg">{{ $alsintan->name }}</p>
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed">
                                        Setelah dikirim, proposal Anda akan masuk ke tahap verifikasi oleh Admin DTPH. Anda dapat memantau statusnya di halaman riwayat proposal.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-8 py-6 flex flex-row-reverse gap-3">
                                <button type="button" @click="$refs.proposalForm.submit()"
                                    class="w-full sm:w-auto px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-lg shadow-primary-600/20">
                                    Ya, Kirim Sekarang
                                </button>
                                <button type="button" @click="showConfirm = false"
                                    class="w-full sm:w-auto px-8 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                                    Periksa Kembali
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

    </div>
</x-app-layout>
