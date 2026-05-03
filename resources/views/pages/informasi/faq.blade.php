<x-layouts.public>
    <x-slot:title>FAQ (Tanya Jawab) - DTPH Muaro Jambi</x-slot:title>
    <x-slot:metaDescription>Temukan jawaban atas pertanyaan yang paling sering diajukan mengenai program bantuan, peminjaman alsintan, dan layanan Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi.</x-slot:metaDescription>

    <div class="bg-[#f8faf9] min-h-screen pb-20" x-data="{ activeFaq: null }">
        
        {{-- Hero Header --}}
        <div class="bg-white py-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight pb-6">FAQ (Tanya Jawab)</h1>
            <div class="w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Punya pertanyaan? Temukan jawaban cepat untuk pertanyaan yang paling sering diajukan seputar layanan dan program bantuan kami.
            </p>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            
            <div class="space-y-6">
                @php
                    $faqs = [
                        [
                            'category' => 'Umum',
                            'questions' => [
                                [
                                    'q' => 'Apa itu sistem E-Proposal DTPH Muaro Jambi?',
                                    'a' => 'Sistem E-Proposal adalah platform digital resmi dari Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi yang memudahkan kelompok tani untuk mengajukan usulan bantuan dan peminjaman alat mesin pertanian (Alsintan) secara online, transparan, dan terukur.'
                                ],
                                [
                                    'q' => 'Siapa saja yang bisa mendaftar di sistem ini?',
                                    'a' => 'Sistem ini diperuntukkan bagi Kelompok Tani (Poktan), Gabungan Kelompok Tani (Gapoktan), dan pelaku usaha tani yang berdomisili di Kabupaten Muaro Jambi dan telah terdaftar di database dinas.'
                                ]
                            ]
                        ],
                        [
                            'category' => 'Pendaftaran Akun',
                            'questions' => [
                                [
                                    'q' => 'Bagaimana cara mendaftarkan akun kelompok tani?',
                                    'a' => 'Klik tombol "Daftar" di pojok kanan atas, isi data diri dan data kelompok tani Anda dengan lengkap, lalu unggah dokumen pendukung yang diminta. Setelah mendaftar, Admin akan melakukan verifikasi manual sebelum akun Anda aktif.'
                                ],
                                [
                                    'q' => 'Berapa lama proses verifikasi akun oleh Admin?',
                                    'a' => 'Proses verifikasi biasanya memakan waktu 1-3 hari kerja, tergantung pada kelengkapan dokumen yang Anda unggah. Anda akan menerima email notifikasi setelah akun disetujui.'
                                ]
                            ]
                        ],
                        [
                            'category' => 'Program Bantuan & Alsintan',
                            'questions' => [
                                [
                                    'q' => 'Bagaimana cara meminjam alat pertanian (Alsintan)?',
                                    'a' => 'Setelah akun Anda diverifikasi, masuk ke Dashboard, pilih menu "Program Bantuan", pilih alat yang tersedia di Katalog, lalu klik "Ajukan Proposal". Isi formulir rencana penggunaan alat dan unggah dokumen persyaratan.'
                                ],
                                [
                                    'q' => 'Apakah peminjaman alat pertanian dikenakan biaya?',
                                    'a' => 'Peminjaman alat pertanian melalui dinas mengikuti peraturan daerah yang berlaku. Beberapa alat mungkin dikenakan biaya retribusi pemeliharaan ringan sesuai dengan ketentuan regulasi terbaru.'
                                ],
                                [
                                    'q' => 'Bagaimana cara mengetahui status proposal saya?',
                                    'a' => 'Anda dapat memantau status setiap usulan Anda melalui menu "Riwayat Usulan" di Dashboard. Status akan berubah secara real-time dari "Menunggu", "Ditinjau", hingga "Disetujui" atau "Ditolak".'
                                ]
                            ]
                        ],
                        [
                            'category' => 'Bantuan Teknis',
                            'questions' => [
                                [
                                    'q' => 'Apa yang harus dilakukan jika saya lupa kata sandi?',
                                    'a' => 'Gunakan fitur "Lupa Kata Sandi" di halaman Login. Masukkan alamat email terdaftar Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.'
                                ],
                                [
                                    'q' => 'Bagaimana jika saya mengalami kendala teknis saat mengunggah dokumen?',
                                    'a' => 'Pastikan file yang Anda unggah berformat PDF atau Gambar (JPG/PNG) dengan ukuran maksimal 2MB. Jika masih bermasalah, Anda dapat menghubungi tim teknis kami melalui menu "Kontak" atau "Pesan & Bantuan" di Dashboard.'
                                ]
                            ]
                        ]
                    ];
                @endphp

                @foreach($faqs as $catIndex => $category)
                    <div class="space-y-4 pt-4 first:pt-0">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] ml-1 mb-4">{{ $category['category'] }}</h2>
                        
                        <div class="space-y-3">
                            @foreach($category['questions'] as $qIndex => $faq)
                                @php $id = "faq-{$catIndex}-{$qIndex}"; @endphp
                                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                                     :class="activeFaq === '{{ $id }}' ? 'border-primary-200 ring-4 ring-primary-500/5' : 'hover:border-gray-200'">
                                    
                                    <button @click="activeFaq = activeFaq === '{{ $id }}' ? null : '{{ $id }}'"
                                            class="w-full px-6 py-5 flex items-center justify-between text-left gap-4">
                                        <span class="font-bold text-gray-800 text-sm md:text-base leading-snug"
                                              :class="activeFaq === '{{ $id }}' ? 'text-primary-700' : ''">
                                            {{ $faq['q'] }}
                                        </span>
                                        <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center transition-all duration-300"
                                             :class="activeFaq === '{{ $id }}' ? 'bg-primary-600 text-white rotate-180' : 'text-gray-400'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </button>

                                    <div x-show="activeFaq === '{{ $id }}'" 
                                         x-collapse
                                         x-cloak>
                                        <div class="px-6 pb-6 text-gray-500 text-sm md:text-base leading-relaxed border-t border-gray-50 pt-5">
                                            {{ $faq['a'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Support CTA --}}
            <div class="mt-20 bg-emerald-950 rounded-[3rem] p-8 md:p-12 text-center relative overflow-hidden group">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/20 rounded-full blur-3xl group-hover:scale-150 transition-all duration-700"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary-500/10 rounded-full blur-3xl group-hover:scale-150 transition-all duration-700"></div>
                
                <div class="relative z-10">
                    <h3 class="text-2xl font-extrabold text-white mb-4">Masih Butuh Bantuan?</h3>
                    <p class="text-emerald-100/70 mb-8 max-w-lg mx-auto font-medium">Jika Anda tidak menemukan jawaban yang Anda cari, jangan ragu untuk menghubungi tim dukungan kami secara langsung.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('kontak') }}" class="w-full sm:w-auto bg-white text-emerald-900 px-8 py-3.5 rounded-2xl font-bold hover:bg-emerald-50 transition-all shadow-xl shadow-black/20 active:scale-95">
                            Hubungi Kami
                        </a>
                        <a href="{{ route('farmer.messages') }}" class="w-full sm:w-auto bg-white/10 text-white border border-white/20 px-8 py-3.5 rounded-2xl font-bold hover:bg-white/20 transition-all active:scale-95">
                            Kirim Tiket Bantuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
