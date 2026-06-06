<x-app-layout>
    <x-slot name="header">Detail Pengajuan</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Pengajuan Proposal</h2>
                <p class="text-gray-500 text-sm mt-1">Informasi lengkap dan status terbaru dari proposal yang Anda ajukan.</p>
            </div>
            <a href="{{ route('farmer.proposals.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
            
            {{-- Header Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    @php
                        $statusColors = [
                            'sedang_diverifikasi_admin'       => 'bg-yellow-100 text-yellow-700',
                            'sedang_diverifikasi_pimpinan'   => 'bg-indigo-100 text-indigo-700',
                            'persiapan_survei'        => 'bg-amber-100 text-amber-700',
                            'sedang_survei'       => 'bg-blue-100 text-blue-700',
                            'survei_selesai'           => 'bg-orange-100 text-orange-700',
                            'verifikasi_cpcl'    => 'bg-purple-100 text-purple-700',
                            'menunggu_keputusan_akhir'     => 'bg-purple-100 text-purple-700',
                            'disetujui'                => 'bg-green-100 text-green-700',
                            'ditolak'                  => 'bg-red-100 text-red-700',
                        ];
                        $color = $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-700';
                        $statusLabel = match($proposal->status) {
                            'verifikasi_cpcl', 'menunggu_keputusan_akhir' => 'Finalisasi',
                            default => $proposal->statusLabel,
                        };
                    @endphp
                    <div class="mb-2">
                        <span class="px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest inline-block {{ $color }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900">
                        @if($proposal->alsintan_id)
                            {{ $proposal->alsintan->name }}
                        @else
                            {{ $proposal->program->name }}
                        @endif
                    </h3>
                    <p class="text-gray-500 text-sm mt-1 mb-3">Nomor Registrasi: <span class="font-bold text-gray-900">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md inline-block {{ $proposal->alsintan_id ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                            {{ $proposal->alsintan_id ? 'Peminjaman Alsintan' : 'Program Bantuan' }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    @if($proposal->status === 'disetujui')
                        @if($proposal->nomor_dokumen_final)
                            @if($proposal->alsintan_id)
                            <a href="{{ route('documents.surat-perjanjian', $proposal->id) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Unduh Surat Perjanjian
                            </a>
                            @else
                            <a href="{{ route('documents.sk-bantuan', $proposal->id) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Unduh SK Bantuan
                            </a>
                            @endif
                        @else
                            <div class="w-full sm:w-auto px-5 py-2.5 bg-amber-50 text-amber-700 text-sm font-bold rounded-xl flex items-center justify-center gap-2 border border-amber-200">
                                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Menunggu Nomor Surat
                            </div>
                        @endif
                    @endif
                    <a href="{{ route('farmer.proposals.download-receipt', $proposal->id) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 bg-primary-600 text-white text-sm font-bold rounded-xl hover:bg-primary-700 transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh Bukti
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Main Info --}}
                <div class="md:col-span-2 space-y-6">
                    <div class="mb-6">
                        <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                            Informasi Pengaju
                        </h4>
                        <x-farmer-profile-detail :user="$proposal->user" />
                    </div>

                    {{-- Detail Pengajuan (Alsintan / Program) --}}
                    <div class="mb-6">
                        <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                            @if($proposal->alsintan_id)
                                Detail Alat yang Dipinjam
                            @else
                                Detail Program yang Diajukan
                            @endif
                        </h4>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8">
                        @if($proposal->alsintan_id)
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
                                    <p class="text-gray-900 font-medium">{{ $proposal->program->target_audience ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Batas Akhir Pengajuan</p>
                                    <p class="text-gray-900 font-medium">{{ $proposal->program->end_date ? $proposal->program->end_date->translatedFormat('d F Y') : '-' }}</p>
                                </div>
                            </div>
                        @endif

                        @if($proposal->file_proposal)
                        <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">File Dokumen Proposal</p>
                                <p class="text-sm font-medium text-gray-600">Dokumen PDF/Word yang diajukan</p>
                            </div>
                            <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 text-sm font-bold rounded-xl transition-colors border border-indigo-100 w-full sm:w-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Lihat Dokumen
                            </a>
                        </div>
                        @endif
                    </div>
                    </div>

                    {{-- Data Survei Lapangan (CPCL) disembunyikan untuk sisi user --}}
                </div>

                {{-- Sidebar Info --}}
                <div class="space-y-6">
                    <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 p-6">
                        <h4 class="font-bold text-gray-900 mb-5 border-b border-gray-200 pb-3">Timeline Pengajuan</h4>
                        
                        @php
                            $disposition      = $proposal->latestDispositionLog;
                            $surveyAssignment = $proposal->surveyAssignments->last();
                            $beritaAcara      = $proposal->beritaAcara;

                            $toUser = $proposal->kabid ?? ($disposition ? $disposition->toUser : null);
                            $kabidLabel = $toUser ? (
                                match($toUser->role) {
                                    'kabid_psp'          => 'Kabid PSP',
                                    'kabid_tp'           => 'Kabid Tanaman Pangan',
                                    'kabid_hortikultura' => 'Kabid Hortikultura',
                                    default              => $toUser->roleLabel
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
                            $rejectedAtFinal     = $proposal->status === 'ditolak' && $proposal->decided_at && $beritaAcara;
                            $rejectedAtDisposisi = $proposal->status === 'ditolak' && $proposal->decided_at && !$beritaAcara;
                        @endphp

                        <div class="relative border-l-2 border-primary-200 ml-3 space-y-8 pb-2">

                            {{-- 1. Pengajuan Dikirim (always done) --}}
                            <div class="relative">
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Pengajuan Dikirim</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->submission_date->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-1">Proposal berhasil dikirim oleh petani.</p>
                                </div>
                            </div>

                            {{-- 2. Verifikasi Admin --}}
                            <div class="relative">
                                @if($rejectedByAdmin)
                                    <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-red-600">Ditolak oleh Admin</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-red-500 mt-1">Alasan: {{ $proposal->admin_notes ?? 'Tidak memenuhi syarat.' }}</p>
                                    </div>
                                @elseif($proposal->reviewed_at)
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Verifikasi Admin Selesai</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Pemeriksaan dokumen selesai dan layak diteruskan.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-yellow-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-yellow-600">Sedang Diverifikasi Admin</p>
                                        <p class="text-xs text-gray-500">Proposal sedang menunggu antrian verifikasi berkas.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- 3. Disposisi Pimpinan (skip if rejected by admin) --}}
                            @if(!$rejectedByAdmin)
                            <div class="relative">
                                @if($rejectedAtDisposisi && !$rejectedAtFinal)
                                    <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-red-600">Ditolak oleh Pimpinan</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-red-500 mt-1">Alasan: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                    </div>
                                @elseif(($currentOrder >= 2 || $rejectedAtFinal) && $disposition)
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Verifikasi Pimpinan Selesai</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $disposition->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Diteruskan ke: {{ $kabidLabel }}</p>
                                    </div>
                                @elseif($proposal->status === 'disetujui' && !$disposition)
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Verifikasi Pimpinan Selesai</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at ? $proposal->decided_at->translatedFormat('d M Y - H:i') : $proposal->updated_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Proposal disetujui langsung oleh Pimpinan.</p>
                                    </div>
                                @elseif($proposal->status === 'sedang_diverifikasi_pimpinan')
                                    <div class="absolute -left-[21px] bg-indigo-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-indigo-600">Sedang Diverifikasi Pimpinan</p>
                                        <p class="text-xs text-gray-400">Proposal sedang dalam tinjauan Pimpinan.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Verifikasi Pimpinan</p></div>
                                @endif
                            </div>
                            @endif

                            {{-- 4. Penugasan Tim Survei (skip if rejected at/before disposisi, or approved without survey) --}}
                            @if(!$rejectedByAdmin && !($rejectedAtDisposisi && !$rejectedAtFinal) && !($proposal->status === 'disetujui' && !$surveyAssignment))
                            <div class="relative">
                                @if(($currentOrder >= 3 || $rejectedAtFinal) && $surveyAssignment)
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Persiapan Survei Selesai</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $surveyAssignment->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Tim teknis dan jadwal survei telah ditentukan.</p>
                                    </div>
                                @elseif($proposal->status === 'persiapan_survei')
                                    <div class="absolute -left-[21px] bg-amber-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-amber-600">Sedang Persiapan Survei</p>
                                        <p class="text-xs text-gray-400">{{ $kabidLabel }} sedang menyusun jadwal dan tim verifikasi lapangan.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Persiapan Survei</p></div>
                                @endif
                            </div>
                            @endif

                            {{-- 5. Pelaksanaan Survei (skip if rejected before this step, or approved without survey) --}}
                            @if(!$rejectedByAdmin && !($rejectedAtDisposisi && !$rejectedAtFinal) && !($proposal->status === 'disetujui' && !$surveyAssignment))
                            <div class="relative">
                                @if($proposal->status === 'sedang_survei')
                                    <div class="absolute -left-[21px] bg-blue-500 w-3 h-3 rounded-full border-4 border-white animate-bounce"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-blue-600">Sedang Pelaksanaan Survei</p>
                                        <p class="text-xs text-gray-500 mt-1">Tim teknis sedang melakukan peninjauan lokasi dan menyusun hasil verifikasi.</p>
                                    </div>
                                @elseif($currentOrder >= 4 || $rejectedAtFinal)
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Pelaksanaan Survei Selesai</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->cpclVerifications->last()?->created_at?->translatedFormat('d M Y - H:i') ?? '-' }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Data lapangan telah diambil dan dimasukkan ke sistem.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Pelaksanaan Survei</p></div>
                                @endif
                            </div>
                            @endif

                            {{-- 6. Keputusan Akhir Pimpinan --}}
                            @if(!$rejectedByAdmin && !($rejectedAtDisposisi && !$rejectedAtFinal))
                            <div class="relative">
                                @if($proposal->status === 'disetujui')
                                    <div class="absolute -left-[21px] bg-green-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-green-700">Proposal Disetujui ✓</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $proposal->pimpinan_notes ?? 'Keputusan akhir telah diambil oleh Pimpinan.' }}</p>
                                    </div>
                                @elseif($rejectedAtFinal)
                                    <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-red-600">Ditolak oleh Pimpinan</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-red-500 mt-1">Alasan: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                    </div>
                                @elseif(in_array($proposal->status, ['survei_selesai', 'verifikasi_cpcl', 'menunggu_keputusan_akhir']))
                                    <div class="absolute -left-[21px] bg-purple-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-purple-700">Menunggu Finalisasi</p>
                                        <p class="text-xs text-gray-500 mt-1">Tahap akhir persetujuan proposal sedang diproses oleh pihak Dinas.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Finalisasi</p></div>
                                @endif
                            </div>
                            @endif

                        </div>
                    </div>

                    {{-- Contact Info removed as requested for Kelompok Tani role --}}
                </div>
            </div>

        </div>
</x-app-layout>
