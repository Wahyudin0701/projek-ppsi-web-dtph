<x-app-layout>
    <x-slot name="header">Edit Data Pegawai</x-slot>

@php
    $structuralRolesList = [
        'Kepala Dinas', 
        'Sekretaris', 
        'Kasubbag Umum Kepegawaian', 
        'Fungsional Perencanaan', 
        'Fungsional Analis Keuangan Pusat dan Daerah', 
        'Kabid. Tanaman Pangan', 
        'Kabid. Hortikultura', 
        'Kabid. PSP', 
        'Kabid. Penyuluhan',
        'UPTD Balai Benih Utama Arang Arang'
    ];
    $isStructural = in_array($employee->role, $structuralRolesList);
@endphp

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Edit Pegawai</h2>
                <p class="text-gray-500 text-sm mt-1">Perbarui data pegawai untuk struktur organisasi.</p>
            </div>
            <a href="{{ route('admin.employees.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>



        <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            @csrf
            @method('PATCH')

            <div class="space-y-5">
                {{-- Foto Upload --}}
                <div x-data="{
                    previewUrl: '{{ $employee->foto ? asset('storage/' . $employee->foto) : '' }}',
                    existingFoto: '{{ $employee->foto ? true : false }}',
                    hapusFoto: false,
                    handleFile(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (ev) => { 
                                this.previewUrl = ev.target.result;
                                this.hapusFoto = false;
                            };
                            reader.readAsDataURL(file);
                        }
                    },
                    clearFile() {
                        this.previewUrl = '';
                        this.hapusFoto = true;
                        this.$refs.fotoInput.value = '';
                    }
                }">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">
                        Foto Pegawai <span class="normal-case font-normal text-gray-400">(Opsional, maks. 2MB)</span>
                    </label>

                    <div class="flex items-start gap-5">
                        {{-- Preview area --}}
                        <div class="flex-shrink-0">
                            <div class="w-24 h-24 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition-all"
                                 :class="previewUrl ? 'border-blue-300 bg-white' : ''">
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" class="w-full h-full object-cover rounded-2xl" alt="Preview foto">
                                </template>
                                <template x-if="!previewUrl">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </template>
                            </div>
                        </div>

                        {{-- Upload controls --}}
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <label for="fotoInputEdit"
                                       class="inline-flex items-center gap-2 cursor-pointer bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-300 text-gray-600 hover:text-blue-600 font-semibold text-sm px-4 py-2.5 rounded-xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span x-text="previewUrl ? 'Ganti Foto' : 'Pilih Foto'"></span>
                                </label>
                                <input type="file" id="fotoInputEdit" name="foto" accept="image/*" x-ref="fotoInput"
                                       @change="handleFile($event)" class="hidden">

                                <button type="button" x-show="previewUrl" @click="clearFile()"
                                        class="inline-flex items-center gap-1.5 text-xs text-red-400 hover:text-red-600 font-semibold transition-colors bg-red-50 hover:bg-red-100 px-3 py-2 rounded-xl border border-red-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus Foto
                                </button>
                            </div>

                            {{-- Hidden input untuk flag hapus foto --}}
                            <input type="hidden" name="hapus_foto" :value="hapusFoto ? '1' : '0'">

                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, WebP. Ukuran maksimal 2MB.</p>
                            @error('foto')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}" required placeholder="Misal: Ir. Budi Santoso"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- NIP --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">NIP <span class="normal-case font-normal text-gray-400">(Opsional untuk Non-PNS)</span></label>
                    <input type="text" name="nip" value="{{ old('nip', $employee->nip) }}" placeholder="Misal: 198001012003121001"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('nip') border-red-400 @enderror">
                    @error('nip')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Pangkat/Golongan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Pangkat/Golongan <span class="normal-case font-normal text-gray-400">(Opsional)</span></label>
                    <input type="text" name="pangkat_gol" value="{{ old('pangkat_gol', $employee->pangkat_gol) }}" placeholder="Misal: Penata TK.I / III d"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('pangkat_gol') border-red-400 @enderror">
                    @error('pangkat_gol')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Jabatan & Bidang --}}
                <div class="grid grid-cols-1 {{ $isStructural ? '' : 'sm:grid-cols-2' }} gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Jabatan *</label>
                        @if($isStructural)
                            <div class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600 font-semibold">
                                {{ $employee->role }}
                            </div>
                            <input type="hidden" name="role" value="{{ $employee->role }}">
                        @else
                            <input type="text" name="role" value="{{ old('role', $employee->role) }}" required placeholder="Misal: Penyuluh Pertanian"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('role') border-red-400 @enderror">
                            @error('role')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        @endif
                    </div>
                    
                    @if(!$isStructural)
                    {{-- Bidang --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Bidang <span class="normal-case font-normal text-gray-400">(Penempatan)</span></label>
                        <select name="bidang" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('bidang') border-red-400 @enderror">
                            <option value="">-- Pilih Bidang (Opsional) --</option>
                            <option value="Tanaman Pangan" {{ old('bidang', $employee->bidang) == 'Tanaman Pangan' ? 'selected' : '' }}>Tanaman Pangan</option>
                            <option value="Hortikultura" {{ old('bidang', $employee->bidang) == 'Hortikultura' ? 'selected' : '' }}>Hortikultura</option>
                            <option value="Penyuluhan" {{ old('bidang', $employee->bidang) == 'Penyuluhan' ? 'selected' : '' }}>Penyuluhan</option>
                            <option value="PSP" {{ old('bidang', $employee->bidang) == 'PSP' ? 'selected' : '' }}>PSP</option>
                            <option value="Umum" {{ old('bidang', $employee->bidang) == 'Umum' ? 'selected' : '' }}>Umum / Lainnya</option>
                        </select>
                        @error('bidang')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    @endif
                </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.employees.index') }}" class="flex-1 text-center py-3.5 rounded-2xl border border-gray-200 font-bold text-sm text-gray-600 hover:bg-gray-50 transition-all order-2 sm:order-1">
                    Batal
                </a>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3.5 rounded-2xl transition-all order-1 sm:order-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
