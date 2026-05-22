<x-app-layout>
    <x-slot name="header">Ajukan Proposal</x-slot>

    <div class="max-w-7xl mx-auto space-y-5">
        {{-- ===== HEADER SECTION ===== --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Pilih Jenis Proposal</h2>
                <p class="text-gray-500 text-sm mt-1">
                    Silakan pilih kategori proposal yang ingin Anda ajukan. Pastikan Anda telah memenuhi persyaratan.
                </p>
            </div>
        </div>

        {{-- ===== SELECTION CARDS ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">

            {{-- ALSINTAN OPTION --}}
            <a href="{{ route('farmer.proposals.alsintan') }}"
               class="group relative bg-white rounded-[2.5rem] p-8 sm:p-10 border border-[#19A148]/30 shadow-md flex flex-col items-center text-center gap-6 overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-[#19A148]/20 hover:border-[#19A148]/50">
                <div class="absolute -right-12 -top-12 w-40 h-40 bg-gradient-to-br from-[#19A148]/5 to-transparent rounded-full opacity-100"></div>
                <div class="absolute -left-12 -bottom-12 w-32 h-32 bg-gradient-to-tr from-[#19A148]/5 to-transparent rounded-full opacity-100"></div>

                <div class="w-24 h-24 rounded-[2rem] bg-[#19A148] flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500 relative z-10 shadow-inner">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11V5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v6m0 0h8a1 1 0 0 1 1 1v3m-2 0h-3.5M17 11V6m-10 5H3m4 0a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm12 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col flex-1">
                    <h3 class="text-2xl font-black text-[#19A148] mb-4">Pengajuan Alsintan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-1">
                        Peminjaman berbagai jenis alat dan mesin pertanian berkualitas tinggi untuk menunjang produktivitas lahan Anda.
                    </p>
                    <span class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-[#19A148] text-white font-bold text-sm shadow-sm group-hover:bg-green-700 transition-all duration-300">
                        Pilih Alsintan
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </span>
                </div>
            </a>

            {{-- PROGRAM BANTUAN OPTION --}}
            <a href="{{ route('farmer.proposals.bantuan') }}"
               class="group relative bg-white rounded-[2.5rem] p-8 sm:p-10 border border-[#19A148]/30 shadow-md flex flex-col items-center text-center gap-6 overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-[#19A148]/20 hover:border-[#19A148]/50">
                <div class="absolute -right-12 -top-12 w-40 h-40 bg-gradient-to-br from-[#19A148]/5 to-transparent rounded-full opacity-100"></div>
                <div class="absolute -left-12 -bottom-12 w-32 h-32 bg-gradient-to-tr from-[#19A148]/5 to-transparent rounded-full opacity-100"></div>

                <div class="w-24 h-24 rounded-[2rem] bg-[#19A148] flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 relative z-10 shadow-inner">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col flex-1">
                    <h3 class="text-2xl font-black text-[#19A148] mb-4">Program Bantuan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-1">
                        Dapatkan dukungan program pemerintah seperti benih unggul, pupuk subsidi, dan pembangunan infrastruktur.
                    </p>
                    <span class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-[#19A148] text-white font-bold text-sm shadow-sm group-hover:bg-green-700 transition-all duration-300">
                        Pilih Program
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </span>
                </div>
            </a>
            
        </div>

        {{-- ===== INFO SECTION ===== --}}
        <div class="bg-blue-50 border border-blue-100 rounded-3xl p-4 flex items-start gap-3">
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