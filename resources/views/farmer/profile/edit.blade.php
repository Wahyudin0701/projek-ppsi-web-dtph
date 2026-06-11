<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
            {{ __('Revisi Data Registrasi') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-8">
            <div class="mb-8">
                <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    {{ $profile->rejection_reason ? 'Perbaiki Data Kelompok Tani' : 'Perbarui Data Kelompok Tani' }}
                </h3>
                @if($profile->rejection_reason)
                    <p class="text-sm text-gray-500 mt-2">Silakan sesuaikan data Anda dengan catatan revisi dari admin. Pastikan semua informasi yang dimasukkan adalah valid dan terbaru.</p>
                @else
                    <p class="text-sm text-gray-500 mt-2">Silakan perbarui data profil Anda sesuai dengan perubahan yang diinginkan. Pastikan semua informasi yang dimasukkan adalah valid dan terbaru.</p>
                @endif
            </div>

            @if($profile->rejection_reason)
                <div class="mb-8 p-5 bg-amber-50 border border-amber-100 rounded-xl">
                    <h4 class="text-sm font-bold text-amber-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Catatan Revisi dari Admin
                    </h4>
                    <p class="text-sm text-amber-700 font-medium">{{ $profile->rejection_reason }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('farmer.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Kelompok -->
                    <div>
                        <label for="nama_kelompok" class="block text-sm font-bold text-gray-800 mb-2">Nama Kelompok Tani</label>
                        <input type="text" name="nama_kelompok" id="nama_kelompok" value="{{ old('nama_kelompok', $profile->nama_kelompok) }}" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm">
                        <x-input-error :messages="$errors->get('nama_kelompok')" class="mt-2" />
                    </div>

                    <!-- ID Poktan -->
                    <div>
                        <label for="id_poktan" class="block text-sm font-bold text-gray-800 mb-2">ID Poktan <span class="text-red-500">*</span></label>
                        <input type="text" name="id_poktan" id="id_poktan" value="{{ old('id_poktan', $profile->id_poktan) }}" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                            placeholder="Masukkan ID Poktan">
                        <x-input-error :messages="$errors->get('id_poktan')" class="mt-2" />
                    </div>

                    <!-- No SK Kelompok -->
                    <div>
                        <label for="no_sk" class="block text-sm font-bold text-gray-800 mb-2">No. SK Kelompok <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="no_sk" id="no_sk" value="{{ old('no_sk', $profile->no_sk) }}"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                        <x-input-error :messages="$errors->get('no_sk')" class="mt-2" />
                    </div>

                    <!-- File SK -->
                    <div>
                        <label for="file_sk" class="block text-sm font-bold text-gray-800 mb-2">
                            File SK Kelompok Baru <span class="text-xs text-gray-400 font-normal">(Opsional, maks 5MB, format PDF/JPG/PNG)</span>
                        </label>
                        <input type="file" name="file_sk" id="file_sk" accept=".pdf,.jpg,.jpeg,.png"
                               class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#19A148]/10 file:text-[#19A148] hover:file:bg-[#19A148]/20">
                        @if($profile->sk_pengukuhan_path)
                            <p class="text-xs text-gray-500 mt-2">File saat ini: <a href="{{ Storage::url($profile->sk_pengukuhan_path) }}" target="_blank" class="text-[#19A148] hover:underline font-semibold">Lihat File</a></p>
                        @endif
                        <x-input-error :messages="$errors->get('file_sk')" class="mt-2" />
                    </div>

                    <!-- Nama Ketua -->
                    <div>
                        <label for="ketua" class="block text-sm font-bold text-gray-800 mb-2">Nama Ketua</label>
                        <input type="text" name="ketua" id="ketua" value="{{ old('ketua', $profile->ketua) }}" required
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                        <x-input-error :messages="$errors->get('ketua')" class="mt-2" />
                    </div>

                    <!-- NIK Ketua -->
                    <div>
                        <label for="nik_ketua" class="block text-sm font-bold text-gray-800 mb-2">NIK Ketua</label>
                        <input type="text" name="nik_ketua" id="nik_ketua" value="{{ old('nik_ketua', $profile->nik_ketua) }}" required
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                        <x-input-error :messages="$errors->get('nik_ketua')" class="mt-2" />
                    </div>

                    <!-- Foto KTP Ketua -->
                    <div class="md:col-span-2">
                        <label for="foto_ktp" class="block text-sm font-bold text-gray-800 mb-2">
                            Foto KTP Ketua Baru <span class="text-xs text-gray-400 font-normal">(Opsional, maks 5MB, format JPG/PNG)</span>
                        </label>
                        <input type="file" name="foto_ktp" id="foto_ktp" accept=".jpg,.jpeg,.png"
                               class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#19A148]/10 file:text-[#19A148] hover:file:bg-[#19A148]/20">
                        @if($profile->foto_ktp)
                            <p class="text-xs text-gray-500 mt-2">Foto saat ini: <a href="{{ Storage::url($profile->foto_ktp) }}" target="_blank" class="text-[#19A148] hover:underline font-semibold">Lihat Foto</a></p>
                        @endif
                        <x-input-error :messages="$errors->get('foto_ktp')" class="mt-2" />
                    </div>

                    <!-- Kontak -->
                    <div>
                        <label for="kontak" class="block text-sm font-bold text-gray-800 mb-2">Nomor WhatsApp / Kontak</label>
                        <input type="text" name="kontak" id="kontak" value="{{ old('kontak', $profile->kontak) }}" required
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                        <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                    </div>

                    <!-- Anggota Kelompok -->
                    <div class="md:col-span-2 pt-4 border-t border-gray-100 mt-2" x-data="{ anggota: {{ old('anggota_nama') ? Js::from(collect(old('anggota_nama'))->map(function($nama, $i) { return ['nama' => $nama, 'nik' => old('anggota_nik.'.$i)]; })->values()->all()) : ($profile->members->count() > 0 ? Js::from($profile->members->map(function($m) { return ['nama' => $m->nama, 'nik' => $m->nik]; })) : "[{nama: '', nik: ''}]") }} }">
                        <label class="block text-sm font-bold text-gray-800 mb-3">Daftar Anggota Kelompok</label>
                        <template x-for="(item, index) in anggota" :key="index">
                            <div class="flex items-start sm:items-center flex-col sm:flex-row gap-3 mb-3">
                                <div class="relative group w-full sm:w-1/2">
                                    <input type="text" x-bind:name="'anggota_nama[' + index + ']'" x-model="item.nama" required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                                           placeholder="Nama Anggota">
                                </div>
                                <div class="relative group w-full sm:w-1/2 flex items-center gap-3">
                                    <input type="text" x-bind:name="'anggota_nik[' + index + ']'" x-model="item.nik" required
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
                        <x-input-error :messages="$errors->get('anggota_nama')" class="mt-2" />
                        <x-input-error :messages="$errors->get('anggota_nik')" class="mt-2" />
                    </div>

                    <!-- Grade -->
                    <div>
                        <label for="grade" class="block text-sm font-bold text-gray-800 mb-2">Grade Tani</label>
                        <select name="grade" id="grade" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white">
                            <option value="Pemula" {{ old('grade', $profile->grade) == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                            <option value="Madya" {{ old('grade', $profile->grade) == 'Madya' ? 'selected' : '' }}>Madya</option>
                            <option value="Utama" {{ old('grade', $profile->grade) == 'Utama' ? 'selected' : '' }}>Utama</option>
                        </select>
                        <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                    </div>

                    <!-- Luas Lahan -->
                    <div class="md:col-span-2">
                        <label for="luas_lahan" class="block text-sm font-bold text-gray-800 mb-2">Luas Lahan Total (Hektar)</label>
                        <input type="number" step="0.01" name="luas_lahan" id="luas_lahan" value="{{ old('luas_lahan', $profile->luas_lahan) }}" required
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all">
                        <x-input-error :messages="$errors->get('luas_lahan')" class="mt-2" />
                    </div>

                    <!-- Komoditi -->
                    @php
                        $rawKomoditi = old('komoditi', $profile->komoditi ? explode(', ', $profile->komoditi) : []);
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
                            <input type="hidden" name="komoditi[]" :value="komoditiDetails[k] && komoditiDetails[k].trim() !== '' ? k + ' (' + komoditiDetails[k].trim() + ')' : k">
                        </template>
                        <x-input-error :messages="$errors->get('komoditi')" class="mt-2" />
                    </div>

                    <!-- Komoditi Utama -->
                    <div class="md:col-span-2">
                        <label for="komoditi_utama" class="block text-sm font-bold text-gray-800 mb-2">Komoditi Utama</label>
                        <select name="komoditi_utama" id="komoditi_utama" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white">
                            <optgroup label="Tanaman Pangan">
                                @foreach(['Padi Sawah', 'Padi Gogo', 'Jagung Hibrida', 'Kedelai', 'Kacang Tanah'] as $kom)
                                    <option value="{{ $kom }}" {{ old('komoditi_utama', $profile->komoditi_utama) == $kom ? 'selected' : '' }}>{{ $kom }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Hortikultura">
                                @foreach(['Sayuran', 'Buah-buahan', 'Biofarmaka'] as $kom)
                                    <option value="{{ $kom }}" {{ old('komoditi_utama', $profile->komoditi_utama) == $kom ? 'selected' : '' }}>{{ $kom }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <x-input-error :messages="$errors->get('komoditi_utama')" class="mt-2" />
                    </div>

                    <!-- Kecamatan & Desa (dependent dropdown) -->
                    <div class="md:col-span-2" x-data="{
                        villages: [],
                        loadingVillages: false,
                        currentDesa: '{{ old('alamat', $profile->alamat) }}',
                        fetchVillages(kecamatan) {
                            this.villages = [];
                            this.currentDesa = '';
                            if (!kecamatan) return;
                            this.loadingVillages = true;
                            fetch(`/api/villages?kecamatan=${encodeURIComponent(kecamatan)}`)
                                .then(res => res.json())
                                .then(data => {
                                    this.villages = data;
                                    this.loadingVillages = false;
                                })
                                .catch(() => { this.loadingVillages = false; });
                        }
                    }" x-init="fetchVillages(document.getElementById('kecamatan').value); $watch('currentDesa', v => {})">

                        <!-- Kecamatan -->
                        <div class="mb-4">
                            <label for="kecamatan" class="block text-sm font-bold text-gray-800 mb-2">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" required
                                    @change="fetchVillages($event.target.value)"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white">
                                @foreach(['Bahar Selatan', 'Bahar Utara', 'Jambi Luar Kota', 'Kumpeh', 'Kumpeh Ulu', 'Maro Sebo', 'Mestong', 'Sekernan', 'Sungai Bahar', 'Sungai Gelam', 'Taman Rajo'] as $kec)
                                    <option value="{{ $kec }}" {{ old('kecamatan', $profile->kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                        </div>

                        <!-- Desa -->
                        <div>
                            <label for="alamat" class="block text-sm font-bold text-gray-800 mb-2">Desa</label>
                            <div class="relative">
                                <select name="alamat" id="alamat" required x-model="currentDesa"
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all bg-white"
                                        :disabled="loadingVillages || villages.length === 0">
                                    <option value="" x-show="loadingVillages">Memuat desa...</option>
                                    <option value="" x-show="!loadingVillages && villages.length === 0">-- Pilih kecamatan terlebih dahulu --</option>
                                    <template x-for="v in villages" :key="v.name">
                                        <option :value="v.name" :selected="v.name === '{{ old('alamat', $profile->alamat) }}'" x-text="v.name"></option>
                                    </template>
                                </select>
                                <div x-show="loadingVillages" class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="animate-spin h-4 w-4 text-[#19A148]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex gap-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-[#19A148] text-white rounded-xl text-sm font-bold hover:bg-[#15883c] transition-all active:scale-95 flex items-center justify-center gap-2">
                        Simpan dan Kirim Ulang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
