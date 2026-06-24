<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas - {{ $proposal->id }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.15; color: #000; background: #fff; margin: 0; padding: 10px 20px; }
        .header-table { width: 100%; margin-bottom: 2px; border: none; }
        .header-table td { border: none; padding: 0; vertical-align: top; }
        .header-table .logo-cell { width: 80px; text-align: center; }
        .header-table .logo-cell img { width: 75px; height: auto; }
        .header-table .text-cell { text-align: center; }
        .header-table h1 { font-size: 13pt; margin: 0; font-weight: bold; }
        .header-table h2 { font-size: 14pt; margin: 0; font-weight: bold; }
        .header-table p { font-size: 8.5pt; margin: 0; }
        .header-line { border: none; border-top: 3px solid #000; border-bottom: 1px solid #000; height: 2px; background: transparent; margin: 5px 0 10px 0; }
        .title { text-align: center; margin-bottom: 15px; }
        .title h3 { font-size: 12pt; margin: 0; text-decoration: underline; font-weight: bold; }
        .title p { margin: 2px 0 0; font-size: 11pt; }
        
        .layout-table { width: 100%; border: none; margin-bottom: 0; border-collapse: collapse; }
        .layout-table td { border: none; padding: 0 0 5px 0; vertical-align: top; }
        .layout-table .col-label { width: 70px; }
        .layout-table .col-colon { width: 25px; text-align: center; }
        
        .person-table { width: 100%; border: none; border-collapse: collapse; }
        .person-table td { border: none; padding: 0; vertical-align: top; }
        .person-table .col-no { width: 25px; }
        .person-table .col-field { width: 100px; }
        .person-table .col-colon2 { width: 15px; text-align: center; }

        .signature { margin-top: 15px; width: 300px; float: right; text-align: center; }
        .signature p { margin: 0; }
        .signature .name { margin-top: 10px; font-weight: bold; text-decoration: underline; }
        .clearfix { clear: both; }
        
        .closing { margin-top: 5px; margin-left: 95px; text-align: justify; }

        @media print {
            body { padding: 0; background: none; }
            @page { size: A4; margin: 1cm 1.5cm; }
            img { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .logo-cell img { display: block !important; width: 75px !important; height: auto !important; }
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @php
                    $paths = [
                        public_path('images/Lambang_Kabupaten_Muaro_Jambi.png'),
                        base_path('../public_html/images/Lambang_Kabupaten_Muaro_Jambi.png'),
                        $_SERVER['DOCUMENT_ROOT'] . '/images/Lambang_Kabupaten_Muaro_Jambi.png',
                    ];
                    $logoData = '';
                    foreach ($paths as $path) {
                        if (file_exists($path)) {
                            $logoData = base64_encode(file_get_contents($path));
                            break;
                        }
                    }
                @endphp
                @if($logoData)
                    <img src="data:image/png;base64,{{ $logoData }}" alt="Logo Muaro Jambi" style="width:75px;height:auto;display:block;">
                @endif
            </td>
            <td class="text-cell">
                <h1>PEMERINTAH KABUPATEN MUARO JAMBI</h1>
                <h2>DINAS TANAMAN PANGAN<br>DAN HORTIKULTURA</h2>
                <p>Komplek Perkantoran Bukit Cinto Kenang, Jalan Lintas Timur Km.26, Sengeti, Kecamatan Sekernan 36381<br>Telp. (0741) 590069, Faksimile. (0741) 590070</p>
            </td>
        </tr>
    </table>
    <hr class="header-line">

    <div class="title">
        <h3>SURAT TUGAS</h3>
        <p>Nomor : {{ $assignment->nomor_surat }}</p>
    </div>

    <table class="layout-table">
        <tr>
            <td class="col-label">Dasar</td>
            <td class="col-colon">:</td>
            <td>
                <table style="width:100%; border:none; margin:0; padding:0; border-collapse:collapse;">
                    <tr><td style="width:25px; vertical-align:top; padding:0;">1.</td><td style="vertical-align:top; padding:0; text-align:justify;">Peraturan Bupati Muaro Jambi tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi, Serta Tata Kerja Dinas Tanaman Pangan dan Hortikultura;</td></tr>
                    <tr><td style="vertical-align:top; padding:0;">2.</td><td style="vertical-align:top; padding:0; text-align:justify;">Dokumen Pelaksanaan Anggaran (DPA) Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi Tahun Anggaran {{ date('Y') }}.</td></tr>
                </table>
            </td>
        </tr>
    </table>
    
    <div style="text-align: center; margin: 15px 0 25px 0; font-weight: bold; font-size: 12pt; text-decoration: underline;">MEMERINTAHKAN :</div>
    
    <table class="layout-table">
        @foreach($assignment->team_members as $index => $member)
        <tr>
            <td class="col-label">
                @if($index === 0)
                    Kepada
                @endif
            </td>
            <td class="col-colon">:</td>
            <td style="padding-bottom: 20px;">
                @php
                    // Coba dapatkan pangkat/gol dari database jika tidak ada di JSON
                    $pangkatGol = $member['pangkat_gol'] ?? null;
                    $nipMember = $member['nip'] ?? null;
                    if (!$pangkatGol && $nipMember) {
                        $emp = \App\Models\Employee::where('nip', $nipMember)->first();
                        $pangkatGol = $emp?->pangkat_gol ?? '-';
                    } elseif (!$pangkatGol) {
                        $pangkatGol = '-';
                    }
                @endphp
                <table class="person-table">
                    <tr>
                        <td class="col-no">1.</td><td class="col-field">Nama</td><td class="col-colon2">:</td><td><b>{{ $member['name'] }}</b></td>
                    </tr>
                    <tr>
                        <td>2.</td><td>Pangkat/gol</td><td>:</td><td>{{ $pangkatGol }}</td>
                    </tr>
                    <tr>
                        <td>3.</td><td>NIP</td><td>:</td><td>{{ $member['nip'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>4.</td><td>Jabatan</td><td>:</td><td>{{ $member['role'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        @endforeach
    </table>

    <table class="layout-table">
        <tr>
            <td class="col-label">Untuk</td>
            <td class="col-colon">:</td>
            <td>
                <table style="width:100%; border:none; margin:0; padding:0; border-collapse:collapse;">
                    @php
                        $lamaHari = \Carbon\Carbon::parse($assignment->valid_from)->diffInDays(\Carbon\Carbon::parse($assignment->valid_until)) + 1;
                        $tanggalTeks = $lamaHari == 1 
                            ? 'tanggal ' . $assignment->valid_from->translatedFormat('d F Y') 
                            : 'tanggal ' . $assignment->valid_from->translatedFormat('d F Y') . ' s/d ' . $assignment->valid_until->translatedFormat('d F Y');
                        
                        if ($proposal->user->role === 'umum') {
                            $namaPengaju = $proposal->user->name;
                            $alamatTugas = 'di ' . ucwords(strtolower($proposal->user->umumProfile->alamat ?? '-'));
                        } else {
                            $namaPengaju = $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name;
                            $alamatTugas = 'di Desa ' . ucwords(strtolower($proposal->user->farmerProfile->alamat ?? '-')) . ' Kecamatan ' . ucwords(strtolower($proposal->user->farmerProfile->kecamatan ?? '-'));
                        }
                    @endphp
                    <tr><td style="width:25px; vertical-align:top; padding:0;">1.</td><td style="vertical-align:top; padding:0; text-align:justify;">Melaksanakan perjalanan dinas dalam rangka verifikasi lokasi {{ $proposal->alsintan_id ? 'peminjaman alsintan ' . $proposal->alsintan->name : 'bantuan ' . $proposal->program->name }} oleh <strong>{{ $namaPengaju }}</strong> {{ $alamatTugas }} selama {{ $lamaHari }} hari pada {{ $tanggalTeks }}</td></tr>
                    <tr><td style="vertical-align:top; padding:0;">2.</td><td style="vertical-align:top; padding:0; text-align:justify;">Biaya di bebankan pada DPA Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi No Rek 3.27.01.2.06.0009.5.1.02.04.001.00003.</td></tr>
                    <tr><td style="vertical-align:top; padding:0;">3.</td><td style="vertical-align:top; padding:0; text-align:justify;">Setelah selesai melaksanakan perjalanan dinas agar melaporkan hasil pelaksanaannya.</td></tr>
                    <tr><td style="vertical-align:top; padding:0;">4.</td><td style="vertical-align:top; padding:0; text-align:justify;">Surat tugas ini berlaku sejak tanggal dikeluarkan.</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="closing">
        <p style="text-indent: 40px; margin: 0;">Demikian surat tugas ini ditetapkan agar dilaksanakan dengan penuh tanggung jawab.</p>
    </div>

    <div class="signature">
        @php
            $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();
        @endphp
        <p>Sengeti, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Kepala Dinas,</p>
        
        <div style="margin: 70px 0;"></div>
        
        <div class="name">{{ $kepalaDinas?->name ?? '.......................' }}</div>
        <p>{{ $kepalaDinas?->pangkat_gol ?? ' ' }}</p>
        <p>NIP. {{ $kepalaDinas?->nip ?? '.......................' }}</p>
    </div>
    <div class="clearfix"></div>
</body>
</html>
