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
        
        .status-badge { font-weight: bold; text-transform: uppercase; font-size: 10px; }
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
                        @php
                            $namaUtama = $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name;
                            $idPoktan = $proposal->user->farmerProfile->id_poktan ?? null;
                        @endphp
                        <strong>{{ $namaUtama }}</strong>
                        @if($idPoktan)
                            <br>
                            <span style="font-size: 9px; color: #555; font-family: monospace;">ID: {{ $idPoktan }}</span>
                        @endif
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
                            $statusConfig = [
                                'sedang_diverifikasi_admin'    => ['bg' => '#FEF9C3', 'text' => '#A16207', 'label' => 'Di Admin'],
                                'sedang_diverifikasi_pimpinan' => ['bg' => '#E0E7FF', 'text' => '#4338CA', 'label' => 'Di Pimpinan'],
                                'persiapan_survei'             => ['bg' => '#FEF3C7', 'text' => '#B45309', 'label' => 'Di Kabid'],
                                'sedang_survei'                => ['bg' => '#DBEAFE', 'text' => '#1D4ED8', 'label' => 'Sedang Survei'],
                                'verifikasi_cpcl'              => ['bg' => '#CCFBF1', 'text' => '#0F766E', 'label' => 'Verifikasi CPCL'],
                                'menunggu_keputusan_akhir'     => ['bg' => '#F3E8FF', 'text' => '#7E22CE', 'label' => 'Finalisasi'],
                                'direkomendasikan'             => ['bg' => '#D1FAE5', 'text' => '#065F46', 'label' => 'Rekomendasi Pusat'],
                                'disetujui'                    => ['bg' => '#DCFCE7', 'text' => '#15803D', 'label' => 'Disetujui'],
                                'dikembalikan'                 => ['bg' => '#F3F4F6', 'text' => '#374151', 'label' => 'Selesai'],
                                'ditolak'                      => ['bg' => '#FEE2E2', 'text' => '#B91C1C', 'label' => 'Ditolak'],
                                'ditolak_pusat'                => ['bg' => '#FEE2E2', 'text' => '#7F1D1D', 'label' => 'Ditolak Pusat'],
                            ];
                            $sc = $statusConfig[$proposal->status] ?? ['bg' => '#F3F4F6', 'text' => '#4B5563', 'label' => $proposal->statusLabel];
                        @endphp
                        <span class="status-badge" style="color: {{ $sc['text'] }};">{{ $sc['label'] }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada data proposal yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px; float: left; width: 230px; margin-right: 20px;">
        <strong style="font-size: 11px;">Rekapitulasi Status Proposal:</strong>
        <table class="data-table" style="margin-top: 5px; margin-bottom: 0;">
            @php
                $statusCounts = [
                    'Di Admin' => $proposals->where('status', 'sedang_diverifikasi_admin')->count(),
                    'Di Pimpinan' => $proposals->where('status', 'sedang_diverifikasi_pimpinan')->count(),
                    'Di Kabid' => $proposals->where('status', 'persiapan_survei')->count(),
                    'Sedang Survei' => $proposals->where('status', 'sedang_survei')->count(),
                    'Verifikasi CPCL' => $proposals->where('status', 'verifikasi_cpcl')->count(),
                    'Finalisasi' => $proposals->where('status', 'menunggu_keputusan_akhir')->count(),
                    'Rekomendasi Pusat' => $proposals->where('status', 'direkomendasikan')->count(),
                    'Disetujui' => $proposals->where('status', 'disetujui')->count(),
                    'Ditolak' => $proposals->where('status', 'ditolak')->count(),
                    'Ditolak Pusat' => $proposals->where('status', 'ditolak_pusat')->count(),
                    'Selesai (Dikembalikan)' => $proposals->where('status', 'dikembalikan')->count(),
                ];
                $hasRecap = false;
            @endphp
            @foreach($statusCounts as $label => $count)
                @if($count > 0)
                    @php $hasRecap = true; @endphp
                    <tr>
                        <td style="padding: 4px 6px;">{{ $label }}</td>
                        <td style="padding: 4px 6px; text-align: center; font-weight: bold; width: 40px;">{{ $count }}</td>
                    </tr>
                @endif
            @endforeach
            @if(!$hasRecap)
                <tr><td colspan="2" style="padding: 4px 6px; text-align: center; color: #777;">Tidak ada data</td></tr>
            @endif
        </table>
    </div>

    <div style="margin-top: 20px; float: left; width: 230px; margin-right: 20px;">
        <strong style="font-size: 11px;">Rekap Jenis Pengajuan:</strong>
        <table class="data-table" style="margin-top: 5px; margin-bottom: 15px;">
            <tr>
                <td style="padding: 4px 6px;">Alsintan</td>
                <td style="padding: 4px 6px; text-align: center; font-weight: bold; width: 40px;">{{ $proposals->whereNotNull('alsintan_id')->count() }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 6px;">Program Bantuan</td>
                <td style="padding: 4px 6px; text-align: center; font-weight: bold; width: 40px;">{{ $proposals->whereNotNull('program_id')->count() }}</td>
            </tr>
        </table>
        
        <strong style="font-size: 11px;">Kategori Alsintan:</strong>
        <table class="data-table" style="margin-top: 5px; margin-bottom: 0;">
            @php
                $alsintanCounts = $proposals->whereNotNull('alsintan_id')->groupBy(function($item) {
                    return $item->alsintan->category->name ?? 'Tanpa Kategori';
                })->map->count();
            @endphp
            @forelse($alsintanCounts as $label => $count)
                <tr>
                    <td style="padding: 4px 6px;">{{ $label }}</td>
                    <td style="padding: 4px 6px; text-align: center; font-weight: bold; width: 40px;">{{ $count }}</td>
                </tr>
            @empty
                <tr><td colspan="2" style="padding: 4px 6px; text-align: center; color: #777;">Tidak ada data</td></tr>
            @endforelse
        </table>
    </div>

    <div style="margin-top: 20px; float: left; width: 230px;">
        <strong style="font-size: 11px;">Jenis Program Bantuan:</strong>
        <table class="data-table" style="margin-top: 5px; margin-bottom: 0;">
            @php
                $programCounts = $proposals->whereNotNull('program_id')->groupBy(function($item) {
                    return $item->program->category->name ?? 'Tanpa Kategori';
                })->map->count();
            @endphp
            @forelse($programCounts as $label => $count)
                <tr>
                    <td style="padding: 4px 6px;">{{ $label }}</td>
                    <td style="padding: 4px 6px; text-align: center; font-weight: bold; width: 40px;">{{ $count }}</td>
                </tr>
            @empty
                <tr><td colspan="2" style="padding: 4px 6px; text-align: center; color: #777;">Tidak ada data</td></tr>
            @endforelse
        </table>
    </div>
    
    <div style="clear: both;"></div>

    <div class="footer">
        <p>Muaro Jambi, {{ now()->translatedFormat('d F Y') }}<br>Kepala Dinas,</p>
        <div class="name">{{ auth()->user()->display_name }}</div>
        <p style="font-size: 10px;">NIP. {{ auth()->user()->display_nip !== '-' ? auth()->user()->display_nip : '........................................' }}</p>
    </div>

</body>
</html>
