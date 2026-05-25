<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengajuan Proposal</title>
    <style>
        @page {
            size: A4;
            margin: 3cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0 0;
            font-size: 12px;
        }
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

    <div class="header">
        <h2>DINAS TANAMAN PANGAN DAN HORTIKULTURA</h2>
        <h2>KABUPATEN MUARO JAMBI</h2>
        <p>Sistem Informasi E-Proposal Pengajuan Alsintan & Bantuan</p>
    </div>

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
            <th>Nama Ketua</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->ketua ?? '-' }}</td>
        </tr>
        <tr>
            <th>Komoditi Utama</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->komoditi_utama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Alamat Sekretariat</th>
            <td class="colon">:</td>
            <td>Kec. {{ $proposal->user->farmerProfile->kecamatan ?? '-' }}</td>
        </tr>
        <tr>
            <th colspan="3" style="padding-top: 20px; font-weight: bold;">Rincian Pengajuan</th>
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
        <tr>
            <th>Alamat Kelompok</th>
            <td class="colon">:</td>
            <td>{{ $proposal->user->farmerProfile->alamat ?? '-' }}</td>
        </tr>
        @if($proposal->alsintan_id)
        <tr>
            <th>Rencana Durasi Pemakaian</th>
            <td class="colon">:</td>
            <td><strong>{{ $proposal->rencana_durasi_hari ?? '-' }} Hari</strong></td>
        </tr>
        @endif
    </table>

    <div class="footer">
        <p>Demikian tanda terima ini dicetak secara otomatis oleh sistem sebagai bukti sah bahwa Kelompok Tani yang bersangkutan telah melakukan pengajuan.</p>
        
        <table style="width: 100%; margin-top: 15px;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <p style="margin-top: 0;"><strong>Status Saat Ini:</strong><br>
                    @php
                        $statusColors = [
                            'pending_verifikasi'       => '#EAB308',
                            'diteruskan_ke_pimpinan'   => '#6366F1',
                            'didisposisi_kabid'        => '#F59E0B',
                            'surat_tugas_terbit'       => '#3B82F6',
                            'survei_selesai'           => '#F97316',
                            'menunggu_approval_ba'     => '#A855F7',
                            'disetujui'                => '#19A148',
                            'ditolak'                  => '#EF4444',
                        ];
                        $statusColor = $statusColors[$proposal->status] ?? '#6B7280';
                    @endphp
                    <span style="color: {{ $statusColor }}; font-weight: bold;">{{ $proposal->statusLabel }}</span></p>
                </td>
                <td style="width: 40%; text-align: center;">
                    <p style="font-size: 10px; margin-bottom: 5px; font-weight: bold; margin-top: 0;">Tanda Tangan Digital:</p>
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
