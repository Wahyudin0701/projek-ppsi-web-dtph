<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengguna Terdaftar - DTPH Muaro Jambi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
        }
        @page {
            size: landscape;
            margin: 1cm;
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans p-8">

    <div class="mb-8 border-b-2 border-slate-800 pb-4 flex items-center gap-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto" onerror="this.style.display='none'">
        <div>
            <h1 class="text-2xl font-black uppercase tracking-wider text-slate-800">Dinas Tanaman Pangan dan Hortikultura</h1>
            <h2 class="text-lg font-bold text-slate-600">Kabupaten Muaro Jambi</h2>
            <p class="text-sm text-gray-500 mt-1">Laporan Rekapitulasi Pengguna Terdaftar (Petani & Kelompok Tani)</p>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-lg border border-gray-200">
        <div>
            <p><span class="font-bold text-gray-700 w-36 inline-block">Periode Daftar:</span> 
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d M Y') : 'Awal' }} 
                s/d 
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d M Y') : 'Akhir' }}
            </p>
            <p><span class="font-bold text-gray-700 w-36 inline-block">Jenis Lembaga:</span> 
                {{ request('afiliasi') == 'kelompok_tani' ? 'Kelompok Tani / Gapoktan / UPJA' : (request('afiliasi') == 'individu' ? 'Petani Individu' : 'Semua Jenis') }}
            </p>
        </div>
        <div>
            <p><span class="font-bold text-gray-700 w-36 inline-block">Status Verifikasi:</span> 
                {{ request('status') == 'approved' ? 'Disetujui' : (request('status') == 'rejected' ? 'Ditolak' : (request('status') == 'pending' ? 'Menunggu' : 'Semua Status')) }}
            </p>
            <p><span class="font-bold text-gray-700 w-36 inline-block">Total Data:</span> 
                {{ $users->count() }} Pengguna
            </p>
        </div>
    </div>

    <table class="w-full text-left border-collapse border border-slate-300">
        <thead>
            <tr class="bg-slate-100 border-b border-slate-300">
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300 w-12 text-center">No</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300">Nama Lengkap / NIK Ketua</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300">Nama Kelompok & Jenis</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300">Kontak & Alamat</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300 text-center">Tgl. Daftar</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($users as $index => $user)
                @php $status = $user->farmerProfile->status ?? 'pending'; @endphp
                <tr>
                    <td class="px-4 py-3 text-sm text-center border-r border-slate-300">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 text-sm border-r border-slate-300">
                        <span class="font-bold">{{ $user->name }}</span><br>
                        <span class="text-xs text-gray-500">NIK: {{ $user->farmerProfile->nik_ketua ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-slate-300">
                        <span class="font-semibold">{{ $user->farmerProfile->nama_kelompok ?? '-' }}</span><br>
                        <span class="text-xs text-indigo-600 uppercase">{{ $user->farmerProfile->afiliasi_lembaga ?? 'BELUM MELENGKAPI PROFIL' }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-slate-300">
                        <span class="font-medium text-xs">{{ $user->farmerProfile->kontak ?? '-' }}</span><br>
                        <span class="text-[10px] text-gray-500 line-clamp-2">{{ $user->farmerProfile->alamat ?? '-' }}, Kec. {{ $user->farmerProfile->kecamatan ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm text-center border-r border-slate-300">
                        {{ $user->created_at?->translatedFormat('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3 text-sm font-bold text-center">
                        @if($status == 'approved')
                            <span class="text-emerald-600 uppercase">Disetujui</span>
                        @elseif($status == 'rejected')
                            <span class="text-rose-600 uppercase">Ditolak</span>
                        @else
                            <span class="text-amber-600 uppercase">Menunggu</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 font-medium">Tidak ada data pengguna yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-12 flex justify-end">
        <div class="text-center">
            <p class="text-sm mb-16">Muaro Jambi, {{ now()->translatedFormat('d F Y') }}<br>Kepala Dinas,</p>
            <p class="font-bold underline">{{ auth()->user()->name }}</p>
            <p class="text-xs">NIP. ........................................</p>
        </div>
    </div>

    <div class="mt-8 text-center no-print">
        <button onclick="window.print()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-bold shadow-md hover:bg-indigo-700">Cetak Sekarang</button>
        <button onclick="window.close()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg font-bold shadow-md hover:bg-gray-300 ml-2">Tutup Tab</button>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
