<x-app-layout>
    <x-slot name="header">Manajemen Pengguna</x-slot>

    <div class="max-w-7xl mx-auto space-y-6 lg:px-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Edit Pengguna: {{ $user->name }}</h2>
                <p class="text-gray-500 text-sm mt-1">Perbarui profil dan hak akses pengguna sistem.</p>
            </div>
            <a href="{{ route('super-admin.users.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="p-6 sm:p-8 text-gray-900">
                
                @if(session('error'))
                    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-medium mb-6">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if($isFixed)
                    <div class="flex items-start gap-2.5 p-4 bg-amber-50 border border-amber-100 rounded-xl mb-6">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-amber-800">Pengguna ini memiliki <strong>Role Tetap</strong> yang dilindungi (seperti Admin, Pimpinan, Kabid). Anda tidak dapat mengubah peran (Role) maupun menghapus akun ini. Anda hanya diizinkan untuk mengubah kredensial dasar (Nama, Email & Password).</p>
                    </div>
                @endif

                    <form action="{{ route('super-admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Role Akses</label>
                        <div class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-gray-600 font-medium flex justify-between items-center cursor-not-allowed">
                            <span>{{ $user->roles->first()?->name ?? $user->role }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <p class="text-xs text-gray-500 mt-1.5">Role akses tidak dapat diubah setelah pengguna dibuat.</p>
                        <input type="hidden" name="role" value="{{ $user->roles->first()?->name ?? $user->role }}">
                    </div>

                    {{-- Status Verifikasi (Global untuk semua user) --}}
                    @if(!$isFixed)
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status Verifikasi</label>
                        <select name="status" id="status" required
                                class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <option value="menunggu" {{ old('status', $user->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="reviewed" {{ old('status', $user->status) == 'reviewed' ? 'selected' : '' }}>Sedang Ditinjau</option>
                            <option value="approved" {{ old('status', $user->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ old('status', $user->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="pengajuan_revisi" {{ old('status', $user->status) == 'pengajuan_revisi' ? 'selected' : '' }}>Revisi</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                    @else
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Verifikasi</label>
                        <input type="text" disabled value="Disetujui (Role Tetap)"
                               class="w-full rounded-xl border-gray-300 bg-gray-50 text-gray-500 shadow-sm">
                    </div>
                    @endif

                    {{-- Password --}}
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-4">Ubah Password</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 md:p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                                <input type="password" name="password" id="password"
                                       placeholder="Biarkan kosong jika tidak ingin diubah"
                                       class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm text-sm">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Data Kelompok Tani (Jika Role = Kelompok Tani) --}}
                    @if($user->role === 'petani')
                        <div class="mt-8 pt-8 border-t border-gray-100">
                            <h4 class="text-sm font-bold text-gray-900 mb-6">Data Profil Kelompok Tani</h4>

                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Nama Kelompok -->
                                    <div>
                                        <label for="profile_nama_kelompok" class="block text-sm font-bold text-gray-800 mb-2">Nama Kelompok Tani</label>
                                        <input type="text" name="profile[nama_kelompok]" id="profile_nama_kelompok" value="{{ old('profile.nama_kelompok', optional($user->farmerProfile)->nama_kelompok) }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm">
                                    </div>

                                    <!-- ID Poktan -->
                                    <div>
                                        <label for="profile_id_poktan" class="block text-sm font-bold text-gray-800 mb-2">ID Poktan <span class="text-red-500">*</span></label>
                                        <input type="text" name="profile[id_poktan]" id="profile_id_poktan" value="{{ old('profile.id_poktan', optional($user->farmerProfile)->id_poktan) }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm">
                                    </div>

                                    <!-- No SK Kelompok -->
                                    <div>
                                        <label for="profile_no_sk" class="block text-sm font-bold text-gray-800 mb-2">No. SK Kelompok <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                                        <input type="text" name="profile[no_sk]" id="profile_no_sk" value="{{ old('profile.no_sk', optional($user->farmerProfile)->no_sk) }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    <!-- File SK -->
                                    <div>
                                        <label for="profile_file_sk" class="block text-sm font-bold text-gray-800 mb-2">
                                            File SK Kelompok Baru <span class="text-xs text-gray-400 font-normal">(Opsional)</span>
                                        </label>
                                        <input type="file" name="profile[file_sk]" id="profile_file_sk" accept=".pdf,.jpg,.jpeg,.png"
                                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#19A148]/10 file:text-[#19A148] hover:file:bg-[#19A148]/20">
                                        @if(optional($user->farmerProfile)->sk_pengukuhan_path)
                                            <p class="text-xs text-gray-500 mt-2">File saat ini: <a href="{{ Storage::url($user->farmerProfile->sk_pengukuhan_path) }}" target="_blank" class="text-[#19A148] hover:underline font-semibold">Lihat File</a></p>
                                        @endif
                                    </div>

                                    <!-- Nama Ketua -->
                                    <div>
                                        <label for="profile_ketua" class="block text-sm font-bold text-gray-800 mb-2">Nama Ketua</label>
                                        <input type="text" name="profile[ketua]" id="profile_ketua" value="{{ old('profile.ketua', optional($user->farmerProfile)->ketua) }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    <!-- NIK Ketua -->
                                    <div>
                                        <label for="profile_nik_ketua" class="block text-sm font-bold text-gray-800 mb-2">NIK Ketua</label>
                                        <input type="text" name="profile[nik_ketua]" id="profile_nik_ketua" value="{{ old('profile.nik_ketua', optional($user->farmerProfile)->nik_ketua) }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    <!-- Foto KTP Ketua -->
                                    <div class="md:col-span-2">
                                        <label for="profile_foto_ktp" class="block text-sm font-bold text-gray-800 mb-2">
                                            Foto KTP Ketua Baru <span class="text-xs text-gray-400 font-normal">(Opsional)</span>
                                        </label>
                                        <input type="file" name="profile[foto_ktp]" id="profile_foto_ktp" accept=".jpg,.jpeg,.png"
                                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#19A148]/10 file:text-[#19A148] hover:file:bg-[#19A148]/20">
                                        @if(optional($user->farmerProfile)->foto_ktp)
                                            <p class="text-xs text-gray-500 mt-2">Foto saat ini: <a href="{{ Storage::url($user->farmerProfile->foto_ktp) }}" target="_blank" class="text-[#19A148] hover:underline font-semibold">Lihat Foto</a></p>
                                        @endif
                                    </div>

                                    <!-- Kontak -->
                                    <div>
                                        <label for="profile_kontak" class="block text-sm font-bold text-gray-800 mb-2">Nomor WhatsApp / Kontak</label>
                                        <input type="text" name="profile[kontak]" id="profile_kontak" value="{{ old('profile.kontak', optional($user->farmerProfile)->kontak) }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    </div>

                                    <!-- Anggota Kelompok -->
                                    <div class="md:col-span-2 pt-4 border-t border-gray-100 mt-2" x-data="{ anggota: {{ old('profile.anggota_nama') ? Js::from(collect(old('profile.anggota_nama'))->map(function($nama, $i) { return ['nama' => $nama, 'nik' => old('profile.anggota_nik.'.$i)]; })->values()->all()) : (optional($user->farmerProfile)->members && $user->farmerProfile->members->count() > 0 ? Js::from($user->farmerProfile->members->map(function($m) { return ['nama' => $m->nama, 'nik' => $m->nik]; })) : "[{nama: '', nik: ''}]") }} }">
                                        <label class="block text-sm font-bold text-gray-800 mb-3">Daftar Anggota Kelompok</label>
                                        <template x-for="(item, index) in anggota" :key="index">
                                            <div class="flex items-start sm:items-center flex-col sm:flex-row gap-3 mb-3">
                                                <div class="relative group w-full sm:w-1/2">
                                                    <input type="text" x-bind:name="'profile[anggota_nama][' + index + ']'" x-model="item.nama"
                                                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                                        placeholder="Nama Anggota">
                                                </div>
                                                <div class="relative group w-full sm:w-1/2 flex items-center gap-3">
                                                    <input type="text" x-bind:name="'profile[anggota_nik][' + index + ']'" x-model="item.nik"
                                                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                                        placeholder="16 Digit NIK">
                                                    <button type="button" @click="anggota.splice(index, 1)" x-show="anggota.length > 1" class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors shrink-0">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                        <button type="button" @click="anggota.push({nama: '', nik: ''})" class="text-sm font-bold text-[#19A148] flex items-center gap-2 hover:text-[#15883c] transition-colors mt-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Tambah Anggota Lainnya
                                        </button>
                                    </div>

                                    <!-- Grade -->
                                    <div>
                                        <label for="profile_grade" class="block text-sm font-bold text-gray-800 mb-2">Grade Tani</label>
                                        <select name="profile[grade]" id="profile_grade"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white">
                                            <option value="Pemula" {{ old('profile.grade', optional($user->farmerProfile)->grade) == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                                            <option value="Madya" {{ old('profile.grade', optional($user->farmerProfile)->grade) == 'Madya' ? 'selected' : '' }}>Madya</option>
                                            <option value="Utama" {{ old('profile.grade', optional($user->farmerProfile)->grade) == 'Utama' ? 'selected' : '' }}>Utama</option>
                                        </select>
                                    </div>

                                    <!-- Luas Lahan -->
                                    <div>
                                        <label for="profile_luas_lahan" class="block text-sm font-bold text-gray-800 mb-2">Luas Lahan Total (Hektar)</label>
                                        <input type="number" step="0.01" name="profile[luas_lahan]" id="profile_luas_lahan" value="{{ old('profile.luas_lahan', optional($user->farmerProfile)->luas_lahan) }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    <!-- Komoditi -->
                                    @php
                                        $rawKomoditi = old('profile.komoditi', optional($user->farmerProfile)->komoditi ? explode(', ', optional($user->farmerProfile)->komoditi) : []);
                                        $selectedBase = [];
                                        $details = [];
                                        foreach($rawKomoditi as $rk) {
                                            if(preg_match('/^(Sayuran|Buah-buahan|Biofarmaka)\s*\((.*?)\)$/', $rk, $m)) {
                                                $selectedBase[] = $m[1];
                                                $details[$m[1]] = $m[2];
                                            } else {
                                                $selectedBase[] = $rk;
                                            }
                                        }
                                    @endphp
                                    <div class="md:col-span-2" x-data="{
                                        selectedKomoditi: {{ json_encode($selectedBase) }},
                                        komoditiDetails: {{ json_encode((object)$details) }}
                                    }">
                                        <label class="block text-sm font-bold text-gray-800 mb-3">Pilih Komoditi</label>
                                        
                                        <!-- Tanaman Pangan -->
                                        <div class="mb-5">
                                            <p class="text-xs font-black text-[#19A148] uppercase tracking-widest mb-3">Tanaman Pangan</p>
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                                @foreach(['Padi Sawah', 'Padi Gogo', 'Jagung Hibrida', 'Kedelai', 'Kacang Tanah'] as $kom)
                                                    <div class="flex flex-col space-y-2">
                                                        <label class="flex items-center space-x-3 cursor-pointer group">
                                                            <input type="checkbox" value="{{ $kom }}" 
                                                                x-model="selectedKomoditi"
                                                                class="w-4 h-4 text-[#19A148] border-gray-300 rounded focus:ring-[#19A148] transition-colors cursor-pointer">
                                                            <span class="text-sm text-gray-700 group-hover:text-gray-900">{{ $kom }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Hortikultura -->
                                        <div>
                                            <p class="text-xs font-black text-[#19A148] uppercase tracking-widest mb-3">Hortikultura</p>
                                            <div class="flex flex-col space-y-3">
                                                @foreach([
                                                    'Sayuran' => 'Contoh: brokoli, kangkung', 
                                                    'Buah-buahan' => 'Contoh: mangga, jeruk', 
                                                    'Biofarmaka' => 'Contoh: jahe, kunyit'
                                                ] as $kom => $placeholder)
                                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                                        <label class="flex items-center space-x-3 cursor-pointer group sm:w-1/3">
                                                            <input type="checkbox" value="{{ $kom }}" 
                                                                x-model="selectedKomoditi"
                                                                class="w-4 h-4 text-[#19A148] border-gray-300 rounded focus:ring-[#19A148] transition-colors cursor-pointer">
                                                            <span class="text-sm text-gray-700 group-hover:text-gray-900">{{ $kom }}</span>
                                                        </label>
                                                        <div x-show="selectedKomoditi.includes('{{ $kom }}')" x-transition class="flex-1">
                                                            <input type="text" x-model="komoditiDetails['{{ $kom }}']" placeholder="{{ $placeholder }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148]">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <template x-for="k in selectedKomoditi" :key="k">
                                            <input type="hidden" name="profile[komoditi][]" :value="komoditiDetails[k] && komoditiDetails[k].trim() !== '' ? k + ' (' + komoditiDetails[k].trim() + ')' : k">
                                        </template>

                                        <!-- Komoditi Utama (di dalam scope x-data yang sama) -->
                                        <div class="mt-5 pt-4 border-t border-gray-100">
                                            <label for="profile_komoditi_utama" class="block text-sm font-bold text-gray-800 mb-2">Komoditi Utama</label>
                                            <select name="profile[komoditi_utama]" id="profile_komoditi_utama"
                                                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white">
                                                <option value="">-- Pilih Komoditi Utama --</option>
                                                <template x-for="k in selectedKomoditi" :key="'utama-' + k">
                                                    <option :value="k" x-text="k" :selected="k === '{{ old('profile.komoditi_utama', optional($user->farmerProfile)->komoditi_utama ?? '') }}'"></option>
                                                </template>
                                            </select>
                                            <p class="text-xs text-gray-500 mt-1">Hanya menampilkan komoditi yang dicentang di atas.</p>
                                        </div>
                                    </div>

                                    <!-- Kecamatan -->
                                    <div class="md:col-span-2">
                                        <label for="profile_kecamatan" class="block text-sm font-bold text-gray-800 mb-2">Kecamatan</label>
                                        <select name="profile[kecamatan]" id="profile_kecamatan"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white">
                                            @foreach(['Bahar Selatan', 'Bahar Utara', 'Jambi Luar Kota', 'Kumpeh', 'Kumpeh Ulu', 'Maro Sebo', 'Mestong', 'Sekernan', 'Sungai Bahar', 'Sungai Gelam', 'Taman Rajo'] as $kec)
                                                <option value="{{ $kec }}" {{ old('profile.kecamatan', optional($user->farmerProfile)->kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Desa -->
                                    <div class="md:col-span-2">
                                        <label for="profile_alamat" class="block text-sm font-bold text-gray-800 mb-2">Desa</label>
                                        <input type="text" name="profile[alamat]" id="profile_alamat" value="{{ old('profile.alamat', optional($user->farmerProfile)->alamat) }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all"
                                            placeholder="Nama Desa">
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Footer Buttons --}}
                    <div class="flex justify-end gap-3 pt-4 pb-6 px-6 border-t border-gray-50 mt-2">
                        <a href="{{ route('super-admin.users.index') }}"
                           class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-bold text-white bg-gray-900 hover:bg-black rounded-xl transition-colors shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
