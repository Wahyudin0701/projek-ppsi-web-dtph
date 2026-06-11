<x-app-layout>
    <x-slot name="header">Manajemen Pengguna</x-slot>

    <div class="max-w-7xl mx-auto space-y-6 lg:px-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Tambah Pengguna Baru</h2>
                <p class="text-gray-500 text-sm mt-1">Buat akun baru untuk pengguna sistem dengan role dinamis.</p>
            </div>
            <a href="{{ route('super-admin.users.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="p-6 sm:p-8 text-gray-900">
                
                <form action="{{ route('super-admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ role: '{{ old('role') }}' }">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   placeholder="Contoh: Budi Santoso"
                                   class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   placeholder="Contoh: budi@gmail.com"
                                   class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" id="password" required
                                   placeholder="Minimal 8 karakter"
                                   class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   placeholder="Ulangi password..."
                                   class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="block text-sm font-bold text-gray-700 mb-2">Role Akses</label>
                        <select name="role" id="role" required x-model="role"
                                class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-2">Catatan: Anda tidak dapat membuat pengguna dengan Role Tetap (seperti Admin, Pimpinan, Kabid) melalui formulir ini.</p>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    {{-- Status Verifikasi (Global untuk semua user) --}}
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status Verifikasi</label>
                        <select name="status" id="status" required
                                class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-1000 shadow-sm">
                            <option value="menunggu" {{ old('status', 'menunggu') == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="reviewed" {{ old('status') == 'reviewed' ? 'selected' : '' }}>Sedang Ditinjau</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="pengajuan_revisi" {{ old('status') == 'pengajuan_revisi' ? 'selected' : '' }}>Revisi</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                                        {{-- Data Kelompok Tani (Ditampilkan jika Role = user) --}}
                    <div x-show="role === 'petani'" x-transition x-cloak class="mt-8 pt-8 border-t border-gray-100">
                        <h4 class="text-sm font-bold text-gray-900 mb-6">Data Profil Kelompok Tani</h4>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<!-- Nama Kelompok -->
                                    <div>
                                        <label for="profile_nama_kelompok" class="block text-sm font-bold text-gray-800 mb-2">Nama Kelompok Tani</label>
                                        <input type="text" name="profile[nama_kelompok]" id="profile_nama_kelompok" value="{{ old('profile.nama_kelompok') }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm">
                                    </div>

                                    <!-- ID Poktan -->
                                    <div>
                                        <label for="profile_id_poktan" class="block text-sm font-bold text-gray-800 mb-2">ID Poktan <span class="text-red-500">*</span></label>
                                        <input type="text" name="profile[id_poktan]" id="profile_id_poktan" value="{{ old('profile.id_poktan') }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm">
                                    </div>

                                    <!-- No SK Kelompok -->
                                    <div>
                                        <label for="profile_no_sk" class="block text-sm font-bold text-gray-800 mb-2">No. SK Kelompok <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                                        <input type="text" name="profile[no_sk]" id="profile_no_sk" value="{{ old('profile.no_sk') }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    <!-- File SK -->
                                    <div>
                                        <label for="profile_file_sk" class="block text-sm font-bold text-gray-800 mb-2">
                                            File SK Kelompok Baru <span class="text-xs text-gray-400 font-normal">(Opsional)</span>
                                        </label>
                                        <input type="file" name="profile[file_sk]" id="profile_file_sk" accept=".pdf,.jpg,.jpeg,.png"
                                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#19A148]/10 file:text-[#19A148] hover:file:bg-[#19A148]/20">
                                        
                                    </div>

                                    <!-- Nama Ketua -->
                                    <div>
                                        <label for="profile_ketua" class="block text-sm font-bold text-gray-800 mb-2">Nama Ketua</label>
                                        <input type="text" name="profile[ketua]" id="profile_ketua" value="{{ old('profile.ketua') }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    <!-- NIK Ketua -->
                                    <div>
                                        <label for="profile_nik_ketua" class="block text-sm font-bold text-gray-800 mb-2">NIK Ketua</label>
                                        <input type="text" name="profile[nik_ketua]" id="profile_nik_ketua" value="{{ old('profile.nik_ketua') }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    <!-- Foto KTP Ketua -->
                                    <div class="md:col-span-2">
                                        <label for="profile_foto_ktp" class="block text-sm font-bold text-gray-800 mb-2">
                                            Foto KTP Ketua Baru <span class="text-xs text-gray-400 font-normal">(Opsional)</span>
                                        </label>
                                        <input type="file" name="profile[foto_ktp]" id="profile_foto_ktp" accept=".jpg,.jpeg,.png"
                                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#19A148]/10 file:text-[#19A148] hover:file:bg-[#19A148]/20">
                                        
                                    </div>

                                    <!-- Kontak -->
                                    <div>
                                        <label for="profile_kontak" class="block text-sm font-bold text-gray-800 mb-2">Nomor WhatsApp / Kontak</label>
                                        <input type="text" name="profile[kontak]" id="profile_kontak" value="{{ old('profile.kontak') }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    </div>

                                    <!-- Anggota Kelompok -->
                                    <div class="md:col-span-2 pt-4 border-t border-gray-100 mt-2" x-data="{ anggota: {{ old('profile.anggota_nama') ? Js::from(collect(old('profile.anggota_nama'))->map(function($nama, $i) { return ['nama' => $nama, 'nik' => old('profile.anggota_nik.'.$i)]; })->values()->all()) : json_encode([['nama' => '', 'nik' => '']]) }} }">
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
                                            <option value="Pemula" {{ old('profile.grade') == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                                            <option value="Madya" {{ old('profile.grade') == 'Madya' ? 'selected' : '' }}>Madya</option>
                                            <option value="Utama" {{ old('profile.grade') == 'Utama' ? 'selected' : '' }}>Utama</option>
                                        </select>
                                    </div>

                                    <!-- Luas Lahan -->
                                    <div>
                                        <label for="profile_luas_lahan" class="block text-sm font-bold text-gray-800 mb-2">Luas Lahan Total (Hektar)</label>
                                        <input type="number" step="0.01" name="profile[luas_lahan]" id="profile_luas_lahan" value="{{ old('profile.luas_lahan') }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                                    </div>

                                    <!-- Komoditi -->
                                    @php
                                        $rawKomoditi = old('profile.komoditi', []);
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
                                    </div>

                                    <!-- Komoditi Utama -->
                                    <div class="md:col-span-2">
                                        <label for="profile_komoditi_utama" class="block text-sm font-bold text-gray-800 mb-2">Komoditi Utama</label>
                                        <select name="profile[komoditi_utama]" id="profile_komoditi_utama"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white">
                                            <optgroup label="Tanaman Pangan">
                                                @foreach(['Padi Sawah', 'Padi Gogo', 'Jagung Hibrida', 'Kedelai', 'Kacang Tanah'] as $kom)
                                                    <option value="{{ $kom }}" {{ old('profile.komoditi_utama') == $kom ? 'selected' : '' }}>{{ $kom }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Hortikultura">
                                                @foreach(['Sayuran', 'Buah-buahan', 'Biofarmaka'] as $kom)
                                                    <option value="{{ $kom }}" {{ old('profile.komoditi_utama') == $kom ? 'selected' : '' }}>{{ $kom }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>

                                    <!-- Kecamatan -->
                                    <div class="md:col-span-2">
                                        <label for="profile_kecamatan" class="block text-sm font-bold text-gray-800 mb-2">Kecamatan</label>
                                        <select name="profile[kecamatan]" id="profile_kecamatan"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white">
                                            @foreach(['Bahar Selatan', 'Bahar Utara', 'Jambi Luar Kota', 'Kumpeh', 'Kumpeh Ulu', 'Maro Sebo', 'Mestong', 'Sekernan', 'Sungai Bahar', 'Sungai Gelam', 'Taman Rajo'] as $kec)
                                                <option value="{{ $kec }}" {{ old('profile.kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Desa -->
                                    <div class="md:col-span-2">
                                        <label for="profile_alamat" class="block text-sm font-bold text-gray-800 mb-2">Desa</label>
                                        <input type="text" name="profile[alamat]" id="profile_alamat" value="{{ old('profile.alamat') }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all"
                                            placeholder="Nama Desa">
                                    </div>

                                </div>
                            </div>
                        </div>

                    {{-- Footer Buttons --}}
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('super-admin.users.index') }}"
                           class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-bold text-white bg-gray-900 hover:bg-black rounded-xl transition-colors shadow-sm">
                            Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
