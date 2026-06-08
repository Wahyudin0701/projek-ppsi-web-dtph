<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita Acara Verifikasi CPCL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50 pt-8">
    <div class="max-w-4xl mx-auto space-y-6 pb-10 px-4 sm:px-6">

        @if(session('error'))
            <div class="bg-red-50 text-red-700 p-4 rounded-xl border border-red-200 mt-6 no-print">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl border border-green-200 mt-6 no-print">
                {{ session('success') }}
            </div>
        @endif

        @php
            $cpcl = $proposal->cpclVerifications->last();
            $assignment = $proposal->surveyAssignments->last();
            $farmer = $proposal->user->farmerProfile;
            $ba = $proposal->beritaAcara;
            
            function terbilang($angka) {
                $angka = abs($angka);
                $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                $terbilang = "";
                if ($angka < 12) {
                    $terbilang = " " . $baca[$angka];
                } else if ($angka < 20) {
                    $terbilang = terbilang($angka - 10) . " Belas";
                } else if ($angka < 100) {
                    $terbilang = terbilang((int)($angka / 10)) . " Puluh" . terbilang($angka % 10);
                } else if ($angka < 200) {
                    $terbilang = " Seratus" . terbilang($angka - 100);
                } else if ($angka < 1000) {
                    $terbilang = terbilang((int)($angka / 100)) . " Ratus" . terbilang($angka % 100);
                } else if ($angka < 2000) {
                    $terbilang = " Seribu" . terbilang($angka - 1000);
                } else if ($angka < 1000000) {
                    $terbilang = terbilang((int)($angka / 1000)) . " Ribu" . terbilang($angka % 1000);
                }
                return $terbilang;
            }

            $hari = $ba ? $ba->survey_date->translatedFormat('l') : '-';
            $tanggalTerbilang = $ba ? trim(terbilang($ba->survey_date->format('j'))) : '-';
            $bulan = $ba ? $ba->survey_date->translatedFormat('F') : '-';
            $tahunTerbilang = $ba ? trim(terbilang($ba->survey_date->format('Y'))) : '-';
        @endphp

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden print-card">
            
            <div class="p-5 sm:p-8 space-y-8">

                <!-- Header Info -->
                <div class="text-center border-b border-gray-200 pb-6 mb-6">
                    <h3 class="font-bold uppercase text-xl tracking-wide text-gray-900">BERITA ACARA</h3>
                    <h3 class="font-bold uppercase text-lg tracking-wide text-gray-800 mt-1">VERIFIKASI CALON PETANI CALON LOKASI (CPCL)</h3>
                </div>

                <!-- Prolog Berita Acara -->
                <div class="text-gray-800 text-sm md:text-base leading-relaxed space-y-4">
                    <p class="indent-8 text-justify">
                        Pada hari <strong>{{ $hari }}</strong>, Tanggal <strong>{{ $tanggalTerbilang }}</strong>, Bulan <strong>{{ $bulan }}</strong>, Tahun <strong>{{ $tahunTerbilang }}</strong>, bertempat di Desa <strong>{{ ucwords(strtolower($farmer->alamat ?? '-')) }}</strong>, Kecamatan <strong>{{ ucwords(strtolower($farmer->kecamatan ?? '-')) }}</strong>, telah dilakukan verifikasi CPCL terhadap calon penerima bantuan :
                    </p>
                    
                    <div class="pl-0 sm:pl-8 space-y-4 my-6">
                        <table class="w-full text-sm">
                            <tr>
                                <td class="w-48 py-1">Nama Kelompok Tani</td>
                                <td class="w-4">:</td>
                                <td class="font-bold">{{ $farmer->nama_kelompok ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">ID Poktan</td>
                                <td>:</td>
                                <td>{{ $farmer->id_poktan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Ketua Kelompok</td>
                                <td>:</td>
                                <td>{{ $farmer->ketua ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Desa</td>
                                <td>:</td>
                                <td>{{ ucwords(strtolower($farmer->alamat ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Kecamatan</td>
                                <td>:</td>
                                <td>{{ ucwords(strtolower($farmer->kecamatan ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">No. Surat Pengajuan</td>
                                <td>:</td>
                                <td>{{ $proposal->no_surat_pengajuan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">No. SK Kelompok Tani</td>
                                <td>:</td>
                                <td>{{ $farmer->no_sk ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <p class="indent-8 text-justify">
                        Yang dilakukan oleh petugas verifikasi CPCL berdasarkan Surat Tugas Kepala Dinas Tanaman Pangan dan Hortikultura Nomor : <strong>{{ $assignment->nomor_surat ?? '-' }}</strong> Tanggal <strong>{{ $assignment ? $assignment->valid_from->translatedFormat('d F Y') : '-' }}</strong>, sebagai berikut :
                    </p>

                    <div class="pl-0 sm:pl-8 space-y-4 mt-2">
                        @if($assignment && is_array($assignment->team_members))
                            @foreach($assignment->team_members as $member)
                            <table class="w-full text-sm">
                                <tr>
                                    <td class="w-48 py-0.5">Nama</td>
                                    <td class="w-4">:</td>
                                    <td class="font-bold">{{ $member['name'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-0.5">NIP</td>
                                    <td>:</td>
                                    <td>{{ $member['nip'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-0.5">Jabatan</td>
                                    <td>:</td>
                                    <td>{{ $member['role'] ?? '-' }}</td>
                                </tr>
                            </table>
                            @endforeach
                        @else
                            <p class="text-gray-500 italic">Data petugas tidak ditemukan.</p>
                        @endif
                    </div>

                    <p class="mt-4 text-justify">
                        Adapun hasil dari verifikasi CPCL sebagai berikut:
                    </p>
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

                <div class="overflow-x-auto border border-gray-100 rounded-xl mb-8">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 w-1/2">Parameter</th>
                                <th class="px-4 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">Status Kepemilikan Lahan</td>
                                <td class="px-4 py-3 text-gray-600 font-bold">{{ $cpcl?->status_kepemilikan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">Luas Lahan</td>
                                <td class="px-4 py-3 text-gray-600 font-bold">{{ $cpcl?->luas_lahan ?? '0' }} <span class="text-xs font-normal text-gray-500">Hektar</span></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">Jenis Tanah</td>
                                <td class="px-4 py-3 text-gray-600">{{ $cpcl?->jenis_tanah ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">Sumber Air Budidaya</td>
                                <td class="px-4 py-3 text-gray-600">{{ $cpcl?->sumber_air ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">Kondisi Lahan</td>
                                <td class="px-4 py-3 text-gray-600">{{ $cpcl?->kondisi_lahan ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">Rawan Bencana</td>
                                <td class="px-4 py-3 text-gray-600">{{ $cpcl?->rawan_bencana ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">Pemanfaatan Lahan Sebelumnya</td>
                                <td class="px-4 py-3 text-gray-600">{{ $cpcl?->pemanfaatan_lahan_sebelumnya ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-gray-900 font-medium">Pengalaman Budidaya</td>
                                <td class="px-4 py-3 text-gray-600">{{ $cpcl?->pengalaman_budidaya ?: '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
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
            
            <div x-data="{ showConfirmModal: false }" class="bg-gray-50 px-5 sm:px-8 py-5 border-t border-gray-100 flex justify-end gap-3 no-print">
                <button onclick="history.back()" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm shadow-sm">
                    Kembali
                </button>
                @if(auth()->user()->isKabid())
                    @if(!in_array($proposal->status, ['menunggu_keputusan_akhir', 'disetujui', 'ditolak']))
                    <button @click="showConfirmModal = true" type="button" class="px-6 py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-colors text-sm flex items-center gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Teruskan ke Pimpinan
                    </button>

                    <!-- Modal Confirmation -->
                    <div x-show="showConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
                        <div @click.away="showConfirmModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 mx-4 transform transition-all"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                             
                            <div class="flex items-center justify-center w-14 h-14 mx-auto bg-green-100 rounded-full mb-5">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            
                            <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Konfirmasi Penerusan</h3>
                            <p class="text-sm text-center text-gray-600 leading-relaxed mb-8">
                                Anda yakin ingin meneruskan proposal ini ke Pimpinan? <br>
                                <span class="font-bold text-red-500 mt-2 block">Pastikan dokumen fisik scan Berita Acara telah diunggah dan seluruh data sudah benar.</span>
                            </p>
                            
                            <div class="flex justify-center gap-3">
                                <button @click="showConfirmModal = false" type="button" class="flex-1 px-5 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors text-sm">
                                    Batal
                                </button>
                                <form action="{{ route('kabid.berita-acara.approve', $proposal) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-5 py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-colors text-sm shadow-sm">
                                        Ya, Teruskan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('kabid.proposals.cpcl.edit', $proposal) }}" class="px-6 py-3 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 transition-colors text-sm flex items-center gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit CPCL
                    </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
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
</body>
</html>
