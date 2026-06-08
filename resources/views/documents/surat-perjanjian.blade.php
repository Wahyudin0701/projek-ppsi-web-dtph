<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perjanjian Pinjam Pakai - PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.5; color: #000; padding: 10px 30px; }
        @page { margin: 1.5cm 2cm; }
        .header-table { width: 100%; margin-bottom: 2px; border: none; }
        .header-table td { border: none; padding: 0; vertical-align: top; }
        .header-table .logo-cell { width: 80px; text-align: center; }
        .header-table .logo-cell img { width: 75px; height: auto; }
        .header-table .text-cell { text-align: center; }
        .header-table h1 { font-size: 13pt; margin: 0; font-weight: bold; }
        .header-table h2 { font-size: 14pt; margin: 0; font-weight: bold; }
        .header-table p { font-size: 8.5pt; margin: 0; font-weight: normal; }
        .header-line { border: none; border-top: 3px solid #000; border-bottom: 1px solid #000; height: 2px; background: transparent; margin: 5px 0 15px 0; }
        .title { text-align: center; margin-bottom: 20px; font-weight: bold;}
        .title h3 { margin: 0; font-size: 12pt; font-weight: bold; text-transform: uppercase;}
        .title p { margin: 0; font-size: 11pt; }
        .content { text-align: justify; }
        .identitas { width: 100%; border-collapse: collapse; margin-bottom: 15px; margin-left: 20px;}
        .identitas td { padding: 2px; vertical-align: top; }
        .identitas td:first-child { width: 4%; }
        .identitas td:nth-child(2) { width: 25%; }
        .identitas td:nth-child(3) { width: 2%; }
        .pasal { text-align: center; margin-top: 15px; margin-bottom: 5px; }
        .pasal p { margin: 0; font-size: 11pt; }
        .pasal h4 { font-size: 11pt; font-weight: normal; margin: 0; }
        .list-pasal { margin-top: 5px; padding-left: 0; list-style: none; }
        .list-pasal li { position: relative; padding-left: 25px; margin-bottom: 3px; text-align: justify; }
        .list-pasal li .num { position: absolute; left: 0; top: 0; }
        .table-alat { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 10pt; }
        .table-alat th, .table-alat td { border: 1px solid #000; padding: 5px; text-align: center; }
        .signature { width: 100%; margin-top: 30px; }
        .signature table { width: 100%; text-align: center; }
        .signature td { width: 50%; vertical-align: top; }
        .signature-mengetahui { width: 100%; text-align: center; margin-top: 20px; }
        .page-break { page-break-after: always; }
        .bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
    </style>
</head>
<body>
    @php
        if (!function_exists('terbilang')) {
            function terbilang($angka) {
                $angka = abs($angka);
                $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                $terbilang = "";
                if ($angka < 12) {
                    $terbilang = " " . $baca[$angka];
                } else if ($angka < 20) {
                    $terbilang = terbilang($angka - 10) . " Belas";
                } else if ($angka < 100) {
                    $terbilang = terbilang((int)($angka / 10)) . " Puluh " . terbilang($angka % 10);
                } else if ($angka < 200) {
                    $terbilang = " Seratus " . terbilang($angka - 100);
                } else if ($angka < 1000) {
                    $terbilang = terbilang((int)($angka / 100)) . " Ratus " . terbilang($angka % 100);
                } else if ($angka < 2000) {
                    $terbilang = " Seribu " . terbilang($angka - 1000);
                } else if ($angka < 1000000) {
                    $terbilang = terbilang((int)($angka / 1000)) . " Ribu " . terbilang($angka % 1000);
                }
                return preg_replace('/\s+/', ' ', trim($terbilang));
            }
        }
        
        $tanggalSekarang = \Carbon\Carbon::now()->locale('id');
        $namaAlat = $proposal->alsintan->name ?? '................';
        $merkAlat = $proposal->alsintan->merk ?? '';
        $fullNamaAlat = trim($namaAlat . ' ' . $merkAlat);
        $namaPoktan = $proposal->user->farmerProfile->nama_kelompok ?? '..........................';
        $ketuaPoktan = $proposal->user->farmerProfile->ketua ?? '..........................';
        $alamatPoktan = $proposal->user->farmerProfile->alamat ?? '..........................';
        $kecamatanPoktan = $proposal->user->farmerProfile->kecamatan ?? '................................';
        $desaPoktan = $proposal->user->farmerProfile->desa ?? '...........';
        $rtPoktan = '.......';
        $noSurat = $proposal->nomor_dokumen_final ?? '531.1/         /DTPH-PSP/V/' . date('Y');
        $durasi = $proposal->rencana_durasi_hari ?? '........';
        
        $kabidName = '.......................................';
        $kabidNip = '.......................................';
        $kabidJabatan = 'Kepala Bidang .......................................';
        // Get kabid info if possible
        $kabidUser = $proposal->kabid ?? \App\Models\User::where('role', 'like', 'kabid%')->first();
        if ($kabidUser) {
            $kabidName = $kabidUser->name;
            $roleMapping = [
                'kabid_psp' => 'Kabid. PSP',
                'kabid_tp' => 'Kabid. Tanaman Pangan',
                'kabid_hortikultura' => 'Kabid. Hortikultura',
            ];
            $employeeRole = $roleMapping[$kabidUser->role] ?? null;
            if ($employeeRole) {
                $employee = \App\Models\Employee::where('role', $employeeRole)->first();
                if ($employee) {
                    $kabidName = $employee->name;
                    $kabidNip = $employee->nip ?? '-';
                    $kabidJabatan = str_replace('Kabid.', 'Kepala Bidang', $employee->role);
                }
            }
        }
        
        $kadisName = $kepalaDinas?->name ?? '.......................................';
        $kadisNip = $kepalaDinas?->nip ?? '.......................................';
        
        $tahunTerbilang = ucwords(strtolower(terbilang($tanggalSekarang->year)));
    @endphp

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('images/Lambang_Kabupaten_Muaro_Jambi.png') }}" alt="Logo Muaro Jambi">
            </td>
            <td class="text-cell">
                <h1>PEMERINTAH KABUPATEN MUARO JAMBI</h1>
                <h2>DINAS TANAMAN PANGAN<br>DAN HORTIKULTURA</h2>
                <p>Komplek Perkantoran Bukit Cinto Kenang, Jalan Lintas Timur Km.26, Sengeti, Kecamatan Sekernan 36381<br>Telp. (0741) 590069, Faksimile. (0741) 590070</p>
            </td>
        </tr>
    </table>
    <hr class="header-line">

    @php
        $romawiBulan = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulanRomawi = $romawiBulan[$tanggalSekarang->month];
    @endphp
    <div class="title">
        <h3>SURAT PERJANJIAN PINJAM PAKAI</h3>
        <p><strong>DINAS TANAMAN PANGAN DAN HORTIKULTURA KABUPATEN MUARO JAMBI<br>DENGAN<br>KELOMPOK TANI {{ strtoupper($namaPoktan) }}</strong></p>
        <br>
        <p><strong>TENTANG<br>PINJAM PAKAI ALAT DAN MESIN BERUPA 1 (SATU) UNIT {{ strtoupper($fullNamaAlat) }} MILIK PEMERINTAH</strong></p>
        <p>NOMOR : 531.1/{{ str_pad($proposal->id, 3, '0', STR_PAD_LEFT) }}/DTPH-PSP/{{ $bulanRomawi }}/{{ $tanggalSekarang->year }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini <strong>{{ $tanggalSekarang->translatedFormat('l') }}</strong> tanggal <strong>{{ $tanggalSekarang->translatedFormat('d') }}</strong> bulan <strong>{{ $tanggalSekarang->translatedFormat('F') }}</strong> Tahun <strong>{{ $tahunTerbilang }}</strong> bertempat di Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi, kami yang bertanda tangan dibawah ini :</p>
        
        <table class="identitas">
            <tr>
                <td>1.</td>
                <td>{{ $kabidName }}</td>
                <td>:</td>
                <td>{{ $kabidJabatan }}<br>yang beralamat dan berkedudukan di Jln. Lintas Timur Komplek Perkantoran Bukit Cinto Kenang, Sengeti, bertindak untuk dan atas nama Dinas Tanaman Pangan dan Kabupaten Muaro Jambi, untuk selanjutnya disebut sebagai <strong>PIHAK PERTAMA;</strong></td>
            </tr>
            <tr>
                <td>2.</td>
                <td>{{ $ketuaPoktan }}</td>
                <td>:</td>
                <td>Ketua Poktan <strong>{{ $namaPoktan }}</strong> Selamanya Beralamat dan Berkedudukan di Desa {{ ucwords(strtolower($alamatPoktan)) }}, Kecamatan {{ $kecamatanPoktan }}, Kabupaten Muaro Jambi, bertindak untuk dan atas nama <strong>{{ $namaPoktan }}</strong> untuk selanjutnya disebut sebagai <strong>PIHAK KEDUA;</strong></td>
            </tr>
        </table>

        <p><strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> selanjutnya secara bersama-sama disebut <strong>PARA PIHAK</strong>; sepakat untuk mengikatkan diri dalam suatu perjanjian dalam hal Pinjam Pakai Alat dan Mesin berupa 1 (satu) Unit <strong>{{ $fullNamaAlat }}</strong> beserta implementnya milik Pemerintah, dengan ketentuan sebagai berikut:</p>

        <div class="pasal">
            <p>Pasal 1</p>
            <p class="bold">Dasar Pelaksanaan</p>
        </div>
        
        <ul class="list-pasal">
            <li><span class="num">(1)</span> Peraturan Pemerintah Nomor. 6 Tahun 2006 tentang Pengelolaan Barang Milik Negara/Daerah sebagaimana diubah dengan Peraturan Pemerintah Republik Indonesia Nomor 38 Tahun 2008 tentang Perubahan Atas Peraturan Pemerintah Nomor. 6 Tahun 2006 tentang Pengelolaan Barang Milik Negara/Daerah;</li>
            <li><span class="num">(2)</span> Peraturan Menteri Dalam Negeri Nomor 17 Tahun 2007 Tentang Pedoman Teknis Pengelolaan Barang Milik Daerah;</li>
            <li><span class="num">(3)</span> Peraturan Daerah Provinsi Jambi Nomor 3 Tahun 2009 tanggal 23 Januari 2009 tentang Pengelolaan Barang Milik Daerah;</li>
            <li><span class="num">(4)</span> Permohonan Dari Pihak Kedua Yang ditujukan Kepada Kepala Dinas Tanaman Pangan dan Hortikultura Muaro Jambi, No : {{ $proposal->no_surat_pengajuan ?? '.......................' }}</li>
        </ul>


        <div class="pasal">
            <p>Pasal 2</p>
            <p class="bold">Maksud dan Tujuan</p>
        </div>
        <p>Maksud dan tujuan dari Surat Perjanjian ini untuk pemanfaatan barang milik daerah dalam bentuk Pinjam Pakai Alat dan Mesin berupa 1 (satu) Unit <strong>{{ $fullNamaAlat }}</strong> Beserta implementnya milik Pemerintah yang dimiliki oleh PIHAK PERTAMA kepada PIHAK KEDUA.</p>

        <div class="pasal">
            <p>Pasal 3</p>
            <p class="bold">Bentuk Kegiatan dan Tanggung jawab</p>
        </div>
        
        <ul class="list-pasal">
            <li><span class="num">(1)</span> PIHAK PERTAMA menyerahkan dan/atau pinjam pakai kepada PIHAK KEDUA Alat dan Mesin berupa 1 (satu) Unit <strong>{{ $fullNamaAlat }}</strong> dengan implement dengan spesifikasi sebagai berikut :
                
                <table class="table-alat">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Alat/Mesin</th>
                            <th>No. Rangka / No. Mesin</th>
                            <th>Jumlah (unit)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="bold">{{ $fullNamaAlat }}</td>
                            <td>{{ $proposal->alsintanInventory->nomor_rangka ?? '-' }} / {{ $proposal->alsintanInventory->nomor_mesin ?? '-' }}</td>
                            <td>1</td>
                            <td>Baik dan Lengkap</td>
                        </tr>
                    </tbody>
                </table>
            </li>
            <li><span class="num">(2)</span> PIHAK KEDUA tidak diperbolehkan menggunakan alat tersebut untuk tujuan selain mendukung Swasembada / Ketahanan Pangan;</li>
            <li><span class="num">(3)</span> PIHAK KEDUA tidak diperbolehkan merubah, memindahtangankan atau mengalih fungsikan alat dan mesin dimaksud kepada pihak lainnya tanpa persetujuan Tertulis dari PIHAK PERTAMA;</li>
            <li><span class="num">(4)</span> PIHAK KEDUA wajib memelihara dan menjaga keutuhan dan keamanan dengan baik serta menanggung segala resiko atas penggunaan alat dan mesin tersebut;</li>
            <li><span class="num">(5)</span> PIHAK KEDUA wajib melaporkan kegiatan pemanfaatan/penggunaan alat dan mesin Secara Rutin Dan Berkala kepada PIHAK PERTAMA;</li>
            <li><span class="num">(6)</span> Apabila PIHAK KEDUA tidak mempergunakan lagi alat dan mesin tersebut, menelantarkan dan/atau tidak menfungsikan alat dan mesin tersebut, maka PIHAK PERTAMA dapat meminta dikembalikan alat dan mesin tersebut sewaktu-waktu, dan PIHAK KEDUA segera menyerahkan alat dan mesin dimaksud dalam keadaan baik;</li>
            <li><span class="num">(7)</span> Segala Resiko Yang Timbul dalam Perjalanan Setelah Keluar dari Gudang Dinas Tanaman Pangan dan hortikultura, Dan kembali kegudang Dinas Tanaman Pangan dan hortikultura Menjadi tanggung Jawab PIHAK KEDUA;</li>
            <li><span class="num">(8)</span> Biaya mobilisasi alat mesin (Pengambilan dan Pengembalian alat mesin ke tempat semula) menjadi tanggung jawab PIHAK KEDUA.</li>
        </ul>

        <div class="pasal">
            <p>Pasal 4</p>
            <p class="bold">Lokasi dan Jangka Waktu Peminjaman</p>
        </div>
        <ul class="list-pasal">
            <li><span class="num">(1)</span> Lokasi operasi alat dan mesin tersebut adalah di Kecamatan <strong>{{ $kecamatanPoktan }}</strong>;</li>
            <li><span class="num">(2)</span> Jangka waktu pinjam pakai alat dan mesin milik Pemerintah dimaksud berlaku selama <strong>{{ $durasi }} Hari</strong> sejak Surat Pinjam Pakai Ditandatangani;</li>
            <li><span class="num">(3)</span> Apabila masa perjanjian telah berakhir Maka PIHAK KEDUA wajib menyerahkan dan Mengembalikan alat dan mesin tersebut kepada PIHAK PERTAMA dalam keadaan baik dan lengkap dengan Biaya ditanggung PIHAK KEDUA;</li>
        </ul>

        <div class="pasal">
            <p>Pasal 5</p>
            <p class="bold">Biaya Operasi, Biaya Pemeliharaan, dan Biaya Perbaikan Alat dan Mesin</p>
        </div>
        <ul class="list-pasal">
            <li><span class="num">(1)</span> Selama masa peminjaman alat dan mesin tersebut, keperluan olie, perbaikan kerusakan, penggantian spare part, dan mekanik menjadi tanggung jawab PIHAK KEDUA;</li>
            <li><span class="num">(2)</span> Pemakaian BBM (Bahan Bakar Minyak) Solar dan Bensin untuk keperluan operasi menjadi tanggung jawab PIHAK KEDUA.</li>
        </ul>


        <div class="pasal">
            <p>Pasal 6</p>
            <p class="bold">Keamanan Alat dan Mesin</p>
        </div>
        <ul class="list-pasal">
            <li><span class="num">(1)</span> PIHAK KEDUA wajib menyediakan petugas keamanan untuk menjaga alat di lokasi kerja;</li>
            <li><span class="num">(2)</span> PIHAK KEDUA wajib membayar ganti rugi terhadap unit kerja jika terjadi pencurian, perusakan dalam bentuk apapun juga yang dilakukan secara sengaja maupun tidak sengaja.</li>
        </ul>

        <div class="pasal">
            <p>Pasal 7</p>
            <p class="bold">Pemindahan, Pengambilan, dan Penggunaan Alat dan Mesin</p>
        </div>
        <ul class="list-pasal">
            <li><span class="num">(1)</span> Alat tidak boleh dipindahkan ke lokasi lain (di luar wilayah sebagaimana yang tertuang dalam surat perjanjian ini) oleh PIHAK KEDUA, terkecuali ada persetujuan dari PIHAK PERTAMA;</li>
            <li><span class="num">(2)</span> Apabila PIHAK KEDUA akan menggunakan alat ke luar lokasi yang telah ditentukan dalam perjanjian ini sementara masa peminjaman belum habis maka PIHAK KEDUA wajib memberitahukan kepada PIHAK PERTAMA;</li>
            <li><span class="num">(3)</span> PIHAK KEDUA Wajib melaporkan pemanfaatan Alat dan Mesin berupa 1 (satu) Unit <strong>{{ $fullNamaAlat }}</strong> Secara berkala setiap Hari Ke Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi, yang mencantumkan Kondisi alat, Luas lahan yang ditanami, objek yang dikerjakan dan permasalahan yang dihadapi.</li>
        </ul>

        <div class="pasal">
            <p>Pasal 8</p>
            <p class="bold">Dan lain-lain</p>
        </div>
        <ul class="list-pasal">
            <li><span class="num">(1)</span> Hal - hal yang belum tercakup atau adanya perubahan dalam perjanjian ini akan diatur kemudian yang tidak terlepas dari item surat perjanjian ini;</li>
            <li><span class="num">(2)</span> Perjanjian ini batal apabila salah satu pihak melanggar ketentuan dan peraturan yang telah disepakati;</li>
            <li><span class="num">(3)</span> Dalam pelaksanaan kegiatan perjanjian ini, apabila ada permasalahan yang timbul diluar kemampuan dari PARA PIHAK akan diselesaikan secara musyawarah dan mufakat guna memperoleh penyelesaian yang mendukung kegiatan perjanjian ini;</li>
            <li><span class="num">(4)</span> Surat Perjanjian ini mulai berlaku sejak ditandatangani oleh PARA PIHAK dan dibuat dalam rangkap 2 (Dua) masing - masing bermaterai cukup dan diberikan cap/stempel PARA PIHAK serta mempunyai kekuatan hukum yang sama.</li>
        </ul>

        <div class="signature">
            <table>
                <tr>
                    <td>
                        <span class="bold">PIHAK KEDUA</span><br>
                        POKTAN {{ strtoupper($namaPoktan) }}<br>
                        <br><br>
                        <span style="font-size: 10px; color: #555;">Materai 10.000</span><br>
                        <br><br>
                        <span style="font-weight: bold; text-decoration: underline;">{{ $ketuaPoktan }}</span><br>
                        Ketua
                    </td>
                    <td>
                        <span class="bold">PIHAK PERTAMA</span><br>
                        <span class="uppercase">{{ $kabidJabatan }}</span><br>
                        <br><br><br><br><br>
                        <span style="font-weight: bold; text-decoration: underline;">{{ $kabidName }}</span><br>
                        NIP. {{ $kabidNip }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="signature-mengetahui">
            Mengetahui,<br>
            KEPALA DINAS TPH M. JAMBI<br>
            <br><br><br><br><br>
            <span style="font-weight: bold; text-decoration: underline;">{{ $kadisName }}</span><br>
            NIP. {{ $kadisNip }}
        </div>
    </div>
</body>
</html>
