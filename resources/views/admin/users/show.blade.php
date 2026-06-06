<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Registrasi Kelompok Tani') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8" x-data="{ rejectModal: false, approveModal: false, reviseModal: false, respondModal: false, respondAction: '', notes: '' }">
        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Registrasi Kelompok Tani</h2>
                <p class="text-gray-500 text-sm mt-1">Tinjau informasi registrasi dan lakukan tindakan verifikasi.</p>
            </div>
            <a href="{{ url()->previous() }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        {{-- Mobile Back Button --}}
        <div class="lg:hidden mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Halaman Sebelumnya
            </a>
        </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Side: Main Data --}}
                <div class="lg:col-span-2 space-y-5">
                    <x-farmer-profile-detail :user="$user" />

                    {{-- Verification History Section --}}
                    @if($user->farmerProfile && $user->farmerProfile->verificationLogs && $user->farmerProfile->verificationLogs->count() > 0)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                                <h3 class="text-lg font-black text-gray-900 tracking-tight">Riwayat Verifikasi</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-6">
                                    @foreach($user->farmerProfile->verificationLogs as $log)
                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center 
                                                    {{ $log->status === 'approved' ? 'bg-green-100 text-green-600' : 
                                                       ($log->status === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600') }}">
                                                    @if($log->status === 'approved')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    @elseif($log->status === 'rejected')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-1 bg-gray-50 rounded-2xl p-4 border border-gray-100">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-xs font-black uppercase tracking-widest 
                                                        {{ $log->status === 'approved' ? 'text-green-600' : 
                                                           ($log->status === 'rejected' ? 'text-red-600' : 'text-amber-600') }}">
                                                        {{ $log->status }}
                                                    </span>
                                                    <span class="text-xs font-bold text-gray-400">{{ $log->created_at->format('d M Y, H:i') }}</span>
                                                </div>
                                                <p class="text-sm font-medium text-gray-700">{{ $log->notes }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right Side: Actions --}}
                <div class="space-y-8">
                    @if(!$user->farmerProfile)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sticky top-8 text-center">
                            <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center bg-gray-50 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 mb-2">Menunggu Kelengkapan Data</h3>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">
                                Status: Belum Melengkapi Profil
                            </p>
                            <p class="text-xs font-medium text-gray-500 mt-4 leading-relaxed">Pengguna ini belum mengisi formulir pendaftarannya secara lengkap. Tindakan verifikasi belum bisa dilakukan.</p>
                        </div>
                    @elseif($user->status === 'menunggu' || $user->status === 'reviewed')
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sticky top-8">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6">Tindakan Verifikasi</h3>
                            
                            <div class="space-y-3">
                                <button type="button" 
                                        @click="approveModal = true"
                                        class="w-full bg-blue-600 text-white px-6 py-3.5 rounded-2xl text-sm font-bold hover:bg-blue-700 hover:shadow-md hover:shadow-blue-600/20 transition-all active:scale-95 flex items-center justify-center gap-2 group">
                                    <span>Setujui Akun</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>

                                <button @click="reviseModal = true" 
                                        type="button"
                                        class="w-full bg-white text-amber-600 border border-amber-200 px-6 py-3.5 rounded-2xl text-sm font-bold hover:bg-amber-50 hover:border-amber-300 transition-all active:scale-95 flex items-center justify-center gap-2 group">
                                    <span>Minta Revisi</span>
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>

                                <button @click="rejectModal = true" 
                                        type="button"
                                        class="w-full bg-white text-red-600 border border-red-200 px-6 py-3.5 rounded-2xl text-sm font-bold hover:bg-red-50 hover:border-red-300 transition-all active:scale-95 flex items-center justify-center gap-2 group">
                                    <span>Tolak Pendaftaran</span>
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>

                            <div class="mt-8 pt-8 border-t border-gray-50">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Informasi Kontak</p>
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">Nomor WA</p>
                                            <p class="text-sm font-bold text-gray-700">{{ $user->farmerProfile->kontak }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($user->status === 'pengajuan_revisi')
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sticky top-8 text-center">
                            <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center bg-purple-50 text-purple-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 mb-2">Permohonan Ubah Data</h3>
                            <p class="text-sm font-bold text-purple-600 uppercase tracking-widest">
                                Status: Menunggu Persetujuan
                            </p>

                            <div class="mt-4 p-4 bg-purple-50 rounded-2xl border border-purple-100 text-left">
                                <p class="text-[10px] font-black text-purple-400 uppercase tracking-widest mb-1">Alasan Perubahan Data</p>
                                <p class="text-xs font-bold text-purple-700 leading-relaxed">{{ $user->farmerProfile->change_request_reason }}</p>
                            </div>

                            <div class="mt-6 space-y-3">
                                <button type="button" 
                                        @click="respondModal = true; respondAction = 'approve'"
                                        class="w-full bg-blue-600 text-white px-6 py-3.5 rounded-2xl text-sm font-bold hover:bg-blue-700 hover:shadow-md hover:shadow-blue-600/20 transition-all active:scale-95 flex items-center justify-center gap-2 group">
                                    <span>Izinkan Revisi</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>

                                <button @click="respondModal = true; respondAction = 'reject'" 
                                        type="button"
                                        class="w-full bg-white text-red-600 border border-red-200 px-6 py-3.5 rounded-2xl text-sm font-bold hover:bg-red-50 hover:border-red-300 transition-all active:scale-95 flex items-center justify-center gap-2 group">
                                    <span>Tolak Permohonan</span>
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>

                        </div>
                    @elseif($user->status === 'revisi')
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sticky top-8 text-center">
                            <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center bg-amber-50 text-amber-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 mb-2">Menunggu Revisi</h3>
                            <p class="text-sm font-bold text-amber-600 uppercase tracking-widest">
                                Status: Dikembalikan ke Pengguna
                            </p>
                            @if($user->farmerProfile->rejection_reason)
                            <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100 text-left">
                                <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">Catatan Revisi</p>
                                <p class="text-xs font-bold text-amber-700 leading-relaxed">{{ $user->farmerProfile->rejection_reason }}</p>
                            </div>
                            @endif

                            <div class="mt-8 pt-8 border-t border-gray-50 text-left">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Informasi Kontak</p>
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">Nomor WA</p>
                                        <p class="text-sm font-bold text-gray-700">{{ $user->farmerProfile->kontak }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sticky top-8 text-center">
                            <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center {{ $user->status === 'approved' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                @if($user->status === 'approved')
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>
                            <h3 class="text-lg font-black text-gray-900 mb-2">Verifikasi Selesai</h3>
                            <p class="text-sm font-bold {{ $user->status === 'approved' ? 'text-green-600' : 'text-red-600' }} uppercase tracking-widest">
                                Status: {{ $user->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                            </p>
                            @if($user->status === 'rejected')
                                <div class="mt-4 p-4 bg-red-50 rounded-2xl border border-red-100">
                                    <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Alasan Penolakan</p>
                                    <p class="text-xs font-bold text-red-700 leading-relaxed">{{ $user->farmerProfile->rejection_reason }}</p>
                                </div>
                            @endif

                            <div class="mt-8 pt-8 border-t border-gray-50 text-left">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Informasi Kontak</p>
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">Nomor WA</p>
                                        <p class="text-sm font-bold text-gray-700">{{ $user->farmerProfile->kontak }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>


        @if($user->farmerProfile)
        {{-- Respond Modal --}}
        <template x-teleport="body">
            <div x-show="respondModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm px-4 text-left">
                <div @click.away="respondModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white rounded-2xl p-6 shadow-xl w-full max-w-lg">
                    <h3 class="text-lg font-bold text-gray-900 mb-2" x-text="respondAction === 'approve' ? 'Konfirmasi Izin Revisi' : 'Tolak Permohonan'"></h3>
                    <p class="text-sm text-gray-500 mb-6" x-text="respondAction === 'approve' ? 'Status kelompok tani akan diubah menjadi Revisi sehingga mereka dapat memperbarui data tanpa memberikan catatan revisi.' : 'Permohonan akan ditolak dan status kembali terkunci (Disetujui).'"></p>

                    <form action="{{ route('admin.users.respond-change', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" x-bind:value="respondAction">

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="respondModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50">Batal</button>
                            <button type="submit" 
                                    :class="respondAction === 'approve' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-red-600 hover:bg-red-700'"
                                    class="px-4 py-2 border border-transparent rounded-xl font-bold text-sm text-white" 
                                    x-text="respondAction === 'approve' ? 'Ya, Izinkan' : 'Ya, Tolak'"></button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        {{-- Reject Modal --}}
        <template x-teleport="body">
            <div x-show="rejectModal" 
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 text-center">
                    <div x-show="rejectModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" 
                         @click="rejectModal = false"></div>

                    <div x-show="rejectModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                         class="inline-block w-full max-w-md p-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl relative z-10">
                        
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-red-500 mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900">Tolak Pendaftaran</h3>
                            <p class="text-sm text-gray-500 mt-1">Berikan alasan penolakan untuk Kelompok Tani <span class="font-bold text-gray-900">{{ $user->farmerProfile->nama_kelompok }}</span></p>
                        </div>

                        <form action="{{ route('admin.users.reject', $user) }}" method="POST" x-data="{ 
                            reason: '',
                            presets: [
                                { label: 'SIMLUHTAN', message: 'Kelompok Tani Anda tidak terdaftar di database SIMLUHTAN. Silakan hubungi PPL setempat untuk pembaruan data.' },
                                { label: 'Luar Wilayah', message: 'Lokasi operasional kelompok tani berada di luar wilayah jangkauan DTPH Muaro Jambi.' },
                                { label: 'Indikasi Fiktif', message: 'Kelompok tani terindikasi fiktif atau sudah tidak aktif beroperasi.' }
                            ]
                        }">
                            @csrf
                            @method('DELETE')
                            
                            <div class="mb-6">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-3 px-1">Pilih Alasan Cepat</label>
                                <div class="flex flex-wrap gap-2 mb-5">
                                    <template x-for="(item, index) in presets" :key="index">
                                        <button type="button" 
                                                @click="reason = item.message"
                                                class="text-[10px] font-extrabold px-3.5 py-2 rounded-xl border transition-all duration-200"
                                                :class="reason === item.message ? 'bg-red-600 border-red-600 text-white shadow-lg shadow-red-600/20' : 'bg-white border-gray-100 text-gray-500 hover:border-gray-300 hover:bg-gray-50'">
                                            <span x-text="item.label"></span>
                                        </button>
                                    </template>
                                </div>

                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2 px-1">Isi Pesan Penolakan (Dapat Diedit)</label>
                                <textarea name="rejection_reason" 
                                          required
                                          rows="4" 
                                          x-model="reason"
                                          class="w-full bg-gray-50 border-gray-100 rounded-2xl focus:ring-red-500 focus:border-red-500 text-sm font-medium p-4 transition-all"
                                          placeholder="Pilih alasan di atas atau ketik pesan kustom Anda di sini..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" @click="rejectModal = false; reason = ''" class="px-6 py-3 bg-white border border-gray-100 text-gray-500 rounded-2xl text-sm font-bold hover:bg-gray-50 transition-all">Batal</button>
                                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-2xl text-sm font-bold hover:bg-red-700 shadow-lg shadow-red-600/30 transition-all active:scale-95">Konfirmasi Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>

        {{-- Revise Modal --}}
        <template x-teleport="body">
            <div x-show="reviseModal" 
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 text-center">
                    <div x-show="reviseModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" 
                         @click="reviseModal = false"></div>

                    <div x-show="reviseModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                         class="inline-block w-full max-w-md p-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl relative z-10">
                        
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center text-amber-500 mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900">Minta Revisi Data</h3>
                            <p class="text-sm text-gray-500 mt-1">Kembalikan pendaftaran ini ke pengguna agar mereka dapat memperbaiki datanya.</p>
                        </div>

                        <form action="{{ route('admin.users.revisi', $user) }}" method="POST" x-data="{ 
                            note: '',
                            presets: [
                                { label: 'NIK Tidak Sesuai', message: 'NIK yang Anda masukkan tidak sesuai dengan KTP atau tidak terdaftar. Mohon periksa kembali dan unggah dokumen yang jelas.' },
                                { label: 'Dokumen Buram', message: 'Dokumen lampiran yang diunggah tidak terbaca/buram. Mohon unggah ulang dengan kualitas foto yang lebih baik.' },
                                { label: 'Nama Tidak Cocok', message: 'Nama Ketua Kelompok tidak sesuai dengan nama yang tercantum di dokumen pendukung.' }
                            ]
                        }">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-6">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-3 px-1">Pilih Alasan Cepat</label>
                                <div class="flex flex-wrap gap-2 mb-5">
                                    <template x-for="(item, index) in presets" :key="index">
                                        <button type="button" 
                                                @click="note = item.message"
                                                class="text-[10px] font-extrabold px-3.5 py-2 rounded-xl border transition-all duration-200"
                                                :class="note === item.message ? 'bg-amber-500 border-amber-500 text-white shadow-lg shadow-amber-500/20' : 'bg-white border-gray-100 text-gray-500 hover:border-gray-300 hover:bg-gray-50'">
                                            <span x-text="item.label"></span>
                                        </button>
                                    </template>
                                </div>

                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2 px-1">Pesan Revisi Untuk Pengguna (Dapat Diedit)</label>
                                <textarea name="revision_note" 
                                          required
                                          rows="4" 
                                          x-model="note"
                                          class="w-full bg-gray-50 border-gray-100 rounded-2xl focus:ring-amber-500 focus:border-amber-500 text-sm font-medium p-4 transition-all"
                                          placeholder="Pilih alasan di atas atau ketik catatan revisi kustom Anda di sini..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" @click="reviseModal = false" class="px-6 py-3 bg-white border border-gray-100 text-gray-500 rounded-2xl text-sm font-bold hover:bg-gray-50 transition-all">Batal</button>
                                <button type="submit" class="px-6 py-3 bg-amber-500 text-white rounded-2xl text-sm font-bold hover:bg-amber-600 shadow-lg shadow-amber-500/30 transition-all active:scale-95">Kirim Revisi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
        {{-- Approve Confirmation Modal --}}
        <template x-teleport="body">
            <div x-show="approveModal" 
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 text-center">
                    <div x-show="approveModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" 
                         @click="approveModal = false"></div>

                    <div x-show="approveModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                         class="inline-block w-full max-w-md p-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl relative z-10">
                        
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center text-green-600 mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900">Konfirmasi Persetujuan</h3>
                            <p class="text-sm text-gray-500 mt-1">Anda akan menyetujui akun Kelompok Tani <span class="font-bold text-gray-900">{{ $user->farmerProfile->nama_kelompok }}</span>. Pastikan semua data sudah valid.</p>
                        </div>

                        <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" @click="approveModal = false" class="px-6 py-3 bg-white border border-gray-100 text-gray-500 rounded-2xl text-sm font-bold hover:bg-gray-50 transition-all">Batal</button>
                                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-2xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all active:scale-95">Setujui Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
        @endif
    </div>
</div>
</x-app-layout>
