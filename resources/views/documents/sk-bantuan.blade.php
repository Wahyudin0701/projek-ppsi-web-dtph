<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SK Bantuan - PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; padding: 2cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1 { font-size: 16pt; margin: 0; font-weight: bold; text-transform: uppercase; }
        .kop-surat h2 { font-size: 14pt; margin: 0; font-weight: bold; }
        .kop-surat p { font-size: 10pt; margin: 0; }
        .title { text-align: center; margin-bottom: 30px; }
        .title h3 { margin: 0; font-size: 14pt; font-weight: bold; text-transform: uppercase;}
        .title p { margin: 0; }
        .content { margin-bottom: 30px; text-align: justify; }
        .considerations td { vertical-align: top; padding-bottom: 10px; }
        .considerations td:first-child { width: 15%; font-weight: bold; }
        .considerations td:nth-child(2) { width: 5%; }
        .signature { width: 100%; margin-top: 50px; }
        .signature table { width: 100%; }
        .signature td { width: 50%; }
        .signature td.right { text-align: center; }
        .qrcode { width: 80px; height: 80px; margin: 10px auto; background: #eee; border: 1px dashed #999; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN MUARO JAMBI</h2>
        <h1>DINAS TANAMAN PANGAN DAN HORTIKULTURA</h1>
        <p>Kompleks Perkantoran Bukit Cinto Kenang, Sengeti, Kab. Muaro Jambi</p>
    </div>

    <div class="title">
        <h3>KEPUTUSAN KEPALA DINAS TPH</h3>
        <p>Nomor: {{ $proposal->nomor_dokumen_final }}</p>
        <br>
        <h3>TENTANG</h3>
        <h3>PENETAPAN PENERIMA BANTUAN {{ strtoupper($proposal->program->name) }}</h3>
    </div>

    <div class="content">
        <table class="considerations">
            <tr>
                <td>Menimbang</td>
                <td>:</td>
                <td>Bahwa berdasarkan hasil verifikasi lapangan dan Berita Acara Nomor BA.{{ date('Y') }}/PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}, permohonan yang diajukan oleh Kelompok Tani memenuhi syarat untuk menerima bantuan.</td>
            </tr>
            <tr>
                <td>Mengingat</td>
                <td>:</td>
                <td>1. Peraturan Daerah Kabupaten Muaro Jambi tentang Pertanian.<br>2. Petunjuk Teknis Program Bantuan Pemerintah Tahun {{ date('Y') }}.</td>
            </tr>
            <tr>
                <td>Memutuskan</td>
                <td>:</td>
                <td>Menetapkan Kelompok Tani <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong> (ID Poktan: {{ $proposal->user->farmerProfile->id_poktan ?? '-' }}) (Desa/Kecamatan: {{ $proposal->user->farmerProfile->kecamatan ?? '-' }}) sebagai penerima sah program bantuan <strong>{{ $proposal->program->name }}</strong>.</td>
            </tr>
        </table>
        
        <p style="margin-top: 20px;">Keputusan ini berlaku sejak tanggal ditetapkan, dengan ketentuan apabila di kemudian hari terdapat kekeliruan akan diadakan perbaikan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <table>
            <tr>
                <td></td>
                <td class="right">
                    Ditetapkan di: Sengeti<br>
                    Pada tanggal: {{ $proposal->decided_at?->translatedFormat('d F Y') ?? date('d F Y') }}<br>
                    <strong>Kepala Dinas TPH</strong><br>
                    <div class="qrcode" style="background: transparent; border: none;">
                        {!! QrCode::size(80)->generate(route('documents.sk-bantuan', $proposal->id)) !!}
                    </div>
                    <u>{{ $kepalaDinas?->name ?? 'Nama Kepala Dinas' }}</u><br>
                    NIP. {{ $kepalaDinas?->nip ?? '.......................' }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
