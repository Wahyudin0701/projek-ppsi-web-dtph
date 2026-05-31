@props(['user'])

<div class="bg-white sm:rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-6 sm:p-8 space-y-8">
    
    @if($user->farmerProfile)
    {{-- Informasi Ketua --}}
    <div>
        <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6 border-b border-gray-100 pb-3">Informasi Ketua Kelompok</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nama Ketua</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-words text-sm">{{ $user->farmerProfile->ketua }}</p>
                </div>
            </div>
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">NIK Ketua</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 font-mono tracking-wider break-all text-sm">{{ $user->farmerProfile->nik_ketua ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Foto KTP Ketua</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    @if($user->farmerProfile->foto_ktp)
                        <a href="{{ Storage::url($user->farmerProfile->foto_ktp) }}" target="_blank" class="text-sm font-bold text-blue-600 hover:underline flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Lihat Foto KTP
                        </a>
                    @else
                        <p class="font-bold text-gray-400 italic text-sm">-</p>
                    @endif
                </div>
            </div>
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nomor WA / Kontak</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-all text-sm">{{ $user->farmerProfile->kontak ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Email Terdaftar</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-all text-sm">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Kelompok --}}
    <div>
        <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6 border-b border-gray-100 pb-3">Informasi Kelompok Tani</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nama Kelompok Tani</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-words text-sm">{{ $user->farmerProfile->nama_kelompok }}</p>
                </div>
            </div>
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">No. SK Kelompok</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-words text-sm">{{ $user->farmerProfile->no_sk ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-1 min-w-0 md:col-span-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">File SK Kelompok</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    @if($user->farmerProfile->sk_pengukuhan_path)
                        <a href="{{ Storage::url($user->farmerProfile->sk_pengukuhan_path) }}" target="_blank" class="text-sm font-bold text-blue-600 hover:underline flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                            Lihat File SK
                        </a>
                    @else
                        <p class="font-bold text-gray-400 italic text-sm">-</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Daftar Anggota Kelompok</label>
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-50">
                @if($user->farmerProfile->members && $user->farmerProfile->members->count() > 0)
                    <ol class="list-decimal list-inside space-y-1">
                        @foreach($user->farmerProfile->members as $member)
                            <li class="text-sm font-bold text-gray-700">
                                {{ $member->nama }}
                                @if($member->nik)
                                    <span class="text-xs font-medium text-gray-500 ml-1">(NIK: {{ $member->nik }})</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @else
                    <p class="text-sm font-medium text-gray-400 italic">Belum ada anggota yang diinputkan.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Alamat --}}
    <div>
        <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6 border-b border-gray-100 pb-3">Lokasi & Alamat Sekretariat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Kecamatan</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-words text-sm">{{ $user->farmerProfile->kecamatan ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Desa</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="text-sm font-bold text-gray-700 leading-relaxed">{{ $user->farmerProfile->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Komoditi Section --}}
    <div>
        <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6 border-b border-gray-100 pb-3">Data Komoditi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            {{-- Komoditi Utama --}}
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Komoditi Utama</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-words text-sm capitalize">{{ $user->farmerProfile->komoditi_utama ?? '-' }}</p>
                </div>
            </div>

            {{-- Komoditi Lainnya --}}
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Komoditi Lainnya</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden h-full">
                    @php
                        $allKomoditi = $user->farmerProfile->komoditi
                            ? array_map('trim', explode(',', $user->farmerProfile->komoditi))
                            : [];
                        
                        $utama = trim($user->farmerProfile->komoditi_utama);
                        
                        // Filter agar komoditi utama tidak muncul lagi di list "Lainnya"
                        $lainnya = array_filter($allKomoditi, function($k) use ($utama) {
                            return strtolower($k) !== strtolower($utama);
                        });
                    @endphp

                    @if(count($lainnya) > 0)
                        <p class="font-bold text-gray-900 break-words text-sm">{{ implode(', ', $lainnya) }}</p>
                    @else
                        <p class="text-sm font-medium text-gray-400 italic">Tidak ada komoditi tambahan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Data Lahan Section --}}
    <div>
        <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6 border-b border-gray-100 pb-3">Kapasitas & Lahan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Luas Lahan</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-words text-sm">{{ $user->farmerProfile->luas_lahan ?? '0' }} Ha</p>
                </div>
            </div>

            <div class="space-y-1 min-w-0">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Grade Kelompok</label>
                <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                    <p class="font-bold text-gray-900 break-words text-sm uppercase">{{ $user->farmerProfile->grade ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    @else
        <div>
            <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6 border-b border-gray-100 pb-3">Informasi Akun Pengaju</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="space-y-1 min-w-0">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nama Pengaju</label>
                    <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                        <p class="font-bold text-gray-900 break-words text-sm">{{ $user->name }}</p>
                    </div>
                </div>
                <div class="space-y-1 min-w-0">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Email Terdaftar</label>
                    <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                        <p class="font-bold text-gray-900 break-all text-sm">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="space-y-1 min-w-0">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Tipe Akun</label>
                    <div class="bg-gray-50 rounded-2xl p-3 border border-gray-50 overflow-hidden">
                        <p class="font-bold text-gray-900 break-all text-sm capitalize">{{ $user->roleLabel }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
