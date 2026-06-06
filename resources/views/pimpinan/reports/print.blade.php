<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Proposal - DTPH Muaro Jambi</title>
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
            <p class="text-sm text-gray-500 mt-1">Laporan Rekapitulasi Pengajuan Proposal Bantuan & Alsintan</p>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-lg border border-gray-200">
        <div>
            <p><span class="font-bold text-gray-700 w-32 inline-block">Periode:</span> 
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d M Y') : 'Awal' }} 
                s/d 
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d M Y') : 'Akhir' }}
            </p>
            <p><span class="font-bold text-gray-700 w-32 inline-block">Jenis Pengajuan:</span> 
                {{ request('type') == 'alsintan' ? 'Alsintan' : (request('type') == 'program' ? 'Program Bantuan' : 'Semua Jenis') }}
            </p>
        </div>
        <div>
            <p><span class="font-bold text-gray-700 w-32 inline-block">Status:</span> 
                {{ request('status') ? ucfirst(request('status')) : 'Semua Status' }}
            </p>
            <p><span class="font-bold text-gray-700 w-32 inline-block">Total Data:</span> 
                {{ $proposals->count() }} Proposal
            </p>
        </div>
    </div>

    <table class="w-full text-left border-collapse border border-slate-300">
        <thead>
            <tr class="bg-slate-100 border-b border-slate-300">
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300 w-12 text-center">No</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300">No. Registrasi</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300">Nama Pengaju (Kelompok Tani)</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300">Jenis & Objek Pengajuan</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider border-r border-slate-300 text-center">Tgl. Pengajuan</th>
                <th class="px-4 py-3 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">Status Akhir</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($proposals as $index => $proposal)
                @php $isAlsintan = $proposal->alsintan_id !== null; @endphp
                <tr>
                    <td class="px-4 py-3 text-sm text-center border-r border-slate-300">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-bold text-sm border-r border-slate-300">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-3 text-sm border-r border-slate-300">
                        <span class="font-bold">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</span><br>
                        <span class="text-xs text-gray-500">Ketua: {{ $proposal->user->name }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-slate-300">
                        <span class="font-semibold text-xs">{{ $isAlsintan ? 'ALSINTAN' : 'PROGRAM' }}</span><br>
                        {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                    </td>
                    <td class="px-4 py-3 text-sm text-center border-r border-slate-300">
                        {{ $proposal->submission_date?->translatedFormat('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3 text-sm font-bold text-center">
                        @if($proposal->status == 'disetujui')
                            <span class="text-emerald-600 uppercase">Disetujui</span>
                        @elseif($proposal->status == 'ditolak')
                            <span class="text-rose-600 uppercase">Ditolak</span>
                        @else
                            <span class="text-amber-600 uppercase">Menunggu</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 font-medium">Tidak ada data proposal yang sesuai dengan filter.</td>
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
            // Auto trigger print dialog when page loads
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
