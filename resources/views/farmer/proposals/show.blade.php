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
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-2xl font-black text-gray-900">
                            @if($proposal->alsintan_id)
                                {{ $proposal->alsintan->name }}
                            @else
                                {{ $proposal->program->name }}
                            @endif
                        </h3>
                        @php
                            $statusColors = [
                                'pending_verifikasi'       => 'bg-yellow-100 text-yellow-700',
                                'diteruskan_ke_pimpinan'   => 'bg-indigo-100 text-indigo-700',
                                'didisposisi_kabid'        => 'bg-amber-100 text-amber-700',
                                'surat_tugas_terbit'       => 'bg-blue-100 text-blue-700',
                                'survei_selesai'           => 'bg-orange-100 text-orange-700',
                                'menunggu_approval_ba'     => 'bg-purple-100 text-purple-700',
                                'disetujui'                => 'bg-green-100 text-green-700',
                                'ditolak'                  => 'bg-red-100 text-red-700',
                            ];
                            $color = $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-700';
                            $statusLabel = $proposal->statusLabel;
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest {{ $color }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm">Nomor Registrasi: <span class="font-bold text-gray-900">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                </div>
                <div class="flex gap-3 w-full sm:w-auto">
                    @if($proposal->status === 'disetujui')
                        @if($proposal->alsintan_id)
                            <a href="{{ route('documents.surat-perjanjian', $proposal) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 bg-green-600 text-white text-sm font-bold rounded-xl hover:bg-green-700 transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Cetak Surat Perjanjian
                            </a>
                        @else
                            <a href="{{ route('documents.sk-bantuan', $proposal) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 bg-green-600 text-white text-sm font-bold rounded-xl hover:bg-green-700 transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Cetak SK Bantuan
                            </a>
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
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8">
                        <h4 class="font-bold text-gray-900 mb-6 text-lg border-b border-gray-100 pb-3">Informasi Kelompok Tani</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Kelompok</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Ketua</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->ketua ?? '-' }}</p>
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
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Lokasi Lahan Penggunaan</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->lokasi_lahan }}</p>
                            </div>
                            @if($proposal->alsintan_id)
                            <div class="sm:col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rencana Durasi Pemakaian Alat</p>
                                <p class="text-[#19A148] font-bold">{{ $proposal->rencana_durasi_hari ?? '-' }} Hari</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Data Survei Lapangan (CPCL) --}}
                    @if($proposal->cpclVerifications->isNotEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8 mt-6">
                        <h4 class="font-bold text-gray-900 mb-6 text-lg border-b border-gray-100 pb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            Hasil Survei Lapangan (CPCL)
                        </h4>
                        
                        @php $cpcl = $proposal->cpclVerifications->last(); @endphp
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 mb-6">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Kepemilikan</p>
                                <p class="text-gray-900 font-medium">{{ $cpcl->status_kepemilikan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Luas Lahan</p>
                                <p class="text-gray-900 font-medium">{{ $cpcl->luas_lahan ?? '-' }} Ha</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kondisi Lahan</p>
                                <p class="text-gray-900 font-medium">{{ $cpcl->kondisi_lahan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kesesuaian Komoditas</p>
                                <p class="font-medium {{ $cpcl->kesesuaian_komoditas ? 'text-green-700' : 'text-red-600' }}">
                                    {{ $cpcl->kesesuaian_komoditas ? 'Sesuai ✓' : 'Tidak Sesuai ✗' }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rekomendasi Petugas</p>
                                <p class="text-gray-900 font-medium">{{ $cpcl->rekomendasi_surveyor ?? '-' }}</p>
                            </div>
                        </div>

                        @if($proposal->surveyDocumentations->isNotEmpty())
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Foto Dokumentasi</p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach($proposal->surveyDocumentations as $doc)
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200 hover:opacity-90 transition-opacity">
                                    <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->keterangan }}" class="w-full h-32 object-cover">
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- Sidebar Info --}}
                <div class="space-y-6">
                    <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 p-6">
                        <h4 class="font-bold text-gray-900 mb-5 border-b border-gray-200 pb-3">Timeline Pengajuan</h4>
                        
                        @php
                            $disposition = $proposal->latestDispositionLog;
                            $surveyAssignment = $proposal->surveyAssignments->last();
                            $beritaAcara = $proposal->beritaAcara;
                        @endphp

                        <div class="relative border-l-2 border-primary-200 ml-3 space-y-8 pb-2">
                            
                            {{-- 1. Submitted --}}
                            <div class="relative">
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Pengajuan Dikirim</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->submission_date->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-1">Proposal berhasil dikirim oleh petani.</p>
                                </div>
                            </div>

                            {{-- 2. Admin Review --}}
                            <div class="relative">
                                @if($proposal->reviewed_at)
                                    <div class="absolute -left-[21px] {{ $proposal->status === 'ditolak' && !$proposal->decided_at ? 'bg-red-500' : 'bg-primary-500' }} w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold {{ $proposal->status === 'ditolak' && !$proposal->decided_at ? 'text-red-600' : 'text-gray-900' }}">Diverifikasi Admin</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs {{ $proposal->status === 'ditolak' && !$proposal->decided_at ? 'text-red-500' : 'text-gray-500' }} mt-1">
                                            {{ $proposal->status === 'ditolak' && !$proposal->decided_at ? 'Proposal ditolak. Alasan: ' . ($proposal->admin_notes ?? 'Tidak memenuhi syarat') : 'Pemeriksaan dokumen selesai dan layak diteruskan.' }}
                                        </p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4 opacity-50">
                                        <p class="text-sm font-bold text-gray-400">Verifikasi Admin</p>
                                        <p class="text-xs text-gray-400">Menunggu antrian verifikasi berkas.</p>
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
                                        <p class="text-xs text-red-500 mt-1">Proposal ditolak. Alasan: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                    </div>
                                @elseif($disposition)
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Disposisi Pimpinan</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $disposition->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Pimpinan menyetujui untuk dilakukan survei lapangan.</p>
                                    </div>
                                @elseif($proposal->status === 'diteruskan_ke_pimpinan')
                                    <div class="absolute -left-[21px] bg-indigo-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-indigo-600">Menunggu Disposisi</p>
                                        <p class="text-xs text-gray-400">Proposal sedang dalam tinjauan Pimpinan.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Disposisi Pimpinan</p></div>
                                @endif
                            </div>
                            @endif

                            {{-- 4. Kabid Assignment --}}
                            @if($proposal->status !== 'ditolak' || $surveyAssignment)
                            <div class="relative">
                                @if($surveyAssignment)
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Penugasan Tim Survei</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $surveyAssignment->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Kabid menunjuk tim teknis untuk survei lokasi.</p>
                                    </div>
                                @elseif($proposal->status === 'didisposisi_kabid')
                                    <div class="absolute -left-[21px] bg-amber-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-amber-600">Persiapan Survei</p>
                                        <p class="text-xs text-gray-400">Kabid sedang mengatur jadwal dan tim survei.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Penugasan Survei</p></div>
                                @endif
                            </div>
                            @endif

                            {{-- 5. Survey Execution --}}
                            @if($proposal->status !== 'ditolak' || $proposal->cpclVerifications->count() > 0)
                            <div class="relative">
                                @if($proposal->status === 'surat_tugas_terbit')
                                    <div class="absolute -left-[21px] bg-blue-500 w-3 h-3 rounded-full border-4 border-white animate-bounce"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-blue-600">Survei Lapangan Sedang Berlangsung</p>
                                        <p class="text-xs text-gray-500 mt-1">Tim teknis sedang melakukan verifikasi data di lokasi lahan.</p>
                                    </div>
                                @elseif(in_array($proposal->status, ['survei_selesai', 'menunggu_approval_ba', 'disetujui']) || ($proposal->status === 'ditolak' && $surveyAssignment))
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Survei Lapangan Selesai</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->cpclVerifications->last()?->created_at?->translatedFormat('d M Y - H:i') ?? '-' }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Data lapangan telah diambil dan dimasukkan ke sistem.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Pelaksanaan Survei</p></div>
                                @endif
                            </div>
                            @endif

                            {{-- 6. Berita Acara / Rekomendasi --}}
                            @if($proposal->status !== 'ditolak' || $beritaAcara)
                            <div class="relative">
                                @if($beritaAcara)
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Laporan Hasil Survei</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $beritaAcara->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">Berita Acara dan rekomendasi teknis telah diterbitkan.</p>
                                    </div>
                                @elseif($proposal->status === 'survei_selesai')
                                    <div class="absolute -left-[21px] bg-orange-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-orange-600">Penyusunan Berita Acara</p>
                                        <p class="text-xs text-gray-400">Tim sedang menyusun laporan hasil pemeriksaan lapangan.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Laporan & Rekomendasi</p></div>
                                @endif
                            </div>
                            @endif

                            {{-- 7. Final Decision --}}
                            @if($proposal->status !== 'ditolak' || ($proposal->status === 'ditolak' && $proposal->decided_at && $beritaAcara))
                            <div class="relative">
                                @if($proposal->status === 'disetujui')
                                    <div class="absolute -left-[21px] bg-green-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-green-700">Proposal Disetujui 🎉</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $proposal->pimpinan_notes ?? 'Keputusan akhir telah diambil oleh Pimpinan DTPH.' }}</p>
                                    </div>
                                @elseif($proposal->status === 'ditolak')
                                    <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-red-600">Proses Dihentikan</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ ($proposal->decided_at ?? $proposal->reviewed_at ?? $proposal->updated_at)->translatedFormat('d M Y - H:i') }} WIB</p>
                                        <p class="text-xs text-red-500 mt-1">Pengajuan proposal ditolak dan tidak dapat dilanjutkan.</p>
                                    </div>
                                @elseif($proposal->status === 'menunggu_approval_ba')
                                    <div class="absolute -left-[21px] bg-purple-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-purple-700">Menunggu Keputusan Akhir</p>
                                        <p class="text-xs text-gray-400">Laporan sudah di meja Pimpinan untuk persetujuan final.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400">Keputusan Akhir</p></div>
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
