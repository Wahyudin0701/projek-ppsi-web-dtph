<x-app-layout>
    <x-slot name="header">Manajemen Program</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Edit Program Bantuan</h2>
                <p class="text-gray-500 text-sm mt-1">Perbarui data program bantuan yang sudah ada.</p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="p-6 sm:p-8 text-gray-900">
                <form action="{{ route('admin.programs.update', $program) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nama Program --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Program</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $program->name) }}" required
                               placeholder="Contoh: Bantuan Alsintan Tahap II — 2025"
                               class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Jenis + Tipe --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jenis" class="block text-sm font-bold text-gray-700 mb-2">Jenis Program</label>
                            <select name="jenis" id="jenis" required
                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                                <option value="" disabled>Pilih Jenis</option>
                                <option value="alsintan" {{ old('jenis', $program->jenis) == 'alsintan' ? 'selected' : '' }}>Alsintan</option>
                                <option value="benih" {{ old('jenis', $program->jenis) == 'benih' ? 'selected' : '' }}>Benih</option>
                                <option value="pupuk" {{ old('jenis', $program->jenis) == 'pupuk' ? 'selected' : '' }}>Pupuk</option>
                                <option value="infrastruktur" {{ old('jenis', $program->jenis) == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="pelatihan" {{ old('jenis', $program->jenis) == 'pelatihan' ? 'selected' : '' }}>Pelatihan & Pendampingan</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                        </div>
                        <div>
                            <label for="type" class="block text-sm font-bold text-gray-700 mb-2">Tipe / Tahap</label>
                            <select name="type" id="type" required
                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                                <option value="" disabled>Pilih Tipe</option>
                                <option value="bantuan_permanen" {{ old('type', $program->type) == 'bantuan_permanen' ? 'selected' : '' }}>Bantuan Permanen (Hibah)</option>
                                <option value="pinjam_alat" {{ old('type', $program->type) == 'pinjam_alat' ? 'selected' : '' }}>Peminjaman Alat</option>
                                <option value="usulan_pendanaan" {{ old('type', $program->type) == 'usulan_pendanaan' ? 'selected' : '' }}>Usulan Pendanaan</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                            Deskripsi Program <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  placeholder="Jelaskan program ini secara singkat untuk ditampilkan di halaman publik..."
                                  class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">{{ old('description', $program->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- SOP --}}
                    <div>
                        <label for="sop_description" class="block text-sm font-bold text-gray-700 mb-2">
                            Alur / SOP Program <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea name="sop_description" id="sop_description" rows="4"
                                  placeholder="Jelaskan langkah-langkah atau SOP untuk mengikuti program ini..."
                                  class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">{{ old('sop_description', $program->sop_description) }}</textarea>
                        <x-input-error :messages="$errors->get('sop_description')" class="mt-2" />
                    </div>

                    {{-- Sasaran & Kuota --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sasaran" class="block text-sm font-bold text-gray-700 mb-2">
                                Sasaran <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" name="sasaran" id="sasaran" value="{{ old('sasaran', $program->sasaran) }}"
                                   placeholder="Contoh: Kelompok Tani Padi"
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('sasaran')" class="mt-2" />
                        </div>
                        <div>
                            <label for="kuota" class="block text-sm font-bold text-gray-700 mb-2">
                                Kuota <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" name="kuota" id="kuota" value="{{ old('kuota', $program->kuota) }}"
                                   placeholder="Contoh: 45 Kelompok Tani"
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('kuota')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Persyaratan --}}
                    <div x-data="{ 
                        requirements: {{ json_encode(old('requirements', $program->requirements ?? [''])) }},
                        addRequirement() { this.requirements.push(''); },
                        removeRequirement(index) { this.requirements.splice(index, 1); if(this.requirements.length === 0) this.addRequirement(); }
                    }">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-bold text-gray-700">Persyaratan Umum</label>
                            <button type="button" @click="addRequirement()" 
                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Syarat
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(req, index) in requirements" :key="index">
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input type="text" :name="'requirements[' + index + ']'" x-model="requirements[index]"
                                               placeholder="Contoh: Fotocopy KTP Ketua Kelompok"
                                               class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm text-sm">
                                    </div>
                                    <button type="button" @click="removeRequirement(index)" 
                                            class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <x-input-error :messages="$errors->get('requirements.*')" class="mt-2" />
                    </div>

                    {{-- Jadwal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="open_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Buka</label>
                            <input type="date" name="open_date" id="open_date" required
                                   value="{{ old('open_date', $program->open_date?->format('Y-m-d')) }}"
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('open_date')" class="mt-2" />
                        </div>
                        <div>
                            <label for="close_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Tutup</label>
                            <input type="date" name="close_date" id="close_date" required
                                   value="{{ old('close_date', $program->close_date?->format('Y-m-d')) }}"
                                   class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <x-input-error :messages="$errors->get('close_date')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-start gap-2.5 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-blue-700">Status program ditentukan <strong>otomatis</strong>: <em>Belum Berjalan</em> → <em>Pendaftaran Buka</em> → <em>Selesai</em>, sesuai tanggal yang diatur.</p>
                    </div>

                    {{-- Footer Buttons --}}
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('admin.programs.index') }}"
                           class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 rounded-xl transition-colors shadow-sm">
                            Perbarui Program
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
