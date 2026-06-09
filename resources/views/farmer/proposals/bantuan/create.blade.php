<x-app-layout>
    <x-slot name="header">Program Bantuan - Ajukan Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Form Pengajuan Program</h2>
                <p class="text-gray-500 text-sm mt-1">Lengkapi data untuk mengajukan bantuan pada program {{ $program->name }}.</p>
            </div>
            <a href="{{ route('farmer.proposals.bantuan') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            {{-- Left Column: Summaries --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Program Detail Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden relative">
                    <div class="p-6">
                        <span class="inline-block rounded-xl bg-primary-50 px-3 py-1 text-[10px] font-extrabold uppercase tracking-widest text-primary-600 border border-primary-100 mb-4">{{ $program->jenis }}</span>
                        <h3 class="text-xl font-black text-gray-900 mb-5 line-clamp-2">{{ $program->name }}</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-3">
                                <span class="text-gray-500 font-medium">Sasaran</span>
                                <span class="font-bold text-gray-800 text-right w-1/2 line-clamp-1">{{ $program->sasaran ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-3">
                                <span class="text-gray-500 font-medium">Kuota</span>
                                <span class="font-bold text-gray-800">{{ $program->kuota ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col text-sm border-b border-gray-50 pb-3 gap-1">
                                <span class="text-gray-500 font-medium text-xs">Jadwal Buka</span>
                                <span class="font-bold text-gray-800">{{ $program->open_date?->translatedFormat('d F Y') ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col text-sm gap-1">
                                <span class="text-gray-500 font-medium text-xs">Jadwal Tutup</span>
                                <span class="font-black text-red-600">{{ $program->close_date?->translatedFormat('d F Y') ?? '-' }}</span>
                            </div>

                            @if($program->contact_person || $program->contact_phone)
                            <div class="flex flex-col text-sm border-t border-gray-50 pt-3 gap-1">
                                <span class="text-gray-500 font-medium text-xs">Kontak Narahubung</span>
                                <span class="font-bold text-gray-800">{{ $program->contact_person ?? '-' }}</span>
                                <span class="text-xs text-gray-500">{{ $program->contact_phone ?? '' }}</span>
                            </div>
                            @endif

                            @if($program->juknis_file)
                            <div class="pt-3 border-t border-gray-50">
                                <a href="{{ Storage::url($program->juknis_file) }}" target="_blank" class="w-full flex justify-center items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-xl font-bold text-xs transition-colors border border-blue-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Unduh Juknis Program
                                </a>
                            </div>
                            @endif
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

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-2xl border border-red-200 font-medium text-sm flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="leading-relaxed">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 sm:p-10" x-data="{ showConfirm: false, agreed: false }">
                    <h3 class="text-2xl font-black text-gray-900 mb-8">Formulir Pengajuan</h3>

                    @if($program->description || ($program->requirements && is_array($program->requirements) && count($program->requirements) > 0) || $program->sop_description)
                        <div class="mb-10 space-y-5">
                            @if($program->description)
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $program->description }}</p>
                            @endif

                            @if($program->requirements && is_array($program->requirements) && count($program->requirements) > 0)
                            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                                <h4 class="text-xs font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#19A148]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Persyaratan Khusus
                                </h4>
                                <ul class="space-y-2.5">
                                    @foreach($program->requirements as $req)
                                    <li class="flex items-start gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-[#19A148] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span class="leading-relaxed">{{ $req }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if($program->sop_description)
                            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <h4 class="text-sm font-bold text-blue-900">Alur / SOP Pengajuan</h4>
                                </div>
                                <p class="text-sm text-blue-800/80 leading-relaxed whitespace-pre-line">{{ $program->sop_description }}</p>
                            </div>
                            @endif
                        </div>
                    @endif

                    <form id="programForm" x-ref="programForm" action="{{ route('farmer.proposals.store', $program) }}" method="POST" enctype="multipart/form-data" @submit.prevent="showConfirm = true">
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
                                Saya bertanggung jawab penuh atas kebenaran data dan berkomitmen untuk mengikuti seluruh tahapan program sesuai ketentuan yang berlaku.
                            </label>
                        </div>

                        <div class="mt-10 flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('farmer.proposals.bantuan') }}" class="px-6 py-3.5 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
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
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
                                     x-show="showConfirm" x-transition.opacity @click="showConfirm = false"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100"
                                     x-show="showConfirm" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                    <div class="bg-white p-8">
                                        <div class="flex items-center gap-4 mb-6">
                                            <div class="w-12 h-12 bg-[#19A148]/10 rounded-2xl flex items-center justify-center shrink-0">
                                                <svg class="w-6 h-6 text-[#19A148]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-black text-gray-900">Konfirmasi Pengajuan</h3>
                                                <p class="text-sm text-gray-500">Kirim usulan proposal sekarang?</p>
                                            </div>
                                        </div>
                                        <div class="space-y-4">
                                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Program</p>
                                                <p class="font-bold text-gray-900 text-lg">{{ $program->name }}</p>
                                            </div>
                                            <p class="text-sm text-gray-600 leading-relaxed">
                                                Setelah dikirim, proposal Anda akan masuk ke tahap verifikasi. Pastikan lokasi lahan dan data pendukung lainnya sudah benar.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-8 py-6 flex flex-col-reverse sm:flex-row-reverse gap-3">
                                        <button type="button" @click="document.getElementById('programForm').submit()"
                                            class="w-full sm:w-auto px-8 py-3 bg-[#19A148] text-white font-bold rounded-xl hover:bg-green-700 transition-colors shadow-lg shadow-[#19A148]/20">
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
