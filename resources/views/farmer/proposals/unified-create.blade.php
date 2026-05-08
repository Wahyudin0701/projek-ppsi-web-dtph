<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Usulan Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="proposalForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="mb-8 pb-6 border-b border-gray-100">
                        <h3 class="text-2xl font-extrabold mt-1">Form Pengajuan Proposal</h3>
                        <p class="text-gray-500 mt-2">Silakan lengkapi form di bawah ini untuk mengajukan peminjaman alat atau program bantuan.</p>
                    </div>

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl border-l-4 border-red-500 font-medium">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('farmer.proposals.store-unified') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        {{-- KATEGORI PENGAJUAN --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Kategori Jenis Pengajuan Proposal <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="kategori_pengajuan" value="alsintan" x-model="kategori" class="peer sr-only" required>
                                    <div class="p-5 rounded-2xl border-2 border-gray-200 peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-gray-50 transition-all h-full">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0">
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11V5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v6m0 0h8a1 1 0 0 1 1 1v3m-2 0h-3.5M17 11V6m-10 5H3m4 0a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm12 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" /></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">Proposal Peminjaman Alat</h4>
                                                <p class="text-xs text-gray-500 mt-1">Pengajuan pinjam pakai Alsintan.</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="kategori_pengajuan" value="bantuan" x-model="kategori" class="peer sr-only" required>
                                    <div class="p-5 rounded-2xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-gray-50 transition-all h-full">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">Proposal Program Bantuan</h4>
                                                <p class="text-xs text-gray-500 mt-1">Bantuan benih, pupuk, dll.</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- DYNAMIC SECTION: ALSINTAN --}}
                        <div x-show="kategori === 'alsintan'" x-transition x-cloak class="space-y-6">
                            <hr class="border-gray-100">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Alat yang Ingin Dipinjam <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto p-1">
                                    @forelse($alsintans as $alat)
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="alsintan_id" value="{{ $alat->id }}" x-model="selectedAlsintan" class="peer sr-only" x-bind:required="kategori === 'alsintan'">
                                            <div class="p-4 rounded-xl border border-gray-200 peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:border-primary-300 transition-all h-full">
                                                <div class="flex gap-4">
                                                    <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0 relative">
                                                        @if($alat->image)
                                                            <img src="{{ Storage::url($alat->image) }}" alt="{{ $alat->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                            </div>
                                                        @endif
                                                        <div class="absolute inset-0 border-2 border-primary-500 rounded-lg opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></div>
                                                    </div>
                                                    <div class="flex-1 flex flex-col">
                                                        <h5 class="font-bold text-gray-800 text-sm line-clamp-2">{{ $alat->name }}</h5>
                                                        <p class="text-xs text-gray-500 mt-1">Merk: {{ $alat->merk ?? '-' }}</p>
                                                        <button type="button" @click.prevent="showDetail({{ $alat->id }})" class="mt-auto pt-2 text-xs font-bold text-primary-600 hover:text-primary-800 flex items-center gap-1 w-max">
                                                            Lihat Detail <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @empty
                                        <div class="col-span-full p-4 bg-gray-50 text-center rounded-xl text-sm text-gray-500">Tidak ada alat yang tersedia saat ini.</div>
                                    @endforelse
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('alsintan_id')" />
                            </div>
                        </div>

                        {{-- DYNAMIC SECTION: PROGRAM BANTUAN --}}
                        <div x-show="kategori === 'bantuan'" x-transition x-cloak class="space-y-6">
                            <hr class="border-gray-100">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Program Bantuan <span class="text-red-500">*</span></label>
                                <div class="space-y-3 max-h-96 overflow-y-auto p-1">
                                    @forelse($programs as $program)
                                        <label class="relative cursor-pointer block">
                                            <input type="radio" name="program_id" value="{{ $program->id }}" x-model="selectedProgram" class="peer sr-only" x-bind:required="kategori === 'bantuan'">
                                            <div class="p-4 rounded-xl border border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300 transition-all flex items-center justify-between">
                                                <div>
                                                    <h5 class="font-bold text-gray-800">{{ $program->name }}</h5>
                                                    <p class="text-xs text-gray-500 mt-1 capitalize">{{ str_replace('_', ' ', $program->type) }}</p>
                                                </div>
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-colors">
                                                    <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                            </div>
                                        </label>
                                    @empty
                                        <div class="p-4 bg-gray-50 text-center rounded-xl text-sm text-gray-500">Tidak ada program bantuan yang dibuka saat ini.</div>
                                    @endforelse
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('program_id')" />
                            </div>
                        </div>

                        {{-- COMMON FIELDS --}}
                        <div x-show="kategori" x-transition x-cloak class="space-y-6">
                            <hr class="border-gray-100">
                            <div>
                                <x-input-label for="lokasi_lahan" value="Lokasi Lahan / Penggunaan (Alamat/Koordinat)" />
                                <x-text-input id="lokasi_lahan" name="lokasi_lahan" type="text" class="mt-1 block w-full" :value="old('lokasi_lahan')" placeholder="Contoh: Desa Makmur, RT 01/RW 02" x-bind:required="kategori !== ''" />
                                <p class="mt-2 text-xs text-gray-500 italic">*Tuliskan lokasi lahan yang akan menjadi objek penggunaan alat atau program bantuan ini.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('lokasi_lahan')" />
                            </div>

                            <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <p class="text-sm text-blue-800 leading-relaxed">
                                    <strong>Catatan:</strong> Dengan menekan tombol kirim, Anda menyatakan bahwa data yang diisi adalah benar atas nama Kelompok Tani <strong>{{ auth()->user()->farmerProfile->nama_kelompok }}</strong>.
                                </p>
                            </div>

                            <div class="flex items-center gap-4 pt-4">
                                <x-primary-button class="px-8 py-3">{{ __('Kirim Usulan Proposal') }}</x-primary-button>
                                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL ALAT --}}
        <div x-show="isModalOpen" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isModalOpen" @click="isModalOpen = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="isModalOpen" x-transition.scale class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button type="button" @click="isModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 pr-8" x-text="activeAlat ? activeAlat.name : ''"></h3>
                            <div class="mt-4">
                                <div class="w-full h-48 bg-gray-100 rounded-xl mb-4 overflow-hidden flex items-center justify-center">
                                    <template x-if="activeAlat && activeAlat.image_url">
                                        <img :src="activeAlat.image_url" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!activeAlat || !activeAlat.image_url">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </template>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mb-4 text-sm bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <div><span class="text-gray-500 block text-xs">Merk/Tipe:</span> <strong x-text="activeAlat ? activeAlat.merk : '-'" class="text-gray-800"></strong></div>
                                    <div><span class="text-gray-500 block text-xs">Kapasitas:</span> <strong x-text="activeAlat ? activeAlat.capacity : '-'" class="text-gray-800"></strong></div>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <span class="text-gray-500 block text-xs mb-1">Deskripsi/Spesifikasi:</span>
                                    <p x-text="activeAlat ? activeAlat.description : '-'" class="leading-relaxed text-gray-800"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 sm:flex sm:flex-row-reverse border-t border-gray-100 pt-4">
                        <button type="button" @click="isModalOpen = false" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-primary-600 text-sm font-bold text-white hover:bg-primary-700 focus:outline-none sm:ml-3 sm:w-auto transition-colors">
                            Tutup Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('proposalForm', () => ({
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
                }
            }))
        })
    </script>
    @endpush
</x-app-layout>
