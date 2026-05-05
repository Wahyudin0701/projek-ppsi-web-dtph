<x-layouts.public>
    <x-slot:title>Detail Berita - DTPH Muaro Jambi</x-slot:title>

    @php
    // Dummy data untuk semua artikel — nanti bisa diganti dari database
    $allArticles = [
        'penyerahan-bantuan-alsintan-45-kelompok-tani' => [
            'kategori'  => 'berita',
            'label'     => 'Berita',
            'labelColor'=> 'bg-blue-100 text-blue-700',
            'accent'    => 'from-blue-800 to-blue-950',
            'foto'      => 'https://picsum.photos/seed/farming1/1400/600',
            'judul'     => 'Penyerahan Bantuan Alsintan kepada 45 Kelompok Tani se-Muaro Jambi',
            'ringkasan' => 'Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi secara resmi menyerahkan bantuan alat dan mesin pertanian kepada 45 kelompok tani di 11 kecamatan.',
            'tanggal'   => '28 April 2025',
            'penulis'   => 'Tim Humas DTPH',
            'waktu'     => '5 menit baca',
            'isi'       => [
                'intro' => 'Sengeti, 28 April 2025 — Dinas Tanaman Pangan dan Hortikultura (DTPH) Kabupaten Muaro Jambi secara resmi menyerahkan bantuan Alat dan Mesin Pertanian (Alsintan) kepada 45 kelompok tani yang tersebar di 11 kecamatan wilayah Kabupaten Muaro Jambi.',
                'paragraphs' => [
                    'Acara serah terima berlangsung di Aula DTPH Kabupaten Muaro Jambi dan dihadiri oleh Kepala Dinas, perwakilan kelompok tani penerima manfaat, serta koordinator Balai Penyuluhan Pertanian (BPP) dari masing-masing kecamatan.',
                    'Bantuan yang diserahkan meliputi traktor roda empat, pompa air sentrifugal, mesin penanam padi (rice transplanter), serta power thresher serbaguna. Total nilai bantuan yang disalurkan pada tahap ini mencapai lebih dari Rp 3,2 miliar yang bersumber dari Dana Alokasi Khusus (DAK) Bidang Pertanian Tahun Anggaran 2025.',
                    'Kepala DTPH Kabupaten Muaro Jambi, Ir. H. Ahmad Fauzi, M.Si., dalam sambutannya menegaskan bahwa penyaluran bantuan ini merupakan wujud nyata komitmen pemerintah dalam meningkatkan produktivitas dan kesejahteraan petani. "Kami berharap alsintan ini dapat dimanfaatkan seoptimal mungkin untuk mendukung kegiatan budidaya pertanian. Perawatan dan pemeliharaan yang baik adalah tanggung jawab bersama," ujarnya.',
                    'Ketua Kelompok Tani Harapan Jaya, Kecamatan Sekernan, Suprianto, menyambut gembira bantuan tersebut. Menurutnya, ketersediaan alsintan yang memadai akan sangat membantu menekan biaya produksi dan mempercepat proses tanam dan panen di lahan mereka.',
                    'Proses pengajuan bantuan alsintan ini dilakukan melalui portal digital E-Proposal DTPH Muaro Jambi, yang memungkinkan kelompok tani mengajukan permohonan secara transparan dan terverifikasi tanpa harus datang langsung ke kantor dinas.',
                ],
                'penutup' => 'DTPH Kabupaten Muaro Jambi berkomitmen untuk terus menghadirkan program bantuan yang tepat sasaran demi mewujudkan ketahanan pangan di tingkat kabupaten dan mendukung swasembada pangan nasional.',
            ],
            'tags' => ['Alsintan', 'Bantuan Pertanian', 'Kelompok Tani', 'Program 2025'],
        ],
        'pendaftaran-e-proposal-alsintan-tahap-2' => [
            'kategori'  => 'program',
            'label'     => 'Program',
            'labelColor'=> 'bg-emerald-100 text-emerald-700',
            'accent'    => 'from-emerald-700 to-emerald-950',
            'foto'      => 'https://picsum.photos/seed/agriculture2/1400/600',
            'judul'     => 'Pendaftaran E-Proposal Alsintan Tahap II Resmi Dibuka',
            'ringkasan' => 'Petani dan kelompok tani di wilayah Kabupaten Muaro Jambi kini dapat mengajukan proposal bantuan alsintan secara digital melalui portal E-Proposal DTPH.',
            'tanggal'   => '22 April 2025',
            'penulis'   => 'Admin DTPH',
            'waktu'     => '3 menit baca',
            'isi'       => [
                'intro' => 'Sengeti, 22 April 2025 — Dinas Tanaman Pangan dan Hortikultura (DTPH) Kabupaten Muaro Jambi resmi membuka pendaftaran E-Proposal Alsintan Tahap II Tahun Anggaran 2025.',
                'paragraphs' => [
                    'Pendaftaran dilakukan secara online melalui portal resmi E-Proposal DTPH. Petani dan pengurus kelompok tani cukup mendaftar akun, melengkapi profil, dan mengisi formulir pengajuan yang telah disediakan.',
                    'Program ini terbuka bagi seluruh kelompok tani aktif yang terdaftar di wilayah Kabupaten Muaro Jambi dan belum pernah menerima bantuan alsintan serupa dalam dua tahun terakhir.',
                    'Pendaftaran dibuka mulai 22 April hingga 31 Mei 2025. Verifikasi lapangan akan dilakukan oleh petugas BPP setempat pada bulan Juni 2025, dan pengumuman penerima manfaat dijadwalkan pada awal Juli 2025.',
                ],
                'penutup' => 'Untuk informasi lebih lanjut, hubungi kantor DTPH atau Koordinator BPP di kecamatan Anda.',
            ],
            'tags' => ['E-Proposal', 'Pendaftaran', 'Alsintan', 'Program'],
        ],
        'cara-merawat-traktor-tangan' => [
            'kategori'  => 'artikel',
            'label'     => 'Artikel',
            'labelColor'=> 'bg-amber-100 text-amber-700',
            'accent'    => 'from-amber-700 to-amber-950',
            'foto'      => 'https://picsum.photos/seed/tractor3/1400/600',
            'judul'     => 'Cara Merawat Traktor Tangan agar Awet dan Produktif',
            'ringkasan' => 'Perawatan rutin alsintan merupakan kunci utama untuk memastikan mesin pertanian tetap bekerja optimal sepanjang musim tanam.',
            'tanggal'   => '15 April 2025',
            'penulis'   => 'Penyuluh Pertanian',
            'waktu'     => '7 menit baca',
            'isi'       => [
                'intro' => 'Traktor tangan (hand tractor) adalah salah satu alsintan paling vital bagi petani. Agar mesin ini tetap awet dan produktif, perawatan rutin mutlak diperlukan.',
                'paragraphs' => [
                    'Pertama, ganti oli mesin secara berkala sesuai rekomendasi pabrik, umumnya setiap 50–100 jam operasi. Oli yang kotor dapat menyebabkan keausan komponen mesin yang lebih cepat.',
                    'Kedua, bersihkan filter udara setiap selesai digunakan. Filter yang tersumbat debu dapat mengurangi pasokan udara ke karburator dan menyebabkan pembakaran tidak sempurna, sehingga mesin kehilangan tenaga.',
                    'Ketiga, periksa dan kencangkan baut-baut yang longgar sebelum setiap pemakaian. Getaran mesin yang terus-menerus dapat membuat baut dan mur menjadi kendur seiring waktu.',
                    'Keempat, simpan traktor di tempat yang terlindungi dari hujan dan sinar matahari langsung saat tidak digunakan. Paparan cuaca dapat mempercepat korosi pada komponen besi dan merusak karet-karet pelindung.',
                    'Kelima, lakukan servis berkala di bengkel resmi atau dengan teknisi yang berpengalaman untuk memastikan semua komponen dalam kondisi optimal.',
                ],
                'penutup' => 'Dengan perawatan yang tepat, traktor tangan dapat bertahan lebih dari 10 tahun dan terus mendukung produktivitas lahan pertanian Anda.',
            ],
            'tags' => ['Alsintan', 'Perawatan', 'Traktor', 'Tips Pertanian'],
        ],
        'bimtek-drone-pertanian-penyuluh-bpp' => [
            'kategori'  => 'kegiatan',
            'label'     => 'Kegiatan',
            'labelColor'=> 'bg-violet-100 text-violet-700',
            'accent'    => 'from-violet-800 to-violet-950',
            'foto'      => null,
            'judul'     => 'Bimtek Penggunaan Drone Pertanian untuk Penyuluh BPP',
            'ringkasan' => 'Sebanyak 24 penyuluh pertanian lapangan mengikuti bimbingan teknis penggunaan drone untuk pemantauan lahan.',
            'tanggal'   => '10 April 2025',
            'penulis'   => 'Bidang Penyuluhan',
            'waktu'     => '4 menit baca',
            'isi'       => [
                'intro' => 'Sengeti, 10 April 2025 — Sebanyak 24 penyuluh pertanian lapangan (PPL) dari seluruh BPP se-Kabupaten Muaro Jambi mengikuti Bimbingan Teknis (Bimtek) penggunaan drone pertanian yang diselenggarakan oleh Bidang Penyuluhan DTPH.',
                'paragraphs' => [
                    'Kegiatan Bimtek ini merupakan bagian dari program peningkatan kapasitas SDM penyuluh pertanian dalam memanfaatkan teknologi digital untuk mendukung pertanian presisi.',
                    'Selama dua hari kegiatan, para penyuluh mendapatkan materi tentang dasar-dasar operasional drone, teknik pemetaan lahan (mapping), analisis citra drone untuk identifikasi hama dan penyakit tanaman, serta penerapan variable rate application (VRA) untuk pemupukan presisi.',
                    'Narasumber yang hadir berasal dari Balai Besar Pengembangan Mekanisasi Pertanian (BBP Mektan) Serpong dan praktisi drone pertanian berpengalaman dari Provinsi Jambi.',
                ],
                'penutup' => 'Diharapkan, kompetensi baru yang diperoleh para penyuluh dapat langsung diaplikasikan di lapangan untuk meningkatkan kualitas pendampingan kepada petani.',
            ],
            'tags' => ['Drone', 'Teknologi Pertanian', 'Penyuluhan', 'Bimtek'],
        ],
        'varietas-padi-unggul-lahan-gambut' => [
            'kategori'  => 'artikel',
            'label'     => 'Artikel',
            'labelColor'=> 'bg-amber-100 text-amber-700',
            'accent'    => 'from-amber-700 to-amber-950',
            'foto'      => null,
            'judul'     => 'Mengenal Varietas Padi Unggul yang Cocok untuk Lahan Gambut',
            'ringkasan' => 'Berikut varietas-varietas padi yang terbukti adaptif dan berdaya hasil tinggi di lahan gambut tropis.',
            'tanggal'   => '05 April 2025',
            'penulis'   => 'Kabid Tanaman Pangan',
            'waktu'     => '6 menit baca',
            'isi'       => [
                'intro' => 'Lahan gambut memiliki karakteristik unik yang membutuhkan varietas padi khusus agar dapat memberikan hasil panen yang optimal.',
                'paragraphs' => [
                    'Inpara 3, Inpara 4, dan Inpara 8 adalah tiga varietas padi yang telah terbukti adaptif pada lahan gambut dengan tingkat keasaman tinggi (pH rendah). Varietas ini dikembangkan khusus oleh Balai Besar Penelitian Tanaman Padi (BB Padi) Subang.',
                    'Inpara 3 memiliki umur panen sekitar 115–125 hari setelah semai, dengan potensi hasil mencapai 5,2–6,4 ton/ha. Varietas ini toleran terhadap keracunan besi yang sering menjadi masalah utama di lahan gambut.',
                    'Inpara 8 merupakan varietas terbaru yang memiliki potensi hasil lebih tinggi, sekitar 6–7 ton/ha, dengan ketahanan yang baik terhadap blast dan hawar daun bakteri.',
                    'Selain pemilihan varietas, manajemen air dan pemupukan yang tepat juga sangat menentukan keberhasilan budidaya padi di lahan gambut. Pengapuran untuk menaikkan pH tanah dan penggunaan pupuk organik sangat direkomendasikan.',
                ],
                'penutup' => 'Konsultasikan pilihan varietas dengan penyuluh pertanian di BPP terdekat untuk mendapatkan rekomendasi yang sesuai dengan kondisi spesifik lahan Anda.',
            ],
            'tags' => ['Padi', 'Lahan Gambut', 'Varietas Unggul', 'Budidaya'],
        ],
        'dtph-raih-penghargaan-inovasi-pelayanan-publik' => [
            'kategori'  => 'berita',
            'label'     => 'Berita',
            'labelColor'=> 'bg-blue-100 text-blue-700',
            'accent'    => 'from-blue-800 to-blue-950',
            'foto'      => null,
            'judul'     => 'DTPH Raih Penghargaan Inovasi Pelayanan Publik Tingkat Provinsi',
            'ringkasan' => 'Melalui program E-Proposal Alsintan, DTPH Muaro Jambi berhasil meraih penghargaan inovasi pelayanan publik terbaik di tingkat Provinsi Jambi.',
            'tanggal'   => '01 April 2025',
            'penulis'   => 'Tim Humas DTPH',
            'waktu'     => '4 menit baca',
            'isi'       => [
                'intro' => 'Jambi, 01 April 2025 — DTPH Kabupaten Muaro Jambi berhasil meraih penghargaan Top Inovasi Pelayanan Publik tingkat Provinsi Jambi Tahun 2025.',
                'paragraphs' => [
                    'Penghargaan ini diterima oleh Kepala DTPH Muaro Jambi atas inovasi program E-Proposal Alsintan yang dinilai berhasil mentransformasi proses pengajuan bantuan pertanian dari sistem manual konvensional menjadi sistem digital yang transparan, efisien, dan akuntabel.',
                    'Sistem E-Proposal telah memangkas waktu proses pengajuan dari rata-rata 3–4 minggu menjadi kurang dari 1 minggu, sekaligus meningkatkan akurasi data penerima manfaat dan meminimalkan potensi tumpang tindih penerima bantuan.',
                    'Penghargaan diserahkan oleh Gubernur Provinsi Jambi dalam rangkaian Peringatan Hari Otonomi Daerah ke-29 yang diselenggarakan di Kantor Gubernur Jambi.',
                ],
                'penutup' => 'Penghargaan ini menjadi motivasi bagi seluruh jajaran DTPH Muaro Jambi untuk terus berinovasi dalam memberikan pelayanan terbaik kepada masyarakat petani.',
            ],
            'tags' => ['Penghargaan', 'Inovasi', 'Pelayanan Publik', 'E-Proposal'],
        ],
    ];

    $article = $allArticles[$slug] ?? null;
    @endphp

    @if(!$article)
        {{-- 404 State - Formal & Minimalist --}}
        <div class="min-h-[80vh] flex items-center justify-center px-4 relative overflow-hidden">
            {{-- Decorative Background Elements --}}
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-emerald-50 rounded-full blur-3xl opacity-40"></div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-40"></div>
            
            <div class="relative max-w-2xl w-full text-center">
                {{-- Big 404 Background Text --}}
                <div class="absolute inset-0 flex items-center justify-center -z-10 opacity-[0.04] select-none">
                    <span class="text-[12rem] md:text-[20rem] font-black tracking-tighter">404</span>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-emerald-50 flex items-center justify-center mb-8 border border-emerald-100 shadow-sm">
                        <svg class="w-10 h-10 text-emerald-600/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Informasi Tidak Ditemukan</h2>
                    <p class="text-gray-500 leading-relaxed mb-12 max-w-lg mx-auto text-sm md:text-base">
                        Mohon maaf, artikel atau informasi yang Anda akses tidak tersedia atau telah dihapus dari sistem informasi publik DTPH Kabupaten Muaro Jambi.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
                        <a href="{{ route('informasi.berita-artikel') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl transition-all shadow-lg shadow-emerald-600/20 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            Kembali ke Daftar Berita
                        </a>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white border border-gray-200 text-gray-600 font-bold text-sm rounded-2xl hover:bg-gray-50 transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
    <div class="bg-[#f8faf9] min-h-screen">

        {{-- Article Hero --}}
        <div class="relative overflow-hidden mb-6 min-h-[380px] md:min-h-[460px] flex flex-col justify-end mx-auto">

            {{-- Background Photo (jika ada) atau fallback gradient --}}
            @if(!empty($article['foto']))
                <img src="{{ $article['foto'] }}"
                     alt="{{ $article['judul'] }}"
                     class="absolute inset-0 w-full h-full object-cover object-center">
            @endif

            {{-- Gradient Overlay (selalu tampil di atas foto atau sebagai background) --}}
            <div class="absolute inset-0 bg-gradient-to-br {{ $article['accent'] }} {{ !empty($article['foto']) ? 'opacity-75' : 'opacity-100' }}"></div>

            {{-- Extra bottom shadow for readability --}}
            <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="relative mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-32">
                <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-white/60 mb-8">
                    <a href="{{ route('home') }}" class="text-white/70 hover:text-white underline decoration-transparent hover:decoration-white/50 underline-offset-4 transition-all duration-300">Beranda</a>
                    <svg class="w-3 h-3 text-white/30" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                    <a href="{{ route('informasi.berita-artikel') }}" class="text-white/70 hover:text-white underline decoration-transparent hover:decoration-white/50 underline-offset-4 transition-all duration-300">Berita &amp; Artikel</a>
                    <svg class="w-3 h-3 text-white/30" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                    <span class="text-white">{{ $article['label'] }}</span>
                </nav>
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm border border-white/20 text-white text-xs font-bold rounded-full uppercase tracking-wider">{{ $article['label'] }}</span>
                    <span class="text-white text-xs">{{ $article['tanggal'] }}</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-white leading-tight mb-6 max-w-4xl">{{ $article['judul'] }}</h1>
                <div class="flex items-center gap-4 pb-12">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($article['penulis'], 0, 2)) }}
                    </div>
                    <div class="text-left">
                        <p class="text-white font-bold text-sm">{{ $article['penulis'] }}</p>
                        <p class="text-xs text-white">{{ $article['waktu'] }} · {{ $article['tanggal'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-40 pb-24 relative z-10">

            {{-- Article Card --}}
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_80px_-20px_rgba(0,0,0,0.1)] border border-gray-100 overflow-hidden">

                {{-- Article Body --}}
                <div class="px-8 md:px-16 pt-12">
                    {{-- Lead / Intro --}}
                    <p class="text-lg md:text-xl text-gray-700 leading-relaxed font-medium border-l-4 border-emerald-500 pl-6 mb-10 italic">
                        {{ $article['isi']['intro'] }}
                    </p>

                    {{-- Paragraphs --}}
                    <div class="space-y-6 text-gray-600 leading-relaxed text-base md:text-[17px]">
                        @foreach($article['isi']['paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>

                    {{-- Closing --}}
                    <div class="mt-10 p-6 bg-emerald-50 border border-emerald-100 rounded-2xl">
                        <p class="text-emerald-800 font-medium text-sm leading-relaxed">
                            <span class="font-extrabold">Catatan Redaksi: </span>{{ $article['isi']['penutup'] }}
                        </p>
                    </div>
                </div>

                {{-- Tags & Share --}}
                <div class="px-8 md:px-16 py-8 border-t border-gray-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach($article['tags'] as $tag)
                        <span class="px-3 py-1 bg-gray-100 hover:bg-emerald-50 hover:text-emerald-700 text-gray-600 text-xs font-bold rounded-xl cursor-pointer transition-colors">#{{ $tag }}</span>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Bagikan:</span>
                        <a href="#" class="w-8 h-8 rounded-xl bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white flex items-center justify-center transition-all duration-300" title="Facebook">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-xl bg-green-50 hover:bg-green-600 text-green-600 hover:text-white flex items-center justify-center transition-all duration-300" title="WhatsApp">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="flex justify-start pt-12">
                <a href="{{ route('informasi.berita-artikel') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold text-sm rounded-2xl hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-700 transition-all duration-300 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Daftar Artikel
                </a>
            </div>

        </div>
    </div>
    @endif

</x-layouts.public>
