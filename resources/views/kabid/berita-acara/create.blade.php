<x-app-layout>
    <x-slot name="header">Buat Berita Acara</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('kabid.proposals.index') }}" class="hover:text-primary-600 transition-colors">Kelola Proposal</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('kabid.proposals.show', $proposal) }}" class="hover:text-primary-600 transition-colors">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-semibold text-gray-700">Berita Acara</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900">Buat Berita Acara Survei</h2>
                <p class="text-gray-500 text-sm mt-1">Lengkapi laporan berita acara hasil verifikasi lapangan untuk diteruskan ke Pimpinan.</p>
            </div>
            <a href="{{ route('kabid.proposals.show', $proposal) }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        {{-- Proposal Summary Card --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md bg-amber-50 text-amber-600">
                {{ $proposal->alsintan_id ? 'Peminjaman Alsintan' : 'Program Bantuan' }}
            </span>
            <h3 class="text-xl font-extrabold text-gray-800 mt-2">
                {{ $proposal->program?->name ?? $proposal->alsintan?->name ?? 'Proposal' }}
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Kelompok Tani: <span class="font-bold text-gray-800">{{ $proposal->user->farmerProfile?->nama_kelompok ?? $proposal->user->name }}</span>
            </p>
        </div>

        {{-- Hasil Verifikasi CPCL --}}
        @if($proposal->cpclVerifications->isNotEmpty())
        @php $cpcl = $proposal->cpclVerifications->last(); @endphp
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-extrabold text-gray-700 mb-4 text-sm uppercase tracking-wide">Hasil Verifikasi Lapangan (CPCL)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status Kepemilikan</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $cpcl->status_kepemilikan }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Luas Lahan</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $cpcl->luas_lahan }} Ha</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kondisi Lahan</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $cpcl->kondisi_lahan }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kesesuaian Komoditas</p>
                    <p class="text-sm font-bold {{ $cpcl->kesesuaian_komoditas ? 'text-green-600' : 'text-red-600' }}">
                        {{ $cpcl->kesesuaian_komoditas ? '✔ Sesuai (Layak)' : '✘ Tidak Sesuai' }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Rekomendasi Surveyor</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $cpcl->rekomendasi_surveyor }}</p>
                </div>
                @if($cpcl->catatan)
                <div class="sm:col-span-2">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Catatan Tambahan</p>
                    <p class="text-sm text-gray-600 italic bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $cpcl->catatan }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Dokumentasi Survei --}}
        @if($proposal->surveyDocumentations->isNotEmpty())
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-extrabold text-gray-700 mb-4 text-sm uppercase tracking-wide">Dokumentasi Survei Lapangan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($proposal->surveyDocumentations as $index => $doc)
                <div>
                    <p class="text-xs font-bold text-gray-500 mb-2">{{ $index + 1 }}. {{ $doc->keterangan ?? 'Foto Dokumentasi' }}</p>
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200 hover:opacity-90 transition-opacity">
                        <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->keterangan }}" class="w-full h-48 object-cover">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Berita Acara Form --}}
        <form action="{{ route('kabid.berita-acara.store', $proposal) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-5">
            @csrf

            <h3 class="font-extrabold text-gray-800 text-lg">Form Berita Acara</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Tanggal Survei *</label>
                    <input type="date" name="survey_date" value="{{ old('survey_date') }}" required
                           max="{{ date('Y-m-d') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('survey_date') border-red-400 @enderror">
                    @error('survey_date')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Lokasi Survei *</label>
                    <input type="text" name="location" value="{{ old('location', $proposal->lokasi_lahan) }}" required
                           placeholder="Alamat/lokasi survei dilakukan"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('location') border-red-400 @enderror">
                    @error('location')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Isi Berita Acara *</label>
                <textarea name="content" rows="8" required
                          placeholder="Tuliskan isi berita acara secara lengkap: kondisi lahan, temuan di lapangan, kesimpulan survei, dan informasi relevan lainnya..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none @error('content') border-red-400 @enderror">{{ old('content') }}</textarea>
                @error('content')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Catatan Tambahan untuk Pimpinan (opsional)</label>
                <textarea name="kabid_notes" rows="3" placeholder="Catatan atau konteks tambahan yang perlu diketahui pimpinan..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none">{{ old('kabid_notes') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Rekomendasi *</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach([
                        ['direkomendasikan', 'Direkomendasikan', 'bg-green-50 border-green-300 text-green-800', 'border-green-500'],
                        ['tidak_direkomendasikan', 'Tidak Direkomendasikan', 'bg-red-50 border-red-300 text-red-800', 'border-red-500'],
                        ['perlu_tindak_lanjut', 'Perlu Tindak Lanjut', 'bg-yellow-50 border-yellow-300 text-yellow-800', 'border-yellow-500'],
                    ] as [$val, $label, $baseClass, $activeClass])
                    <label class="relative cursor-pointer">
                        <input type="radio" name="recommendation" value="{{ $val }}" {{ old('recommendation') === $val ? 'checked' : '' }} required class="absolute inset-0 opacity-0 w-0 h-0 pointer-events-none peer">
                        <div class="p-4 rounded-2xl border-2 border-gray-200 text-center text-sm font-bold transition-all peer-checked:{{ $activeClass }} peer-checked:{{ $baseClass }} hover:border-gray-300">
                            {{ $label }}
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('recommendation')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Lampiran (PDF/Foto, opsional)</label>
                <input type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                @error('attachment')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('kabid.proposals.show', $proposal) }}" class="flex-1 text-center py-3 rounded-2xl border border-gray-200 font-bold text-sm text-gray-600 hover:bg-gray-50 transition-all">Batal</a>
                <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-extrabold py-3 rounded-2xl transition-all shadow-lg shadow-amber-500/30">
                    Kirim Berita Acara ke Pimpinan →
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
