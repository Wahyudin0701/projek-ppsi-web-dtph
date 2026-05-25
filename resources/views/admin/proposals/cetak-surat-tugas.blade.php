<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas - {{ $proposal->id }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11.5pt; line-height: 1.25; color: #000; background: #fff; }
        .header-table { width: 100%; margin-bottom: 5px; border: none; }
        .header-table td { border: none; padding: 0; vertical-align: middle; }
        .header-table .logo-cell { width: 90px; text-align: left; }
        .header-table .logo-cell img { width: 80px; height: auto; }
        .header-table .text-cell { text-align: center; padding-left: 20px; padding-right: 20px; }
        .header-table h1 { font-size: 14pt; margin: 0; font-weight: bold; text-transform: uppercase; white-space: nowrap; }
        .header-table h2 { font-size: 15pt; margin: 0; font-weight: bold; text-transform: uppercase; white-space: nowrap; }
        .header-table p { font-size: 11pt; margin: 0; }
        .header-line { border: none; border-top: 3px solid #000; border-bottom: 1px solid #000; height: 2px; background: transparent; margin: 0 0 20px 0; }
        .title { text-align: center; margin-bottom: 20px; }
        .title h3 { font-size: 13pt; margin: 0; text-decoration: underline; font-weight: bold; }
        .title p { margin: 2px 0 0; }
        .content { text-align: justify; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .signature { margin-top: 30px; width: 250px; float: right; text-align: left; }
        .signature p { margin: 0; }
        .signature .name { margin-top: 60px; font-weight: bold; text-decoration: underline; }
        @media print {
            body { padding: 0; background: none; }
            @page { size: A4; margin: 1.5cm 2cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('images/Lambang_Kabupaten_Muaro_Jambi.png') }}" alt="Logo Muaro Jambi">
            </td>
            <td class="text-cell">
                <h1>Pemerintah Kabupaten Muaro Jambi</h1>
                <h2>Dinas Tanaman Pangan dan Hortikultura</h2>
                <p>Jln Lintas Timur Komplek Perkantoran Bukit Cinto Kenang<br>Sengeti 36381</p>
            </td>
        </tr>
    </table>
    <hr class="header-line">

    <div class="title">
        <h3>SURAT TUGAS</h3>
        <p>Nomor: {{ $assignment->nomor_surat }}</p>
    </div>

    <div class="content">
        <p>Berdasarkan hasil verifikasi administrasi dan disposisi Kepala Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi, menugaskan nama-nama di bawah ini:</p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No.</th>
                    <th>Nama Lengkap</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignment->team_members as $index => $member)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $member['name'] }}</td>
                    <td>{{ $member['nip'] ?? '-' }}</td>
                    <td>{{ $member['role'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p>Untuk melaksanakan kunjungan dan verifikasi teknis Calon Petani Calon Lokasi (CPCL) atas proposal pengajuan {{ $proposal->alsintan_id ? 'peminjaman alsintan ' . $proposal->alsintan->name : 'program bantuan ' . $proposal->program->name }} dari pemohon/kelompok tani <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong> yang berlokasi di <strong>{{ $proposal->lokasi_lahan }}</strong>.</p>

        <p>Surat tugas ini berlaku sejak tanggal <strong>{{ $assignment->valid_from->translatedFormat('d F Y') }}</strong> sampai dengan <strong>{{ $assignment->valid_until->translatedFormat('d F Y') }}</strong>. Demikian Surat Tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>
    </div>

    <div class="signature">
        <p>Sengeti, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Kepala Dinas,</p>
        <div class="name">{{ $kepalaDinas?->name ?? '.......................' }}</div>
        <p>NIP. {{ $kepalaDinas?->nip ?? '.......................' }}</p>
    </div>
</body>
</html>

