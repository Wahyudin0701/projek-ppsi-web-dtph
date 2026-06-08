<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Proposal - DTPH Muaro Jambi</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.3;
        }
        .header-table { width: 100%; margin-bottom: 2px; border: none; font-family: 'Times New Roman', Times, serif; }
        .header-table td { border: none; padding: 0; vertical-align: top; }
        .header-table .logo-cell { width: 80px; text-align: center; vertical-align: middle; }
        .header-table .logo-cell img { width: 75px; height: auto; }
        .header-table .text-cell { text-align: center; }
        .header-table h1 { font-size: 14pt; margin: 0; font-weight: bold; }
        .header-table h2 { font-size: 15pt; margin: 0; font-weight: bold; }
        .header-table p { font-size: 9pt; margin: 0; }
        .header-line { border: none; border-top: 3px solid #000; border-bottom: 1px solid #000; height: 2px; margin: 5px 0 15px 0; }
        
        .title { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 5px; text-decoration: underline; }
        .subtitle { text-align: center; font-size: 12px; margin-bottom: 15px; }
        
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 2px 0; vertical-align: top; }
        .info-table .label { width: 120px; font-weight: bold; }
        .info-table .colon { width: 10px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #999; padding: 6px; vertical-align: top; }
        .data-table th { background-color: #f0f0f0; font-weight: bold; text-align: center; text-transform: uppercase; font-size: 10px; }
        .data-table .text-center { text-align: center; }
        
        .footer { width: 300px; float: right; text-align: center; margin-top: 20px; }
        .footer p { margin: 0; }
        .footer .name { margin-top: 60px; font-weight: bold; text-decoration: underline; }
        
        .status-badge { font-weight: bold; text-transform: uppercase; font-size: 9px; }
        .status-approved { color: #166534; }
        .status-rejected { color: #991b1b; }
        .status-pending { color: #b45309; }
    </style>
</head>
<body>
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

    <div class="title">LAPORAN REKAPITULASI PENGAJUAN PROPOSAL</div>
    <div class="subtitle">BANTUAN DAN PEMINJAMAN ALSINTAN</div>

    <table class="info-table">
        <tr>
            <td class="label">Periode</td>
            <td class="colon">:</td>
            <td style="width: 40%">
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d M Y') : 'Awal' }} 
                s/d 
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d M Y') : 'Akhir' }}
            </td>
            <td class="label">Status</td>
            <td class="colon">:</td>
            <td>{{ request('status') ? ucfirst(request('status')) : 'Semua Status' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Pengajuan</td>
            <td class="colon">:</td>
            <td>{{ request('type') == 'alsintan' ? 'Alsintan' : (request('type') == 'program' ? 'Program Bantuan' : 'Semua Jenis') }}</td>
            <td class="label">Total Data</td>
            <td class="colon">:</td>
            <td>{{ $proposals->count() }} Proposal</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 100px;">No. Registrasi</th>
                <th>Nama Pengaju (Kelompok Tani)</th>
                <th>Jenis & Objek Pengajuan</th>
                <th style="width: 100px;">Tgl. Pengajuan</th>
                <th style="width: 100px;">Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proposals as $index => $proposal)
                @php $isAlsintan = $proposal->alsintan_id !== null; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>
                        <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong><br>
                        <span style="font-size: 9px; color: #555;">Ketua: {{ $proposal->user->name }}</span>
                    </td>
                    <td>
                        <span style="font-size: 9px; font-weight: bold;">{{ $isAlsintan ? 'ALSINTAN' : 'PROGRAM' }}</span><br>
                        {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                    </td>
                    <td class="text-center">
                        {{ $proposal->submission_date?->translatedFormat('d/m/Y') }}
                    </td>
                    <td class="text-center">
                        @php
                            $statusColors = [
                                'sedang_diverifikasi_admin'    => '#EAB308',
                                'sedang_diverifikasi_pimpinan' => '#6366F1',
                                'persiapan_survei'             => '#F59E0B',
                                'sedang_survei'                => '#3B82F6',
                                'verifikasi_cpcl'              => '#F59E0B',
                                'menunggu_keputusan_akhir'     => '#A855F7',
                                'disetujui'                    => '#16A34A',
                                'dikembalikan'                 => '#14B8A6',
                                'ditolak'                      => '#DC2626',
                            ];
                            $statusColor = $statusColors[$proposal->status] ?? '#6B7280';
                        @endphp
                        <span class="status-badge" style="color: {{ $statusColor }}">{{ $proposal->statusLabel }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada data proposal yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Muaro Jambi, {{ now()->translatedFormat('d F Y') }}<br>Kepala Dinas,</p>
        <div class="name">{{ auth()->user()->display_name }}</div>
        <p style="font-size: 10px;">NIP. {{ auth()->user()->display_nip !== '-' ? auth()->user()->display_nip : '........................................' }}</p>
    </div>

</body>
</html>
