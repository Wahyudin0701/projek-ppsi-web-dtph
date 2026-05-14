<x-app-layout>
    <x-slot name="header">Detail Pengajuan</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('farmer.proposals.index') }}" class="hover:text-primary-600 transition-colors">Riwayat Ajuan</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-semibold text-gray-700">Detail Proposal</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Pengajuan Proposal</h2>
                <p class="text-gray-500 text-sm mt-1">Informasi lengkap dan status terbaru dari proposal yang Anda ajukan.</p>
            </div>
            <a href="{{ route('farmer.proposals.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
            
            {{-- Header Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-2xl font-black text-gray-900">
                            @if($proposal->alsintan_id)
                                {{ $proposal->alsintan->name }}
                            @else
                                {{ $proposal->program->name }}
                            @endif
                        </h3>
                        @php
                            $statusColors = [
                                'pending_verifikasi' => 'bg-yellow-100 text-yellow-700',
                                'disetujui'          => 'bg-green-100 text-green-700',
                                'ditolak'            => 'bg-red-100 text-red-700',
                            ];
                            $color = $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest {{ $color }}">
                            {{ str_replace('_', ' ', $proposal->status) }}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm">Nomor Registrasi: <span class="font-bold text-gray-900">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                </div>
                <div class="flex gap-3 w-full sm:w-auto">
                    <a href="{{ route('farmer.proposals.download-receipt', $proposal->id) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 bg-primary-600 text-white text-sm font-bold rounded-xl hover:bg-primary-700 transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh Bukti
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Main Info --}}
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8">
                        <h4 class="font-bold text-gray-900 mb-6 text-lg border-b border-gray-100 pb-3">Informasi Kelompok Tani</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Kelompok</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Ketua</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->ketua ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Komoditi Utama</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->komoditi_utama ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kecamatan</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->kecamatan ?? '-' }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Lokasi Lahan Penggunaan</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->lokasi_lahan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Info --}}
                <div class="space-y-6">
                    <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 p-6">
                        <h4 class="font-bold text-gray-900 mb-5 border-b border-gray-200 pb-3">Timeline Pengajuan</h4>
                        
                        <div class="relative border-l-2 border-primary-200 ml-3 space-y-6 pb-2">
                            
                            {{-- Step 1: Submitted --}}
                            <div class="relative">
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Pengajuan Dikirim</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $proposal->submission_date->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-[11px] text-primary-600 font-semibold mt-0.5">Proposal berhasil masuk ke sistem.</p>
                                </div>
                            </div>

                            {{-- Step 2: Review Process --}}
                            <div class="relative">
                                @if($proposal->status === 'pending_verifikasi')
                                    <div class="absolute -left-[21px] bg-yellow-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Menunggu Ditinjau</p>
                                        <p class="text-xs text-gray-500 mt-1">Proposal Anda sedang dalam antrian verifikasi Admin.</p>
                                        <span class="inline-block mt-1.5 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">Proses</span>
                                    </div>
                                @else
                                    <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-900">Ditinjau oleh Admin</p>
                                        <p class="text-xs text-gray-500 mt-1">Proposal Anda telah diterima dan dievaluasi oleh tim Admin DTPH.</p>
                                        <span class="inline-block mt-1.5 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-primary-100 text-primary-700">Selesai</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Step 3: Final Decision --}}
                            @if($proposal->status !== 'pending_verifikasi')
                                <div class="relative">
                                    @if($proposal->status === 'disetujui')
                                        <div class="absolute -left-[21px] bg-green-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                        <div class="pl-4">
                                            <p class="text-sm font-bold text-green-700">Proposal Disetujui 🎉</p>
                                            <p class="text-xs text-gray-500 mt-1">Selamat! Proposal Anda telah resmi disetujui oleh Admin DTPH.</p>
                                            <span class="inline-block mt-1.5 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-green-100 text-green-700">Disetujui</span>
                                        </div>
                                    @elseif($proposal->status === 'ditolak')
                                        <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                        <div class="pl-4">
                                            <p class="text-sm font-bold text-red-600">Proposal Ditolak</p>
                                            <p class="text-xs text-gray-500 mt-1">Proposal Anda tidak lolos proses verifikasi. Anda dapat mengajukan kembali.</p>
                                            <span class="inline-block mt-1.5 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-red-100 text-red-700">Ditolak</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>
