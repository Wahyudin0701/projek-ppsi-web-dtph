<x-app-layout>
    <x-slot name="header">Detail Proposal</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.proposals.index') }}" class="hover:text-primary-600 transition-colors">Kelola Proposal</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-semibold text-gray-700">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Pengajuan Proposal</h2>
                <p class="text-gray-500 text-sm mt-1">Tinjau informasi lengkap dan ambil keputusan untuk proposal ini.</p>
            </div>
            <a href="{{ route('admin.proposals.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @php
            $isAlsintan = $proposal->alsintan_id !== null;
            $statusConfig = [
                'pending_verifikasi' => ['bg' => 'bg-yellow-100 text-yellow-700', 'label' => 'Menunggu Verifikasi'],
                'disetujui'          => ['bg' => 'bg-green-100 text-green-700', 'label' => 'Disetujui'],
                'ditolak'            => ['bg' => 'bg-red-100 text-red-700', 'label' => 'Ditolak'],
            ];
            $sc = $statusConfig[$proposal->status] ?? ['bg' => 'bg-gray-100 text-gray-600', 'label' => $proposal->status];
        @endphp

        {{-- Top Summary Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                        {{ $isAlsintan ? 'Peminjaman Alsintan' : 'Program Bantuan' }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest {{ $sc['bg'] }}">
                        {{ $sc['label'] }}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-gray-900">
                    {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                </h3>
                <p class="text-gray-500 text-sm mt-1">Nomor Registrasi: <span class="font-bold text-gray-900">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span></p>
            </div>

            {{-- Action Buttons --}}
            @if($proposal->status === 'pending_verifikasi')
                <div class="flex flex-wrap gap-3 w-full sm:w-auto" x-data="{ showApprove: false, showReject: false }">
                    <button @click="showApprove = true"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#19A148] text-white text-sm font-bold rounded-xl hover:bg-green-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Setujui
                    </button>
                    <button @click="showReject = true"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak
                    </button>

                    {{-- Approve Confirm Modal --}}
                    <template x-if="showApprove">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showApprove = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Konfirmasi Persetujuan</h3>
                                            <p class="text-sm text-gray-500">Tindakan ini tidak dapat diurungkan.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-6">Anda akan <strong class="text-green-600">menyetujui</strong> proposal <strong>{{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong>.</p>
                                    <div class="flex flex-row-reverse gap-3">
                                        <form action="{{ route('admin.proposals.approve', $proposal) }}" method="POST" class="flex-1">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="w-full px-6 py-3 bg-[#19A148] text-white font-bold rounded-xl hover:bg-green-700 transition-colors text-sm">Ya, Setujui</button>
                                        </form>
                                        <button @click="showApprove = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Reject Confirm Modal --}}
                    <template x-if="showReject">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showReject = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Konfirmasi Penolakan</h3>
                                            <p class="text-sm text-gray-500">Tindakan ini tidak dapat diurungkan.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-6">Anda akan <strong class="text-red-600">menolak</strong> proposal <strong>{{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong>.</p>
                                    <div class="flex flex-row-reverse gap-3">
                                        <form action="{{ route('admin.proposals.reject', $proposal) }}" method="POST" class="flex-1">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full px-6 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors text-sm">Ya, Tolak</button>
                                        </form>
                                        <button @click="showReject = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @else
                <span class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold {{ $proposal->status === 'disetujui' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                    {{ $proposal->status === 'disetujui' ? 'Sudah Disetujui' : 'Sudah Ditolak' }}
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Main Info --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Petani Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                    <h4 class="font-bold text-gray-900 mb-6 text-lg border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Informasi Pengaju
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Kelompok Tani</p>
                            <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->nama_kelompok ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Ketua</p>
                            <p class="text-gray-900 font-medium">{{ $proposal->user->farmerProfile->ketua ?? $proposal->user->name }}</p>
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
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Lokasi Lahan / Penggunaan</p>
                            <p class="text-gray-900 font-medium">{{ $proposal->lokasi_lahan }}</p>
                        </div>
                    </div>
                </div>

                {{-- Object Detail --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                    <h4 class="font-bold text-gray-900 mb-6 text-lg border-b border-gray-100 pb-3 flex items-center gap-2">
                        @if($isAlsintan)
                            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z"/></svg>
                            Detail Alat yang Dipinjam
                        @else
                            <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Detail Program yang Diajukan
                        @endif
                    </h4>
                    @if($isAlsintan)
                        <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Alat</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->alsintan->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Merk / Tipe</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->alsintan->merk ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kapasitas</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->alsintan->capacity ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Stok Tersedia (saat ini)</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->alsintan->available_stock }} unit</p>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Program</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->program->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tipe Program</p>
                                <p class="text-gray-900 font-medium capitalize">{{ str_replace('_', ' ', $proposal->program->type) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Sasaran</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->program->sasaran ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kuota Program</p>
                                <p class="text-gray-900 font-medium">{{ $proposal->program->kuota ?? '-' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar Timeline --}}
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h4 class="font-bold text-gray-900 mb-5 border-b border-gray-200 pb-3">Timeline Pengajuan</h4>
                    <div class="relative border-l-2 border-primary-200 ml-3 space-y-6 pb-2">

                        <div class="relative">
                            <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                            <div class="pl-4">
                                <p class="text-sm font-bold text-gray-900">Pengajuan Diterima</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $proposal->submission_date?->translatedFormat('d M Y - H:i') }} WIB</p>
                            </div>
                        </div>

                        <div class="relative">
                            @if($proposal->status === 'pending_verifikasi')
                                <div class="absolute -left-[21px] bg-yellow-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Menunggu Keputusan</p>
                                    <p class="text-xs text-gray-500 mt-1">Sedang dalam antrian verifikasi</p>
                                </div>
                            @elseif($proposal->status === 'disetujui')
                                <div class="absolute -left-[21px] bg-green-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-green-700">Proposal Disetujui</p>
                                    <p class="text-xs text-gray-500 mt-1">Verifikasi selesai & berhasil</p>
                                </div>
                            @elseif($proposal->status === 'ditolak')
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Proposal Ditolak</p>
                                    <p class="text-xs text-gray-500 mt-1">Tidak lolos proses verifikasi</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h4 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Kontak Pengaju</h4>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Nama Akun</p>
                                <p class="text-sm font-bold text-gray-800">{{ $proposal->user->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Email</p>
                                <p class="text-sm font-bold text-gray-800">{{ $proposal->user->email }}</p>
                            </div>
                        </div>
                        @if($proposal->user->farmerProfile?->no_telp)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">No. Telepon</p>
                                <p class="text-sm font-bold text-gray-800">{{ $proposal->user->farmerProfile->no_telp }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
