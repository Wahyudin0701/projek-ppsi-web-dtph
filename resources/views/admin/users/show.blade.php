<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-500 hover:text-primary-600 hover:shadow-sm transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
                {{ __('Detail Registrasi Kelompok Tani') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8" x-data="{ rejectModal: false, approveModal: false }">
            {{-- Mobile Back Button --}}
            <div class="lg:hidden mb-6">
                <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#19A148] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Halaman Sebelumnya
                </a>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Side: Main Data --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight">Informasi Utama Kelompok</h3>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1 min-w-0">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nama Kelompok Tani</label>
                                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-50 overflow-hidden">
                                        <p class="font-bold text-gray-900 break-words text-sm">{{ $user->farmerProfile->nama_kelompok }}</p>
                                    </div>
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nama Ketua</label>
                                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-50 overflow-hidden">
                                        <p class="font-bold text-gray-900 break-words text-sm">{{ $user->farmerProfile->ketua }}</p>
                                    </div>
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">NIK Ketua</label>
                                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-50 overflow-hidden">
                                        <p class="font-bold text-gray-900 font-mono tracking-wider break-all text-sm">{{ $user->farmerProfile->nik_ketua ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nomor WA / Kontak</label>
                                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-50 overflow-hidden">
                                        <p class="font-bold text-gray-900 break-all text-sm">{{ $user->farmerProfile->kontak ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Email Terdaftar</label>
                                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-50 overflow-hidden">
                                        <p class="font-bold text-gray-900 break-all text-sm">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Kecamatan</label>
                                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-50 overflow-hidden">
                                        <p class="font-bold text-gray-900 break-words text-sm">{{ $user->farmerProfile->kecamatan ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Alamat Sekretariat</label>
                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-50">
                                    <p class="text-sm font-bold text-gray-700 leading-relaxed">{{ $user->farmerProfile->alamat ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Komoditi Section --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight">Data Komoditi</h3>
                        </div>
                        <div class="p-8 space-y-6">
                            {{-- Komoditi Utama --}}
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Komoditi Utama</label>
                                <div class="bg-primary-50 rounded-2xl p-6 border border-primary-100">
                                    <p class="text-[10px] font-bold text-primary-600 uppercase tracking-widest mb-1">Fokus Utama Kelompok</p>
                                    <p class="text-2xl font-black text-primary-900 capitalize">
                                        {{ $user->farmerProfile->komoditi_utama ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Komoditi Lainnya --}}
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Komoditi Lainnya</label>
                                @php
                                    $allKomoditi = $user->farmerProfile->komoditi
                                        ? array_map('trim', explode(',', $user->farmerProfile->komoditi))
                                        : [];
                                    
                                    $utama = trim($user->farmerProfile->komoditi_utama);
                                    
                                    // Filter agar komoditi utama tidak muncul lagi di list "Lainnya"
                                    $lainnya = array_filter($allKomoditi, function($k) use ($utama) {
                                        return strtolower($k) !== strtolower($utama);
                                    });
                                @endphp

                                @if(count($lainnya) > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($lainnya as $k)
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gray-50 border border-gray-100 text-gray-600 hover:bg-white hover:border-gray-200 transition-all">
                                                {{ $k }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-4 rounded-2xl bg-gray-50/50 border border-dashed border-gray-200">
                                        <p class="text-xs font-medium text-gray-400 italic text-center">Tidak ada komoditi tambahan.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Data Lahan Section --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight">Kapasitas & Lahan</h3>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="bg-emerald-50/50 rounded-2xl p-6 border border-emerald-100/50">
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-2 leading-none">Luas Lahan</p>
                                    <p class="text-3xl font-black text-emerald-900 leading-none">{{ $user->farmerProfile->luas_lahan ?? '0' }} <span class="text-sm font-bold opacity-60">Ha</span></p>
                                </div>

                                <div class="bg-amber-50/50 rounded-2xl p-6 border border-amber-100/50">
                                    <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em] mb-2 leading-none">Grade Kelompok</p>
                                    <p class="text-3xl font-black text-amber-900 leading-none uppercase">{{ $user->farmerProfile->grade ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Actions --}}
                <div class="space-y-8">
                    @if($user->farmerProfile->status === 'menunggu' || $user->farmerProfile->status === 'reviewed')
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sticky top-8">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6">Tindakan Verifikasi</h3>
                            
                            <div class="space-y-4">
                                <button type="button" 
                                        @click="approveModal = true"
                                        class="w-full bg-[#19A148] text-white px-8 py-5 rounded-2xl text-sm font-black hover:bg-[#15803d] shadow-xl shadow-green-600/20 transition-all active:scale-95 flex items-center justify-center gap-3 group">
                                    <span>Setujui Akun</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>

                                <button @click="rejectModal = true" 
                                        class="w-full bg-white text-red-600 border-2 border-red-50 px-8 py-5 rounded-2xl text-sm font-black hover:bg-red-50 transition-all active:scale-95 flex items-center justify-center gap-3 group">
                                    <span>Tolak Pendaftaran</span>
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                    @else
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sticky top-8 text-center">
                            <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center {{ $user->farmerProfile->status === 'approved' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                @if($user->farmerProfile->status === 'approved')
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>
                            <h3 class="text-lg font-black text-gray-900 mb-2">Verifikasi Selesai</h3>
                            <p class="text-sm font-bold {{ $user->farmerProfile->status === 'approved' ? 'text-green-600' : 'text-red-600' }} uppercase tracking-widest">
                                Status: {{ $user->farmerProfile->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                            </p>
                            @if($user->farmerProfile->status === 'rejected')
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


        {{-- Reject Modal --}}
        <div x-show="rejectModal" 
             class="fixed inset-0 z-[70] overflow-y-auto" 
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
                            { label: 'NIK Tidak Valid', message: 'NIK Ketua yang diinput tidak valid atau tidak sesuai dengan KTP yang diunggah.' },
                            { label: 'Dokumen Kurang', message: 'Dokumen pendukung (SK/Surat Keterangan) tidak lengkap atau tidak terbaca dengan jelas.' },
                            { label: 'Lahan Tidak Sesuai', message: 'Data luas lahan yang diinput tidak sesuai dengan bukti fisik atau peta lokasi.' },
                            { label: 'Luar Wilayah', message: 'Lokasi operasional kelompok tani berada di luar wilayah jangkauan DTPH Muaro Jambi.' }
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
        {{-- Approve Confirmation Modal --}}
        <div x-show="approveModal" 
             class="fixed inset-0 z-[70] overflow-y-auto" 
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
                            <button type="submit" class="px-6 py-3 bg-[#19A148] text-white rounded-2xl text-sm font-bold hover:bg-[#15883c] shadow-lg shadow-green-600/30 transition-all active:scale-95">Setujui Sekarang</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
</x-app-layout>
