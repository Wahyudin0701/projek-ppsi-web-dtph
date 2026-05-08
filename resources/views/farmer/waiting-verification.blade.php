<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header Status --}}
        <div class="bg-gradient-to-br from-emerald-50 to-primary-100/50 p-8 text-center border-b border-emerald-100">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 mb-4 shadow-inner">
                @if(auth()->user()->farmerProfile->status === 'rejected')
                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif(auth()->user()->farmerProfile->status === 'approved')
                    <svg class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </div>
            
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
                @if(auth()->user()->farmerProfile->status === 'rejected')
                    Pendaftaran Ditolak
                @elseif(auth()->user()->farmerProfile->status === 'approved')
                    Akun Berhasil Diverifikasi!
                @else
                    Menunggu Verifikasi Admin
                @endif
            </h2>
            <p class="text-gray-600 max-w-lg mx-auto leading-relaxed">
                @if(auth()->user()->farmerProfile->status === 'rejected')
                    Mohon maaf, pendaftaran akun kelompok tani Anda tidak dapat kami setujui saat ini. Silakan periksa alasan penolakan di bawah.
                @elseif(auth()->user()->farmerProfile->status === 'approved')
                    Selamat! Akun Kelompok Tani <strong>{{ auth()->user()->farmerProfile->nama_kelompok }}</strong> telah berhasil diverifikasi oleh tim DTPH Muaro Jambi.
                @else
                    Terima kasih telah mendaftar. Tim kami sedang meninjau data pendaftaran kelompok tani Anda. Proses ini mungkin memakan waktu 1-2 hari kerja.
                @endif
            </p>
        </div>

        @if(auth()->user()->farmerProfile->status === 'approved')
            {{-- Success Section --}}
            <div class="p-10 text-center">
                <div class="mb-8">
                    <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 inline-block">
                        <p class="text-sm text-emerald-800 leading-relaxed max-w-md">
                            Anda sekarang memiliki akses penuh ke sistem E-Proposal. Anda dapat mulai melihat program bantuan yang tersedia dan mengajukan usulan alat pertanian.
                        </p>
                    </div>
                </div>
                
                <a href="{{ route('dashboard', ['verified' => 1]) }}" 
                   class="inline-flex items-center gap-3 px-8 py-4 bg-[#19A148] text-white rounded-2xl font-black text-lg hover:bg-[#15883c] shadow-xl shadow-green-600/20 transition-all active:scale-95 group">
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </a>
                
                <p class="mt-6 text-xs text-gray-400 font-medium italic">
                    *Gunakan menu di samping untuk mengelola profil dan riwayat Anda.
                </p>
            </div>
        @elseif(auth()->user()->farmerProfile->status === 'rejected')
            {{-- Rejection Alert (Existing) --}}
            <div class="p-8">
                <div class="rounded-xl border border-red-100 bg-red-50 p-5">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">Alasan Penolakan:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>{{ auth()->user()->farmerProfile->rejection_reason ?? 'Data tidak valid atau tidak lengkap. Silakan hubungi dinas terkait untuk informasi lebih lanjut.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500 mb-4">Jika Anda merasa ini adalah kesalahan atau ingin memperbaiki data, silakan hubungi admin kami.</p>
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                        Hubungi Bantuan
                    </a>
                </div>
            </div>
        @else
            {{-- Status Tracker (Existing for Pending/Reviewed) --}}
            <div class="p-8">
                <h3 class="font-bold text-gray-800 mb-6 text-center">Status Pendaftaran Saat Ini</h3>
                
                @php
                    $status = auth()->user()->farmerProfile->status;
                    $steps = [
                        'menunggu' => 1,
                        'reviewed' => 2,
                        'verifying' => 3,
                    ];
                    $currentStep = $steps[$status] ?? 1;
                @endphp

                <div class="relative max-w-2xl mx-auto">
                    <!-- Track Line -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-100 rounded-full z-0"></div>
                    <!-- Active Track Line -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-[#19A148] rounded-full z-0 transition-all duration-500" 
                         style="width: {{ ($currentStep - 1) * 50 }}%;"></div>

                    <div class="relative z-10 flex justify-between">
                        {{-- Steps... (existing logic remains) --}}
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-colors
                                {{ $currentStep >= 1 ? 'bg-[#19A148] text-white border-2 border-white' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                                @if($currentStep > 1)
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    1
                                @endif
                            </div>
                            <span class="mt-3 text-xs font-bold {{ $currentStep >= 1 ? 'text-gray-900' : 'text-gray-400' }}">Belum Dilihat</span>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-colors
                                {{ $currentStep >= 2 ? 'bg-[#19A148] text-white border-2 border-white' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                                @if($currentStep > 2)
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    2
                                @endif
                            </div>
                            <span class="mt-3 text-xs font-bold {{ $currentStep >= 2 ? 'text-gray-900' : 'text-gray-400' }}">Sedang Dilihat</span>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-colors
                                {{ $currentStep >= 3 ? 'bg-[#19A148] text-white border-2 border-white' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                                3
                            </div>
                            <span class="mt-3 text-xs font-bold {{ $currentStep >= 3 ? 'text-gray-900' : 'text-gray-400' }}">Tahap Verifikasi</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 text-center bg-gray-50 rounded-xl p-5 border border-gray-100">
                    <h4 class="text-sm font-bold text-gray-800 mb-1">
                        @if($currentStep === 1)
                            Pendaftaran Anda Telah Diterima
                        @elseif($currentStep === 2)
                            Admin Sedang Meninjau Data Anda
                        @elseif($currentStep === 3)
                            Data Memasuki Tahap Verifikasi Akhir
                        @endif
                    </h4>
                    <p class="text-xs text-gray-500">
                        @if($currentStep === 1)
                            Pendaftaran berhasil masuk ke sistem kami dan menunggu giliran untuk ditinjau oleh tim verifikator.
                        @elseif($currentStep === 2)
                            Tim kami sedang memeriksa kelengkapan dan keabsahan dokumen serta data yang Anda berikan.
                        @elseif($currentStep === 3)
                            Data Anda sedang diverifikasi silang dengan dinas terkait sebelum akun Anda diaktifkan.
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>

    {{-- Info Card (Only show when NOT approved) --}}
    @if(auth()->user()->farmerProfile->status !== 'approved')
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 flex gap-4">
            <div class="flex-shrink-0 mt-1">
                <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-blue-900 mb-1">Informasi Verifikasi</h4>
                <p class="text-xs text-blue-800/80 leading-relaxed">
                    Selama masa tunggu, Anda belum dapat mengajukan proposal peminjaman alat pertanian. Pastikan nomor kontak yang Anda daftarkan aktif karena admin mungkin akan menghubungi Anda untuk konfirmasi data lebih lanjut.
                </p>
            </div>
        </div>
    @endif
</div>
