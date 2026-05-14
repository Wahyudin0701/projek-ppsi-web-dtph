<x-app-layout>
    <x-slot name="header">Ajukan Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        {{-- ===== HEADER SECTION ===== --}}
        <div class="text-center py-10">
            <h2 class="text-3xl font-black text-gray-800 mb-4">Pilih Jenis Proposal</h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-base leading-relaxed font-medium">
                Silakan pilih kategori proposal yang ingin Anda ajukan. Pastikan Anda telah memenuhi persyaratan untuk kategori yang dipilih.
            </p>
        </div>

        {{-- ===== SELECTION CARDS ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            {{-- ALSINTAN OPTION --}}
            <a href="{{ route('farmer.proposals.alsintan') }}" 
               class="group relative bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-primary-600/10 hover:-translate-y-2 transition-all duration-500 flex flex-col items-center text-center overflow-hidden">
                {{-- Background Decoration --}}
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary-50 rounded-full opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
                
                {{-- Icon --}}
                <div class="w-24 h-24 rounded-3xl bg-primary-50 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:bg-primary-600 transition-all duration-500">
                    <svg class="w-12 h-12 text-primary-600 group-hover:text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11V5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v6m0 0h8a1 1 0 0 1 1 1v3m-2 0h-3.5M17 11V6m-10 5H3m4 0a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm12 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                    </svg>
                </div>

                <h3 class="text-2xl font-black text-gray-800 mb-3 group-hover:text-primary-700 transition-colors">Proposal Pengajuan Alsintan</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">
                    Pengajuan untuk peminjaman Alat dan Mesin Pertanian seperti Traktor, Pompa Air, Combine Harvester, dan lainnya.
                </p>
                
                <span class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gray-50 text-gray-700 font-bold text-sm group-hover:bg-primary-600 group-hover:text-white transition-all duration-500">
                    Ajukan Peminjaman
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </a>

            {{-- PROGRAM BANTUAN OPTION --}}
            <a href="{{ route('farmer.proposals.bantuan') }}" 
               class="group relative bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-emerald-600/10 hover:-translate-y-2 transition-all duration-500 flex flex-col items-center text-center overflow-hidden">
                {{-- Background Decoration --}}
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-50 rounded-full opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
                
                {{-- Icon --}}
                <div class="w-24 h-24 rounded-3xl bg-emerald-50 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:bg-emerald-600 transition-all duration-500">
                    <svg class="w-12 h-12 text-emerald-600 group-hover:text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <h3 class="text-2xl font-black text-gray-800 mb-3 group-hover:text-emerald-700 transition-colors">Proposal Program Bantuan</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">
                    Pengajuan untuk program bantuan pemerintah seperti Benih Unggul, Pupuk Subsidi, Pembangunan Infrastruktur, dan Pelatihan.
                </p>
                
                <span class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gray-50 text-gray-700 font-bold text-sm group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                    Lihat Program
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </a>
        </div>

        {{-- ===== INFO SECTION ===== --}}
        <div class="max-w-4xl mx-auto bg-blue-50 border border-blue-100 rounded-3xl p-6 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h4 class="text-blue-900 font-bold text-sm mb-1">Informasi Penting</h4>
                <p class="text-blue-800/70 text-xs leading-relaxed">
                    Setiap pengajuan proposal akan melewati proses verifikasi oleh tim Admin Dinas Tanaman Pangan dan Hortikultura. Pastikan data kelompok tani Anda sudah lengkap di menu profil sebelum melakukan pengajuan.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
