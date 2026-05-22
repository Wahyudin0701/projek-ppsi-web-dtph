<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Data Kelompok Tani') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Berikut adalah data informasi Kelompok Tani Anda yang terdaftar pada sistem.') }}
        </p>
    </header>

    @if(auth()->user()->farmerProfile)
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Kelompok -->
            <div>
                <x-input-label value="Nama Kelompok Tani" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200 font-semibold">
                    {{ auth()->user()->farmerProfile->nama_kelompok }}
                </p>
            </div>

            <!-- Nama Ketua -->
            <div>
                <x-input-label value="Nama Ketua" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                    {{ auth()->user()->farmerProfile->ketua }}
                </p>
            </div>

            <!-- NIK Ketua -->
            <div>
                <x-input-label value="NIK Ketua" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                    {{ auth()->user()->farmerProfile->nik_ketua }}
                </p>
            </div>

            <!-- Kontak -->
            <div>
                <x-input-label value="Nomor HP/WhatsApp" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                    {{ auth()->user()->farmerProfile->kontak }}
                </p>
            </div>

            <!-- Grade / Kelas Kelompok -->
            <div>
                <x-input-label value="Kelas Kelompok" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200 uppercase">
                    {{ auth()->user()->farmerProfile->grade }}
                </p>
            </div>

            <!-- Luas Lahan -->
            <div>
                <x-input-label value="Luas Lahan (Ha)" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                    {{ auth()->user()->farmerProfile->luas_lahan }} Hektar
                </p>
            </div>

            <!-- Komoditi Utama -->
            <div>
                <x-input-label value="Komoditi Utama" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                    {{ auth()->user()->farmerProfile->komoditi_utama ?: '-' }}
                </p>
            </div>

            <!-- Komoditi Lainnya -->
            <div>
                <x-input-label value="Komoditi Lainnya" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                    {{ auth()->user()->farmerProfile->komoditi ?: '-' }}
                </p>
            </div>

            <!-- Kecamatan -->
            <div>
                <x-input-label value="Kecamatan" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                    {{ auth()->user()->farmerProfile->kecamatan }}
                </p>
            </div>

            <!-- Status Verifikasi -->
            <div>
                <x-input-label value="Status Verifikasi" />
                <div class="mt-1">
                    @php
                        $status = auth()->user()->farmerProfile->status;
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

            <!-- Alamat Lengkap -->
            <div class="md:col-span-2">
                <x-input-label value="Alamat Lengkap" />
                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-200 leading-relaxed">
                    {{ auth()->user()->farmerProfile->alamat }}
                </p>
            </div>

            @if(auth()->user()->farmerProfile->status === 'rejected' && auth()->user()->farmerProfile->rejection_reason)
                <div class="md:col-span-2 mt-2">
                    <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <h4 class="text-sm font-bold text-red-800">Alasan Penolakan Data</h4>
                                <p class="text-sm text-red-700 mt-1">{{ auth()->user()->farmerProfile->rejection_reason }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm text-yellow-700">Data Kelompok Tani belum tersedia. Silakan lengkapi profil Anda terlebih dahulu.</p>
        </div>
    @endif
</section>
