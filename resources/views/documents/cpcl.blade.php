<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Verifikasi CPCL</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.3; margin: 1cm 1cm; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-8 { margin-top: 2rem; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 1rem; }
        .table-bordered th, .table-bordered td { border: 1px solid black; padding: 4px 8px; vertical-align: top; }
        .table-borderless td { padding: 2px 4px; vertical-align: top; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    @php
        function terbilang($angka) {
            $angka = (int)$angka;
            $bilangan = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
            if ($angka < 12) {
                return $bilangan[$angka];
            } else if ($angka < 20) {
                return $bilangan[$angka - 10] . ' Belas';
            } else if ($angka < 100) {
                return $bilangan[floor($angka / 10)] . ' Puluh ' . $bilangan[$angka % 10];
            } else if ($angka < 200) {
                return 'Seratus ' . terbilang($angka - 100);
            } else if ($angka < 1000) {
                return $bilangan[floor($angka / 100)] . ' Ratus ' . terbilang($angka % 100);
            } else if ($angka < 2000) {
                return 'Seribu ' . terbilang($angka - 1000);
            } else if ($angka < 1000000) {
                return terbilang(floor($angka / 1000)) . ' Ribu ' . terbilang($angka % 1000);
            }
            return (string)$angka;
        }

        $assignment = $proposal->surveyAssignments->last();
        $cpcl = $proposal->cpclVerifications->last();
        $farmer = $proposal->user->farmerProfile;
        
        if ($assignment) {
            $date = $assignment->created_at;
            $hari = $date->isoFormat('dddd');
            $tgl_huruf = terbilang($date->format('j'));
            $bulan = $date->isoFormat('MMMM');
            $tahun_huruf = terbilang($date->format('Y'));
            $tgl_surat = $date->isoFormat('d MMMM Y');
            $nomor_surat = $assignment->nomor_surat ?? '-';
        } else {
            $hari = '......';
            $tgl_huruf = '......';
            $bulan = '......';
            $tahun_huruf = '......';
            $tgl_surat = '......';
            $nomor_surat = '......';
        }
    @endphp

    <div class="text-center mb-4">
        <h3 class="font-bold uppercase" style="margin: 0;">BERITA ACARA</h3>
        <h3 class="font-bold uppercase" style="margin-top: 2px;">VERIFIKASI CALON PETANI CALON LOKASI (CPCL)</h3>
    </div>

    <p style="text-align: justify; text-indent: 40px; margin-bottom: 10px;">
        Pada hari {{ $hari }}, Tanggal {{ $tgl_huruf }}, Bulan {{ $bulan }}, Tahun {{ $tahun_huruf }}, bertempat di Desa {{ $farmer->alamat ?? '......' }}, Kecamatan {{ $farmer->kecamatan ?? '......' }}, telah dilakukan verifikasi CPCL terhadap calon penerima bantuan :
    </p>

    <table class="table-borderless mb-2" style="margin-left: 50px; width: 80%;">
        <tr>
            <td style="width: 180px;">Nama Kelompok Tani</td>
            <td style="width: 10px;">:</td>
            <td>{{ $farmer->nama_kelompok ?? '-' }}</td>
        </tr>
        <tr>
            <td>Desa</td>
            <td>:</td>
            <td>{{ $farmer->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td>:</td>
            <td>{{ $farmer->kecamatan ?? '-' }}</td>
        </tr>
        <tr>
            <td>No. Surat Pengajuan</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>No. SK Kelompok Tani</td>
            <td>:</td>
            <td>{{ $farmer->nomor_sk ?? '-' }}</td>
        </tr>
    </table>

    <p style="text-align: justify; margin-bottom: 10px;">
        Yang dilakukan oleh petugas verifikasi CPCL berdasarkan Surat Tugas Kepala Dinas Tanaman Pangan dan Hortikultura Nomor : {{ $nomor_surat }} Tanggal {{ $tgl_surat }}, sebagai berikut :
    </p>

    <table class="table-borderless mb-4" style="margin-left: 50px; width: 80%;">
        @if($assignment && $assignment->team_members)
            @foreach($assignment->team_members as $member)
            <tr>
                <td style="width: 180px;">Nama</td>
                <td style="width: 10px;">:</td>
                <td>{{ $member['name'] }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $member['nip'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $member['role'] }}</td>
            </tr>
            <tr><td colspan="3" style="height: 10px;"></td></tr>
            @endforeach
        @else
            <tr>
                <td style="width: 180px;">Nama</td>
                <td style="width: 10px;">:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>-</td>
            </tr>
        @endif
    </table>

    <p style="margin-bottom: 5px;">Adapun hasil dari verifikasi CPCL sebagai berikut:</p>
    
    <p class="font-bold mb-2">A. Hasil Verifikasi Administrasi</p>
    <table class="table-bordered mb-4">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 45%">Uraian</th>
                <th style="width: 15%">Sesuai</th>
                <th style="width: 15%">Tidak Sesuai</th>
                <th style="width: 20%">Ket</th>
            </tr>
        </thead>
        <tbody>
            @php
                if($cpcl) {
                    $checks = [
                        ['Surat Permohonan', $cpcl->is_surat_permohonan_sesuai, $cpcl->ket_surat_permohonan],
                        ['Fotocopy KTP Ketua Kelompok dan Seluruh Anggota', $cpcl->is_ktp_sesuai, $cpcl->ket_ktp],
                        ['Fotocopy SK Kelompok Tani yang ditandatangani Kepala Desa', $cpcl->is_sk_desa_sesuai, $cpcl->ket_sk_desa],
                        ['Fotocopy atau Printout data Kelompok Tani di Sistem Informasi Penyuluh Pertanian (Simluhtan)', $cpcl->is_simluhtan_sesuai, $cpcl->ket_simluhtan],
                        ['Fotocopy Notula dan Daftar Hadir Rapat Kelompok Tani terkait permohonan bantuan', $cpcl->is_notula_rapat_sesuai, $cpcl->ket_notula_rapat],
                        ['Titik Koordinat lokasi usaha tani', $cpcl->is_titik_koordinat_sesuai, $cpcl->ket_titik_koordinat],
                        ['Tidak menerima bantuan yang sama dalam satu musim tanam', $cpcl->is_tidak_menerima_bantuan_sama, $cpcl->ket_tidak_menerima_bantuan_sama],
                    ];
                } else {
                    $checks = [
                        ['Surat Permohonan', null, ''],
                        ['Fotocopy KTP Ketua Kelompok dan Seluruh Anggota', null, ''],
                        ['Fotocopy SK Kelompok Tani yang ditandatangani Kepala Desa', null, ''],
                        ['Fotocopy atau Printout data Kelompok Tani di Sistem Informasi Penyuluh Pertanian (Simluhtan)', null, ''],
                        ['Fotocopy Notula dan Daftar Hadir Rapat Kelompok Tani terkait permohonan bantuan', null, ''],
                        ['Titik Koordinat lokasi usaha tani', null, ''],
                        ['Tidak menerima bantuan yang sama dalam satu musim tanam', null, ''],
                    ];
                }
            @endphp
            @foreach($checks as $idx => $chk)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $chk[0] }}</td>
                <td class="text-center">{{ $chk[1] === true || $chk[1] === 1 ? 'V' : '' }}</td>
                <td class="text-center">{{ $chk[1] === false || $chk[1] === 0 ? 'V' : '' }}</td>
                <td>{{ $chk[2] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="font-bold mb-2">B. Hasil Verifikasi Teknis</p>
    <table class="table-bordered mb-4">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 35%">Uraian</th>
                <th style="width: 30%">Fakta Lapangan</th>
                <th style="width: 30%">Ket</th>
            </tr>
        </thead>
        <tbody>
            @php
                $teknis = [
                    ['Status Kepemilikan Lahan', $cpcl?->status_kepemilikan ?? '', 'Milik Sendiri / Sewa / Pinjam Pakai'],
                    ['Luas Lahan', ($cpcl?->luas_lahan ?? '') . ($cpcl?->luas_lahan ? ' Ha' : ''), ''],
                    ['Jenis Tanah', '', ''],
                    ['Sumber Air Budidaya', '', 'Sungai/Kolam/Embung/Sumur'],
                    ['Kondisi Lahan', $cpcl?->kondisi_lahan ?? '', 'Semak Belukar/Bekas Budidaya'],
                    ['Rawan Bencana', '', 'Banjir/Kebakaran Hutan'],
                    ['Pemanfaatan Lahan Sebelumnya', '', ''],
                    ['Pengalaman Budidaya', '', ''],
                    ['Informasi Lainnya', $cpcl?->catatan ?? '', ''],
                ];
            @endphp
            @foreach($teknis as $idx => $item)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $item[0] }}</td>
                <td>{{ $item[1] }}</td>
                <td>{{ $item[2] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="font-bold mb-2 mt-4">b. Dokumentasi lapangan sebagai berikut :</p>
    <table class="table-borderless mb-2">
        <tr>
            <td style="width: 180px;">Petugas Dokumentasi</td>
            <td style="width: 10px;">:</td>
            <td>.........................................................</td>
        </tr>
        <tr>
            <td>Petugas Pemetaan</td>
            <td>:</td>
            <td>......................................................... <span style="margin-left: 20px;">No. HP : ..............................</span></td>
        </tr>
    </table>

    @php
        $foto_pemetaan = $proposal->surveyDocumentations()->where('keterangan', 'Foto Hasil Pemetaan Data')->first();
        $foto_lahan = $proposal->surveyDocumentations()->where('keterangan', 'Foto Lahan Survei CPCL')->first();
    @endphp
    
    <table class="table-bordered text-center mb-6" style="width: 100%;">
        <tr>
            <td style="width: 50%; height: 250px; vertical-align: middle;">
                @if($foto_pemetaan)
                    <img src="{{ public_path('storage/' . $foto_pemetaan->file_path) }}" style="max-height: 230px; max-width: 100%; object-fit: contain;">
                @else
                    <br/><br/><br/>[Area Foto Pemetaan Lahan]<br/><br/><br/>
                @endif
            </td>
            <td style="width: 50%; height: 250px; vertical-align: middle;">
                @if($foto_lahan)
                    <img src="{{ public_path('storage/' . $foto_lahan->file_path) }}" style="max-height: 230px; max-width: 100%; object-fit: contain;">
                @else
                    <br/><br/><br/>[Area Foto Lahan]<br/><br/><br/>
                @endif
            </td>
        </tr>
        <tr>
            <td class="font-bold">Foto 1 : Hasil Pemetaan Lahan</td>
            <td class="font-bold">Foto 2 : Lahan</td>
        </tr>
    </table>

    <p style="margin-bottom: 1.5rem;">Demikian berita acara verifikasi CPCL ini dibuat dan ditandatangani.</p>

    <p class="font-bold">Petugas Verifikasi CPCL :</p>
    <table class="table-borderless mb-4" style="width: 100%; margin-left: 10px;">
        @if($assignment && $assignment->team_members)
            @foreach($assignment->team_members as $idx => $member)
            <tr>
                <td style="width: 5%; vertical-align: bottom;">{{ $idx + 1 }}.</td>
                <td style="width: 45%; vertical-align: bottom;">{{ $member['name'] }}</td>
                <td style="width: 50%; border-bottom: 1px solid black; height: 30px;"></td>
            </tr>
            @endforeach
        @else
            <tr>
                <td style="width: 5%; vertical-align: bottom;">1.</td>
                <td style="width: 45%; vertical-align: bottom;">.............................................</td>
                <td style="width: 50%; border-bottom: 1px solid black; height: 30px;"></td>
            </tr>
        @endif
    </table>

    <p class="font-bold mt-6">Penyuluh Pertanian Lapangan</p>
    <table class="table-borderless mb-4" style="width: 100%; margin-left: 10px;">
        <tr>
            <td style="width: 5%; vertical-align: bottom;">1.</td>
            <td style="width: 45%; vertical-align: bottom;">.............................................</td>
            <td style="width: 50%; border-bottom: 1px solid black; height: 30px;"></td>
        </tr>
    </table>

    <p class="font-bold mt-6">Pengurus Gapoktan/Poktan</p>
    <table class="table-borderless mb-4" style="width: 100%; margin-left: 10px;">
        <tr>
            <td style="width: 5%; vertical-align: bottom;">1.</td>
            <td style="width: 45%; vertical-align: bottom;">.............................................</td>
            <td style="width: 50%; border-bottom: 1px solid black; height: 30px;"></td>
        </tr>
    </table>

</body>
</html>
