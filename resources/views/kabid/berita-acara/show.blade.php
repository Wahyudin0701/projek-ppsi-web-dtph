<x-app-layout>
    <x-slot name="header">Berita Acara Survei</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        {{-- Action Buttons --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('kabid.proposals.show', $proposal) }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-amber-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Proposal
            </a>
            <a href="{{ route('documents.berita-acara', $proposal) }}" target="_blank"
               class="flex items-center gap-2 bg-primary-600 text-white font-bold text-sm px-5 py-2.5 rounded-2xl hover:bg-primary-700 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak PDF
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 space-y-6 print:shadow-none print:border-0">
            {{-- Header --}}
            <div class="text-center border-b border-gray-100 pb-6">
                <h1 class="text-2xl font-extrabold text-gray-900">BERITA ACARA SURVEI LAPANGAN</h1>
                <p class="text-sm text-gray-500 mt-1">Dinas Tanaman Pangan dan Hortikultura</p>
                <p class="text-xs text-gray-400 mt-1">Dibuat oleh: {{ $beritaAcara->kabid->name }} ({{ $beritaAcara->kabid->roleLabel }})</p>
            </div>

            {{-- Proposal Info --}}
            <div>
                <h2 class="font-extrabold text-gray-700 text-sm uppercase tracking-wide mb-3">Data Proposal</h2>
                <table class="w-full text-sm">
                    <tr class="border-b border-gray-50"><td class="py-2 text-gray-500 w-40">No. Proposal</td><td class="py-2 font-semibold">PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-2 text-gray-500">Nama Pengajuan</td><td class="py-2 font-semibold">{{ $proposal->program?->name ?? $proposal->alsintan?->name }}</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-2 text-gray-500">Pemohon</td><td class="py-2 font-semibold">{{ $proposal->user->farmerProfile?->nama_kelompok ?? $proposal->user->name }}</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-2 text-gray-500">Alamat Kelompok</td><td class="py-2 font-semibold">{{ $proposal->user->farmerProfile->alamat ?? '-' }}</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-2 text-gray-500">Tanggal Survei</td><td class="py-2 font-semibold">{{ $beritaAcara->survey_date->format('d F Y') }}</td></tr>
                    <tr><td class="py-2 text-gray-500">Lokasi Survei</td><td class="py-2 font-semibold">{{ $beritaAcara->location }}</td></tr>
                </table>
            </div>

            {{-- Hasil Verifikasi CPCL --}}
            @if($proposal->cpclVerifications->isNotEmpty())
            @php $cpcl = $proposal->cpclVerifications->last(); @endphp
            <div>
                <h2 class="font-extrabold text-gray-700 text-sm uppercase tracking-wide mb-3">Hasil Verifikasi Lapangan (CPCL)</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status Kepemilikan</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $cpcl->status_kepemilikan }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Luas Lahan</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $cpcl->luas_lahan }} Ha</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kondisi Lahan</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $cpcl->kondisi_lahan }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kesesuaian Komoditas</p>
                        <p class="text-sm font-bold {{ $cpcl->kesesuaian_komoditas ? 'text-green-600' : 'text-red-600' }}">
                            {{ $cpcl->kesesuaian_komoditas ? '✔ Sesuai (Layak)' : '✘ Tidak Sesuai' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Rekomendasi Surveyor</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $cpcl->rekomendasi_surveyor }}</p>
                    </div>
                    @if($cpcl->catatan)
                    <div class="sm:col-span-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Catatan Tambahan</p>
                        <p class="text-sm text-gray-600 italic">{{ $cpcl->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Dokumentasi Survei --}}
            @if($proposal->surveyDocumentations->isNotEmpty())
            <div>
                <h2 class="font-extrabold text-gray-700 text-sm uppercase tracking-wide mb-3">Dokumentasi Survei</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($proposal->surveyDocumentations as $index => $doc)
                    <div>
                        <p class="text-xs font-bold text-gray-500 mb-2">{{ $index + 1 }}. {{ $doc->keterangan ?? 'Foto Dokumentasi' }}</p>
                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200 hover:opacity-90 transition-opacity">
                            <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->keterangan }}" class="w-full h-48 object-cover">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Content --}}
            <div>
                <h2 class="font-extrabold text-gray-700 text-sm uppercase tracking-wide mb-3">Isi Berita Acara</h2>
                <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap border border-gray-100 rounded-2xl p-4 bg-gray-50">{{ $beritaAcara->content }}</div>
            </div>

            {{-- Recommendation --}}
            <div class="flex items-center justify-between p-5 rounded-2xl
                {{ $beritaAcara->recommendation === 'direkomendasikan' ? 'bg-green-50 border border-green-200' :
                   ($beritaAcara->recommendation === 'tidak_direkomendasikan' ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200') }}">
                <span class="font-bold text-sm text-gray-700">Rekomendasi Kepala Bidang:</span>
                <span class="font-extrabold text-base
                    {{ $beritaAcara->recommendation === 'direkomendasikan' ? 'text-green-700' :
                       ($beritaAcara->recommendation === 'tidak_direkomendasikan' ? 'text-red-700' : 'text-yellow-700') }}">
                    {{ $beritaAcara->recommendationLabel }}
                </span>
            </div>

            {{-- Attachment --}}
            @if($beritaAcara->attachment)
            <div>
                <a href="{{ Storage::url($beritaAcara->attachment) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    Lihat Lampiran
                </a>
            </div>
            @endif

            {{-- Signature area --}}
            <div class="grid grid-cols-2 gap-6 pt-6 border-t border-gray-100 text-sm text-center">
                <div>
                    <p class="text-gray-500 mb-16">Penyurvei</p>
                    <p class="font-bold text-gray-800 border-t border-gray-300 pt-2">Tim Survei</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-16">Kepala Bidang</p>
                    <p class="font-bold text-gray-800 border-t border-gray-300 pt-2">{{ $beritaAcara->kabid->name }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
