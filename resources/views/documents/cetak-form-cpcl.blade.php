<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form CPCL Blank - PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.5; color: #000; padding: 1cm; margin: 0; }
        .title { text-align: center; margin-bottom: 20px; }
        .title h3 { margin: 0; font-size: 11pt; font-weight: bold; text-transform: uppercase; }
        .content { margin-bottom: 20px; text-align: justify; }
        .info-table { margin-left: 30px; margin-bottom: 10px; }
        .info-table td { padding: 1px 5px; vertical-align: top; }
        .info-table td:first-child { width: 150px; }
        .table-check { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table-check th, .table-check td { border: 1px solid #000; padding: 4px 6px; text-align: left; vertical-align: middle; }
        .table-check th { text-align: center; font-weight: bold; }
        .section-title { font-weight: normal; margin-top: 5px; margin-bottom: 5px; }
        .photo-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .photo-table td { border: 1px solid #000; padding: 5px; text-align: left; height: 250px; width: 50%; vertical-align: bottom; }
    </style>
</head>
<body>
    <div class="title">
        <h3>BERITA ACARA</h3>
        <h3>VERIFIKASI CALON PETANI CALON LOKASI (CPCL)</h3>
    </div>

    <div class="content">
        @php
            $assignment = $proposal->surveyAssignments->last();
            
            if (!function_exists('terbilang')) {
                function terbilang($angka) {
                    $angka = abs((int)$angka);
                    $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                    $terbilang = "";
                    if ($angka < 12) {
                        $terbilang = " " . $baca[$angka];
                    } else if ($angka < 20) {
                        $terbilang = terbilang($angka - 10) . " Belas";
                    } else if ($angka < 100) {
                        $terbilang = terbilang($angka / 10) . " Puluh" . terbilang($angka % 10);
                    } else if ($angka < 200) {
                        $terbilang = " Seratus" . terbilang($angka - 100);
                    } else if ($angka < 1000) {
                        $terbilang = terbilang($angka / 100) . " Ratus" . terbilang($angka % 100);
                    } else if ($angka < 2000) {
                        $terbilang = " Seribu" . terbilang($angka - 1000);
                    } else if ($angka < 1000000) {
                        $terbilang = terbilang($angka / 1000) . " Ribu" . terbilang($angka % 1000);
                    }
                    return trim($terbilang);
                }
            }

            $dateToUse = $assignment ? $assignment->created_at : now();
            
            $hari = $dateToUse->translatedFormat('l');
            $tanggal = terbilang($dateToUse->format('d'));
            $bulan = $dateToUse->translatedFormat('F');
            $tahun = terbilang($dateToUse->format('Y'));
            
            // Menggunakan field alamat karena database tidak memiliki kolom desa
            $desa = !empty($proposal->user->farmerProfile->alamat) ? $proposal->user->farmerProfile->alamat : '....................';
            $kecamatan = !empty($proposal->user->farmerProfile->kecamatan) ? $proposal->user->farmerProfile->kecamatan : '....................';
            
            $noSk = !empty($assignment->no_sk_kelompok_tani) ? $assignment->no_sk_kelompok_tani : ($proposal->user->farmerProfile->no_sk ?? '-');
        @endphp

        <p style="text-indent: 40px; margin-bottom: 10px;">
            Pada hari {{ $hari }}, Tanggal {{ $tanggal }}, Bulan {{ $bulan }}, Tahun {{ $tahun }}, bertempat di Desa {{ $desa }}, Kecamatan {{ strtoupper($kecamatan) }}, telah dilakukan verifikasi CPCL terhadap calon penerima bantuan :
        </p>
        
        <table class="info-table">
            <tr>
                <td>Nama Kelompok Tani</td>
                <td>: {{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</td>
            </tr>
            <tr>
                <td>Desa</td>
                <td>: {{ !empty($proposal->user->farmerProfile->alamat) ? $proposal->user->farmerProfile->alamat : '-' }}</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>: {{ !empty($proposal->user->farmerProfile->kecamatan) ? strtoupper($proposal->user->farmerProfile->kecamatan) : '-' }}</td>
            </tr>
            <tr>
                <td>No. Surat Pengajuan</td>
                <td>: {{ $assignment->no_surat_pengajuan ?? '-' }}</td>
            </tr>
            <tr>
                <td>No. SK Kelompok Tani</td>
                <td>: {{ $noSk }}</td>
            </tr>
        </table>

        <p style="margin-bottom: 10px;">
            Yang dilakukan oleh petugas verifikasi CPCL berdasarkan Surat Tugas Kepala Dinas Tanaman Pangan dan Hortikultura Nomor : {{ $assignment ? $assignment->nomor_surat : '................' }} Tanggal {{ $assignment ? $assignment->created_at->translatedFormat('d F Y') : '................' }}, sebagai berikut :
        </p>

        <table class="info-table" style="margin-bottom: 10px;">
            @if($assignment && $assignment->team_members)
                @foreach($assignment->team_members as $member)
                <tr>
                    <td style="width: 100px;">Nama</td>
                    <td>: {{ $member['name'] }}</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>: {{ $member['nip'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 10px;">Jabatan</td>
                    <td style="padding-bottom: 10px;">: {{ $member['role'] ?? '-' }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td style="width: 100px;">Nama</td>
                    <td>: .......................................</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>: .......................................</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 10px;">Jabatan</td>
                    <td style="padding-bottom: 10px;">: .......................................</td>
                </tr>
            @endif
        </table>

        <p style="margin-bottom: 5px;">Adapun hasil dari verifikasi CPCL sebagai berikut:</p>

        <div class="section-title">A. Hasil Verifikasi Administrasi</div>
        <table class="table-check">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 45%;">Uraian</th>
                    <th style="width: 15%;">Sesuai</th>
                    <th style="width: 15%;">Tidak Sesuai</th>
                    <th style="width: 20%;">Ket</th>
                </tr>
            </thead>
            <tbody>
                <tr><td style="text-align: center;">1</td><td>Surat Permohonan</td><td></td><td></td><td></td></tr>
                <tr><td style="text-align: center;">2</td><td>Fotocopy KTP Ketua Kelompok dan Seluruh Anggota</td><td></td><td></td><td></td></tr>
                <tr><td style="text-align: center;">3</td><td>Fotocopy SK Kelompok Tani yang di tandatangani oleh Kepala Desa</td><td></td><td></td><td></td></tr>
                <tr><td style="text-align: center;">4</td><td>Fotocopy atau Printout data Kelompok Tani di Sistem Informasi Penyuluh Pertanian (Simluhtan)</td><td></td><td></td><td></td></tr>
                <tr><td style="text-align: center;">5</td><td>Fotocopy Notula dan Daftar Hadir Rapat Kelompok Tani terkait permohonan bantuan</td><td></td><td></td><td></td></tr>
                <tr><td style="text-align: center;">6</td><td>Titik Koordinat lokasi usaha tani</td><td></td><td></td><td></td></tr>
                <tr><td style="text-align: center;">7</td><td>Tidak menerima bantuan yang sama dalam satu musim tanam</td><td></td><td></td><td></td></tr>
            </tbody>
        </table>

        <div class="section-title">B. Hasil Verifikasi Teknis</div>
        <table class="table-check">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">Uraian</th>
                    <th style="width: 35%;">Fakta Lapangan</th>
                    <th style="width: 30%;">Ket</th>
                </tr>
            </thead>
            <tbody>
                <tr><td style="text-align: center;">1</td><td>Status Kepemilikan Lahan</td><td style="height: 30px;"></td><td style="vertical-align: top; font-size: 10pt;">Milik Sendiri / Sewa / Pinjam Pakai</td></tr>
                <tr><td style="text-align: center;">2</td><td>Luas Lahan</td><td style="height: 30px;"></td><td></td></tr>
                <tr><td style="text-align: center;">3</td><td>Jenis Tanah</td><td style="height: 30px;"></td><td></td></tr>
                <tr><td style="text-align: center;">4</td><td>Sumber Air Budidaya</td><td style="height: 30px;"></td><td style="vertical-align: top; font-size: 10pt;">Sungai/Kolam/Embung/Sumur</td></tr>
                <tr><td style="text-align: center;">5</td><td>Kondisi Lahan</td><td style="height: 30px;"></td><td style="vertical-align: top; font-size: 10pt;">Semak Belukar/Bekas Budidaya</td></tr>
                <tr><td style="text-align: center;">6</td><td>Rawan Bencana</td><td style="height: 30px;"></td><td style="vertical-align: top; font-size: 10pt;">Banjir/Kebakaran Hutan</td></tr>
                <tr><td style="text-align: center;">7</td><td>Pemanfaatan Lahan Sebelumnya</td><td style="height: 30px;"></td><td></td></tr>
                <tr><td style="text-align: center;">8</td><td>Pengalaman Budidaya</td><td style="height: 30px;"></td><td></td></tr>
                <tr><td style="text-align: center;">9</td><td>Informasi Lainnya</td><td style="height: 30px;"></td><td></td></tr>
            </tbody>
        </table>

        <div class="section-title" style="margin-top: 20px;">b. Dokumentasi lapangan sebagai berikut :</div>
        
        <table style="width: 100%; margin-left: 20px; margin-bottom: 10px;">
            <tr>
                <td style="width: 250px;">Petugas Dokumentasi</td>
                <td>: .......................................</td>
            </tr>
            <tr>
                <td>Petugas Pemetaan</td>
                <td>: ....................................... &nbsp;&nbsp;&nbsp;&nbsp; No. HP : .......................</td>
            </tr>
        </table>

        <table class="photo-table">
            <tr>
                <td>
                    <div style="height: 220px;"></div>
                    Foto 1 : Hasil Pemetaan Lahan
                </td>
                <td>
                    <div style="height: 220px;"></div>
                    Foto 2 : Lahan
                </td>
            </tr>
        </table>

        <p style="margin-top: 20px; margin-bottom: 15px;">
            Demikian berita acara verifikasi CPCL ini dibuat dan ditandatangani.
        </p>

        <p style="margin-bottom: 5px;">Petugas Verifikasi CPCL :</p>
        
        <table style="width: 100%; margin-left: 20px; margin-bottom: 15px;">
            @if($assignment && $assignment->team_members)
                @foreach($assignment->team_members as $index => $member)
                <tr>
                    <td style="padding: 5px 0; width: 350px;">{{ $index + 1 }}. {{ $member['name'] }}</td>
                    <td style="padding: 5px 0;">_______________________</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td style="padding: 5px 0; width: 350px;">1. .......................................</td>
                    <td style="padding: 5px 0;">_______________________</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;">2. .......................................</td>
                    <td style="padding: 5px 0;">_______________________</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;">3. .......................................</td>
                    <td style="padding: 5px 0;">_______________________</td>
                </tr>
            @endif
        </table>

        <p style="margin-bottom: 5px;">Penyuluh Pertanian Lapangan</p>
        <table style="width: 100%; margin-left: 20px; margin-bottom: 15px;">
            <tr>
                <td style="padding: 5px 0; width: 350px;">1. .......................................</td>
                <td style="padding: 5px 0;">_______________________</td>
            </tr>
        </table>

        <p style="margin-bottom: 5px;">Pengurus Gapoktan/Poktan</p>
        <table style="width: 100%; margin-left: 20px;">
            <tr>
                <td style="padding: 5px 0; width: 350px;">1. .......................................</td>
                <td style="padding: 5px 0;">_______________________</td>
            </tr>
        </table>

    </div>
</body>
</html>
