<x-layouts.public>
    <x-slot:title>Verifikasi Dokumen</x-slot:title>

    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            @if(isset($status) && $status === 'valid')
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4 shadow-lg shadow-green-100">
                    <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Dokumen Valid
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Tanda tangan elektronik ini terverifikasi asli dan tercatat di sistem kami.
                </p>
            @else
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4 shadow-lg shadow-red-100">
                    <svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Dokumen Tidak Valid
                </h2>
                <p class="mt-2 text-center text-sm text-red-600 font-medium">
                    {{ $message ?? 'Dokumen tidak ditemukan atau tanda tangan palsu.' }}
                </p>
            @endif
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="bg-white py-8 px-4 shadow-xl shadow-gray-200/50 sm:rounded-2xl sm:px-10 border border-gray-100">
                @if(isset($status) && $status === 'valid' && isset($signature))
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Informasi Dokumen</h3>
                            <dl class="space-y-3 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <dt class="font-medium">Jenis Dokumen:</dt>
                                    <dd class="text-gray-900 font-semibold">{{ ucwords(str_replace('_', ' ', $signature->document_type)) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium">ID Referensi:</dt>
                                    <dd class="text-gray-900">#{{ $signature->document_id }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium">Waktu Tanda Tangan:</dt>
                                    <dd class="text-gray-900">{{ $signature->signed_at->format('d M Y H:i:s') }} WIB</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Penandatangan</h3>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-[#19A148]/10 flex items-center justify-center border border-[#19A148]/20">
                                        <span class="text-[#19A148] font-bold text-xl">{{ substr($signature->signer->name ?? 'A', 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $signature->signer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $signature->signer->role_label }}</div>
                                    @if($signature->signer->employee && $signature->signer->employee->nip)
                                        <div class="text-xs text-gray-400 mt-0.5">NIP: {{ $signature->signer->employee->nip }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('home') }}" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#19A148] hover:bg-[#148f3d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-colors">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 mb-6">Silakan periksa kembali URL atau QR Code yang Anda pindai. Pastikan Anda memindai QR Code dari dokumen resmi yang diterbitkan oleh sistem kami.</p>
                        <a href="{{ route('home') }}" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-colors">
                            Kembali ke Beranda
                        </a>
                    </div>
                @endif
            </div>
            
            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi.<br>Sistem Verifikasi Dokumen Elektronik.
            </div>
        </div>
    </div>
</x-layouts.public>
