<x-app-layout>
    <x-slot name="header">Ajukan Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-5">
        {{-- ===== HEADER SECTION ===== --}}
        <div class="text-center pt-4 pb-2">
            <h2 class="text-3xl font-black text-gray-800 mb-3">Pilih Jenis Proposal</h2>
            <p class="text-gray-500 max-w-xl mx-auto text-md leading-relaxed">
                Silakan pilih kategori proposal yang ingin Anda ajukan. Pastikan Anda telah memenuhi persyaratan untuk kategori yang dipilih.
            </p>
        </div>

        {{-- ===== SELECTION CARDS ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-4xl mx-auto">

            {{-- ALSINTAN OPTION --}}
            <a href="{{ route('farmer.proposals.alsintan') }}"
               class="proposal-card group relative bg-white rounded-3xl p-5 border border-gray-100 shadow-sm flex flex-row items-start gap-4 overflow-hidden transition-all duration-300
               hover:-translate-y-1 hover:shadow-lg hover:shadow-primary-600/10 hover:border-primary-200">
                <div class="absolute -right-5 -bottom-5 w-20 h-20 bg-primary-50 rounded-full opacity-0 group-hover:opacity-50 transition-opacity duration-300"></div>

                <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-100 group-hover:scale-105 transition-all duration-300">
                    <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11V5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v6m0 0h8a1 1 0 0 1 1 1v3m-2 0h-3.5M17 11V6m-10 5H3m4 0a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm12 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="text-xl font-black text-gray-800 mb-1 group-hover:text-primary-700 transition-colors">Pengajuan Alsintan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-3">
                        Pengajuan untuk peminjaman alat dan mesin pertanian seperti Traktor, Pompa Air, Combine Harvester, dan lain-lain.
                    </p>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary-50 text-primary-700 font-bold text-xs group-hover:bg-primary-100 transition-colors duration-300">
                        Ajukan Peminjaman
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </div>
            </a>

            {{-- PROGRAM BANTUAN OPTION --}}
            <a href="{{ route('farmer.proposals.bantuan') }}"
               class="proposal-card group relative bg-white rounded-3xl p-5 border border-gray-100 shadow-sm flex flex-row items-start gap-4 overflow-hidden transition-all duration-300
               hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-600/10 hover:border-emerald-200">
                <div class="absolute -right-5 -bottom-5 w-20 h-20 bg-emerald-50 rounded-full opacity-0 group-hover:opacity-50 transition-opacity duration-300"></div>

                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 group-hover:scale-105 transition-all duration-300">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="text-xl font-black text-gray-800 mb-1 group-hover:text-emerald-700 transition-colors">Program Bantuan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-3">
                        Pengajuan untuk program bantuan pemerintah seperti Benih Unggul, Pupuk Subsidi, Pembangunan Infrastruktur, dan Pelatihan.
                    </p>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 font-bold text-xs group-hover:bg-emerald-100 transition-colors duration-300">
                        Lihat Program
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </div>
            </a>
        </div>

        {{-- ===== INFO SECTION ===== --}}
        <div class="max-w-4xl mx-auto bg-blue-50 border border-blue-100 rounded-3xl p-4 flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h4 class="text-blue-900 font-bold text-sm mb-0.5">Informasi Penting</h4>
                <p class="text-blue-800/70 text-xs leading-relaxed">
                    Setiap pengajuan proposal akan melewati proses verifikasi oleh tim Admin Dinas Tanaman Pangan dan Hortikultura. Pastikan data kelompok tani Anda sudah lengkap di menu profil sebelum melakukan pengajuan.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>