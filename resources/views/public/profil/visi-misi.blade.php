<x-layouts.public>
    <x-slot:title>Visi & Misi - DTPH Muaro Jambi</x-slot:title>

    <div class="bg-white">
        {{-- Hero Header / Title --}}
        <div class="bg-white py-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight pb-6">Visi & Misi</h1>
            <div class="w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
        </div>

        {{-- Main Content Container --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

            {{-- Visi Section --}}
            <div class="mb-16">
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-primary-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Visi</h2>
                </div>

                <div class="relative bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl p-8 md:p-10 shadow-xl shadow-primary-600/20 overflow-hidden">
                    {{-- Decorative circles --}}
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full"></div>
                    <div class="absolute -bottom-12 -left-8 w-56 h-56 bg-white/5 rounded-full"></div>
                    <div class="relative z-10">
                        <svg class="w-10 h-10 text-primary-300/60 mb-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                        <p class="text-xl md:text-2xl font-bold text-white leading-relaxed text-center md:text-left">
                            Terwujudnya Kabupaten Muaro Jambi yang Unggul dalam Produksi Tanaman Pangan dan Hortikultura yang Berkelanjutan, Berdaya Saing, dan Mensejahterakan Petani.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mb-16"></div>

            {{-- Misi Section --}}
            <div>
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-primary-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Misi</h2>
                </div>

                <div class="space-y-5">
                    @php
                    $misi = [
                        [
                            'no'   => '01',
                            'text' => 'Meningkatkan produksi dan produktivitas komoditas tanaman pangan (padi, jagung, kedelai, dan palawija) guna mendukung ketahanan pangan daerah dan nasional.',
                        ],
                        [
                            'no'   => '02',
                            'text' => 'Mengembangkan potensi komoditas hortikultura unggulan daerah yang bernilai ekonomi tinggi dan berdaya saing di pasar lokal maupun regional.',
                        ],
                        [
                            'no'   => '03',
                            'text' => 'Mendorong penggunaan teknologi pertanian modern, alat dan mesin pertanian (Alsintan), serta praktik pertanian yang efisien dan ramah lingkungan.',
                        ],
                        [
                            'no'   => '04',
                            'text' => 'Meningkatkan kapasitas sumber daya manusia pertanian, kelembagaan petani, dan penyuluhan pertanian yang efektif dan merata di seluruh kecamatan.',
                        ],
                        [
                            'no'   => '05',
                            'text' => 'Mewujudkan tata kelola distribusi bantuan prasarana dan sarana pertanian yang transparan, akuntabel, dan tepat sasaran melalui sistem digitalisasi layanan publik seperti E-Proposal Alsintan.',
                        ],
                        [
                            'no'   => '06',
                            'text' => 'Memperkuat kemitraan dan sinergi antar instansi pemerintah, swasta, perguruan tinggi, dan masyarakat tani dalam rangka percepatan pembangunan pertanian yang berkelanjutan.',
                        ],
                    ];
                    @endphp

                    @foreach($misi as $item)
                    <div class="flex gap-5 p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50/40 hover:shadow-md transition-all duration-300 group">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-white border-2 border-primary-500 flex items-center justify-center group-hover:bg-primary-600 group-hover:border-primary-600 transition-all duration-300 shadow-sm">
                            <span class="text-sm font-extrabold text-primary-600 group-hover:text-white transition-colors duration-300">{{ $item['no'] }}</span>
                        </div>
                        <p class="text-gray-700 text-base leading-relaxed pt-2.5 text-justify">{{ $item['text'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Motto --}}
            <div class="mt-16 rounded-2xl bg-gray-900 text-white p-8 md:p-10 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_#16a34a,_transparent_70%)] opacity-40"></div>
                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-widest text-primary-400 mb-3">Motto Pelayanan</p>
                    <h3 class="text-2xl md:text-3xl font-extrabold text-white mb-4">"Melayani dengan PRIMA"</h3>
                    <div class="flex flex-wrap justify-center gap-3 mt-6">
                        @foreach(['Profesional', 'Responsif', 'Inovatif', 'Modern', 'Amanah'] as $item)
                        <span class="bg-white/10 border border-white/20 text-white text-sm font-semibold px-4 py-2 rounded-full">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.public>
