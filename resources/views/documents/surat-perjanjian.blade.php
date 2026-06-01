<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perjanjian Pinjam Pakai - PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; padding: 2cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1 { font-size: 16pt; margin: 0; font-weight: bold; text-transform: uppercase; }
        .kop-surat h2 { font-size: 14pt; margin: 0; font-weight: bold; }
        .kop-surat p { font-size: 10pt; margin: 0; }
        .title { text-align: center; margin-bottom: 30px; }
        .title h3 { text-decoration: underline; margin: 0; font-size: 14pt; font-weight: bold; text-transform: uppercase;}
        .title p { margin: 0; }
        .content { margin-bottom: 30px; text-align: justify; }
        .identitas { width: 100%; border-collapse: collapse; margin-bottom: 20px; margin-left: 20px;}
        .identitas td { padding: 3px; vertical-align: top; }
        .identitas td:first-child { width: 25%; }
        .identitas td:nth-child(2) { width: 5%; }
        .pasal h4 { font-size: 12pt; text-align: center; margin-bottom: 5px; }
        .pasal p { margin-top: 0; }
        .signature { width: 100%; margin-top: 50px; }
        .signature table { width: 100%; text-align: center; }
        .signature td { width: 50%; vertical-align: bottom; height: 120px; }
        .qrcode { width: 80px; height: 80px; margin: 0 auto; background: #eee; border: 1px dashed #999; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #666;}
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN MUARO JAMBI</h2>
        <h1>DINAS TANAMAN PANGAN DAN HORTIKULTURA</h1>
        <p>Kompleks Perkantoran Bukit Cinto Kenang, Sengeti, Kab. Muaro Jambi</p>
    </div>

    <div class="title">
        <h3>SURAT PERJANJIAN PINJAM PAKAI ALSINTAN</h3>
        <p>Nomor: {{ $proposal->nomor_dokumen_final }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini, tanggal <strong>{{ $proposal->decided_at?->translatedFormat('d F Y') ?? date('d F Y') }}</strong>, yang bertanda tangan di bawah ini:</p>
        
        <table class="identitas">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $kepalaDinas?->name ?? 'Nama Kepala Dinas / PPK' }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>Kepala Dinas TPH Kab. Muaro Jambi</td>
            </tr>
        </table>
        <p style="margin-left: 20px;">Selanjutnya disebut <strong>PIHAK PERTAMA</strong>.</p>

        <table class="identitas">
            <tr>
                <td>Nama Ketua</td>
                <td>:</td>
                <td>{{ $proposal->user->farmerProfile->ketua ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelompok Tani</td>
                <td>:</td>
                <td>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</td>
            </tr>
            <tr>
                <td>ID Poktan</td>
                <td>:</td>
                <td>{{ $proposal->user->farmerProfile->id_poktan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat Kelompok</td>
                <td>:</td>
                <td>{{ $proposal->user->farmerProfile->alamat ?? '-' }}</td>
            </tr>
        </table>
        <p style="margin-left: 20px;">Selanjutnya disebut <strong>PIHAK KEDUA</strong>.</p>

        <p>Kedua belah pihak sepakat mengadakan perjanjian pinjam pakai Alat dan Mesin Pertanian (Alsintan) berupa <strong>{{ $proposal->alsintan->name }}</strong> dengan ketentuan sebagai berikut:</p>

        <div class="pasal">
            <h4>PASAL 1<br>OBJEK PERJANJIAN</h4>
            <p>PIHAK PERTAMA meminjamkan kepada PIHAK KEDUA berupa 1 (satu) unit {{ $proposal->alsintan->name }} dalam kondisi baik dan siap pakai.</p>
            
            <h4>PASAL 2<br>HAK DAN KEWAJIBAN</h4>
            <p>1. PIHAK KEDUA berhak menggunakan Alsintan tersebut untuk keperluan pengelolaan lahan pertanian.<br>
               2. PIHAK KEDUA berkewajiban merawat, menjaga, dan mengembalikan Alsintan dalam kondisi baik seperti semula setelah selesai digunakan.</p>

            <h4>PASAL 3<br>PENUTUP</h4>
            <p>Surat perjanjian ini dibuat rangkap 2 (dua) dan ditandatangani di atas meterai secukupnya, memiliki kekuatan hukum yang sama.</p>
        </div>
    </div>

    <div class="signature">
        <table>
            <tr>
                <td>
                    <strong>PIHAK KEDUA</strong><br>
                    Ketua Kelompok Tani<br>
                    <br><br><br><br><br>
                    <u>{{ $proposal->user->farmerProfile->ketua ?? $proposal->user->name }}</u><br>
                </td>
                <td>
                    <strong>PIHAK PERTAMA</strong><br>
                    Kepala Dinas TPH<br>
                    <div class="qrcode" style="margin-top: 10px; margin-bottom: 10px; background: transparent; border: none;">
                        {!! QrCode::size(80)->generate(route('documents.surat-perjanjian', $proposal->id)) !!}
                    </div>
                    <u>{{ $kepalaDinas?->name ?? '.......................' }}</u><br>
                    NIP. {{ $kepalaDinas?->nip ?? '.......................' }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
