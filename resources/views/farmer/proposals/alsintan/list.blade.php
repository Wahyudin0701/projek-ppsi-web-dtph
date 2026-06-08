<x-app-layout>
    <x-slot name="header">Katalog Alsintan</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Pilih Alat yang Ingin Dipinjam</h2>
                <p class="text-gray-500 text-sm mt-1">Pilih salah satu alat pertanian di bawah ini untuk mengajukan proposal peminjaman.</p>
            </div>
            <a href="{{ route('farmer.proposals.pilih') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        @if(session('error'))
            <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-sm font-medium">{{ session('error') }}</div>
        @endif

        {{-- ===== ALSINTAN YANG BISA DIAJUKAN ===== --}}
        <div class="space-y-4">
            @forelse($alsintans as $alsintan)
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden hover:shadow-xl hover:shadow-gray-200/50 hover:border-gray-200 transition-all duration-300 flex flex-col sm:flex-row group relative">
                    {{-- Clickable Overlay for whole card --}}
                    <a href="{{ route('farmer.proposals.alsintan.show', $alsintan->id) }}" class="absolute inset-0 z-0"></a>

                    {{-- Image --}}
                    <div class="w-full sm:w-64 h-56 sm:h-auto bg-gray-50 flex-shrink-0 relative overflow-hidden">
                        @if($alsintan->image)
                            <img src="{{ Storage::url($alsintan->image) }}" alt="{{ $alsintan->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 transition-transform duration-700 group-hover:scale-110">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute top-5 left-5 z-10">
                            <span class="inline-block rounded-xl bg-white/95 backdrop-blur-md px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-widest text-[#19A148] shadow-sm">
                                {{ $alsintan->category->name }}
                            </span>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 p-6 sm:p-8 flex flex-col justify-between bg-white relative z-10 pointer-events-none">
                        <div>
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div>
                                    <h3 class="font-black text-gray-900 text-xl md:text-2xl mb-2.5">{{ $alsintan->name }}</h3>
                                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-gray-500">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                            <span class="font-medium text-gray-700">{{ $alsintan->merk ?? 'Tanpa Merk' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                            <span class="font-medium text-gray-700">{{ $alsintan->capacity ?? 'Kapasitas Standar' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($alsintan->description)
                                <p class="text-sm text-gray-500 leading-relaxed mb-6 line-clamp-2">{{ $alsintan->description }}</p>
                            @endif
                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto pointer-events-auto">
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto">
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-[#19A148]/10 rounded-xl border border-[#19A148]/20 text-xs">
                                    <span class="font-medium text-[#19A148]">Tersedia:</span>
                                    <span class="font-bold text-[#19A148]">{{ $alsintan->available_stock ?? '0' }}</span>
                                </div>
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-amber-50 rounded-xl border border-amber-100/50 text-xs">
                                    <span class="font-medium text-amber-700">Dipinjam:</span>
                                    <span class="font-bold text-amber-900">{{ $alsintan->borrowed_count ?? '0' }}</span>
                                </div>
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-red-50 rounded-xl border border-red-100/50 text-xs">
                                    <span class="font-medium text-red-700">Rusak:</span>
                                    <span class="font-bold text-red-900">{{ $alsintan->broken_count ?? '0' }}</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('farmer.proposals.alsintan.create', $alsintan->id) }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-[#19A148] text-white font-bold text-sm rounded-xl hover:bg-green-700 hover:shadow-xl hover:shadow-green-900/20 hover:-translate-y-0.5 transition-all duration-300">
                                Ajukan Proposal
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-16 text-center">
                    <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p class="text-gray-500 font-medium">Belum ada alat yang tersedia untuk dipinjam saat ini.</p>
                </div>
            @endforelse
        </div>

        {{-- ===== ALSINTAN YANG TIDAK TERSEDIA ===== --}}
        @if($unavailableAlsintans->isNotEmpty())
            <div class="mt-8">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-black text-gray-800 text-lg">Tidak Dapat Dipinjam Saat Ini</h2>
                        <p class="text-sm text-gray-500">Alat di bawah ini sedang dalam proses peminjaman Anda atau stoknya tidak tersedia.</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 overflow-hidden divide-y divide-gray-100 bg-white shadow-sm">
                    @foreach($unavailableAlsintans as $alsintan)
                        <div onclick="window.location.href='{{ route('farmer.proposals.alsintan.show', $alsintan) }}'" class="group cursor-pointer flex flex-col sm:flex-row hover:bg-gray-50 transition-colors">
                            {{-- Image --}}
                            <div class="w-full sm:w-40 h-36 sm:h-auto bg-gray-50 flex-shrink-0 overflow-hidden flex items-center justify-center border-r border-gray-100">
                                @if($alsintan->image)
                                    <img src="{{ Storage::url($alsintan->image) }}" alt="{{ $alsintan->name }}" class="w-full h-full object-cover grayscale opacity-60">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 p-5 flex flex-col justify-between opacity-80 group-hover:opacity-100 transition-opacity">
                                <div>
                                    <h3 class="font-bold text-gray-700 text-base mb-1">{{ $alsintan->name }}</h3>
                                    <div class="flex items-center gap-4 text-xs text-gray-500 mb-2">
                                        <span>Tersedia: <span class="font-bold text-gray-700">{{ $alsintan->available_stock }} unit</span></span>
                                        <span>Dipinjam: <span class="font-bold text-gray-700">{{ $alsintan->borrowed_count }}</span></span>
                                    </div>
                                    @if($alsintan->description)
                                        <p class="text-sm text-gray-400 line-clamp-1">{{ $alsintan->description }}</p>
                                    @endif
                                </div>

                                <div class="mt-3 pt-3 border-t border-gray-50">
                                    @if(array_key_exists($alsintan->id, $activeAlsintans))
                                        @if($activeAlsintans[$alsintan->id] === 'disetujui')
                                        <span class="inline-flex items-center gap-2 px-5 py-2 bg-green-50 border border-green-200 text-green-600 font-bold text-xs rounded-xl cursor-not-allowed">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Aktif Dipinjam
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-50 border border-yellow-200 text-yellow-600 font-bold text-xs rounded-xl cursor-not-allowed">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Sedang Diproses
                                        </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-gray-400 font-bold text-xs rounded-xl cursor-not-allowed">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            Stok Tidak Tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
