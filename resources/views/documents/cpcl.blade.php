<x-app-layout>
    <x-slot name="header">Rangkuman Hasil Verifikasi CPCL</x-slot>

    <div class="max-w-7xl mx-auto space-y-6 pb-10">

        {{-- Page Header --}}
        <div class="flex items-center justify-between mt-2 no-print">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 leading-tight">Rangkuman Hasil Verifikasi CPCL</h2>
                <p class="text-gray-500 text-sm mt-1">Data komprehensif hasil temuan tim survei di lapangan.</p>
            </div>
        </div>

        @php
            $cpcl = $proposal->cpclVerifications->last();
            $assignment = $proposal->surveyAssignments->last();
            $farmer = $proposal->user->farmerProfile;
        @endphp

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden print-card">
            
            <div class="p-5 sm:p-8 space-y-8">

                <!-- Header Info (Print Only) -->
                <div class="hidden print-header text-center border-b border-gray-200 pb-6 mb-6">
                    <h3 class="font-bold uppercase text-xl">RANGKUMAN HASIL SURVEI</h3>
                    <h3 class="font-bold uppercase text-lg">CALON PETANI CALON LOKASI (CPCL)</h3>
                    <p class="mt-4 text-sm text-gray-600">Nomor Registrasi: #PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm text-gray-600">Kelompok Tani: {{ $farmer->nama_kelompok ?? '-' }}</p>
                </div>

                <!-- A. Verifikasi Administrasi -->
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h4 class="text-lg font-bold text-gray-900">A. Hasil Verifikasi Administrasi</h4>
                </div>

                @php
                    $checklist = [
                        ['label' => '1. Surat Permohonan', 'value' => $cpcl?->is_surat_permohonan_sesuai, 'ket' => $cpcl?->ket_surat_permohonan],
                        ['label' => '2. Fotocopy KTP Ketua Kelompok dan Seluruh Anggota', 'value' => $cpcl?->is_ktp_sesuai, 'ket' => $cpcl?->ket_ktp],
                        ['label' => '3. Fotocopy SK Kelompok Tani (TTD Kepala Desa)', 'value' => $cpcl?->is_sk_desa_sesuai, 'ket' => $cpcl?->ket_sk_desa],
                        ['label' => '4. Data Poktan di Simluhtan', 'value' => $cpcl?->is_simluhtan_sesuai, 'ket' => $cpcl?->ket_simluhtan],
                        ['label' => '5. Notula dan Daftar Hadir Rapat', 'value' => $cpcl?->is_notula_rapat_sesuai, 'ket' => $cpcl?->ket_notula_rapat],
                        ['label' => '6. Titik Koordinat lokasi usaha tani', 'value' => $cpcl?->is_titik_koordinat_sesuai, 'ket' => $cpcl?->ket_titik_koordinat],
                        ['label' => '7. Tidak menerima bantuan sama dalam 1 musim', 'value' => $cpcl?->is_tidak_menerima_bantuan_sama, 'ket' => $cpcl?->ket_tidak_menerima_bantuan_sama],
                    ];
                @endphp

                <div class="overflow-x-auto border border-gray-100 rounded-xl mb-8">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Uraian</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($checklist as $item)
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">{{ $item['label'] }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($item['value'] === true || $item['value'] === 1)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Sesuai
                                        </span>
                                    @elseif($item['value'] === false || $item['value'] === 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            Tidak Sesuai
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $item['ket'] ?: '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- B. Aspek Teknis & Lahan -->
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h4 class="text-lg font-bold text-gray-900">B. Aspek Teknis & Lahan</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Kepemilikan Lahan</p>
                        <p class="text-gray-900 font-bold text-base">{{ $cpcl?->status_kepemilikan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Luas Lahan</p>
                        <p class="text-gray-900 font-bold text-base">{{ $cpcl?->luas_lahan ?? '0' }} <span class="text-sm font-medium text-gray-500">Hektar</span></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Jenis Tanah</p>
                        <p class="text-gray-900 font-medium">{{ $cpcl?->jenis_tanah ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Sumber Air Budidaya</p>
                        <p class="text-gray-900 font-medium">{{ $cpcl?->sumber_air ?: '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kondisi Lahan</p>
                        <p class="text-gray-900 font-medium">{{ $cpcl?->kondisi_lahan ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rawan Bencana</p>
                        <p class="text-gray-900 font-medium">{{ $cpcl?->rawan_bencana ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pemanfaatan Lahan Sebelumnya</p>
                        <p class="text-gray-900 font-medium">{{ $cpcl?->pemanfaatan_lahan_sebelumnya ?: '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pengalaman Budidaya</p>
                        <p class="text-gray-900 font-medium">{{ $cpcl?->pengalaman_budidaya ?: '-' }}</p>
                    </div>
                </div>

                <!-- C. Kesesuaian & Rekomendasi Lapangan -->
                <div class="border-b border-gray-100 pb-4 mb-4 pt-6">
                    <h4 class="text-lg font-bold text-gray-900">C. Kesesuaian & Rekomendasi Lapangan</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 mb-6">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kesesuaian Komoditas</p>
                        @if($cpcl?->kesesuaian_komoditas)
                            <p class="text-green-600 font-bold text-base flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Sesuai (Layak)
                            </p>
                        @else
                            <p class="text-red-600 font-bold text-base flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Tidak Sesuai
                            </p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rekomendasi Tim Survei</p>
                        <p class="text-blue-600 font-bold text-base">{{ $cpcl?->rekomendasi_surveyor ?: '-' }}</p>
                    </div>
                    <div class="sm:col-span-2 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Informasi Lainnya (Catatan)</p>
                        <p class="text-gray-700 italic text-sm">{{ $cpcl?->catatan ?: 'Tidak ada catatan tambahan.' }}</p>
                    </div>
                </div>

                <!-- D. Dokumentasi Lapangan -->
                <div class="border-b border-gray-100 pb-4 mb-4 pt-4">
                    <h4 class="text-lg font-bold text-gray-900">D. Dokumentasi Lapangan</h4>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Petugas Dokumentasi</p>
                        <p class="text-gray-900 font-medium">{{ $cpcl?->petugas_dokumentasi ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Petugas Pemetaan</p>
                        <p class="text-gray-900 font-medium">{{ $cpcl?->petugas_pemetaan ?: '-' }} <span class="text-gray-400 text-sm ml-2">({{ $cpcl?->no_hp_pemetaan ?: '-' }})</span></p>
                    </div>
                </div>

                @php
                    $foto_pemetaan = $proposal->surveyDocumentations()->where('keterangan', 'Foto Hasil Pemetaan Data')->first();
                    $foto_lahan = $proposal->surveyDocumentations()->where('keterangan', 'Foto Lahan Survei CPCL')->first();
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-center flex flex-col items-center justify-center">
                        <p class="text-sm font-bold text-gray-600 mb-4">Foto Hasil Pemetaan Lahan</p>
                        @if($foto_pemetaan)
                            <img src="{{ Storage::url($foto_pemetaan->file_path) }}" class="rounded-lg max-h-64 object-contain shadow-sm border border-gray-200 bg-white">
                        @else
                            <div class="w-full h-40 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <span class="text-gray-400 text-sm font-medium">Tidak ada foto pemetaan</span>
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-center flex flex-col items-center justify-center">
                        <p class="text-sm font-bold text-gray-600 mb-4">Foto Lahan / Bukti Survei</p>
                        @if($foto_lahan)
                            <img src="{{ Storage::url($foto_lahan->file_path) }}" class="rounded-lg max-h-64 object-contain shadow-sm border border-gray-200 bg-white">
                        @else
                            <div class="w-full h-40 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <span class="text-gray-400 text-sm font-medium">Tidak ada foto lahan</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                @if($cpcl && $cpcl->dokumen_fisik_path)
                <div class="mt-8 p-4 bg-primary-50 rounded-xl border border-primary-100 flex items-center justify-between no-print">
                    <div>
                        <p class="font-bold text-primary-900 text-sm">Dokumen Fisik CPCL</p>
                        <p class="text-xs text-primary-700">Scan dokumen Berita Acara yang telah ditandatangani.</p>
                    </div>
                    <a href="{{ Storage::url($cpcl->dokumen_fisik_path) }}" target="_blank" class="px-4 py-2 bg-white border border-primary-200 text-primary-700 text-xs font-bold rounded-lg hover:bg-primary-100 transition-colors">
                        Lihat Dokumen
                    </a>
                </div>
                @endif
                
            </div>
            
            <div class="bg-gray-50 px-5 sm:px-8 py-5 border-t border-gray-100 flex justify-end gap-3 no-print">
                <button onclick="history.back()" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm shadow-sm">
                    Kembali
                </button>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.proposals.cpcl.edit', $proposal) }}" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit CPCL
                </a>
                @endif
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background-color: white !important; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            nav, header { display: none !important; }
            .max-w-7xl { max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .print-card { border: none !important; box-shadow: none !important; }
            .print-header { display: block !important; }
            .bg-gray-50 { background-color: white !important; border-color: #f3f4f6 !important; }
            /* Force page break inside avoidance for cards */
            .grid > div { page-break-inside: avoid; }
        }
    </style>
</x-app-layout>
