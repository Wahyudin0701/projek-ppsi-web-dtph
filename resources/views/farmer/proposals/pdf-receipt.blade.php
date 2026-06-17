<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengajuan Proposal</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm 2cm; /* Mengurangi margin agar muat 1 halaman */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12.5px; /* Sedikit mengurangi ukuran font dasar */
            color: #333;
            line-height: 1.35;
        }
        .header-table { width: 100%; margin-bottom: 2px; border: none; font-family: 'Times New Roman', Times, serif; }
        .header-table td { border: none; padding: 0; vertical-align: top; }
        .header-table .logo-cell { width: 80px; text-align: center; vertical-align: middle; }
        .header-table .logo-cell img { width: 75px; height: auto; }
        .header-table .text-cell { text-align: center; }
        .header-table h1 { font-size: 13pt; margin: 0; font-weight: bold; }
        .header-table h2 { font-size: 14pt; margin: 0; font-weight: bold; }
        .header-table p { font-size: 8.5pt; margin: 0; }
        .header-line { border: none; border-top: 3px solid #000; border-bottom: 1px solid #000; height: 2px; background: transparent; margin: 5px 0 15px 0; }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-decoration: underline;
        }
        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-info th, .table-info td {
            text-align: left;
            padding: 6px 8px;
            vertical-align: top;
        }
        .table-info th {
            width: 180px;
        }
        .table-info td.colon {
            width: 10px;
        }
        .footer {
            margin-top: 20px;
        }
        .footer-note {
            font-size: 10px;
            color: #666;
            font-style: italic;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 70px;
            color: rgba(0,0,0,0.03);
            z-index: -1;
        }
    </style>
</head>
<body>

    <div class="watermark">DTPH MUARO JAMBI</div>

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @php
                    $logoPath = public_path('images/Lambang_Kabupaten_Muaro_Jambi.png');
                    $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
                @endphp
                @if($logoData)
                    <img src="data:image/png;base64,{{ $logoData }}" alt="Logo Muaro Jambi">
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
        TANDA TERIMA PENGAJUAN PROPOSAL
    </div>

    <p>Telah diterima data pengajuan proposal melalui sistem E-Proposal dengan rincian sebagai berikut:</p>

    <table class="table-info">
        <tr>
            <th>Nomor Registrasi / ID</th>
            <td class="colon">:</td>
            <td><strong>#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
        </tr>
        <tr>
            <th>Tanggal Pengajuan</th>
            <td class="colon">:</td>
            <td>{{ \Carbon\Carbon::parse($proposal->submission_date)->translatedFormat('d F Y H:i') }} WIB</td>
        </tr>
        <tr>
            <th>Nama Kelompok Tani</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</td>
        </tr>
        <tr>
            <th>ID Poktan</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->id_poktan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama Ketua</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->ketua ?? '-' }}</td>
        </tr>
        <tr>
            <th>NIK Ketua</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->nik_ketua ?? '-' }}</td>
        </tr>
        <tr>
            <th>No. Kontak</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->kontak ?? '-' }}</td>
        </tr>
        <tr>
            <th>Komoditi Utama</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->komoditi_utama ?? '-' }} (Luas: {{ $proposal->user->farmerProfile->luas_lahan ?? '-' }} Ha)</td>
        </tr>
        <tr>
            <th>Alamat Sekretariat</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->alamat ?? '-' }}, Kec. {{ $proposal->user->farmerProfile->kecamatan ?? '-' }}</td>
        </tr>
        <tr>
            <th colspan="3" style="padding-top: 20px; font-weight: bold;">Rincian Pengajuan</th>
        </tr>
        <tr>
            <th>No. Surat Pengajuan</th>
            <td class="colon">:</td>
            <td>{{ $proposal->no_surat_pengajuan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jenis Bantuan</th>
            <td class="colon">:</td>
            <td>
                @if($proposal->alsintan_id)
                    <strong>Peminjaman Alsintan</strong>
                @else
                    <strong>Program Bantuan (Hibah)</strong>
                @endif
            </td>
        </tr>
        <tr>
            <th>Item / Nama Program</th>
            <td class="colon">:</td>
            <td>
                @if($proposal->alsintan_id)
                    {{ $proposal->alsintan->name }} (Merk: {{ $proposal->alsintan->merk ?? '-' }})
                @else
                    {{ $proposal->program->name }}
                @endif
            </td>
        </tr>

    </table>

    <div class="footer">
        <p>Demikian tanda terima ini dicetak secara otomatis oleh sistem sebagai bukti sah bahwa Kelompok Tani yang bersangkutan telah melakukan pengajuan.</p>
        
        <table style="width: 100%; margin-top: 15px;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <p style="margin-top: 0;"><strong>Status Saat Ini:</strong><br>
                    @php
                        $statusColors = [
                            'sedang_diverifikasi_admin'       => '#EAB308',
                            'sedang_diverifikasi_pimpinan'   => '#6366F1',
                            'persiapan_survei'        => '#F59E0B',
                            'sedang_survei'       => '#3B82F6',

                            'menunggu_keputusan_akhir'     => '#A855F7',
                            'disetujui'                => '#19A148',
                            'ditolak'                  => '#EF4444',
                        ];
                        $statusColor = $statusColors[$proposal->status] ?? '#6B7280';
                    @endphp
                    <span style="color: {{ $statusColor }}; font-weight: bold;">{{ $proposal->statusLabel }}</span></p>
                </td>
                <td style="width: 40%; text-align: center;">
                    @php
                        $hash = substr(md5($proposal->id . $proposal->submission_date->timestamp . config('app.key')), 0, 10);
                        $verifyUrl = route('verification.proposal', ['id' => $proposal->id, 'hash' => $hash]);
                        $qrCode = base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(80)->margin(1)->generate($verifyUrl));
                    @endphp
                    <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="80" height="80" style="border: 1px solid #eee; padding: 3px;">
                    <p style="font-size: 8px; color: #888; margin-top: 3px; margin-bottom: 0;">Scan untuk validasi dokumen</p>
                </td>
            </tr>
        </table>

        <p class="footer-note" style="margin-top: 25px; margin-bottom: 0;">
            * Dokumen ini di-generate oleh sistem E-Proposal DTPH Muaro Jambi pada {{ now()->translatedFormat('d F Y H:i') }}.<br>
            * Segala bentuk pemalsuan terhadap dokumen ini dapat dikenakan sanksi sesuai hukum yang berlaku.<br>
            * Pengajuan bantuan di lingkungan DTPH TIDAK DIPUNGUT BIAYA (GRATIS).
        </p>
    </div>
</body>
</html>
