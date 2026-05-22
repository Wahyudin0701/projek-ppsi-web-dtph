<x-app-layout>
    <x-slot name="header">Detail Proposal</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">

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

        {{-- Header Card --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <h2 class="text-xl font-extrabold text-gray-800">
                        {{ $proposal->program?->name ?? $proposal->alsintan?->name ?? 'Proposal' }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $proposal->user->farmerProfile?->nama_kelompok ?? $proposal->user->name }}
                        &bull; {{ $proposal->submission_date?->format('d F Y') }}
                    </p>
                </div>
                @php
                    $badgeColor = match($proposal->status) {
                        'didisposisi_kabid'        => 'bg-amber-100 text-amber-700',
                        'surat_tugas_terbit'       => 'bg-blue-100 text-blue-700',
                        'survei_selesai'           => 'bg-orange-100 text-orange-700',
                        'menunggu_approval_ba'     => 'bg-purple-100 text-purple-700',
                        'disetujui'                => 'bg-green-100 text-green-700',
                        'ditolak'                  => 'bg-red-100 text-red-700',
                        default                    => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <span class="text-sm font-bold px-4 py-2 rounded-full {{ $badgeColor }}">{{ $proposal->statusLabel }}</span>
            </div>
        </div>

        {{-- Info Proposal --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-extrabold text-gray-800 mb-4">Informasi Proposal</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Jenis Pengajuan</dt>
                    <dd class="font-semibold text-gray-700 mt-1">{{ $proposal->alsintan_id ? 'Peminjaman Alsintan' : 'Program Bantuan' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Lokasi Lahan</dt>
                    <dd class="font-semibold text-gray-700 mt-1">{{ $proposal->lokasi_lahan }}</dd>
                </div>
                @if($proposal->alsintan_id)
                <div class="sm:col-span-2">
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Rencana Durasi Pemakaian Alat</dt>
                    <dd class="font-bold text-[#19A148] mt-1">{{ $proposal->rencana_durasi_hari ?? '-' }} Hari</dd>
                </div>
                @endif
                @if($proposal->latestDispositionLog)
                <div class="sm:col-span-2">
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wide">Catatan Disposisi Pimpinan</dt>
                    <dd class="font-semibold text-gray-700 mt-1">{{ $proposal->latestDispositionLog->instruction ?? '-' }}</dd>
                </div>
                @endif
            </dl>
        </div>

        {{-- FASE 4: Pembentukan Tim Survei --}}
        @if($proposal->status === 'didisposisi_kabid')
        <div class="bg-amber-50 rounded-3xl border border-amber-200 p-6" x-data="{ open: true, members: [{name: '', role: 'Ketua Tim'}] }">
            <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                <h3 class="font-extrabold text-amber-800 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Tindakan: Bentuk Tim Survei
                </h3>
                <svg class="w-4 h-4 text-amber-500 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>

            <div x-show="open" x-transition class="mt-5">
                <form action="{{ route('kabid.proposals.assign-team', $proposal) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-amber-700 uppercase tracking-wide mb-2">Berlaku Dari *</label>
                            <input type="date" name="valid_from" required class="w-full border border-amber-200 rounded-xl px-4 py-3 text-sm font-semibold bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-amber-700 uppercase tracking-wide mb-2">Berlaku Sampai *</label>
                            <input type="date" name="valid_until" required class="w-full border border-amber-200 rounded-xl px-4 py-3 text-sm font-semibold bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-amber-700 uppercase tracking-wide mb-2">Anggota Tim Survei *</label>
                        <div class="space-y-3">
                            <template x-for="(member, index) in members" :key="index">
                                <div class="flex gap-3">
                                    <input type="text" x-model="member.name" :name="'team_members['+index+'][name]'" required placeholder="Nama Lengkap" class="flex-1 border border-amber-200 rounded-xl px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <input type="text" x-model="member.role" :name="'team_members['+index+'][role]'" required placeholder="Jabatan (Ketua/Anggota)" class="w-40 border border-amber-200 rounded-xl px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <button type="button" @click="members.splice(index, 1)" x-show="members.length > 1" class="px-3 py-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <button type="button" @click="members.push({name: '', role: 'Anggota'})" class="mt-3 text-sm font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1">
                            <span>+ Tambah Anggota</span>
                        </button>
                    </div>

                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-extrabold py-3 rounded-2xl transition-all">
                        Simpan Tim & Minta Admin Terbitkan Surat Tugas
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Survey Team Info --}}
        @if($proposal->surveyAssignments->isNotEmpty())
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-extrabold text-gray-800 mb-4">Data Surat Tugas & Tim Survei</h3>
            @foreach($proposal->surveyAssignments as $assignment)
            <div class="p-4 bg-blue-50 rounded-2xl mb-4 last:mb-0 border border-blue-100">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-bold text-sm text-gray-800">Nomor: {{ $assignment->nomor_surat }}</p>
                        <p class="text-xs text-gray-500">Masa Berlaku: {{ $assignment->valid_from->format('d M Y') }} s/d {{ $assignment->valid_until->format('d M Y') }}</p>
                    </div>
                    <span class="bg-blue-200 text-blue-800 text-xs font-bold px-2 py-1 rounded">Aktif</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Anggota Tim:</p>
                    <ul class="space-y-1">
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
        @endif

        {{-- CPCL Verification Data --}}
        @if($proposal->cpclVerifications->isNotEmpty())
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-extrabold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Hasil Verifikasi CPCL
                </h3>
                @if($proposal->status === 'survei_selesai' && !$proposal->beritaAcara)
                <a href="{{ route('kabid.berita-acara.create', $proposal) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Berita Acara
                </a>
                @endif
            </div>
            @foreach($proposal->cpclVerifications as $cpcl)
            <div class="bg-orange-50 rounded-2xl p-5 border border-orange-100 mb-4 last:mb-0">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Status Kepemilikan</p>
                        <p class="font-semibold text-gray-800">{{ $cpcl->status_kepemilikan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Luas Lahan</p>
                        <p class="font-semibold text-gray-800">{{ $cpcl->luas_lahan ?? '-' }} Ha</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Kondisi Lahan</p>
                        <p class="font-semibold text-gray-800">{{ $cpcl->kondisi_lahan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Kesesuaian Komoditas</p>
                        <p class="font-semibold {{ $cpcl->kesesuaian_komoditas ? 'text-green-700' : 'text-red-600' }}">
                            {{ $cpcl->kesesuaian_komoditas ? 'Sesuai ✓' : 'Tidak Sesuai ✗' }}
                        </p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Rekomendasi Surveyor</p>
                        <p class="font-semibold text-gray-800">{{ $cpcl->rekomendasi_surveyor ?? '-' }}</p>
                    </div>
                    @if($cpcl->catatan)
                    <div class="col-span-2 sm:col-span-3">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Catatan</p>
                        <p class="text-gray-700 text-sm bg-white p-3 rounded-xl border border-orange-100">{{ $cpcl->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            {{-- Foto Survei --}}
            @if($proposal->surveyDocumentations->isNotEmpty())
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Dokumentasi Foto Lapangan</p>
                <div class="grid grid-cols-3 gap-3">
                    @foreach($proposal->surveyDocumentations as $doc)
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200 hover:opacity-80 transition-opacity">
                        <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->keterangan }}" class="w-full h-24 object-cover">
                        @if($doc->keterangan)<p class="text-[10px] text-gray-500 font-semibold px-2 py-1 bg-white">{{ $doc->keterangan }}</p>@endif
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @elseif($proposal->status === 'survei_selesai')
        <div class="bg-orange-50 rounded-3xl border border-orange-200 p-6 text-center">
            <svg class="w-10 h-10 text-orange-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="font-bold text-orange-700">Data CPCL Belum Diinput Admin</p>
            <p class="text-sm text-orange-600 mt-1">Admin sedang menginput hasil survei lapangan ke sistem.</p>
        </div>
        @endif

        {{-- Berita Acara Preview --}}
        @if($proposal->beritaAcara)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-extrabold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Berita Acara Survei
                </h3>
                <div class="flex items-center gap-3">
                    <a href="{{ route('documents.berita-acara', $proposal) }}" target="_blank" class="text-sm text-primary-600 font-bold hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak PDF
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('kabid.berita-acara.show', $proposal) }}" class="text-sm text-amber-600 font-bold hover:underline">Lihat Detail →</a>
                </div>
            </div>
            @php $ba = $proposal->beritaAcara; @endphp
            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase">Tanggal Survei</dt>
                    <dd class="font-semibold text-gray-700 mt-1">{{ $ba->survey_date->format('d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase">Rekomendasi</dt>
                    <dd class="mt-1">
                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ $ba->recommendation === 'direkomendasikan' ? 'bg-green-100 text-green-700' : ($ba->recommendation === 'tidak_direkomendasikan' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $ba->recommendationLabel }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
        @endif
    </div>
</x-app-layout>
