<x-layouts.app>
    <x-slot:title>Ajukan E-Proposal</x-slot:title>
    <x-slot:pageTitle>Pengajuan Proposal</x-slot:pageTitle>
    <x-slot:pageSubtitle>Lengkapi data untuk meminjam alat pertanian</x-slot:pageSubtitle>

    <div x-data="{
        step: 1,
        totalSteps: 3,
        formData: {
            luas_lahan: '',
            lokasi: '',
            koordinat: '',
            alat_id: '{{ request('alat') }}',
            foto_ktp: null,
            foto_lahan: null
        },
        errors: {},
        nextStep() {
            if (this.validateStep()) {
                if (this.step < this.totalSteps) this.step++;
            }
        },
        prevStep() {
            if (this.step > 1) this.step--;
        },
        validateStep() {
            this.errors = {};
            if (this.step === 1) {
                if (!this.formData.luas_lahan) this.errors.luas_lahan = 'Luas lahan wajib diisi';
                if (!this.formData.lokasi) this.errors.lokasi = 'Lokasi lahan wajib diisi';
            }
            if (this.step === 2) {
                if (!this.formData.alat_id) this.errors.alat_id = 'Pilih alat yang ingin dipinjam';
            }
            return Object.keys(this.errors).length === 0;
        },
        submitForm() {
            if (this.validateStep()) {
                // Simulasi loading/submit
                alert('Proposal Berhasil Diajukan!');
                window.location.href = '{{ route('dashboard') }}';
            }
        }
    }" class="max-w-3xl mx-auto">

        {{-- Step Indicator --}}
        <div class="mb-8 flex items-center justify-between px-4 sm:px-10">
            <template x-for="i in totalSteps" :key="i">
                <div class="flex items-center flex-1 last:flex-none">
                    <div class="flex flex-col items-center gap-2">
                        <div class="step-dot"
                             :class="{
                                'step-dot-active': step === i,
                                'step-dot-done': step > i,
                                'step-dot-inactive': step < i
                             }">
                            <template x-if="step > i">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </template>
                            <template x-if="step <= i">
                                <span x-text="i"></span>
                            </template>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider"
                              :class="step === i ? 'text-primary-600' : 'text-gray-400'">
                            <span x-show="i === 1">Lahan</span>
                            <span x-show="i === 2">Alat</span>
                            <span x-show="i === 3">Berkas</span>
                        </span>
                    </div>
                    <div x-show="i < totalSteps"
                         class="flex-1 h-0.5 mx-4 -mt-6 transition-colors duration-300"
                         :class="step > i ? 'bg-primary-300' : 'bg-gray-200'">
                    </div>
                </div>
            </template>
        </div>

        {{-- Form Content --}}
        <div class="card p-6 sm:p-8">

            {{-- Step 1: Data Lahan --}}
            <div x-show="step === 1" x-transition:enter="animate-slide-in-right">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Langkah 1: Informasi Lahan</h3>
                <div class="space-y-5">
                    <div>
                        <label class="form-label">Luas Lahan (Hektar) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" x-model="formData.luas_lahan"
                               placeholder="Contoh: 1.5" class="form-input" :class="errors.luas_lahan ? 'form-input-error' : ''">
                        <p x-show="errors.luas_lahan" class="form-error" x-text="errors.luas_lahan"></p>
                    </div>
                    <div>
                        <label class="form-label">Lokasi / Alamat Lahan <span class="text-red-500">*</span></label>
                        <textarea x-model="formData.lokasi" rows="3"
                                  placeholder="Sebutkan blok/dusun dan desa"
                                  class="form-input resize-none" :class="errors.lokasi ? 'form-input-error' : ''"></textarea>
                        <p x-show="errors.lokasi" class="form-error" x-text="errors.lokasi"></p>
                    </div>
                    <div>
                        <label class="form-label">Titik Koordinat (Opsional)</label>
                        <div class="flex gap-2">
                            <input type="text" x-model="formData.koordinat" readonly
                                   placeholder="Klik 'Ambil Lokasi'" class="form-input bg-gray-50 flex-1">
                            <button type="button" @click="formData.koordinat = '-6.67123, 106.89234'"
                                    class="btn-secondary whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                GPS
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 2: Pilih Alat --}}
            <div x-show="step === 2" x-transition:enter="animate-slide-in-right" style="display:none">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Langkah 2: Pilih Alat Pertanian</h3>
                <div>
                    <label class="form-label">Pilih Alat <span class="text-red-500">*</span></label>
                    <select x-model="formData.alat_id" class="form-select" :class="errors.alat_id ? 'form-input-error' : ''">
                        <option value="">-- Pilih Alat --</option>
                        <option value="1">Traktor Roda 2</option>
                        <option value="2">Traktor Roda 4</option>
                        <option value="3">Pompa Air 3 Inch</option>
                        <option value="5">Cultivator</option>
                        <option value="7">Sprayer Elektrik</option>
                    </select>
                    <p x-show="errors.alat_id" class="form-error" x-text="errors.alat_id"></p>
                </div>
                <div class="mt-6 p-4 rounded-xl bg-primary-50 border border-primary-100 flex gap-4">
                    <div class="w-12 h-12 rounded-lg bg-primary-200 flex items-center justify-center flex-shrink-0 text-2xl">🚜</div>
                    <div>
                        <p class="text-xs font-bold text-primary-700 uppercase">Informasi Ketersediaan</p>
                        <p class="text-sm text-primary-600 mt-1">Alat yang Anda pilih tersedia di UPTD terdekat. Estimasi waktu tunggu survei: 1-2 hari kerja.</p>
                    </div>
                </div>
            </div>

            {{-- Step 3: Upload Berkas --}}
            <div x-show="step === 3" x-transition:enter="animate-slide-in-right" style="display:none">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Langkah 3: Unggah Berkas</h3>
                <div class="space-y-6">
                    <div>
                        <label class="form-label">Foto KTP <span class="text-red-500">*</span></label>
                        <div class="upload-zone" @click="$refs.ktpInput.click()">
                            <input type="file" x-ref="ktpInput" class="hidden" @change="formData.foto_ktp = $event.target.files[0].name">
                            <svg class="w-8 h-8 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-gray-500" x-text="formData.foto_ktp || 'Klik atau tarik foto KTP ke sini'"></p>
                            <p class="text-[10px] text-gray-400 mt-1">Format JPG/PNG, Maks 2MB</p>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Foto Lahan <span class="text-red-500">*</span></label>
                        <div class="upload-zone" @click="$refs.lahanInput.click()">
                            <input type="file" x-ref="lahanInput" class="hidden" @change="formData.foto_lahan = $event.target.files[0].name">
                            <svg class="w-8 h-8 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-gray-500" x-text="formData.foto_lahan || 'Klik atau tarik foto lahan ke sini'"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                <button type="button" @click="prevStep" x-show="step > 1" class="btn-secondary" style="display:none">
                    Kembali
                </button>
                <div x-show="step === 1"></div> {{-- spacer --}}

                <button type="button" @click="nextStep" x-show="step < totalSteps" class="btn-primary">
                    Selanjutnya
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                <button type="button" @click="submitForm" x-show="step === totalSteps" class="btn-primary" style="display:none">
                    Kirim Proposal
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>
