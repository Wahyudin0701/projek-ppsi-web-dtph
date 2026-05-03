<x-layouts.public>
    <x-slot:title>Satuan Kerja - DTPH Muaro Jambi</x-slot:title>

    <div class="bg-[#fcfdfc] min-h-screen">
        {{-- Hero Header (Consistent Style) --}}
        <div class="bg-white py-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight pb-6">Satuan Kerja</h1>
            <div class="w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Unit Pelaksana Teknis (UPT) dan Balai Penyuluhan Pertanian (BPP) di Wilayah Kabupaten Muaro Jambi
            </p>
        </div>

        {{-- Floating Stats & Intro Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-emerald-900/5 border border-emerald-100 p-8 md:p-12 flex flex-col lg:flex-row gap-12 items-center mb-16">
                <div class="flex-1 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Pelayanan Terpadu
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">Pendampingan Intensif di Setiap Penjuru</h2>
                    <p class="text-gray-600 text-justify leading-relaxed">
                        Kami mengintegrasikan teknologi dan pendampingan lapangan untuk memastikan setiap kelompok tani mendapatkan akses prasarana dan sarana pertanian yang tepat sasaran. Melalui 12 Balai Penyuluhan Pertanian, kami hadir lebih dekat dengan Anda.
                    </p>
                </div>
                <div class="flex gap-6 shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-px shadow-xl shadow-emerald-600/30">
                        <div class="w-full h-full bg-white rounded-[23px] flex flex-col items-center justify-center">
                            <span class="text-4xl font-black text-emerald-600">11</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center mt-1">Kecamatan</span>
                        </div>
                    </div>
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-3xl bg-gradient-to-br from-green-400 to-emerald-600 p-px shadow-xl shadow-emerald-600/30">
                        <div class="w-full h-full bg-white rounded-[23px] flex flex-col items-center justify-center">
                            <span class="text-4xl font-black text-emerald-600">12</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center mt-1">Unit BPP</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BPP Listing Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-6">
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Daftar Balai Penyuluhan Pertanian</h3>
                    <p class="text-gray-500 text-sm">Temukan lokasi dan kontak koordinator di wilayah Anda.</p>
                </div>
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari kecamatan..." class="bg-transparent border-none focus:ring-0 text-sm font-medium text-emerald-900 placeholder:text-emerald-300 w-48">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                $bppList = [
                    ['nama' => 'BPP Kec. Sekernan', 'alamat' => 'Jl. Lintas Timur, Sekernan', 'koordinator' => 'Eko Prasetyo, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Sekernan+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Sungai Gelam', 'alamat' => 'Jl. Poros Sungai Gelam', 'koordinator' => 'Dewi Lestari, S.P.', 'hp' => '0813-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Sungai+Gelam+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Kumpeh', 'alamat' => 'Jl. Raya Kumpeh', 'koordinator' => 'M. Ridwan, S.P.', 'hp' => '0821-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Kumpeh+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Kumpeh Ulu', 'alamat' => 'Jl. Kumpeh Ulu No. 12', 'koordinator' => 'Fitriani, S.P.', 'hp' => '0852-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Kumpeh+Ulu+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Mestong', 'alamat' => 'Jl. Lintas Sumatera, KM 23', 'koordinator' => 'Heri Susanto, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Mestong+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Jambi Luar Kota', 'alamat' => 'Pematang Gajah, Jaluko', 'koordinator' => 'Ani Maryani, S.P.', 'hp' => '0811-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Jambi+Luar+Kota+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Bahar Selatan', 'alamat' => 'Unit 4 Bahar Selatan', 'koordinator' => 'Supriadi, S.P.', 'hp' => '0822-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Bahar+Selatan+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Bahar Utara', 'alamat' => 'Unit 1 Bahar Utara', 'koordinator' => 'Yuni Astuti, S.P.', 'hp' => '0813-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Bahar+Utara+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Taman Rajo', 'alamat' => 'Kec. Taman Rajo', 'koordinator' => 'Darmawan, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Taman+Rajo+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Sungai Bahar', 'alamat' => 'Unit 2 Sungai Bahar', 'koordinator' => 'Ratna Wulan, S.P.', 'hp' => '0813-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Sungai+Bahar+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Maro Sebo', 'alamat' => 'Kec. Maro Sebo', 'koordinator' => 'Junaidi, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Maro+Sebo+Muaro+Jambi'],
                    ['nama' => 'BPP Kec. Dendang', 'alamat' => 'Kec. Dendang', 'koordinator' => 'Sari Indah, S.P.', 'hp' => '0812-xxxx-xxxx', 'maps' => 'https://www.google.com/maps/search/BPP+Dendang+Muaro+Jambi'],
                ];
                @endphp

                @foreach($bppList as $bpp)
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_-15px_rgba(16,185,129,0.1)] transition-all duration-500 group flex flex-col h-full">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-500 shadow-inner border border-emerald-100/50">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">Operational</span>
                        </div>
                    </div>
                    
                    <div class="mb-8 flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-emerald-700 transition-colors leading-tight">{{ $bpp['nama'] }}</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0 text-gray-400 group-hover:text-emerald-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <p class="text-sm text-gray-500 font-medium pt-1.5 leading-relaxed">{{ $bpp['alamat'] }}</p>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0 text-gray-400 group-hover:text-emerald-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Koordinator</p>
                                    <p class="text-sm text-gray-900 font-bold">{{ $bpp['koordinator'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ $bpp['maps'] }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-3.5 bg-gray-50 hover:bg-emerald-50 text-gray-600 hover:text-emerald-700 text-xs font-bold rounded-2xl transition-all duration-300 border border-transparent hover:border-emerald-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Lokasi
                        </a>
                        <a href="https://wa.me/{{ str_replace('-', '', $bpp['hp']) }}" class="flex items-center justify-center gap-2 px-4 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-600/10 hover:shadow-emerald-600/30 hover:-translate-y-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Support Info Section --}}
            <div class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-8 rounded-3xl bg-emerald-50 border border-emerald-100">
                    <h4 class="text-lg font-bold text-emerald-900 mb-3">Butuh Bantuan Lebih Lanjut?</h4>
                    <p class="text-emerald-700 text-sm leading-relaxed mb-6">Jika Anda tidak dapat menemukan lokasi atau membutuhkan informasi teknis lainnya, tim kami di Kantor Pusat DTPH siap membantu Anda.</p>
                    <a href="#" class="inline-flex items-center gap-2 text-emerald-800 font-bold text-sm hover:translate-x-1 transition-transform">
                        Hubungi Kantor Pusat
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                <div class="p-8 rounded-3xl bg-white border border-gray-100 shadow-sm">
                    <h4 class="text-lg font-bold text-gray-900 mb-3">Waktu Pelayanan</h4>
                    <ul class="space-y-3">
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-500">Senin - Kamis</span>
                            <span class="font-bold text-gray-900">07:30 - 16:00 WIB</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-500">Jumat</span>
                            <span class="font-bold text-gray-900">07:30 - 11:30 WIB</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-500">Sabtu - Minggu</span>
                            <span class="text-red-500 font-bold">Libur</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Summary Footer --}}
            <div class="mt-32 text-center">
                <div class="inline-flex items-center gap-3 bg-white border border-gray-100 px-8 py-4 rounded-[2rem] shadow-xl shadow-gray-200/50">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <p class="text-sm font-bold text-gray-600">Pusat Informasi Digital DTPH Muaro Jambi — Terintegrasi & Akuntabel</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
