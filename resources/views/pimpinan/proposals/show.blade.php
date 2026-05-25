<x-app-layout>
    <x-slot name="header">Detail Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Pengajuan Proposal</h2>
            </div>
            <a href="{{ route('pimpinan.proposals.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @php
            $isAlsintan = $proposal->alsintan_id !== null;
            $sc = match($proposal->status) {
                'pending_verifikasi'       => ['bg' => 'bg-yellow-100 text-yellow-700',  'label' => 'Menunggu Verifikasi Admin'],
                'diteruskan_ke_pimpinan'   => ['bg' => 'bg-indigo-100 text-indigo-700',  'label' => 'Menunggu Disposisi Anda'],
                'didisposisi_kabid'        => ['bg' => 'bg-amber-100 text-amber-700',    'label' => 'Disposisi ke Kabid'],
                'surat_tugas_terbit'       => ['bg' => 'bg-blue-100 text-blue-700',      'label' => 'Surat Tugas Terbit'],
                'survei_selesai'           => ['bg' => 'bg-orange-100 text-orange-700',  'label' => 'Survei Selesai'],
                'menunggu_approval_ba'     => ['bg' => 'bg-purple-100 text-purple-700',  'label' => 'Menunggu Keputusan Akhir'],
                'disetujui'                => ['bg' => 'bg-green-100 text-green-700',    'label' => 'Disetujui'],
                'ditolak'                  => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Ditolak'],
                default                    => ['bg' => 'bg-gray-100 text-gray-600',       'label' => $proposal->status],
            };
        @endphp

        {{-- Summary + Actions --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="mb-2">
                    <span class="px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest inline-block {{ $sc['bg'] }}">
                        {{ $sc['label'] }}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-gray-900">
                    {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                </h3>
                <p class="text-gray-500 text-sm mt-1 mb-3">Nomor Registrasi: <span class="font-bold text-gray-900">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md inline-block {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                        {{ $isAlsintan ? 'Peminjaman Alsintan' : 'Program Bantuan' }}
                    </span>
                </div>
            </div>

            {{-- Action Buttons --}}
            @if($proposal->status === 'disetujui')
                <div class="flex gap-3 w-full sm:w-auto">
                    @if($isAlsintan)
                        <a href="{{ route('documents.surat-perjanjian', $proposal) }}" target="_blank" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Cetak Surat Perjanjian
                        </a>
                    @else
                        <a href="{{ route('documents.sk-bantuan', $proposal) }}" target="_blank" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Cetak SK Bantuan
                        </a>
                    @endif
                </div>
            @elseif($proposal->status === 'diteruskan_ke_pimpinan')
                <div class="flex flex-wrap gap-3 w-full sm:w-auto"
                     x-data="{ showDispose: false, showApprove: false, showReject: false }">

                    {{-- Primary: Disposisi --}}
                    <button @click="showDispose = true"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        Disposisi ke Kabid
                    </button>
                    <button @click="showApprove = true"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Setujui Langsung
                    </button>
                    <button @click="showReject = true"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak
                    </button>

                    {{-- Dispose Modal --}}
                    <template x-if="showDispose">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showDispose = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <h3 class="text-lg font-black text-gray-900 mb-1">Disposisi ke Kepala Bidang</h3>
                                    <p class="text-sm text-gray-500 mb-5">Pilih Kepala Bidang yang akan menangani survei lapangan proposal ini.</p>
                                    <form action="{{ route('pimpinan.proposals.dispose', $proposal) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Kepala Bidang *</label>
                                            <select name="kabid_id" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                                                <option value="">-- Pilih Kepala Bidang --</option>
                                                @foreach($kabidList as $kabid)
                                                <option value="{{ $kabid->id }}">{{ $kabid->displayName }} ({{ $kabid->roleLabel }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Catatan Disposisi (opsional)</label>
                                            <textarea name="disposition_notes" rows="3" placeholder="Arahan atau konteks khusus untuk Kabid..."
                                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 transition-colors text-sm">Disposisi</button>
                                            <button type="button" @click="showDispose = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Approve Modal --}}
                    <template x-if="showApprove">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showApprove = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <h3 class="text-lg font-black text-gray-900 mb-4">Setujui Proposal</h3>
                                    <form action="{{ route('pimpinan.proposals.approve', $proposal) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="mb-5">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Catatan (opsional)</label>
                                            <textarea name="pimpinan_notes" rows="3" placeholder="Tambahkan catatan untuk petani..."
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 resize-none"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors text-sm">Ya, Setujui</button>
                                            <button type="button" @click="showApprove = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Reject Modal --}}
                    <template x-if="showReject">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showReject = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <h3 class="text-lg font-black text-gray-900 mb-4">Tolak Proposal</h3>
                                    <form action="{{ route('pimpinan.proposals.reject', $proposal) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <div class="mb-5">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alasan Penolakan <span class="text-red-500">*</span></label>
                                            <textarea name="pimpinan_notes" rows="3" required placeholder="Tulis alasan penolakan..."
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 resize-none"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors text-sm">Ya, Tolak</button>
                                            <button type="button" @click="showReject = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            @elseif($proposal->status === 'menunggu_approval_ba')
                {{-- Final decision after berita acara --}}
                <div class="flex flex-wrap gap-3 w-full sm:w-auto"
                     x-data="{ showApprove: false, showReject: false, showBeritaAcara: false }">
                    @if($proposal->beritaAcara)
                    <button @click="showBeritaAcara = true" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-purple-50 border border-purple-200 text-purple-700 text-sm font-bold rounded-xl hover:bg-purple-100 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Lihat Berita Acara
                    </button>
                    @endif
                    <button @click="showApprove = true"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Setujui
                    </button>
                    <button @click="showReject = true"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak
                    </button>
                    <template x-if="showApprove">
                        <div class="fixed inset-0 z-[999] overflow-y-auto"><div class="flex items-center justify-center min-h-screen px-4"><div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showApprove = false"></div>
                            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8"><h3 class="text-lg font-black mb-4">Keputusan Akhir: Setujui</h3>
                                <form action="{{ route('pimpinan.proposals.approve', $proposal) }}" method="POST">@csrf @method('PATCH')
                                    <textarea name="pimpinan_notes" rows="3" placeholder="Catatan keputusan akhir (opsional)..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                                    <div class="flex gap-3"><button type="button" @click="showApprove = false" class="flex-1 py-3 border rounded-xl font-bold text-sm">Batal</button><button type="submit" class="flex-1 py-3 bg-indigo-600 text-white font-bold rounded-xl text-sm">Setujui</button></div>
                                </form></div></div></div>
                    </template>
                    <template x-if="showReject">
                        <div class="fixed inset-0 z-[999] overflow-y-auto"><div class="flex items-center justify-center min-h-screen px-4"><div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showReject = false"></div>
                            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8"><h3 class="text-lg font-black mb-4">Keputusan Akhir: Tolak</h3>
                                <form action="{{ route('pimpinan.proposals.reject', $proposal) }}" method="POST">@csrf @method('DELETE')
                                    <textarea name="pimpinan_notes" rows="3" required placeholder="Alasan penolakan..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none mb-4 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                                    <div class="flex gap-3"><button type="button" @click="showReject = false" class="flex-1 py-3 border rounded-xl font-bold text-sm">Batal</button><button type="submit" class="flex-1 py-3 bg-red-500 text-white font-bold rounded-xl text-sm">Tolak</button></div>
                                </form></div></div></div>
                    </template>
                    
                    {{-- Modal Berita Acara --}}
                    @if($proposal->beritaAcara)
                    <template x-if="showBeritaAcara">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showBeritaAcara = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8 border border-gray-100">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-black text-gray-900">Detail Berita Acara</h3>
                                        <button @click="showBeritaAcara = false" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-xl transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                    <div class="space-y-5">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kepala Bidang</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ $proposal->beritaAcara->kabid->name ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tanggal Survei</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ $proposal->beritaAcara->survey_date?->translatedFormat('d F Y') ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Lokasi Survei</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $proposal->beritaAcara->location ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Rekomendasi Final</p>
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $proposal->beritaAcara->recommendation === 'direkomendasikan' ? 'bg-green-50 text-green-700 border-green-200' : ($proposal->beritaAcara->recommendation === 'tidak_direkomendasikan' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                                                {{ $proposal->beritaAcara->recommendationLabel }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Hasil & Catatan Lapangan</p>
                                            <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 whitespace-pre-line leading-relaxed">{{ $proposal->beritaAcara->content }}</div>
                                        </div>
                                        @if($proposal->beritaAcara->attachment)
                                        <div class="pt-2">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Dokumen Lampiran</p>
                                            <a href="{{ asset('storage/' . $proposal->beritaAcara->attachment) }}" target="_blank" 
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 text-sm font-bold rounded-xl transition-colors border border-indigo-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                                Lihat Lampiran File
                                            </a>
                                        </div>
                                        @endif
                                        
                                        {{-- Dokumentasi Survei Lapangan --}}
                                        @if($proposal->surveyDocumentations->isNotEmpty())
                                        <div class="pt-2">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Dokumentasi Survei Lapangan</p>
                                            <div class="grid grid-cols-2 gap-4">
                                                @foreach($proposal->surveyDocumentations as $doc)
                                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200 hover:opacity-90 transition-opacity">
                                                    <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->keterangan }}" class="w-full h-32 object-cover">
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    @endif
                </div>
                <span class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold {{ $proposal->status === 'disetujui' ? 'bg-green-50 text-green-700 border border-green-100' : ($proposal->status === 'ditolak' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-gray-50 text-gray-600 border border-gray-100') }}">
                    {{ $proposal->statusLabel }}
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Main Info --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Petani Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h4 class="font-bold text-gray-900 mb-5 text-base border-b border-gray-100 pb-3">Informasi Pengaju</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Kelompok Tani</p>
                            <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->nama_kelompok ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Ketua</p>
                            <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->ketua ?? $proposal->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Komoditi Utama</p>
                            <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->komoditi_utama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kecamatan</p>
                            <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->kecamatan ?? '-' }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Lokasi Lahan</p>
                            <p class="text-gray-900 font-medium">{{ $proposal->lokasi_lahan }}</p>
                        </div>
                    </div>
                </div>

                {{-- Object Detail --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h4 class="font-bold text-gray-900 mb-5 text-base border-b border-gray-100 pb-3">
                        {{ $isAlsintan ? 'Detail Alat yang Dipinjam' : 'Detail Program yang Diajukan' }}
                    </h4>
                    @if($isAlsintan)
                        <div class="grid grid-cols-2 gap-5">
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Alat</p><p class="text-gray-900 font-bold">{{ $proposal->alsintan->name }}</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Merk / Tipe</p><p class="text-gray-900 font-medium">{{ $proposal->alsintan->merk ?? '-' }}</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kapasitas</p><p class="text-gray-900 font-medium">{{ $proposal->alsintan->capacity ?? '-' }}</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Stok Tersedia</p><p class="text-gray-900 font-medium">{{ $proposal->alsintan->available_stock }} unit</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rencana Durasi Pemakaian</p><p class="text-[#19A148] font-bold">{{ $proposal->rencana_durasi_hari ?? '-' }} Hari</p></div>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-5">
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Program</p><p class="text-gray-900 font-bold">{{ $proposal->program->name }}</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tipe</p><p class="text-gray-900 font-medium capitalize">{{ str_replace('_', ' ', $proposal->program->type) }}</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Sasaran</p><p class="text-gray-900 font-medium">{{ $proposal->program->sasaran ?? '-' }}</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kuota</p><p class="text-gray-900 font-medium">{{ $proposal->program->kuota ?? '-' }}</p></div>
                        </div>
                    @endif
                </div>

                </div>

            {{-- Sidebar Timeline --}}
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h4 class="font-bold text-gray-900 mb-5 border-b border-gray-200 pb-3 flex items-center justify-between">
                        Timeline Pengajuan
                        <span class="text-[10px] font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">Real-time</span>
                    </h4>
                    
                    @php
                        $disposition = $proposal->dispositionLogs->sortByDesc('created_at')->first();
                        $surveyAssignment = $proposal->surveyAssignments->sortByDesc('created_at')->first();
                        $beritaAcara = $proposal->beritaAcara;

                        $toUser = $proposal->kabid ?? ($disposition ? $disposition->toUser : null);
                        $kabidLabel = $toUser ? (
                            match($toUser->role) {
                                'kabid_psp' => 'Kabid PSP',
                                'kabid_tp' => 'Kabid Tanaman Pangan',
                                'kabid_hortikultura' => 'Kabid Hortikultura',
                                default => $toUser->roleLabel
                            }
                        ) : 'Kabid';
                    @endphp

                    <div class="relative border-l-2 border-primary-200 ml-3 space-y-8 pb-2">
                        
                        {{-- 1. Submitted --}}
                        <div class="relative">
                            <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                            <div class="pl-4">
                                <p class="text-sm font-bold text-gray-900">Pengajuan Dikirim</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->submission_date->translatedFormat('d M Y - H:i') }} WIB</p>
                                <p class="text-xs text-gray-500 mt-0.5">Proposal berhasil dikirim oleh petani.</p>
                            </div>
                        </div>

                        {{-- 2. Admin Review --}}
                        <div class="relative">
                            @if($proposal->reviewed_at)
                                <div class="absolute -left-[21px] {{ $proposal->status === 'ditolak' && !$proposal->decided_at ? 'bg-red-500' : 'bg-primary-500' }} w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold {{ $proposal->status === 'ditolak' && !$proposal->decided_at ? 'text-red-600' : 'text-gray-900' }}">Diverifikasi Admin</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs {{ $proposal->status === 'ditolak' && !$proposal->decided_at ? 'text-red-500' : 'text-gray-500' }} mt-0.5">
                                        {{ $proposal->status === 'ditolak' && !$proposal->decided_at ? 'Ditolak: ' . ($proposal->admin_notes ?? '-') : 'Berkas dinyatakan lengkap & layak.' }}
                                    </p>

                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-yellow-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Proses Verifikasi</p>
                                    <p class="text-xs text-gray-500">Admin sedang memeriksa kelengkapan berkas.</p>
                                </div>
                            @endif
                        </div>

                        {{-- 3. Pimpinan Disposition --}}
                        @if($proposal->status !== 'ditolak' || $disposition || $proposal->decided_at)
                        <div class="relative">
                            @if($proposal->status === 'ditolak' && !$disposition && $proposal->decided_at)
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak Pimpinan</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Ditolak: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                </div>
                            @elseif($disposition || in_array($proposal->status, ['didisposisi_kabid', 'surat_tugas_terbit', 'survei_selesai', 'menunggu_approval_ba', 'disetujui']))
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Disposisi Pimpinan</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ ($disposition ? $disposition->created_at : $proposal->updated_at)->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Diteruskan ke: {{ $kabidLabel }}</p>
                                </div>
                            @elseif($proposal->status === 'diteruskan_ke_pimpinan')
                                <div class="absolute -left-[21px] bg-indigo-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-indigo-600">Menunggu Disposisi</p>
                                    <p class="text-xs text-gray-400">Proposal sedang dalam tinjauan Pimpinan.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Disposisi Pimpinan</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 4. Kabid Assignment --}}
                        @if($proposal->status !== 'ditolak' || $surveyAssignment)
                        <div class="relative">
                            @if($surveyAssignment)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Surat Tugas Terbit</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $surveyAssignment->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Nomor: {{ $surveyAssignment->nomor_surat }}</p>
                                </div>
                            @elseif($proposal->status === 'didisposisi_kabid')
                                <div class="absolute -left-[21px] bg-amber-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-amber-600">Penugasan Tim Survei</p>
                                    <p class="text-xs text-gray-400">Menunggu {{ $kabidLabel }} membentuk tim survey.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Penugasan Survei</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 5. Survey Execution --}}
                        @if($proposal->status !== 'ditolak' || $proposal->cpclVerifications->count() > 0)
                        <div class="relative">
                            @if($proposal->status === 'surat_tugas_terbit')
                                <div class="absolute -left-[21px] bg-blue-500 w-3 h-3 rounded-full border-4 border-white animate-bounce"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-blue-600">Survei Sedang Jalan</p>
                                    <p class="text-xs text-gray-500">Menunggu input hasil CPCL offline.</p>
                                </div>
                            @elseif(in_array($proposal->status, ['survei_selesai', 'menunggu_approval_ba', 'disetujui']) || ($proposal->status === 'ditolak' && $proposal->cpclVerifications->count() > 0))
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi CPCL Selesai</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Hasil survei telah diinput ke sistem.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Pelaksanaan Survei</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 6. Berita Acara --}}
                        @if($proposal->status !== 'ditolak' || $beritaAcara)
                        <div class="relative">
                            @if($beritaAcara)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Berita Acara Terbit</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $beritaAcara->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">BA & Rekomendasi sudah diupload.</p>
                                </div>
                            @elseif($proposal->status === 'survei_selesai')
                                <div class="absolute -left-[21px] bg-orange-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-orange-600">Penyusunan BA</p>
                                    <p class="text-xs text-gray-400">Tim sedang menyusun laporan.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Berita Acara</p></div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-6">
                    <div class="p-6">
                        <h4 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Kontak Pengaju
                        </h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Akun</p>
                                    <p class="text-sm font-black text-gray-900">{{ $proposal->user->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email</p>
                                    <p class="text-sm font-black text-gray-900 break-all">{{ $proposal->user->email }}</p>
                                </div>
                            </div>
                            @if($proposal->user->farmerProfile?->no_telp)
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">No. Telepon</p>
                                    <p class="text-sm font-black text-gray-900">{{ $proposal->user->farmerProfile->no_telp }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
