<x-layouts.public>
    <x-slot:title>Verifikasi Dokumen Resmi</x-slot:title>

    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Portal Verifikasi Dokumen</h1>
            <p class="text-sm text-gray-500 mt-2">Dinas Tanaman Pangan dan Hortikultura Kab. Muaro Jambi</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            @if($status === 'valid')
                {{-- VALID STATUS --}}
                <div class="bg-gradient-to-b from-primary-50 to-white p-8 md:p-10 text-center border-b border-primary-100/50">
                    <div class="w-24 h-24 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-3xl font-black text-primary-800 tracking-tight mb-3">DOKUMEN VALID</h2>
                    <p class="text-primary-700/80 font-medium">Dokumen ini diterbitkan secara sah oleh sistem E-Proposal DTPH Muaro Jambi.</p>
                </div>

                <div class="p-8 md:p-10 space-y-6">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nomor Registrasi</p>
                        <p class="text-lg font-bold text-gray-900 font-mono tracking-wider">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu Pengajuan</p>
                        <p class="text-base font-bold text-gray-800">{{ $proposal->submission_date->translatedFormat('l, d F Y H:i') }} WIB</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Kelompok Tani</p>
                        <p class="text-xl font-black text-gray-900">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Ketua / Kontak</p>
                        <p class="text-base font-bold text-gray-800">{{ $proposal->user->farmerProfile->ketua ?? '-' }} <span class="text-gray-400 text-sm font-normal">({{ $proposal->user->farmerProfile->kontak ?? '-' }})</span></p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Detail Pengajuan</p>
                        @if($proposal->alsintan_id)
                            <div class="inline-block px-3 py-1 bg-primary-50 text-primary-700 text-xs font-bold rounded-lg mb-2">Peminjaman Alsintan</div>
                            <p class="text-lg font-bold text-gray-900">{{ $proposal->alsintan->name }} ({{ $proposal->alsintan->merk ?? '-' }})</p>
                        @else
                            <div class="inline-block px-3 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-lg mb-2">Program Bantuan</div>
                            <p class="text-lg font-bold text-gray-900">{{ $proposal->program->name }}</p>
                        @endif
                    </div>
                </div>

            @else
                {{-- INVALID OR NOT FOUND STATUS --}}
                <div class="bg-gradient-to-b from-red-50 to-white p-8 md:p-12 text-center">
                    <div class="w-24 h-24 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <h2 class="text-3xl font-black text-red-800 tracking-tight mb-4">DOKUMEN TIDAK VALID</h2>
                    <div class="bg-white border border-red-100 rounded-2xl p-6 text-left shadow-sm">
                        <p class="text-red-700 font-medium leading-relaxed">{{ $message }}</p>
                    </div>
                    <p class="text-xs text-gray-400 mt-8 italic">Peringatan: Pemalsuan dokumen adalah tindakan melanggar hukum.</p>
                </div>
            @endif
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-sm font-bold text-primary-600 hover:text-primary-700 hover:underline">
                &larr; Kembali ke Beranda DTPH
            </a>
        </div>
    </div>
</x-layouts.public>
