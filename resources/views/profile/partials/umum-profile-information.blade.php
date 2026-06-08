<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Data Informasi Umum') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Berikut adalah data informasi pendaftaran Anda yang terdaftar pada sistem.') }}
        </p>
    </header>

    @if(auth()->user()->umumProfile)
        <div class="mt-8 space-y-8">
            
            <!-- INFORMASI PENDAFTAR -->
            <div>
                <h3 class="text-md font-bold text-gray-800 border-b border-gray-200 pb-2 mb-4">Informasi Pendaftar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label value="Nama Lengkap / Instansi" />
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <x-input-label value="NIK" />
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">{{ auth()->user()->umumProfile->nik }}</p>
                    </div>
                    <div>
                        <x-input-label value="Foto KTP" />
                        <div class="mt-1 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                            @if(auth()->user()->umumProfile->foto_ktp)
                                <a href="{{ Storage::url(auth()->user()->umumProfile->foto_ktp) }}" target="_blank" class="text-sm font-semibold text-[#19A148] hover:underline flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    Lihat Foto KTP
                                </a>
                            @else
                                <span class="text-sm text-gray-500 italic">-</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <x-input-label value="Nomor HP/WhatsApp" />
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">{{ auth()->user()->umumProfile->no_wa }}</p>
                    </div>
                </div>
            </div>

            <!-- STATUS VERIFIKASI -->
            <div>
                <h3 class="text-md font-bold text-gray-800 border-b border-gray-200 pb-2 mb-4">Status Pengajuan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label value="Status Verifikasi" />
                        <div class="mt-1">
                            @php
                                $status = auth()->user()->status;
                                $statusColor = match($status) {
                                    'approved' => 'bg-green-100 text-green-800 border-green-200',
                                    'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                    'reviewed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    default => 'bg-yellow-100 text-yellow-800 border-yellow-200'
                                };
                                $statusText = match($status) {
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    'reviewed' => 'Sedang Ditinjau',
                                    default => 'Menunggu Verifikasi'
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusColor }}">
                                {{ $statusText }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->user()->status === 'rejected' && auth()->user()->umumProfile->rejection_reason)
                <div class="md:col-span-2 mt-2">
                    <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <h4 class="text-sm font-bold text-red-800">Alasan Penolakan Data</h4>
                                <p class="text-sm text-red-700 mt-1">{{ auth()->user()->umumProfile->rejection_reason }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(auth()->user()->status === 'pengajuan_revisi')
                <div class="md:col-span-2 mt-2">
                    <div class="p-4 bg-purple-50 rounded-xl border border-purple-100">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-purple-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h4 class="text-sm font-bold text-purple-800">Menunggu Persetujuan Ubah Data</h4>
                                <p class="text-sm text-purple-700 mt-1">Anda telah mengajukan permohonan untuk mengubah data dengan alasan: <strong>"{{ auth()->user()->umumProfile->change_request_reason }}"</strong>. Permohonan Anda sedang ditinjau oleh Admin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(auth()->user()->status === 'approved')
                <div class="md:col-span-2 mt-4 flex justify-end" x-data="{ openRequestModal: false }">
                    <button type="button" @click="openRequestModal = true" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Ajukan Permohonan Ubah Data
                    </button>

                    <!-- Modal Pengajuan -->
                    <div x-show="openRequestModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm px-4">
                        <div @click.away="openRequestModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-white rounded-2xl p-6 shadow-xl w-full max-w-lg">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Permohonan Ubah Data</h3>
                            <p class="text-sm text-gray-500 mb-4">Jelaskan secara singkat bagian data mana yang ingin Anda ubah dan alasannya. Admin akan meninjau permohonan Anda terlebih dahulu.</p>
                            
                            <div class="mb-6 p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <p class="text-xs text-amber-800 leading-relaxed"><strong>Peringatan:</strong> Selama masa pengajuan perubahan data (Menunggu Persetujuan Admin), akses Anda ke <strong>fitur utama sistem akan dibatasi</strong> hingga permohonan diselesaikan.</p>
                            </div>

                            <form action="{{ route('farmer.profile.request-change') }}" method="POST">
                                @csrf
                                <div>
                                    <label for="change_request_reason" class="block text-sm font-bold text-gray-700 mb-2">Alasan Perubahan Data</label>
                                    <textarea name="change_request_reason" id="change_request_reason" rows="4" required class="block w-full rounded-xl border-gray-300 focus:border-[#19A148] focus:ring-[#19A148] sm:text-sm resize-none" placeholder="Contoh: Ada pembaruan KTP / ganti nomor WhatsApp..."></textarea>
                                </div>
                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" @click="openRequestModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-[#19A148] border border-transparent rounded-xl font-bold text-sm text-white hover:bg-[#158C3D]">Kirim Permohonan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm text-yellow-700">Data Profil Umum belum tersedia. Silakan lengkapi profil Anda terlebih dahulu.</p>
        </div>
    @endif
</section>
