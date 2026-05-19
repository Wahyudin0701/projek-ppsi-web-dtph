<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara - PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; padding: 2cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1 { font-size: 16pt; margin: 0; font-weight: bold; text-transform: uppercase; }
        .kop-surat h2 { font-size: 14pt; margin: 0; font-weight: bold; }
        .kop-surat p { font-size: 10pt; margin: 0; }
        .title { text-align: center; margin-bottom: 20px; }
        .title h3 { text-decoration: underline; margin: 0; font-size: 14pt; font-weight: bold; }
        .title p { margin: 0; }
        .content { margin-bottom: 30px; text-align: justify; }
        .table-data { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        .table-data td { padding: 5px; vertical-align: top; }
        .table-data td:first-child { width: 30%; font-weight: bold; }
        .signature { width: 100%; margin-top: 50px; }
        .signature table { width: 100%; text-align: center; }
        .signature td { width: 50%; vertical-align: bottom; height: 120px; }
        .qrcode { width: 80px; height: 80px; margin: 0 auto; background: #eee; border: 1px dashed #999; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #666;}
        .qrcode img { width: 100%; height: 100%; object-fit: contain; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN MUARO JAMBI</h2>
        <h1>DINAS TANAMAN PANGAN DAN HORTIKULTURA</h1>
        <p>Kompleks Perkantoran Bukit Cinto Kenang, Sengeti, Kab. Muaro Jambi</p>
    </div>

    <div class="title">
        <h3>BERITA ACARA HASIL SURVEI LAPANGAN</h3>
        <p>Nomor: BA.{{ date('Y') }}/PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini, tanggal <strong>{{ $proposal->beritaAcara->survey_date->translatedFormat('d F Y') }}</strong>, telah dilakukan peninjauan dan verifikasi lapangan terhadap usulan permohonan {{ $proposal->alsintan_id ? 'Peminjaman Alsintan' : 'Program Bantuan' }}:</p>
        
        <table class="table-data">
            <tr>
                <td>Nama Kelompok Tani</td>
                <td>: {{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</td>
            </tr>
            <tr>
                <td>Ketua Kelompok</td>
                <td>: {{ $proposal->user->farmerProfile->ketua ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Usulan</td>
                <td>: {{ $proposal->alsintan_id ? $proposal->alsintan->name : $proposal->program->name }}</td>
            </tr>
            <tr>
                <td>Lokasi Lahan</td>
                <td>: {{ $proposal->lokasi_lahan }}</td>
            </tr>
        </table>

        <p><strong>Hasil Verifikasi (CPCL):</strong></p>
        @if($proposal->cpclVerifications->isNotEmpty())
            @php $cpcl = $proposal->cpclVerifications->last(); @endphp
            <ul>
                <li>Status Kepemilikan Lahan: {{ $cpcl->status_kepemilikan }}</li>
                <li>Luas Lahan: {{ $cpcl->luas_lahan }} Ha</li>
                <li>Kondisi Lahan: {{ $cpcl->kondisi_lahan }}</li>
                <li>Kesesuaian Komoditas: {{ $cpcl->kesesuaian_komoditas ? 'Sesuai' : 'Tidak Sesuai' }}</li>
            </ul>
        @else
            <p><em>(Data CPCL belum tercatat secara digital)</em></p>
        @endif

        <p><strong>Catatan/Rekomendasi Teknis:</strong></p>
        <p>{{ $proposal->beritaAcara->content }}</p>
        
        <p><strong>Kesimpulan:</strong></p>
        <p>Berdasarkan hasil survei, pengajuan ini dinyatakan <strong>{{ strtoupper($proposal->beritaAcara->recommendationLabel) }}</strong> untuk diproses lebih lanjut.</p>
        
        <p>Demikian Berita Acara ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <table>
            <tr>
                <td>
                    Mengetahui,<br>
                    <strong>Kepala Bidang</strong><br>
                    <br><br><br><br>
                    <u>{{ $proposal->beritaAcara->kabid->name ?? '.......................' }}</u><br>
                    NIP. .......................
                </td>
                <td>
                    Mengesahkan,<br>
                    <strong>Kepala Dinas TPH</strong><br>
                    <div class="qrcode" style="margin-top: 10px; margin-bottom: 10px; background: transparent; border: none;">
                        {!! QrCode::size(80)->generate(route('documents.berita-acara', $proposal->id)) !!}
                    </div>
                    <u>.......................</u><br>
                    NIP. .......................
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
