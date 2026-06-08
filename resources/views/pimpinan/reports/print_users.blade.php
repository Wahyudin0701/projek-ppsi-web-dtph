<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Pengguna Terdaftar - DTPH Muaro Jambi</title>
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

    <div class="title">LAPORAN REKAPITULASI PENGGUNA TERDAFTAR</div>
    <div class="subtitle">(PETANI & KELOMPOK TANI)</div>

    <table class="info-table">
        <tr>
            <td class="label">Periode Daftar</td>
            <td class="colon">:</td>
            <td style="width: 40%">
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d M Y') : 'Awal' }} 
                s/d 
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d M Y') : 'Akhir' }}
            </td>
            <td class="label">Status Verifikasi</td>
            <td class="colon">:</td>
            <td>
                {{ request('status') == 'approved' ? 'Disetujui' : (request('status') == 'rejected' ? 'Ditolak' : (request('status') == 'pending' ? 'Menunggu' : 'Semua Status')) }}
            </td>
        </tr>
        <tr>
            <td class="label">Jenis Lembaga</td>
            <td class="colon">:</td>
            <td>
                {{ request('afiliasi') == 'kelompok_tani' ? 'Kelompok Tani / Gapoktan / UPJA' : (request('afiliasi') == 'individu' ? 'User Umum' : 'Semua Jenis') }}
            </td>
            <td class="label">Total Data</td>
            <td class="colon">:</td>
            <td>{{ $users->count() }} Pengguna</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Lengkap / NIK Ketua</th>
                <th>Nama Kelompok & Jenis</th>
                <th>Kontak & Alamat</th>
                <th style="width: 100px;">Tgl. Daftar</th>
                <th style="width: 100px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                @php $status = $user->farmerProfile->status ?? 'pending'; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $user->name }}</strong><br>
                        <span style="font-size: 9px; color: #555;">NIK: {{ $user->farmerProfile->nik_ketua ?? '-' }}</span>
                    </td>
                    <td>
                        <strong>{{ $user->farmerProfile->nama_kelompok ?? '-' }}</strong><br>
                        <span style="font-size: 9px; text-transform: uppercase;">{{ $user->farmerProfile->afiliasi_lembaga ?? 'BELUM MELENGKAPI PROFIL' }}</span>
                    </td>
                    <td>
                        <strong>{{ $user->farmerProfile->kontak ?? '-' }}</strong><br>
                        <span style="font-size: 9px; color: #555;">{{ $user->farmerProfile->alamat ?? '-' }}, Kec. {{ $user->farmerProfile->kecamatan ?? '-' }}</span>
                    </td>
                    <td class="text-center">
                        {{ $user->created_at?->translatedFormat('d/m/Y') }}
                    </td>
                    <td class="text-center">
                        @if($status == 'approved')
                            <span class="status-badge status-approved">Disetujui</span>
                        @elseif($status == 'rejected')
                            <span class="status-badge status-rejected">Ditolak</span>
                        @else
                            <span class="status-badge status-pending">Menunggu</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada data pengguna yang sesuai dengan filter.</td>
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
