<x-app-layout>
    <x-slot name="header">Detail Alat</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">{{ $alsintan->name }}</h2>
                <p class="text-gray-500 text-sm mt-1">Detail spesifikasi dan ketersediaan alat pertanian</p>
            </div>
            <a href="{{ route('farmer.proposals.alsintan') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            {{-- Left Column: Image & CTA --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Image Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden relative">
                    <div class="aspect-square bg-gray-50 relative">
                        @if($alsintan->image)
                            <img src="{{ Storage::url($alsintan->image) }}" alt="{{ $alsintan->name }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-5 left-5 z-10">
                            <span class="inline-block rounded-xl bg-white/95 backdrop-blur-md px-4 py-2 text-xs font-extrabold uppercase tracking-widest text-[#19A148] shadow-sm">
                                {{ $alsintan->category }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- CTA Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6 sm:p-8 text-center">
                    <h3 class="font-bold text-gray-900 mb-2">Ingin Meminjam Alat Ini?</h3>
                    <p class="text-sm text-gray-500 mb-6">Ajukan proposal peminjaman sekarang dengan melengkapi form yang tersedia.</p>
                    @if($alsintan->available_stock > 0)
                        <a href="{{ route('farmer.proposals.alsintan.create', $alsintan->id) }}"
                           class="group w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#19A148] text-white font-bold text-base rounded-2xl hover:bg-green-700 hover:shadow-xl hover:shadow-green-900/20 hover:-translate-y-1 transition-all duration-300">
                            Ajukan Proposal
                            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @else
                        <button disabled class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-gray-100 text-gray-400 font-bold text-base rounded-2xl cursor-not-allowed">
                            Stok Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>

            {{-- Right Column: Details --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Specs Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 sm:p-10">
                    <h3 class="font-black text-2xl text-gray-900 mb-6">Spesifikasi Alat</h3>
                    
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Merk / Tipe</p>
                            <p class="font-bold text-gray-800 text-lg">{{ $alsintan->merk ?? 'Tanpa Merk' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Kapasitas</p>
                            <p class="font-bold text-gray-800 text-lg">{{ $alsintan->capacity ?? 'Standar' }}</p>
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-gray-900 mb-3 border-t border-gray-100 pt-8">Deskripsi</h3>
                    <p class="text-gray-600 leading-relaxed text-justify">
                        {{ $alsintan->description ?? 'Belum ada deskripsi lengkap untuk alat pertanian ini.' }}
                    </p>
                </div>

                {{-- Availability Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 sm:p-10">
                    <h3 class="font-bold text-lg text-gray-900 mb-6">Informasi Ketersediaan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-[#19A148]/5 rounded-2xl p-6 border border-[#19A148]/10 text-center flex flex-col justify-center">
                            <span class="block text-4xl font-black text-[#19A148] mb-2">{{ $alsintan->available_stock ?? '0' }}</span>
                            <span class="text-xs font-bold uppercase tracking-widest text-[#19A148]/70">Tersedia</span>
                        </div>
                        <div class="bg-amber-50 rounded-2xl p-6 border border-amber-100/50 text-center flex flex-col justify-center">
                            <span class="block text-4xl font-black text-amber-600 mb-2">{{ $alsintan->borrowed_count ?? '0' }}</span>
                            <span class="text-xs font-bold uppercase tracking-widest text-amber-600/70">Dipinjam</span>
                        </div>
                        <div class="bg-red-50 rounded-2xl p-6 border border-red-100/50 text-center flex flex-col justify-center">
                            <span class="block text-4xl font-black text-red-600 mb-2">{{ $alsintan->broken_count ?? '0' }}</span>
                            <span class="text-xs font-bold uppercase tracking-widest text-red-600/70">Rusak</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
