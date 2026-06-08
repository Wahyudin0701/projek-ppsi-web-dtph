<div class="max-w-7xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header Status --}}
        <div class="bg-gradient-to-br from-emerald-50 to-primary-100/50 p-8 text-center border-b border-emerald-100">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 mb-4 shadow-inner">
                @if(auth()->user()->status === 'rejected')
                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif(auth()->user()->status === 'approved')
                    <svg class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif(auth()->user()->status === 'revisi')
                    <svg class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                @else
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </div>
            
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
                @if(auth()->user()->status === 'rejected')
                    Pendaftaran Ditolak
                @elseif(auth()->user()->status === 'approved')
                    Akun Berhasil Diverifikasi!
                @elseif(auth()->user()->status === 'revisi')
                    {{ auth()->user()->farmerProfile?->rejection_reason ? 'Revisi Data Diperlukan' : 'Izin Ubah Data Diberikan' }}
                @else
                    Menunggu Verifikasi Admin
                @endif
            </h2>
            <p class="text-gray-600 max-w-lg mx-auto leading-relaxed">
                @if(auth()->user()->status === 'rejected')
                    Mohon maaf, pendaftaran akun Anda tidak dapat kami setujui saat ini. Silakan periksa alasan penolakan di bawah.
                @elseif(auth()->user()->status === 'approved')
                    Selamat! Akun Kelompok Tani <strong>{{ auth()->user()->farmerProfile ? auth()->user()->farmerProfile->nama_kelompok : auth()->user()->name }}</strong> telah berhasil diverifikasi oleh tim DTPH Muaro Jambi.
                @elseif(auth()->user()->status === 'revisi')
                    @if(auth()->user()->farmerProfile?->rejection_reason)
                        Admin telah memeriksa data pendaftaran Anda dan meminta beberapa perbaikan. Silakan periksa catatan revisi di bawah dan perbarui profil Anda.
                    @else
                        Permohonan ubah data Anda telah disetujui. Silakan perbarui data profil Anda sesuai dengan perubahan yang diinginkan.
                    @endif
                @else
                    Terima kasih telah mendaftar. Tim kami sedang meninjau data pendaftaran Anda. Proses ini mungkin memakan waktu 1-2 hari kerja.
                @endif
            </p>
        </div>

        @if(auth()->user()->status === 'approved')
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
        @elseif(auth()->user()->status === 'rejected' || auth()->user()->status === 'revisi')
            {{-- Rejection / Revisi Alert --}}
            <div class="p-8">
                @if(!(auth()->user()->status === 'revisi' && empty(auth()->user()->farmerProfile?->rejection_reason)))
                <div class="rounded-xl border {{ auth()->user()->status === 'revisi' ? 'border-amber-100 bg-amber-50' : 'border-red-100 bg-red-50' }} p-5">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @if(auth()->user()->status === 'revisi')
                                <svg class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            @else
                                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold {{ auth()->user()->status === 'revisi' ? 'text-amber-800' : 'text-red-800' }}">
                                {{ auth()->user()->status === 'revisi' ? 'Catatan Revisi dari Admin:' : 'Alasan Penolakan:' }}
                            </h3>
                            <div class="mt-2 text-sm {{ auth()->user()->status === 'revisi' ? 'text-amber-700' : 'text-red-700' }}">
                                <p>{{ auth()->user()->farmerProfile?->rejection_reason ?? 'Silakan periksa kembali data Anda.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="mt-8 text-center">
                    @if(auth()->user()->status === 'revisi')
                        <p class="text-sm text-gray-500 mb-4">
                            @if(auth()->user()->farmerProfile?->rejection_reason)
                                Silakan perbaiki data profil pendaftaran Anda sesuai catatan admin agar dapat diproses kembali.
                            @else
                                Silakan akses formulir di bawah ini untuk memperbarui profil Anda.
                            @endif
                        </p>
                        <a href="{{ route('farmer.profile.edit') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold text-sm shadow-md shadow-amber-500/20 transition-all active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Data Registrasi
                        </a>
                    @else
                        <p class="text-sm text-gray-500 mb-4">Jika Anda merasa ini adalah kesalahan atau ingin memperbaiki data, silakan hubungi admin kami.</p>
                        <a href="{{ route('kontak') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                            Hubungi Bantuan
                        </a>
                    @endif
                </div>
            </div>
        @else
            {{-- Status Tracker (Existing for Pending/Reviewed) --}}
            <div class="p-8">
                <h3 class="font-bold text-gray-800 mb-6 text-center">Status Pendaftaran Saat Ini</h3>
                
                @php
                    $status = auth()->user()->status;
                    $steps = [
                        'menunggu' => 1,
                        'reviewed' => 2,
                        'verifying' => 3,
                    ];
                    $currentStep = $steps[$status] ?? 1;
                @endphp

                <div class="relative max-w-2xl mx-auto">
                    <!-- Track Line -->
                    <div class="absolute left-[16.66%] right-[16.66%] top-5 -translate-y-1/2 h-1 bg-gray-100 rounded-full z-0"></div>
                    <!-- Active Track Line -->
                    <div class="absolute left-[16.66%] top-5 -translate-y-1/2 h-1 bg-[#19A148] rounded-full z-0 transition-all duration-500" 
                         style="width: {{ ($currentStep - 1) * 33.33 }}%;"></div>

                    <div class="relative z-10 flex justify-between">
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-colors
                                {{ $currentStep >= 1 ? 'bg-[#19A148] text-white ring-4 ring-white' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                                @if($currentStep > 1)
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    1
                                @endif
                            </div>
                            <span class="mt-3 text-xs font-bold {{ $currentStep >= 1 ? 'text-gray-900' : 'text-gray-400' }} text-center">Belum Dilihat</span>
                        </div>

                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-colors
                                {{ $currentStep >= 2 ? 'bg-[#19A148] text-white ring-4 ring-white' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                                @if($currentStep > 2)
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    2
                                @endif
                            </div>
                            <span class="mt-3 text-xs font-bold {{ $currentStep >= 2 ? 'text-gray-900' : 'text-gray-400' }} text-center">Sedang Dilihat</span>
                        </div>

                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-colors
                                {{ $currentStep >= 3 ? 'bg-[#19A148] text-white ring-4 ring-white' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                                @if($currentStep > 3)
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    3
                                @endif
                            </div>
                            <span class="mt-3 text-xs font-bold {{ $currentStep >= 3 ? 'text-gray-900' : 'text-gray-400' }} text-center">Tahap Verifikasi</span>
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
    @if(auth()->user()->status !== 'approved')
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
