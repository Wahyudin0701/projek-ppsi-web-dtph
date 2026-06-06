<x-app-layout>
    <x-slot name="header">Detail Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Pengajuan Proposal</h2>
                <p class="text-gray-500 text-sm mt-1">Tinjau informasi lengkap dan ambil keputusan untuk proposal ini.</p>
            </div>
            <a href="{{ route('admin.proposals.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @php
            $isAlsintan = $proposal->alsintan_id !== null;
            $sc = match($proposal->status) {
                'sedang_diverifikasi_admin'       => ['bg' => 'bg-yellow-100 text-yellow-700',  'label' => 'Sedang Diverifikasi Admin'],
                'sedang_diverifikasi_pimpinan'   => ['bg' => 'bg-indigo-100 text-indigo-700',  'label' => 'Sedang Diverifikasi Pimpinan'],
                'persiapan_survei'        => ['bg' => 'bg-amber-100 text-amber-700',    'label' => 'Disposisi ke Kabid'],
                'sedang_survei'       => ['bg' => 'bg-blue-100 text-blue-700',      'label' => 'Sedang Survei'],
                'survei_selesai'           => ['bg' => 'bg-orange-100 text-orange-700',  'label' => 'Survei Selesai'],
                'verifikasi_cpcl'    => ['bg' => 'bg-teal-100 text-teal-700',      'label' => 'Verifikasi CPCL'],
                'menunggu_keputusan_akhir'     => ['bg' => 'bg-purple-100 text-purple-700',  'label' => 'Keputusan Akhir'],
                'disetujui'                => ['bg' => 'bg-green-100 text-green-700',    'label' => 'Disetujui'],
                'ditolak'                  => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Ditolak'],
                default                    => ['bg' => 'bg-gray-100 text-gray-600',       'label' => $proposal->statusLabel],
            };
        @endphp

        {{-- Summary Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">
            <div class="flex-shrink-0">
                <div class="mb-2">
                    <span class="px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest inline-block {{ $sc['bg'] }}">
                        {{ $sc['label'] }}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-gray-900">
                    {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                </h3>
                <p class="text-gray-500 text-sm mt-1 mb-3 whitespace-nowrap">Nomor Registrasi: <span class="font-bold text-gray-900">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md inline-block {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                        {{ $isAlsintan ? 'Peminjaman Alsintan' : 'Program Bantuan' }}
                    </span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row flex-wrap justify-end gap-3 w-full sm:w-auto items-stretch sm:items-center" x-data="{ showApprove: false, showReject: false }">
                @if($proposal->file_proposal)
                    <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-50 border border-indigo-100 text-indigo-700 hover:bg-indigo-100 text-sm font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Lihat Proposal
                    </a>
                @endif



            @if($proposal->status === 'sedang_diverifikasi_admin')
                    <button @click="showApprove = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Terima & Verifikasi
                    </button>
                    <button @click="showReject = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak
                    </button>

                    {{-- Approve Modal --}}
                    <template x-if="showApprove">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showApprove = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-primary-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Verifikasi Proposal</h3>
                                            <p class="text-sm text-gray-500">Proposal akan diteruskan ke Pimpinan.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-6">Anda telah memeriksa kelengkapan berkas dan menyatakan proposal ini <strong class="text-primary-600">layak</strong> untuk diproses lebih lanjut.</p>
                                    <form action="{{ route('admin.proposals.approve', $proposal) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm">Ya, Verifikasi</button>
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
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Tolak Proposal</h3>
                                            <p class="text-sm text-gray-500">Proposal akan ditolak secara permanen.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">Anda akan <strong class="text-red-600">menolak</strong> proposal <strong>{{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong>.</p>
                                    <form action="{{ route('admin.proposals.reject', $proposal) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <div class="mb-5">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alasan Penolakan <span class="text-red-500">*</span></label>
                                            <textarea name="admin_notes" rows="3" required placeholder="Tulis alasan penolakan..."
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
            @else
                    @if($proposal->cpclVerifications->isNotEmpty())

                        <a href="{{ route('documents.cpcl', $proposal) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Lihat Berita Acara CPCL
                        </a>
                        @php
                            $cpclData = $proposal->cpclVerifications->last();
                        @endphp
                        @if($cpclData && $cpclData->dokumen_fisik_path)
                            <a href="{{ Storage::url($cpclData->dokumen_fisik_path) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Lihat Dokumen Fisik CPCL
                            </a>
                        @endif
                    @endif
                @endif
            </div>
        </div>



        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Main Info --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Petani Info --}}
                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        Informasi Pengaju
                    </h4>
                    <x-farmer-profile-detail :user="$proposal->user" />
                </div>



                {{-- Object Detail --}}
                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        @if($isAlsintan)
                            Detail Alat yang Dipinjam
                        @else
                            Detail Program yang Diajukan
                        @endif
                    </h4>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                    @if($isAlsintan)
                        <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">No. Surat Pengajuan</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->no_surat_pengajuan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Alat</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->alsintan->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Merk / Tipe</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->alsintan->merk ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kapasitas</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->alsintan->capacity ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Durasi Peminjaman</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->rencana_durasi_hari ? $proposal->rencana_durasi_hari . ' Hari' : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Stok Tersedia (saat ini)</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->alsintan->available_stock }} unit</p>
                            </div>

                        </div>
                        @if($proposal->alsintan->image)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Foto Alsintan</p>
                            <img src="{{ Storage::url($proposal->alsintan->image) }}" alt="{{ $proposal->alsintan->name }}" class="w-full max-w-sm h-auto rounded-xl border border-gray-100 shadow-sm object-cover aspect-video">
                        </div>
                        @endif
                    @else
                        <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">No. Surat Pengajuan</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->no_surat_pengajuan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Program</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->program->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tipe Program</p>
                                <p class="text-gray-900 font-medium capitalize">{{ str_replace('_', ' ', $proposal->program->type) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Sasaran</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->program->sasaran ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kuota Program</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->program->kuota ?? '-' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
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

                        // Strict ordered statuses
                        $statusOrder = [
                            'sedang_diverifikasi_admin'     => 0,
                            'sedang_diverifikasi_pimpinan' => 1,
                            'persiapan_survei'      => 2,
                            'sedang_survei'     => 3,
                            'survei_selesai'         => 4,
                            'verifikasi_cpcl'  => 5,
                            'menunggu_keputusan_akhir'   => 6,
                            'disetujui'              => 7,
                            'ditolak'                => -1,
                        ];
                        $currentOrder = $statusOrder[$proposal->status] ?? 0;

                        // Rejection stage detection
                        $rejectedByAdmin     = $proposal->status === 'ditolak' && $proposal->reviewed_at && !$proposal->decided_at;
                        $rejectedAtDisposisi = $proposal->status === 'ditolak' && $proposal->decided_at && !$beritaAcara;
                        $rejectedAtFinal     = $proposal->status === 'ditolak' && $proposal->decided_at && $beritaAcara;
                    @endphp

                    <div class="relative border-l-2 border-primary-200 ml-3 space-y-8 pb-2">

                        {{-- 1. Pengajuan Dikirim (always done) --}}
                        <div class="relative">
                            <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                            <div class="pl-4">
                                <p class="text-sm font-bold text-gray-900">Pengajuan Dikirim</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->submission_date->translatedFormat('d M Y - H:i') }} WIB</p>
                                <p class="text-xs text-gray-500 mt-0.5">Dikirim oleh: {{ $proposal->user->name }}</p>
                            </div>
                        </div>

                        {{-- 2. Verifikasi Admin --}}
                        <div class="relative">
                            @if($rejectedByAdmin)
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak oleh Admin</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: {{ $proposal->admin_notes ?? '-' }}</p>
                                </div>
                            @elseif($proposal->reviewed_at)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi Admin Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Berkas dinyatakan lengkap & layak.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-yellow-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-yellow-600">Sedang Diverifikasi Admin</p>
                                    <p class="text-xs text-gray-500">Proposal sedang menunggu antrian verifikasi berkas.</p>
                                </div>
                            @endif
                        </div>

                        {{-- 3. Disposisi Pimpinan (hidden if rejected by admin) --}}
                        @if(!$rejectedByAdmin)
                        <div class="relative">
                            @if($rejectedAtDisposisi)
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak oleh Pimpinan</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                </div>
                            @elseif(($currentOrder >= 2 || $rejectedAtFinal) && $disposition)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi Pimpinan Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $disposition->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Diteruskan ke: {{ $kabidLabel }}</p>
                                </div>
                            @elseif($proposal->status === 'disetujui' && !$disposition)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi Pimpinan Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at ? $proposal->decided_at->translatedFormat('d M Y - H:i') : $proposal->updated_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Proposal disetujui langsung oleh Pimpinan.</p>
                                </div>
                            @elseif($proposal->status === 'sedang_diverifikasi_pimpinan')
                                <div class="absolute -left-[21px] bg-indigo-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-indigo-600">Sedang Diverifikasi Pimpinan</p>
                                    <p class="text-xs text-gray-400">Pimpinan perlu meninjau proposal.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Verifikasi Pimpinan</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 4. Penugasan Survei (hidden if rejected at/before disposisi, or approved without survey) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !($proposal->status === 'disetujui' && !$surveyAssignment))
                        <div class="relative">
                            @if($currentOrder >= 3 && $surveyAssignment)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Persiapan Survei Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $surveyAssignment->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Tim teknis dan jadwal survei telah ditentukan.</p>
                                </div>
                            @elseif($rejectedAtFinal && $surveyAssignment)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Sedang Survei</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $surveyAssignment->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Nomor: {{ $surveyAssignment->nomor_surat }}</p>
                                </div>
                            @elseif($proposal->status === 'persiapan_survei')
                                <div class="absolute -left-[21px] bg-amber-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-amber-600">Sedang Persiapan Survei</p>
                                    <p class="text-xs text-gray-400">{{ $kabidLabel }} sedang menyusun jadwal dan tim verifikasi lapangan.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Persiapan Survei</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 5. Pelaksanaan Survei (hidden if rejected at/before disposisi, or approved without survey) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !($proposal->status === 'disetujui' && !$surveyAssignment))
                        <div class="relative">
                            @if($proposal->status === 'sedang_survei')
                                <div class="absolute -left-[21px] bg-blue-500 w-3 h-3 rounded-full border-4 border-white animate-bounce"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-blue-600">Sedang Pelaksanaan Survei</p>
                                    <p class="text-xs text-gray-400">Tim teknis sedang melakukan peninjauan lokasi dan menyusun hasil verifikasi.</p>
                                </div>
                            @elseif($currentOrder >= 4 || $rejectedAtFinal)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Pelaksanaan Survei Selesai</p>
                                    @if($proposal->cpclVerifications->last())
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->cpclVerifications->last()->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-0.5">Hasil survei telah diinput ke sistem.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Pelaksanaan Survei</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 6. Verifikasi CPCL (only shown from survei_selesai and above, or rejected at final) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !($proposal->status === 'disetujui' && !$surveyAssignment))
                        <div class="relative">
                            @if(($currentOrder >= 6 || $rejectedAtFinal) && $beritaAcara)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi CPCL Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $beritaAcara->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Berita Acara dan dokumen rekomendasi telah berhasil diteruskan ke Pimpinan.</p>
                                </div>
                            @elseif($proposal->status === 'verifikasi_cpcl' || $proposal->status === 'survei_selesai')
                                <div class="absolute -left-[21px] bg-blue-500 w-3 h-3 rounded-full border-4 border-white animate-bounce"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-blue-600">Sedang Verifikasi CPCL</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Menunggu {{ $kabidLabel }} mengunggah Berita Acara dan meneruskan ke Pimpinan.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Verifikasi CPCL</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 7. Keputusan Akhir (only shown from menunggu_approval_ba and above, or rejected at final) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi)
                        <div class="relative">
                            @if($proposal->status === 'disetujui')
                                <div class="absolute -left-[21px] bg-green-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-green-700">Proposal Disetujui ✓</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $proposal->pimpinan_notes ?? 'Keputusan akhir telah diambil oleh Pimpinan.' }}</p>
                                </div>
                            @elseif($rejectedAtFinal)
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak Pimpinan (Tahap Akhir)</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                </div>
                            @elseif($proposal->status === 'menunggu_keputusan_akhir')
                                <div class="absolute -left-[21px] bg-purple-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-purple-700">Menunggu Keputusan Akhir</p>
                                    <p class="text-xs text-gray-400">Menunggu persetujuan final Pimpinan.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Keputusan Akhir</p></div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h4 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Kontak Pengaju
                        </h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Akun</p>
                                    <p class="text-sm font-black text-gray-900">{{ $proposal->user->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email</p>
                                    <p class="text-sm font-black text-gray-900 break-all">{{ $proposal->user->email }}</p>
                                </div>
                            </div>
                            @if($proposal->user->farmerProfile?->no_telp)
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary-600 transition-colors">
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
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 text-center uppercase tracking-widest italic">Data terverifikasi sistem</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

