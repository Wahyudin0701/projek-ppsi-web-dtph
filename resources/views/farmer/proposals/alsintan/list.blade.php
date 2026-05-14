<x-app-layout>
    <x-slot name="header">Katalog Alsintan - Ajukan Peminjaman</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('farmer.proposals.pilih') }}" class="hover:text-primary-600 transition-colors">Ajukan Proposal</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-semibold text-gray-700">Peminjaman Alsintan</span>
                </div>
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

        @forelse($alsintans as $alsintan)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row">
                {{-- Image --}}
                <div class="w-full sm:w-48 h-48 sm:h-auto bg-gray-100 flex-shrink-0 overflow-hidden">
                    @if($alsintan->image)
                        <img src="{{ Storage::url($alsintan->image) }}" alt="{{ $alsintan->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <h3 class="font-extrabold text-gray-900 text-xl">{{ $alsintan->name }}</h3>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm mb-4 items-center">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Merk / Tipe</p>
                                <p class="font-bold text-gray-800">{{ $alsintan->merk ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Kapasitas</p>
                                <p class="font-bold text-gray-800">{{ $alsintan->capacity ?? '-' }}</p>
                            </div>
                            <div class="px-3 py-1.5 bg-emerald-50 rounded-xl border border-emerald-100 text-center">
                                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-0.5">Tersedia</p>
                                <p class="font-bold text-emerald-700">{{ $alsintan->available_stock ?? '0' }}</p>
                            </div>
                            <div class="px-3 py-1.5 bg-amber-50 rounded-xl border border-amber-100 text-center">
                                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mb-0.5">Dipinjam</p>
                                <p class="font-bold text-amber-700">{{ $alsintan->borrowed_count ?? '0' }}</p>
                            </div>
                            <div class="px-3 py-1.5 bg-red-50 rounded-xl border border-red-100 text-center">
                                <p class="text-[10px] font-bold text-red-600 uppercase tracking-wider mb-0.5">Rusak</p>
                                <p class="font-bold text-red-700">{{ $alsintan->broken_count ?? '0' }}</p>
                            </div>
                        </div>
                        @if($alsintan->description)
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-2">{{ $alsintan->description }}</p>
                        @endif
                    </div>

                    <div class="mt-5 pt-4 border-t border-gray-50">
                        @if($alsintan->available_stock > 0)
                            @if(in_array($alsintan->id, $activeAlsintanIds))
                                {{-- Sudah ada proposal aktif untuk alat ini --}}
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center gap-2 px-5 py-3 bg-yellow-50 border border-yellow-200 text-yellow-700 font-bold text-sm rounded-xl cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Sedang Diproses
                                    </span>
                                    <span class="text-xs text-gray-400 font-medium">Proposal Anda sedang diverifikasi</span>
                                </div>
                            @else
                                <a href="{{ route('farmer.proposals.alsintan.create', $alsintan->id) }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold text-sm rounded-xl shadow-sm hover:bg-primary-700 hover:shadow-md transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Ajukan Proposal
                                </a>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-400 font-bold text-sm rounded-xl cursor-not-allowed">
                                Tidak Bisa Ajukan Peminjaman
                            </span>
                        @endif
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
</x-app-layout>
