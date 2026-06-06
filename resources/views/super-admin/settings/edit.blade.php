<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Latar Belakang Web') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola gambar latar belakang untuk halaman beranda dan login aplikasi.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-start shadow-sm" x-data="{ show: true }" x-show="show">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-emerald-800">Berhasil!</h3>
                        <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="bg-emerald-50 rounded-md inline-flex text-emerald-500 hover:text-emerald-600 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <form action="{{ route('super-admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 md:p-8 space-y-8">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Gambar Latar Belakang (Homepage)</h3>
                            <p class="text-sm text-gray-500 mb-6">Gambar ini akan digunakan sebagai latar belakang utama pada halaman beranda, halaman login, dan pendaftaran.</p>

                            <div class="space-y-4">
                                <div class="rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 p-6 flex flex-col justify-center items-center relative overflow-hidden" x-data="imageViewer()">
                                    
                                    <!-- Existing/Preview Image -->
                                    <div class="absolute inset-0 w-full h-full">
                                        <template x-if="imageUrl">
                                            <img :src="imageUrl" class="w-full h-full object-cover opacity-50" alt="Preview">
                                        </template>
                                        <template x-if="!imageUrl">
                                            <img src="{{ $homepageBackground ? asset('storage/' . $homepageBackground) : asset('images/img_dtph.png') }}" class="w-full h-full object-cover opacity-50" alt="Current Background">
                                        </template>
                                    </div>

                                    <!-- Upload UI -->
                                    <div class="relative z-10 text-center flex flex-col items-center p-6 bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-900">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <h4 class="text-base font-bold text-gray-900 mb-1">Unggah Gambar Baru</h4>
                                        <p class="text-sm text-gray-500 mb-4">PNG, JPG, JPEG atau WEBP (Maksimal 20MB)</p>
                                        
                                        <label for="homepage_background" class="cursor-pointer inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-1000 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Pilih Berkas
                                            <input id="homepage_background" type="file" name="homepage_background" class="sr-only" accept="image/jpeg,image/png,image/jpg,image/webp" @change="fileChosen">
                                        </label>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('homepage_background')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="reset" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-bold text-sm text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-1000 focus:ring-offset-2 transition ease-in-out duration-150">
                            Reset
                        </button>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-gray-900 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-black focus:bg-black active:bg-black focus:outline-none focus:ring-2 focus:ring-gray-1000 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageViewer', () => ({
                imageUrl: '',

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },

                fileToDataUrl(event, callback) {
                    if (! event.target.files.length) return

                    let file = event.target.files[0],
                        reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }))
        })
    </script>
    @endpush
</x-app-layout>
