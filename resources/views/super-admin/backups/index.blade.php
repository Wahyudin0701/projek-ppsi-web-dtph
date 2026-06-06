<x-app-layout>
    <x-slot:title>Kelola Backup Sistem</x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Backup Data</h1>
            <p class="text-sm text-gray-500 mt-1">Amankan data sistem dengan mengunduh salinan database dan file ke komputer Anda.</p>
        </div>
        
        <!-- Form Buat Backup Baru dengan Alpine Modal -->
        <div x-data="{ 
            showConfirmModal: false, 
            isProcessing: false,
            progress: 0,
            narration: 'Memulai proses...',
            intervalId: null,
            backupType: 'db',
            startProgress() {
                this.isProcessing = true;
                this.showConfirmModal = false;
                this.progress = 0;
                this.narration = 'Mempersiapkan sistem dan memverifikasi koneksi...';
                
                this.intervalId = setInterval(() => {
                    if (this.progress < 80) {
                        this.progress += Math.floor(Math.random() * 8) + 2;
                    } else if (this.progress < 99) {
                        this.progress += 1;
                    } else {
                        clearInterval(this.intervalId);
                    }
                    
                    if (this.progress < 25) this.narration = 'Mempersiapkan sistem dan memverifikasi koneksi...';
                    else if (this.progress < 50) this.narration = 'Mengekstrak struktur dan menyalin data tabel...';
                    else if (this.progress < 80) this.narration = 'Mengumpulkan berkas dan mengompresi ke arsip ZIP...';
                    else if (this.progress < 99) this.narration = 'Menyelesaikan proses finalisasi dan menyimpan file...';
                    else this.narration = 'Sistem sedang memproses hasil akhir, mohon tunggu...';
                }, 600);
                
                setTimeout(() => document.getElementById('backupForm').submit(), 100);
            },
            cancelBackup() {
                this.isProcessing = false;
                this.progress = 0;
                clearInterval(this.intervalId);
                window.stop(); // Menghentikan request HTTP browser
            }
        }" class="flex items-center gap-2">
            <form action="{{ route('super-admin.backups.store') }}" method="POST" id="backupForm" class="hidden">
                @csrf
                <input type="hidden" name="type" :value="backupType">
            </form>
            
            <select x-model="backupType" class="rounded-xl border-gray-300 text-sm focus:border-gray-900 focus:ring focus:ring-blue-200">
                <option value="db">Backup Database Saja</option>
                <option value="full">Full Backup (DB + File Upload)</option>
            </select>
            
            <button type="button" @click="showConfirmModal = true" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-black transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Generate Backup
            </button>

            <!-- Loading Modal with Progress Bar & Narration -->
            <div x-show="isProcessing" style="display: none" class="relative z-[100]" aria-labelledby="loading-title" role="dialog" aria-modal="true">
                <div x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center p-4">
                    <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-8 text-center relative overflow-hidden">
                        
                        <!-- Spinner & Percentage -->
                        <div class="mx-auto w-16 h-16 mb-5 text-gray-900 relative flex items-center justify-center">
                            <svg class="animate-spin absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs font-bold text-blue-700 relative z-10" x-text="`${progress}%`"></span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2" id="loading-title">Memproses Backup</h3>
                        
                        <!-- Narration Text -->
                        <p class="text-sm text-gray-500 mb-6 h-10 flex items-center justify-center transition-all duration-300" x-text="narration"></p>
                        
                        <!-- Progress Bar Container -->
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-6 overflow-hidden">
                            <div class="bg-gray-900 h-1.5 rounded-full transition-all duration-300 ease-out" :style="`width: ${progress}%`"></div>
                        </div>

                        <!-- Cancel Button -->
                        <button type="button" @click="cancelBackup()" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:text-red-600 hover:border-red-300 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/50 transition-colors">
                            Batalkan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Alpine Modal Konfirmasi -->
            <div x-show="showConfirmModal" style="display: none" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div x-show="showConfirmModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div x-show="showConfirmModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.away="showConfirmModal = false" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gray-200 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Konfirmasi Backup Data</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Sistem akan memproses dan mengompresi data Anda ke dalam file arsip. Proses ini akan membutuhkan beberapa saat tergantung dari ukuran data. Apakah Anda ingin melanjutkan?</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" @click="startProgress()" class="inline-flex w-full justify-center rounded-xl bg-gray-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-black sm:ml-3 sm:w-auto transition-colors">Lanjutkan Backup</button>
                                <button type="button" @click="showConfirmModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <span class="font-medium text-sm">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-bold text-gray-900">Riwayat File Backup</h3>
            <p class="text-sm text-gray-500">Daftar file arsip (zip) yang tersimpan di server.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Nama File</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Ukuran</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Tanggal Dibuat</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 text-sm text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($backups as $backup)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-900 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-bold text-gray-900 text-sm block">{{ $backup['name'] }}</span>
                                    <span class="text-xs text-gray-500">Berkas ZIP Arsip</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-600 whitespace-nowrap">
                            {{ $backup['size'] }}
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-600 whitespace-nowrap">
                            {{ $backup['date']->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="py-4 px-6 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('super-admin.backups.download', $backup['name']) }}" class="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" title="Download Backup">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                                <div x-data="{ showDeleteModal: false }" class="inline-block">
                                    <button type="button" @click="showDeleteModal = true" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Backup">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div x-show="showDeleteModal" style="display: none" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                                <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.away="showDeleteModal = false" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg whitespace-normal">
                                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                            </div>
                                                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                                                <h3 class="text-lg font-semibold leading-6 text-gray-900">Konfirmasi Hapus Backup</h3>
                                                                <div class="mt-2">
                                                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus file backup <strong class="text-gray-700">{{ $backup['name'] }}</strong>? File yang dihapus tidak dapat dikembalikan lagi.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                        <form action="{{ route('super-admin.backups.destroy', $backup['name']) }}" method="POST" class="inline-flex w-full sm:w-auto">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition-colors">Ya, Hapus</button>
                                                        </form>
                                                        <button type="button" @click="showDeleteModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 px-6 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 mb-1">Belum Ada Backup</h3>
                            <p class="text-gray-500 text-sm max-w-sm mx-auto">Sistem belum pernah di-backup sebelumnya. Silakan klik tombol <strong>Generate Backup</strong> di atas untuk membuat cadangan pertama Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
