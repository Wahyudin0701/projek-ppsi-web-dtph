<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas - {{ $proposal->id }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; padding: 2cm; max-width: 21cm; margin: 0 auto; background: #fff; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 25px; position: relative; }
        /* Placeholder for Logo */
        .header .logo { width: 70px; height: 70px; background-color: #eee; border-radius: 50%; position: absolute; left: 0; top: 0; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #888; border: 1px solid #ccc; }
        .header h1 { font-size: 16pt; margin: 0; font-weight: bold; text-transform: uppercase; }
        .header h2 { font-size: 18pt; margin: 5px 0; font-weight: bold; text-transform: uppercase; }
        .header p { font-size: 11pt; margin: 0; }
        .title { text-align: center; margin-bottom: 30px; }
        .title h3 { font-size: 14pt; margin: 0; text-decoration: underline; font-weight: bold; }
        .title p { margin: 5px 0 0; }
        .content { text-align: justify; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .signature { margin-top: 50px; width: 300px; float: right; text-align: left; }
        .signature p { margin: 0; }
        .signature .name { margin-top: 80px; font-weight: bold; text-decoration: underline; }
        @media print {
            body { padding: 0; background: none; }
            @page { size: A4; margin: 2cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #19A148; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Cetak Dokumen</button>
    </div>

    <div class="header">
        <div class="logo">LOGO</div>
        <h1>Pemerintah Kabupaten Muaro Jambi</h1>
        <h2>Dinas Tanaman Pangan dan Hortikultura</h2>
        <p>Komplek Perkantoran Bukit Cinto Kenang, Sengeti</p>
    </div>

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
                    <th>Jabatan dalam Tim</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignment->team_members as $index => $member)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $member['name'] }}</td>
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
        <div class="name">Parada S.E., M.Si.</div>
        <p>NIP. 19700101 199503 1 001</p>
    </div>
</body>
</html>
