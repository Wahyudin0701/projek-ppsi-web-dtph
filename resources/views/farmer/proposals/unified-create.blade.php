<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Usulan Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="proposalForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-2xl border border-gray-100 relative">
                
                {{-- Decorative Header Background --}}
                <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-br from-primary-50 to-emerald-50 z-0"></div>

                <div class="p-8 sm:p-10 relative z-10">
                    <div class="mb-10 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white shadow-sm border border-gray-100 text-primary-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">Form Pengajuan Proposal</h3>
                        <p class="text-gray-500 mt-2 max-w-lg mx-auto">Ikuti tahapan di bawah ini untuk mengajukan peminjaman alat mesin pertanian atau program bantuan lainnya.</p>
                    </div>

                    @if(session('error'))
                        <div class="mb-8 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- Stepper UI --}}
                    <div class="mb-10 px-4 sm:px-12 relative">
                        <div class="flex items-center justify-between relative">
                            <div class="absolute left-0 top-4 transform -translate-y-1/2 w-full h-1 bg-gray-100 z-0 rounded-full"></div>
                            <div class="absolute left-0 top-4 transform -translate-y-1/2 h-1 bg-primary-500 z-0 rounded-full transition-all duration-500 ease-in-out" :style="'width: ' + ((step - 1) / 2 * 100) + '%'"></div>
                            
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 ring-4 ring-white" :class="step >= 1 ? 'bg-primary-500 text-white shadow-md' : 'bg-gray-100 text-gray-400'">1</div>
                                <span class="text-xs font-bold mt-2 transition-colors duration-300" :class="step >= 1 ? 'text-primary-600' : 'text-gray-400'">Kategori</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 ring-4 ring-white" :class="step >= 2 ? 'bg-primary-500 text-white shadow-md' : 'bg-gray-100 text-gray-400'">2</div>
                                <span class="text-xs font-bold mt-2 transition-colors duration-300" :class="step >= 2 ? 'text-primary-600' : 'text-gray-400'">Pilihan</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 ring-4 ring-white" :class="step >= 3 ? 'bg-primary-500 text-white shadow-md' : 'bg-gray-100 text-gray-400'">3</div>
                                <span class="text-xs font-bold mt-2 transition-colors duration-300" :class="step >= 3 ? 'text-primary-600' : 'text-gray-400'">Konfirmasi</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('farmer.proposals.store-unified') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        {{-- STEP 1: KATEGORI PENGAJUAN --}}
                        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            <label class="block text-base font-bold text-gray-800 mb-4">Kategori Pengajuan <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="kategori_pengajuan" value="alsintan" x-model="kategori" class="peer sr-only" required>
                                    <div class="p-6 rounded-2xl border-2 border-gray-200 peer-checked:border-primary-500 peer-checked:bg-primary-50/50 hover:bg-gray-50 transition-all h-full relative overflow-hidden">
                                        <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-primary-500 peer-checked:bg-primary-500 flex items-center justify-center transition-colors z-10">
                                            <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <div class="w-14 h-14 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11V5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v6m0 0h8a1 1 0 0 1 1 1v3m-2 0h-3.5M17 11V6m-10 5H3m4 0a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm12 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" /></svg>
                                        </div>
                                        <h4 class="font-bold text-gray-900 text-lg">Peminjaman Alat</h4>
                                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">Pengajuan pinjam pakai berbagai mesin dan alat pertanian yang tersedia.</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="kategori_pengajuan" value="bantuan" x-model="kategori" class="peer sr-only" required>
                                    <div class="p-6 rounded-2xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 hover:bg-gray-50 transition-all h-full relative overflow-hidden">
                                        <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-colors z-10">
                                            <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                        </div>
                                        <h4 class="font-bold text-gray-900 text-lg">Program Bantuan</h4>
                                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">Pengajuan bantuan produksi berupa benih unggul, pupuk, atau pestisida.</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- STEP 2: PILIHAN DETAIL (ALSINTAN OR PROGRAM) --}}
                        <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            
                            {{-- JIKA PILIH ALSINTAN --}}
                            <div x-show="kategori === 'alsintan'">
                                <label class="block text-base font-bold text-gray-800 mb-4">Pilih Alat yang Ingin Dipinjam <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                    @forelse($alsintans as $alat)
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="alsintan_id" value="{{ $alat->id }}" x-model="selectedAlsintan" class="peer sr-only" x-bind:required="step === 2 && kategori === 'alsintan'">
                                            <div class="p-4 rounded-xl border border-gray-200 peer-checked:border-primary-500 peer-checked:ring-1 peer-checked:ring-primary-500 hover:border-primary-300 transition-all bg-white h-full shadow-sm">
                                                <div class="flex gap-4">
                                                    <div class="w-20 h-20 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0 relative border border-gray-100">
                                                        @if($alat->image)
                                                            <img src="{{ Storage::url($alat->image) }}" alt="{{ $alat->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                            </div>
                                                        @endif
                                                        <div class="absolute top-1 left-1 w-5 h-5 rounded-full bg-white/90 shadow-sm border border-gray-200 flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                                            <svg class="w-3.5 h-3.5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 flex flex-col justify-center">
                                                        <h5 class="font-bold text-gray-900 text-sm leading-tight mb-1">{{ $alat->name }}</h5>
                                                        <p class="text-[11px] font-medium text-gray-500 bg-gray-100 w-max px-2 py-0.5 rounded uppercase tracking-wide">{{ $alat->merk ?? 'Tanpa Merk' }}</p>
                                                        <button type="button" @click.prevent="showDetail({{ $alat->id }})" class="mt-2 text-[11px] font-bold text-primary-600 hover:text-primary-800 flex items-center gap-1 w-max">
                                                            Lihat Spesifikasi <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @empty
                                        <div class="col-span-full p-8 bg-gray-50 text-center rounded-xl border border-gray-100">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            <p class="text-sm font-medium text-gray-600">Tidak ada alat yang tersedia saat ini.</p>
                                        </div>
                                    @endforelse
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('alsintan_id')" />
                            </div>

                            {{-- JIKA PILIH PROGRAM --}}
                            <div x-show="kategori === 'bantuan'">
                                <label class="block text-base font-bold text-gray-800 mb-4">Pilih Program Bantuan <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 gap-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                    @forelse($programs as $program)
                                        <label class="relative cursor-pointer block group">
                                            <input type="radio" name="program_id" value="{{ $program->id }}" x-model="selectedProgram" class="peer sr-only" x-bind:required="step === 2 && kategori === 'bantuan'">
                                            <div class="p-5 rounded-xl border border-gray-200 peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 hover:border-emerald-300 transition-all bg-white shadow-sm flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center shrink-0 border border-emerald-100">
                                                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="font-bold text-gray-900 leading-tight mb-1">{{ $program->name }}</h5>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded capitalize tracking-wide">{{ str_replace('_', ' ', $program->type) }}</span>
                                                        <span class="text-xs text-gray-500">Batas akhir: {{ \Carbon\Carbon::parse($program->close_date)->translatedFormat('d M Y') }}</span>
                                                    </div>
                                                </div>
                                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-colors shrink-0">
                                                    <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                            </div>
                                        </label>
                                    @empty
                                        <div class="p-8 bg-gray-50 text-center rounded-xl border border-gray-100">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <p class="text-sm font-medium text-gray-600">Tidak ada program bantuan yang dibuka saat ini.</p>
                                        </div>
                                    @endforelse
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('program_id')" />
                            </div>
                        </div>

                        {{-- STEP 3: DOKUMEN DAN KONFIRMASI --}}
                        <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                                <label for="file_proposal" class="block text-sm font-bold text-gray-800 mb-2">Dokumen Proposal (PDF/Word) <span class="text-red-500">*</span></label>
                                <input type="file" name="file_proposal" id="file_proposal" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" x-bind:required="step === 3">
                                <p class="mt-2 text-[11px] text-gray-500 font-medium">Upload file proposal resmi Anda. Maksimal 5MB.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('file_proposal')" />
                            </div>

                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200" x-show="kategori === 'alsintan'">
                                <label for="rencana_durasi_hari" class="block text-sm font-bold text-gray-800 mb-2">Rencana Durasi Pemakaian (Hari) <span class="text-red-500">*</span></label>
                                <div class="relative max-w-sm">
                                    <input type="number" name="rencana_durasi_hari" id="rencana_durasi_hari" min="1" max="365"
                                        class="block w-full pl-5 pr-16 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all sm:text-sm"
                                        placeholder="Misal: 7" x-bind:required="step === 3 && kategori === 'alsintan'">
                                    <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">
                                        <span class="text-sm font-bold text-gray-400">Hari</span>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('rencana_durasi_hari')" />
                            </div>

                            <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100 flex items-start gap-3">
                                <div class="mt-0.5">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div class="text-sm text-blue-900 leading-relaxed">
                                    <p class="font-bold mb-1">Pernyataan Pertanggungjawaban</p>
                                    <p>Dengan menekan tombol kirim, Anda menyatakan bahwa usulan ini sah dan diajukan atas nama Kelompok Tani <strong>{{ auth()->user()->farmerProfile->nama_kelompok ?? 'Anda' }}</strong>.</p>
                                </div>
                            </div>
                        </div>

                        {{-- NAVIGATION BUTTONS --}}
                        <div class="pt-6 mt-8 border-t border-gray-100 flex items-center justify-between gap-4">
                            <button type="button" x-show="step > 1" x-cloak @click="step--" class="px-6 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                                Kembali
                            </button>
                            <div x-show="step === 1" class="flex-1"></div> <!-- Spacer for step 1 -->

                            <button type="button" x-show="step < 3" @click="nextStep" class="px-8 py-3 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all flex items-center ml-auto">
                                Selanjutnya
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>

                            <button type="submit" x-show="step === 3" x-cloak class="px-8 py-3 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all flex items-center ml-auto">
                                Kirim Usulan
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL ALAT --}}
        <div x-show="isModalOpen" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isModalOpen" @click="isModalOpen = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="isModalOpen" x-transition.scale class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 border border-gray-100">
                    <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                        <button type="button" @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 bg-white rounded-full p-1 focus:outline-none transition-colors">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-extrabold text-gray-900 pr-8" x-text="activeAlat ? activeAlat.name : ''"></h3>
                            <div class="mt-5">
                                <div class="w-full h-56 bg-gray-100 rounded-xl mb-5 overflow-hidden flex items-center justify-center shadow-inner relative">
                                    <template x-if="activeAlat && activeAlat.image_url">
                                        <img :src="activeAlat.image_url" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!activeAlat || !activeAlat.image_url">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </template>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mb-5 text-sm bg-gray-50/80 p-4 rounded-xl border border-gray-100">
                                    <div><span class="text-gray-500 font-semibold text-[11px] uppercase tracking-wider block mb-1">Merk / Tipe</span> <strong x-text="activeAlat ? activeAlat.merk : '-'" class="text-gray-900 text-base"></strong></div>
                                    <div><span class="text-gray-500 font-semibold text-[11px] uppercase tracking-wider block mb-1">Kapasitas</span> <strong x-text="activeAlat ? activeAlat.capacity : '-'" class="text-gray-900 text-base"></strong></div>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <span class="text-gray-500 font-semibold text-[11px] uppercase tracking-wider block mb-2">Spesifikasi Lengkap</span>
                                    <div class="prose prose-sm max-w-none text-gray-700 bg-white p-4 rounded-xl border border-gray-100">
                                        <p x-text="activeAlat ? activeAlat.description : '-'" class="leading-relaxed whitespace-pre-wrap"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="isModalOpen = false" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gray-900 text-sm font-bold text-white hover:bg-gray-800 focus:outline-none sm:w-auto transition-colors">
                            Tutup Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('proposalForm', () => ({
                step: 1,
                kategori: '{{ old('kategori_pengajuan', request('kategori_pengajuan', '')) }}',
                selectedAlsintan: '{{ old('alsintan_id', request('alsintan_id', '')) }}',
                selectedProgram: '{{ old('program_id', request('program_id', '')) }}',
                
                // Modal logic
                isModalOpen: false,
                activeAlat: null,
                alsintansData: @json($alsintans->map(function($a) {
                    $a->image_url = $a->image ? Storage::url($a->image) : null;
                    return $a;
                })),

                showDetail(id) {
                    this.activeAlat = this.alsintansData.find(a => a.id === id);
                    this.isModalOpen = true;
                },

                nextStep() {
                    // Validasi tahap 1
                    if (this.step === 1) {
                        if (!this.kategori) {
                            alert('Silakan pilih kategori pengajuan terlebih dahulu.');
                            return;
                        }
                    }
                    
                    // Validasi tahap 2
                    if (this.step === 2) {
                        if (this.kategori === 'alsintan' && !this.selectedAlsintan) {
                            alert('Silakan pilih alat yang ingin dipinjam.');
                            return;
                        }
                        if (this.kategori === 'bantuan' && !this.selectedProgram) {
                            alert('Silakan pilih program bantuan.');
                            return;
                        }
                    }

                    this.step++;
                }
            }))
        })
    </script>
    @endpush
</x-app-layout>
