<x-app-layout>
    <x-slot name="header">{{ __('Pengajuan Berhasil') }}</x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-2xl border border-gray-100 text-center px-8 py-8 sm:px-12 sm:py-10">

                {{-- Icon --}}
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>

                <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Proposal Berhasil Diajukan!</h3>
                <p class="text-gray-500 mb-6 max-w-lg mx-auto text-sm leading-relaxed">Terima kasih, data proposal Anda telah masuk ke sistem kami dan akan segera diverifikasi oleh tim Dinas Tanaman Pangan dan Hortikultura.</p>

                {{-- Detail Box --}}
                <div class="bg-gray-50 rounded-2xl p-5 text-left mb-6 border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-3 border-b border-gray-200 pb-2 text-sm">Rincian Pengajuan</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 text-sm">
                        <div>
                            <p class="text-gray-500 font-semibold mb-0.5 text-xs">ID Proposal</p>
                            <p class="font-bold text-gray-900">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-semibold mb-0.5 text-xs">Tanggal Pengajuan</p>
                            <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($proposal->submission_date)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-gray-500 font-semibold mb-0.5 text-xs">Jenis Pengajuan</p>
                            <p class="font-bold text-gray-900">
                                @if($proposal->alsintan_id)
                                    Peminjaman Alat — {{ $proposal->alsintan->name }}
                                @else
                                    Program Bantuan — {{ $proposal->program->name }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('farmer.proposals.download-receipt', $proposal->id) }}" target="_blank"
                       class="w-full sm:w-auto px-8 py-3 bg-primary-600 text-white font-bold rounded-xl shadow-md shadow-primary-500/30 hover:bg-primary-700 transition-colors flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download Bukti PDF
                    </a>
                    <a href="{{ route('farmer.proposals.index') }}"
                       class="w-full sm:w-auto px-8 py-3 bg-white text-gray-700 border border-gray-300 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                        Lihat Riwayat
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>