<x-app-layout>
    <x-slot name="header">Detail Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Pengajuan Proposal</h2>
                <p class="text-gray-500 text-sm mt-1">Tinjau informasi lengkap dan ambil keputusan untuk proposal ini.</p>
            </div>
            <a href="{{ route('kabid.proposals.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        {{-- Success / Error Alerts --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-4 text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-5 py-4 text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif

        @php
            $isAlsintan = $proposal->alsintan_id !== null;
            $sc = match($proposal->status) {
                'didisposisi_kabid'        => ['bg' => 'bg-amber-100 text-amber-700',    'label' => 'Disposisi ke Kabid'],
                'surat_tugas_terbit'       => ['bg' => 'bg-blue-100 text-blue-700',      'label' => 'Sedang Survei'],
                'survei_selesai'           => ['bg' => 'bg-orange-100 text-orange-700',  'label' => 'Survei Selesai'],
                'menunggu_review_kabid'    => ['bg' => 'bg-teal-100 text-teal-700',      'label' => 'Menunggu Review Kabid'],
                'menunggu_approval_ba'     => ['bg' => 'bg-purple-100 text-purple-700',  'label' => 'Menunggu Keputusan Akhir'],
                'disetujui'                => ['bg' => 'bg-green-100 text-green-700',    'label' => 'Disetujui'],
                'ditolak'                  => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Ditolak'],
                default                    => ['bg' => 'bg-gray-100 text-gray-600',       'label' => $proposal->statusLabel],
            };
        @endphp

        {{-- Summary Card --}}
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

            {{-- Summary Card Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-end sm:items-center">
                @if($proposal->file_proposal)
                    <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-50 border border-indigo-100 text-indigo-700 hover:bg-indigo-100 text-sm font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Lihat Proposal
                    </a>
                @endif

                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    @if($proposal->status === 'didisposisi_kabid')
                    <a href="{{ route('kabid.proposals.assign-team.form', $proposal) }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Buat Surat Tugas & Tim Survei
                    </a>
                @elseif($proposal->status === 'survei_selesai' && !$proposal->beritaAcara)
                    <span class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold {{ $sc['bg'] }} border border-transparent shadow-sm">
                        {{ $sc['label'] }} (Menunggu Admin)
                    </span>
                @elseif($proposal->status === 'menunggu_review_kabid' && $proposal->beritaAcara)
                    <div x-data="{ openConfirm: false }" class="inline w-full sm:w-auto">
                        <button type="button" @click="openConfirm = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-green-500 text-white text-sm font-bold rounded-xl hover:bg-green-600 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Teruskan ke Pimpinan
                        </button>

                        <div x-show="openConfirm" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-cloak>
                            <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="openConfirm = false" x-show="openConfirm" x-transition.opacity></div>
                            <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 relative z-10"
                                 x-show="openConfirm" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-90 translate-y-4">
                                
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4 text-blue-500">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Teruskan ke Pimpinan?</h3>
                                    <p class="text-gray-500 text-sm mb-6 leading-relaxed">Apakah Anda yakin meneruskan Berita Acara ini ke Pimpinan? Data CPCL akan <span class="font-bold text-gray-700">dikunci</span> dan masuk ke tahap Keputusan Akhir.</p>
                                    
                                    <div class="flex items-center gap-3 w-full">
                                        <button @click="openConfirm = false" type="button" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">Batal</button>
                                        <form action="{{ route('kabid.berita-acara.approve', $proposal) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-colors">
                                                Ya, Teruskan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($proposal->status === 'surat_tugas_terbit')

                    <a href="{{ route('kabid.proposals.cetak-form-cpcl', $proposal) }}" target="_blank"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Form CPCL
                    </a>
                    <a href="{{ route('kabid.proposals.cpcl.create', $proposal) }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Input CPCL
                    </a>
                @endif
            </div>
        </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Left Side: Main Info / Actions --}}
            <div class="md:col-span-2 space-y-6">

                @if($proposal->cpclVerifications->isNotEmpty() || $proposal->beritaAcara || $proposal->status === 'survei_selesai')
                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        Verifikasi Lapangan & Berita Acara
                    </h4>
                    <div class="space-y-4">
                        {{-- CPCL Verification Data --}}
                        @if($proposal->cpclVerifications->isNotEmpty())
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
                                <div class="w-full">
                                    @if($proposal->beritaAcara)
                                        @php 
                                            $ba = $proposal->beritaAcara; 
                                            $cpcl = $proposal->cpclVerifications->last();
                                        @endphp
                                        <div class="space-y-6">
                                            <div>
                                                <div class="flex items-center gap-2 mb-2.5">
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Rekomendasi Final</p>
                                                    <div class="w-1 h-1 rounded-full bg-gray-300"></div>
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $ba->survey_date->translatedFormat('d M Y') }}</p>
                                                </div>
                                                <span class="inline-block text-sm font-bold px-4 py-2 rounded-lg border {{ $ba->recommendation === 'direkomendasikan' ? 'bg-green-50 text-green-700 border-green-200' : ($ba->recommendation === 'tidak_direkomendasikan' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-amber-50 text-amber-700 border-amber-200') }}">
                                                    {{ $ba->recommendationLabel }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5">Hasil & Catatan Lapangan</p>
                                                <div class="bg-gray-50 rounded-xl p-4 text-gray-700 text-sm border border-gray-100">
                                                    {{ $cpcl?->catatan ?? 'Tidak ada catatan khusus dari tim lapangan.' }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2 shrink-0">
                                    @if(!in_array($proposal->status, ['menunggu_approval_ba', 'disetujui', 'ditolak']))
                                    <a href="{{ route('kabid.proposals.cpcl.edit', $proposal) }}" class="h-fit text-xs px-4 py-2 bg-blue-50 text-blue-600 rounded-lg font-bold hover:bg-blue-100 transition-colors flex items-center gap-1.5 shadow-sm border border-blue-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    @endif
                                    <a href="{{ route('documents.cpcl', $proposal) }}" class="h-fit text-xs px-4 py-2 bg-primary-50 text-primary-600 rounded-lg font-bold hover:bg-primary-100 transition-colors flex items-center gap-1.5 shadow-sm border border-primary-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Lihat Berita Acara
                                    </a>
                                </div>
                            </div>
                        </div>
                        @elseif($proposal->status === 'survei_selesai')
                        <div class="bg-orange-50/50 rounded-2xl border border-orange-200 p-8 text-center">
                            <svg class="w-10 h-10 text-orange-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="font-bold text-orange-700">Data CPCL Belum Diinput</p>
                            <p class="text-xs text-orange-500 mt-1 leading-relaxed">Hasil survei lapangan masih perlu diinput oleh Anda.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Survey Team Info --}}
                @if($proposal->surveyAssignments->isNotEmpty())
                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        Data Surat Tugas & Tim Survei
                    </h4>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                    @foreach($proposal->surveyAssignments as $assignment)
                    <div class="mb-6 last:mb-0">
                        <div class="flex flex-col sm:flex-row justify-between items-start mb-3 gap-4">
                            <div>
                                <p class="font-bold text-sm text-gray-800">Nomor: {{ $assignment->nomor_surat }}</p>
                                <p class="text-xs text-gray-400 font-semibold mt-1">Masa Berlaku: {{ $assignment->valid_from->format('d M Y') }} s/d {{ $assignment->valid_until->format('d M Y') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('kabid.proposals.cetak-surat-tugas', $proposal) }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-lg border border-gray-200 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Cetak Surat Tugas
                                </a>
                                @if($proposal->status === 'surat_tugas_terbit')
                                <a href="{{ route('kabid.proposals.assignment.edit', [$proposal, $assignment]) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-lg border border-amber-200 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Edit
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5">Anggota Tim:</p>
                            <ul class="space-y-2">
                                @foreach($assignment->team_members as $member)
                                <li class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    {{ $member['name'] }} <span class="text-gray-400 font-normal">({{ $member['role'] }})</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
                </div>
                @endif

                {{-- Informasi Pengaju (Farmer Info) --}}
                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        Informasi Pengaju
                    </h4>
                    <x-farmer-profile-detail :user="$proposal->user" />
                </div>

                {{-- Detail Pengajuan (Alsintan / Program) --}}
                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        {{ $isAlsintan ? 'Detail Alat yang Dipinjam' : 'Detail Program yang Diajukan' }}
                    </h4>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                    @if($isAlsintan)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
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
                                <p class="text-gray-900 font-semibold text-sm">{{ $proposal->alsintan->merk ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kapasitas</p>
                                <p class="text-gray-900 font-semibold text-sm">{{ $proposal->alsintan->capacity ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rencana Durasi Pemakaian</p>
                                <p class="text-amber-600 font-bold text-base">{{ $proposal->rencana_durasi_hari ?? '-' }} Hari</p>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
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
                                <p class="text-gray-900 font-semibold text-sm capitalize">{{ str_replace('_', ' ', $proposal->program->type) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Sasaran</p>
                                <p class="text-gray-900 font-semibold text-sm">{{ $proposal->program->sasaran ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kuota Program</p>
                                <p class="text-gray-900 font-semibold text-sm">{{ $proposal->program->kuota ?? '-' }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Admin Verification Notes --}}
                    @if($proposal->admin_notes)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Catatan Verifikasi Admin</p>
                        <p class="text-gray-700 font-medium text-sm bg-blue-50/50 p-4 rounded-xl border border-blue-100/50 leading-relaxed">{{ $proposal->admin_notes }}</p>
                    </div>
                    @endif

                    {{-- Pimpinan Disposition Notes --}}
                    @if($proposal->latestDispositionLog)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Catatan Disposisi Pimpinan</p>
                        <p class="text-gray-700 font-medium text-sm bg-amber-50/50 p-4 rounded-xl border border-amber-100/50 leading-relaxed">{{ $proposal->latestDispositionLog->notes ?? '-' }}</p>
                    </div>
                    @endif
                </div>
                </div>
            </div>

            {{-- Right Side: Timeline Sidebar --}}
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
                            'pending_verifikasi'     => 0,
                            'diteruskan_ke_pimpinan' => 1,
                            'didisposisi_kabid'      => 2,
                            'surat_tugas_terbit'     => 3,
                            'survei_selesai'         => 4,
                            'menunggu_review_kabid'  => 5,
                            'menunggu_approval_ba'   => 6,
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
                                <p class="text-xs text-gray-500 mt-0.5">Proposal berhasil dikirim oleh petani.</p>
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
                                    <p class="text-sm font-bold text-gray-900">Diverifikasi Admin</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Berkas dinyatakan lengkap & layak.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-yellow-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-yellow-600">Menunggu Verifikasi Admin</p>
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
                            @elseif($currentOrder >= 2 && $disposition)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Disposisi Pimpinan</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $disposition->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
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

                        {{-- 4. Surat Tugas / Penugasan Survei (hidden if rejected at/before disposisi, or approved without survey) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !($proposal->status === 'disetujui' && !$surveyAssignment))
                        <div class="relative">
                            @if(($currentOrder >= 3 || $rejectedAtFinal) && $surveyAssignment)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Sedang Survei</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $surveyAssignment->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Nomor: {{ $surveyAssignment->nomor_surat }}</p>
                                </div>
                            @elseif($proposal->status === 'didisposisi_kabid')
                                <div class="absolute -left-[21px] bg-amber-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-amber-600">Penugasan Tim Survei</p>
                                    <p class="text-xs text-gray-400">Menunggu {{ $kabidLabel }} membentuk tim.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Penugasan Survei</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 5. Pelaksanaan Survei (hidden if rejected at/before disposisi, or approved without survey) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !($proposal->status === 'disetujui' && !$surveyAssignment))
                        <div class="relative">
                            @if($proposal->status === 'surat_tugas_terbit')
                                <div class="absolute -left-[21px] bg-blue-500 w-3 h-3 rounded-full border-4 border-white animate-bounce"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-blue-600">Survei Sedang Jalan</p>
                                    <p class="text-xs text-gray-500">Menunggu input hasil CPCL offline.</p>
                                </div>
                            @elseif($currentOrder >= 4 || $rejectedAtFinal)
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

                        {{-- 6. Berita Acara (hidden if rejected at/before disposisi, or approved without survey) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !($proposal->status === 'disetujui' && !$surveyAssignment))
                        <div class="relative">
                            @if(($currentOrder >= 5 || $rejectedAtFinal) && $beritaAcara)
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

                        {{-- 7. Keputusan Akhir (hidden if rejected at/before disposisi) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi)
                        <div class="relative">
                            @if($proposal->status === 'disetujui')
                                <div class="absolute -left-[21px] bg-green-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-green-700">Proposal Disetujui ✓</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $proposal->pimpinan_notes ?? 'Keputusan telah diambil.' }}</p>
                                </div>
                            @elseif($rejectedAtFinal)
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak Pimpinan (Tahap Akhir)</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                </div>
                            @elseif($proposal->status === 'menunggu_approval_ba')
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
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Kontak Pengaju
                        </h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-amber-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Akun</p>
                                    <p class="text-sm font-black text-gray-900">{{ $proposal->user->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-amber-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email</p>
                                    <p class="text-sm font-black text-gray-900 break-all">{{ $proposal->user->email }}</p>
                                </div>
                            </div>
                            @if($proposal->user->farmerProfile && $proposal->user->farmerProfile->kontak)
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-amber-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">No. Telepon</p>
                                    <p class="text-sm font-black text-gray-900">{{ $proposal->user->farmerProfile->kontak }}</p>
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
