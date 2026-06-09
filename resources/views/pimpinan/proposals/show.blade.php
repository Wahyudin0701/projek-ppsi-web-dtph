<x-app-layout>
    <x-slot name="header">Detail Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Pengajuan Proposal</h2>
            </div>
            <a href="{{ route('pimpinan.proposals.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @php
            $isAlsintan = $proposal->alsintan_id !== null;
            $sc = match($proposal->status) {
                'sedang_diverifikasi_admin'       => ['bg' => 'bg-yellow-100 text-yellow-700',  'label' => 'Sedang Diverifikasi Admin'],
                'sedang_diverifikasi_pimpinan'   => ['bg' => 'bg-indigo-100 text-indigo-700',  'label' => 'Sedang Diverifikasi Pimpinan'],
                'persiapan_survei'        => ['bg' => 'bg-amber-100 text-amber-700',    'label' => 'Disposisi ke Kabid'],
                'sedang_survei'       => ['bg' => 'bg-blue-100 text-blue-700',      'label' => 'Sedang Survei'],
                'verifikasi_cpcl'    => ['bg' => 'bg-teal-100 text-teal-700',      'label' => 'Verifikasi CPCL'],
                'menunggu_keputusan_akhir'     => ['bg' => 'bg-purple-100 text-purple-700',  'label' => 'Menunggu Keputusan Akhir'],
                'direkomendasikan'             => ['bg' => 'bg-emerald-100 text-emerald-700','label' => 'Sedang Diverifikasi Pusat'],
                'disetujui'                => ['bg' => 'bg-green-100 text-green-700',    'label' => 'Disetujui'],
                'dikembalikan'             => ['bg' => 'bg-gray-100 text-gray-700',      'label' => 'Telah Dikembalikan'],
                'ditolak'                  => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Di tolak'],
                'ditolak_pusat'            => ['bg' => 'bg-red-100 text-red-700',        'label' => 'Di tolak'],
                default                    => ['bg' => 'bg-gray-100 text-gray-600',       'label' => $proposal->statusLabel],
            };
        @endphp

        {{-- Summary + Actions --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="mb-2">
                    <span class="px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest inline-block {{ $sc['bg'] }}">
                        {{ $sc['label'] }}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-gray-900">
                    {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                </h3>
                <p class="text-gray-500 text-sm mt-1 mb-3">Nomor Registrasi: <span class="font-bold text-gray-900">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md inline-block {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                        {{ $isAlsintan ? 'Peminjaman Alsintan' : 'Program Bantuan' }}
                    </span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-end sm:items-center">
                @if($proposal->file_proposal)
                    <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-50 border border-indigo-100 text-indigo-700 hover:bg-indigo-100 text-sm font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Lihat Proposal
                    </a>
                @endif
                
                @if($proposal->status === 'sedang_diverifikasi_pimpinan')
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto"
                     x-data="{ showDispose: false, showApprove: false, showReject: false }">

                    {{-- Primary: Disposisi --}}
                    <button @click="showDispose = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        Disposisi ke Kabid
                    </button>
                    <button @click="showApprove = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Setujui Langsung
                    </button>
                    <button @click="showReject = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak
                    </button>

                    {{-- Dispose Modal --}}
                    <template x-if="showDispose">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showDispose = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <h3 class="text-lg font-black text-gray-900 mb-1">Disposisi ke Kepala Bidang</h3>
                                    <p class="text-sm text-gray-500 mb-5">Pilih Kepala Bidang yang akan menangani survei lapangan proposal ini.</p>
                                    <form action="{{ route('pimpinan.proposals.dispose', $proposal) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Kepala Bidang *</label>
                                            <select name="kabid_id" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                                                <option value="">-- Pilih Kepala Bidang --</option>
                                                @foreach($kabidList as $kabid)
                                                <option value="{{ $kabid->id }}">
                                                    {{ ($kabid->employee?->name && $kabid->employee->name !== 'Belum Diisi') ? $kabid->employee->name . ' (' . $kabid->roleLabel . ')' : '(' . $kabid->roleLabel . ')' }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Catatan Disposisi (opsional)</label>
                                            <textarea name="disposition_notes" rows="3" placeholder="Arahan atau konteks khusus untuk Kabid..."
                                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 transition-colors text-sm">Disposisi</button>
                                            <button type="button" @click="showDispose = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Approve Modal --}}
                    <template x-if="showApprove">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showApprove = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-primary-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Setujui Proposal</h3>
                                            <p class="text-sm text-gray-500">Proposal akan diproses ke tahap selanjutnya.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">Anda akan <strong class="text-indigo-600">menyetujui</strong> proposal <strong>{{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong>.</p>
                                    <form action="{{ route('pimpinan.proposals.approve', $proposal) }}" method="POST">
                                        @csrf @method('PATCH')
                                        @if($proposal->alsintan_id)
                                        <div class="mb-4">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Unit Fisik Alsintan <span class="text-red-500">*</span></label>
                                            <select name="alsintan_inventory_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                                <option value="" disabled selected>Pilih Unit (Nomor Rangka / Mesin)...</option>
                                                @foreach($availableInventories as $inventory)
                                                    <option value="{{ $inventory->id }}">
                                                        No Rangka: {{ $inventory->nomor_rangka ?? '-' }} | No Mesin: {{ $inventory->nomor_mesin ?? '-' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($availableInventories->isEmpty())
                                                <p class="text-xs text-red-500 mt-1 font-bold">Peringatan: Tidak ada unit tersedia di gudang untuk alsintan ini!</p>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="mb-5">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Catatan (opsional)</label>
                                            <textarea name="pimpinan_notes" rows="3" placeholder="Tambahkan catatan untuk pengaju..."
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 resize-none"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors text-sm">Ya, Setujui</button>
                                            <button type="button" @click="showApprove = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Reject Modal --}}
                    <template x-if="showReject">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showReject = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Tolak Proposal</h3>
                                            <p class="text-sm text-gray-500">Proposal akan ditolak secara permanen.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">Anda akan <strong class="text-red-600">menolak</strong> proposal <strong>{{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong>.</p>
                                    <form action="{{ route('pimpinan.proposals.reject', $proposal) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <div class="mb-5">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alasan Penolakan <span class="text-red-500">*</span></label>
                                            <textarea name="pimpinan_notes" rows="3" required placeholder="Tulis alasan penolakan..."
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 resize-none"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors text-sm">Ya, Tolak</button>
                                            <button type="button" @click="showReject = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            @elseif($proposal->status === 'menunggu_keputusan_akhir')
                {{-- Final decision after berita acara --}}
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto"
                     x-data="{ showApprove: false, showReject: false }">
                    <button @click="showApprove = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Setujui
                    </button>
                    <button @click="showReject = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak
                    </button>
                    <template x-if="showApprove">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showApprove = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-primary-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Keputusan Akhir: Setujui</h3>
                                            <p class="text-sm text-gray-500">Proposal akan disetujui secara permanen.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">Anda akan memberikan keputusan akhir <strong class="text-indigo-600">menyetujui</strong> proposal <strong>{{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong>.</p>
                                    <form action="{{ route('pimpinan.proposals.approve', $proposal) }}" method="POST">
                                        @csrf @method('PATCH')
                                        @if($proposal->alsintan_id)
                                        <div class="mb-4">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Unit Fisik Alsintan <span class="text-red-500">*</span></label>
                                            <select name="alsintan_inventory_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                                <option value="" disabled selected>Pilih Unit (Nomor Rangka / Mesin)...</option>
                                                @foreach($availableInventories as $inventory)
                                                    <option value="{{ $inventory->id }}">
                                                        No Rangka: {{ $inventory->nomor_rangka ?? '-' }} | No Mesin: {{ $inventory->nomor_mesin ?? '-' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($availableInventories->isEmpty())
                                                <p class="text-xs text-red-500 mt-1 font-bold">Peringatan: Tidak ada unit tersedia di gudang untuk alsintan ini!</p>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="mb-5">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Catatan (Opsional)</label>
                                            <textarea name="pimpinan_notes" rows="3" placeholder="Catatan keputusan akhir (opsional)..."
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 resize-none"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors text-sm">Ya, Setujui</button>
                                            <button type="button" @click="showApprove = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="showReject">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showReject = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Tolak Proposal</h3>
                                            <p class="text-sm text-gray-500">Proposal akan ditolak secara permanen.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">Anda akan <strong class="text-red-600">menolak</strong> proposal <strong>{{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong>.</p>
                                    <form action="{{ route('pimpinan.proposals.reject', $proposal) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <div class="mb-5">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alasan Penolakan <span class="text-red-500">*</span></label>
                                            <textarea name="pimpinan_notes" rows="3" required placeholder="Tulis alasan penolakan..."
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 resize-none"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors text-sm">Ya, Tolak</button>
                                            <button type="button" @click="showReject = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            @elseif($proposal->status === 'direkomendasikan')
                {{-- Final decision after Pusat approves/rejects --}}
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto" x-data="{ showFinalize: false, showRejectPusat: false }">
                    <button @click="showFinalize = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Disetujui Pusat
                    </button>
                    
                    <button @click="showRejectPusat = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-red-200 text-red-600 text-sm font-bold rounded-xl hover:bg-red-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Ditolak Pusat
                    </button>

                    <template x-if="showFinalize">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showFinalize = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Tetapkan Penerima (Pusat)</h3>
                                            <p class="text-sm text-gray-500">Proposal Program Bantuan ini telah disetujui pusat.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">Anda akan memberikan SK Final (Penerima Bantuan) untuk proposal <strong>{{ $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong> karena DIPA/Anggaran dari pusat telah turun.</p>
                                    <form action="{{ route('pimpinan.proposals.finalize', $proposal) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="flex flex-row-reverse gap-3 mt-6">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-colors text-sm">Ya, Terbitkan SK</button>
                                            <button type="button" @click="showFinalize = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="showRejectPusat">
                        <div class="fixed inset-0 z-[999] overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showRejectPusat = false"></div>
                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
                                    <div class="flex items-center gap-4 mb-5">
                                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Ditolak oleh Pusat</h3>
                                            <p class="text-sm text-gray-500">Proposal Program Bantuan ini ditolak/tidak masuk kuota pusat.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">Anda akan menandai proposal <strong>{{ $proposal->program->name }}</strong> dari <strong>{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</strong> ditolak oleh pusat.</p>
                                    <form action="{{ route('pimpinan.proposals.reject-pusat', $proposal) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="mb-5">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alasan/Catatan Penolakan <span class="text-red-500">*</span></label>
                                            <textarea name="pimpinan_notes" rows="3" required placeholder="Tulis alasan dari pusat..."
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 resize-none"></textarea>
                                        </div>
                                        <div class="flex flex-row-reverse gap-3 mt-6">
                                            <button type="submit" class="flex-1 px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors text-sm">Ya, Tolak</button>
                                            <button type="button" @click="showRejectPusat = false" class="flex-1 px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                @endif
            </div>
        </div>

        @if(in_array($proposal->status, ['disetujui', 'dikembalikan']))
        <div class="p-5 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-4 shadow-sm">
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-blue-900 mb-1">Menunggu Tindakan Petani</h4>
                <p class="text-sm text-blue-700 leading-relaxed">
                    Proposal ini telah disetujui. Langkah selanjutnya adalah menunggu pihak pemohon (petani) untuk mencetak {{ $isAlsintan ? 'Surat Perjanjian' : 'SK Bantuan' }} dari sistem mereka, menandatanganinya di atas materai, dan menyerahkannya ke Dinas sebagai bukti sah.
                </p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Main Info --}}
            <div class="md:col-span-2 space-y-6">

                @if(in_array($proposal->status, ['menunggu_keputusan_akhir', 'disetujui']) && $proposal->beritaAcara && $proposal->cpclVerifications->count())
                @php
                    $cpcl = $proposal->cpclVerifications->last();
                @endphp
                {{-- Berita Acara & Dokumen Fisik Panel --}}
                <div class="mb-6 space-y-4">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        Verifikasi Lapangan & Dokumen Fisik
                    </h4>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="grid grid-cols-1 xl:grid-cols-2 divide-y xl:divide-y-0 xl:divide-x divide-gray-100">
                            {{-- Rangkuman Data --}}
                            <div class="p-6 lg:p-8 space-y-6">
                                <h5 class="font-black text-sm uppercase tracking-wider text-gray-500 mb-2">Rangkuman Hasil Survei</h5>
                                <div class="grid grid-cols-2 gap-5">
                                    <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kepala Bidang</p><p class="text-sm font-semibold text-gray-900">{{ $proposal->beritaAcara->kabid->name ?? '-' }}</p></div>
                                    <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tanggal Survei</p><p class="text-sm font-semibold text-gray-900">{{ $proposal->beritaAcara->survey_date?->translatedFormat('d F Y') ?? '-' }}</p></div>
                                </div>
                                <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Rekomendasi Final</p>
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $proposal->beritaAcara->recommendation === 'direkomendasikan' ? 'bg-green-50 text-green-700 border-green-200' : ($proposal->beritaAcara->recommendation === 'tidak_direkomendasikan' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                                        {{ $proposal->beritaAcara->recommendationLabel }}
                                    </span>
                                </div>
                                <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Hasil & Catatan Lapangan</p>
                                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 whitespace-pre-line leading-relaxed">{{ $proposal->beritaAcara->content }}</div>
                                </div>
                                
                                <div class="pt-4 border-t border-gray-100">
                                    <a href="{{ route('documents.cpcl', $proposal->id) }}" 
                                       class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-bold rounded-xl border border-purple-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Berita Acara
                                    </a>
                                </div>
                            </div>
                            
                            {{-- Dokumen Fisik --}}
                            <div class="p-6 lg:p-8 bg-gray-50 flex flex-col justify-center items-center text-center xl:min-h-[300px]">
                                <h5 class="font-black text-sm uppercase tracking-wider text-gray-500 mb-4">File Scan Berita Acara Fisik</h5>
                                @if($cpcl && $cpcl->dokumen_fisik_path)
                                    @php
                                        $url = Storage::url($cpcl->dokumen_fisik_path);
                                    @endphp
                                    <div class="flex-1 w-full flex flex-col items-center justify-center space-y-4">
                                        <div class="bg-indigo-50 p-4 rounded-full">
                                            <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <p class="text-sm text-gray-600 max-w-xs">Dokumen ini adalah salinan otentik Berita Acara yang telah ditandatangani basah di lapangan.</p>
                                        <a href="{{ $url }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            Lihat Dokumen Fisik
                                        </a>
                                    </div>
                                @else
                                    <div class="flex-1 w-full flex items-center justify-center flex-col text-center border-2 border-dashed border-gray-300 rounded-xl bg-white p-6">
                                        <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-sm font-semibold text-gray-500">Dokumen fisik belum diunggah.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Petani Info --}}
                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        Informasi Pengaju
                    </h4>
                    <x-farmer-profile-detail :user="$proposal->user" />
                </div>


                {{-- Object Detail --}}
                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg flex items-center gap-2">
                        {{ $isAlsintan ? 'Detail Alat yang Dipinjam' : 'Detail Program yang Diajukan' }}
                    </h4>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    @if($isAlsintan)
                        <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">No. Surat Pengajuan</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->no_surat_pengajuan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Alat</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->alsintan->name }}</p>
                            </div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Merk / Tipe</p><p class="text-gray-900 font-medium">{{ $proposal->alsintan->merk ?? '-' }}</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Stok Tersedia</p><p class="text-gray-900 font-medium">{{ $proposal->alsintan->available_stock }} unit</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Durasi Peminjaman</p><p class="text-gray-900 font-medium">{{ $proposal->rencana_durasi_hari ? $proposal->rencana_durasi_hari . ' Hari' : '-' }}</p></div>
                            <div class="col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Spesifikasi Alat</p>
                                <p class="text-gray-900 font-medium whitespace-pre-line">{{ $proposal->alsintan->description ?? '-' }}</p>
                            </div>
                        </div>
                        @if($proposal->alsintan->image)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Foto Alsintan</p>
                            <img src="{{ Storage::url($proposal->alsintan->image) }}" alt="{{ $proposal->alsintan->name }}" class="w-full max-w-sm h-auto rounded-xl border border-gray-100 shadow-sm object-cover aspect-video">
                        </div>
                        @endif
                    @else
                        <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">No. Surat Pengajuan</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->no_surat_pengajuan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Program</p>
                                <p class="text-gray-900 font-bold text-base">{{ $proposal->program->name }}</p>
                            </div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Sasaran</p><p class="text-gray-900 font-medium">{{ $proposal->program->sasaran ?? '-' }}</p></div>
                            <div><p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kuota</p><p class="text-gray-900 font-medium">{{ $proposal->program->kuota ?? '-' }}</p></div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Narahubung (Contact Person)</p>
                                @if($proposal->program->contact_person)
                                    <p class="text-gray-900 font-medium">
                                        {{ $proposal->program->contact_person }}
                                        @if($proposal->program->contact_phone)
                                            <span class="text-gray-500 font-normal">({{ $proposal->program->contact_phone }})</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-gray-900 font-medium">-</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Dokumen Juknis</p>
                                @if($proposal->program->juknis_file)
                                    <a href="{{ Storage::url($proposal->program->juknis_file) }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-bold mt-0.5 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        Unduh Dokumen
                                    </a>
                                @else
                                    <p class="text-gray-900 font-medium">-</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                </div>
            </div>

            {{-- Sidebar Timeline --}}
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h4 class="font-bold text-gray-900 mb-5 border-b border-gray-200 pb-3 flex items-center justify-between">
                        Timeline Pengajuan
                        <span class="text-[10px] font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">Real-time</span>
                    </h4>
                    
                    @php
                        $disposition = $proposal->dispositionLogs->sortByDesc('created_at')->first();
                        $surveyAssignment = $proposal->surveyAssignments->sortByDesc('created_at')->first();
                        $beritaAcara = $proposal->beritaAcara;

                        $toUser = $proposal->kabid ?? ($disposition ? $disposition->toUser : null);
                        $kabidLabel = $toUser ? (
                            match($toUser->role) {
                                'kabid_psp' => 'Kabid PSP',
                                'kabid_tp' => 'Kabid Tanaman Pangan',
                                'kabid_hortikultura' => 'Kabid Hortikultura',
                                default => $toUser->roleLabel
                            }
                        ) : 'Kabid';

                        // Strict ordered statuses
                        $statusOrder = [
                            'sedang_diverifikasi_admin'     => 0,
                            'sedang_diverifikasi_pimpinan' => 1,
                            'persiapan_survei'      => 2,
                            'sedang_survei'     => 3,
                            'verifikasi_cpcl'  => 4,
                            'menunggu_keputusan_akhir'   => 5,
                            'direkomendasikan'       => 6,
                            'disetujui'              => 7,
                            'ditolak_pusat'          => 7,
                            'dikembalikan'           => 8,
                            'ditolak'                => -1,
                        ];
                        $currentOrder = $statusOrder[$proposal->status] ?? 0;

                        // Rejection stage detection
                        $rejectedByAdmin     = $proposal->status === 'ditolak' && $proposal->reviewed_at && !$proposal->decided_at;
                        $rejectedAtDisposisi = $proposal->status === 'ditolak' && $proposal->decided_at && !$beritaAcara;
                        $rejectedAtFinal     = $proposal->status === 'ditolak' && $proposal->decided_at && $beritaAcara;
                    @endphp

                    <div class="relative border-l-2 border-primary-200 ml-3 space-y-8 pb-2">

                        {{-- 1. Pengajuan Dikirim (always done) --}}
                        <div class="relative">
                            <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                            <div class="pl-4">
                                <p class="text-sm font-bold text-gray-900">Pengajuan Dikirim</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->submission_date->translatedFormat('d M Y - H:i') }} WIB</p>
                                <p class="text-xs text-gray-500 mt-0.5">Proposal berhasil dikirim oleh petani.</p>
                            </div>
                        </div>

                        {{-- 2. Verifikasi Admin --}}
                        <div class="relative">
                            @if($rejectedByAdmin)
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak oleh Admin</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: {{ $proposal->admin_notes ?? '-' }}</p>
                                </div>
                            @elseif($proposal->reviewed_at || $currentOrder >= 1 || $rejectedAtFinal || $rejectedAtDisposisi)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi Admin Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->reviewed_at ? $proposal->reviewed_at->translatedFormat('d M Y - H:i') : $proposal->updated_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Berkas dinyatakan lengkap & layak.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-yellow-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-yellow-600">Sedang Diverifikasi Admin</p>
                                    <p class="text-xs text-gray-500">Proposal sedang menunggu antrian verifikasi berkas.</p>
                                </div>
                            @endif
                        </div>

                        {{-- 3. Disposisi Pimpinan (hidden if rejected by admin) --}}
                        @if(!$rejectedByAdmin)
                        <div class="relative">
                            @if($rejectedAtDisposisi)
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak oleh Pimpinan</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                </div>
                            @elseif(($currentOrder >= 2 || $rejectedAtFinal) && $disposition)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi Pimpinan Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $disposition->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Diteruskan ke: {{ $kabidLabel }}</p>
                                </div>
                            @elseif(in_array($proposal->status, ['disetujui', 'dikembalikan', 'direkomendasikan', 'ditolak_pusat']) && !$disposition)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi Pimpinan Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at ? $proposal->decided_at->translatedFormat('d M Y - H:i') : $proposal->updated_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Proposal disetujui langsung oleh Pimpinan.</p>
                                </div>
                            @elseif($proposal->status === 'sedang_diverifikasi_pimpinan')
                                <div class="absolute -left-[21px] bg-indigo-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-indigo-600">Sedang Diverifikasi Pimpinan</p>
                                    <p class="text-xs text-gray-400">Proposal sedang dalam tinjauan Pimpinan.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Verifikasi Pimpinan</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 4. Penugasan Survei (hidden if rejected at/before disposisi, or approved without survey) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !(in_array($proposal->status, ['disetujui', 'dikembalikan', 'direkomendasikan', 'ditolak_pusat']) && !$surveyAssignment))
                        <div class="relative">
                            @if(($currentOrder >= 3 || $rejectedAtFinal) && $surveyAssignment)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Persiapan Survei Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $surveyAssignment->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Tim teknis dan jadwal survei telah ditentukan.</p>
                                </div>
                            @elseif($proposal->status === 'persiapan_survei')
                                <div class="absolute -left-[21px] bg-amber-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-amber-600">Sedang Persiapan Survei</p>
                                    <p class="text-xs text-gray-400">{{ $kabidLabel }} sedang menyusun jadwal dan tim verifikasi lapangan.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Persiapan Survei</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 5. Pelaksanaan Survei (hidden if rejected at/before disposisi, or approved without survey) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !(in_array($proposal->status, ['disetujui', 'dikembalikan', 'direkomendasikan', 'ditolak_pusat']) && !$surveyAssignment))
                        <div class="relative">
                            @if($proposal->status === 'sedang_survei')
                                <div class="absolute -left-[21px] bg-blue-500 w-3 h-3 rounded-full border-4 border-white animate-bounce"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-blue-600">Sedang Pelaksanaan Survei</p>
                                    <p class="text-xs text-gray-400">Tim teknis sedang melakukan peninjauan lokasi dan menyusun hasil verifikasi.</p>
                                </div>
                            @elseif($currentOrder >= 4 || $rejectedAtFinal)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Pelaksanaan Survei Selesai</p>
                                    @if($proposal->cpclVerifications->last())
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->cpclVerifications->last()->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-0.5">Hasil survei telah diinput ke sistem.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Pelaksanaan Survei</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 6. Verifikasi CPCL (hidden if rejected at/before disposisi, or approved without survey) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi && !(in_array($proposal->status, ['disetujui', 'dikembalikan', 'direkomendasikan', 'ditolak_pusat']) && !$surveyAssignment))
                        <div class="relative">
                            @if(($currentOrder >= 5 || $rejectedAtFinal) && $beritaAcara)
                                <div class="absolute -left-[21px] bg-primary-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-gray-900">Verifikasi CPCL Selesai</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $beritaAcara->created_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Berita Acara dan dokumen rekomendasi telah berhasil diteruskan ke Pimpinan.</p>
                                </div>
                            @elseif($proposal->status === 'verifikasi_cpcl')
                                <div class="absolute -left-[21px] bg-blue-500 w-3 h-3 rounded-full border-4 border-white animate-bounce"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-blue-600">Sedang Verifikasi CPCL</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Menunggu {{ $kabidLabel }} menyiapkan rekomendasi untuk Anda setujui.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Verifikasi CPCL</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 7. Keputusan Akhir (hidden if rejected at/before disposisi) --}}
                        @if(!$rejectedByAdmin && !$rejectedAtDisposisi)
                        <div class="relative">
                            @if(in_array($proposal->status, ['disetujui', 'dikembalikan']))
                                <div class="absolute -left-[21px] bg-green-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-green-700">Proposal Disetujui ✓</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $proposal->pimpinan_notes ?? 'Keputusan akhir telah Anda ambil.' }}</p>
                                </div>
                            @elseif($proposal->status === 'ditolak_pusat')
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak oleh Pusat</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at ? $proposal->decided_at->translatedFormat('d M Y - H:i') : $proposal->updated_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: {{ str_replace('DITOLAK PUSAT: ', '', $proposal->pimpinan_notes ?? '-') }}</p>
                                </div>
                            @elseif($rejectedAtFinal)
                                <div class="absolute -left-[21px] bg-red-500 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-red-600">Ditolak Pimpinan (Tahap Akhir)</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->decided_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: {{ $proposal->pimpinan_notes ?? '-' }}</p>
                                </div>
                            @elseif($proposal->status === 'menunggu_keputusan_akhir')
                                <div class="absolute -left-[21px] bg-purple-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-purple-700">Menunggu Keputusan Akhir</p>
                                    <p class="text-xs text-gray-400">Laporan dan rekomendasi siap untuk Anda tinjau dan berikan keputusan final.</p>
                                </div>
                            @elseif($proposal->status === 'direkomendasikan')
                                <div class="absolute -left-[21px] bg-emerald-400 w-3 h-3 rounded-full border-4 border-white animate-pulse"></div>
                                <div class="pl-4">
                                    <p class="text-sm font-bold text-emerald-700">Diusulkan ke Pusat (CPCL)</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->updated_at->translatedFormat('d M Y - H:i') }} WIB</p>
                                    <p class="text-xs text-gray-500 mt-1">Proposal telah disetujui sebagai Calon Petani Calon Lokasi (CPCL) dan diteruskan ke Pemerintah Pusat.</p>
                                </div>
                            @else
                                <div class="absolute -left-[21px] bg-gray-200 w-3 h-3 rounded-full border-4 border-white"></div>
                                <div class="pl-4 opacity-50"><p class="text-sm font-bold text-gray-400 text-[13px]">Keputusan Akhir</p></div>
                            @endif
                        </div>
                        @endif

                        {{-- 8. Alat Dikembalikan --}}
                        @if($proposal->status === 'dikembalikan')
                        <div class="relative mt-8">
                            <div class="absolute -left-[21px] bg-emerald-500 w-3 h-3 rounded-full border-4 border-white"></div>
                            <div class="pl-4">
                                <p class="text-sm font-bold text-emerald-700">Alat Telah Dikembalikan</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $proposal->returned_at ? $proposal->returned_at->translatedFormat('d M Y - H:i') : '-' }} WIB</p>
                                <p class="text-xs text-gray-500 mt-0.5">Siklus peminjaman alat telah selesai (close).</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-6">
                    <div class="p-6">
                        <h4 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Kontak Pengaju
                        </h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Akun</p>
                                    <p class="text-sm font-black text-gray-900">{{ $proposal->user->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email</p>
                                    <p class="text-sm font-black text-gray-900 break-all">{{ $proposal->user->email }}</p>
                                </div>
                            </div>
                            @if($proposal->user->farmerProfile?->no_telp)
                            <div class="flex items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">No. Telepon</p>
                                    <p class="text-sm font-black text-gray-900">{{ $proposal->user->farmerProfile->no_telp }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
