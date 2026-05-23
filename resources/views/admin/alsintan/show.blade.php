<x-app-layout>
    <x-slot name="header">Manajemen Alsintan</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Page Header --}}
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900">Detail Alsintan</h2>
                    <p class="text-gray-500 text-sm mt-1">Dinas Tanaman Pangan dan Hortikultura</p>
                </div>
                <a href="{{ route('admin.alsintan.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali
                </a>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    {{-- Image Side --}}
                    <div class="bg-gray-50 p-6 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                        @if($alsintan->image)
                            <img src="{{ asset('storage/' . $alsintan->image) }}" alt="{{ $alsintan->name }}" class="w-full max-w-sm rounded-2xl object-cover shadow-sm">
                        @else
                            <div class="w-full aspect-square max-w-xs rounded-2xl bg-gray-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="mt-6 text-center w-full">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ID Asset</p>
                            <p class="font-mono text-lg font-bold text-gray-800">#AST-{{ str_pad($alsintan->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>

                    {{-- Details Side --}}
                    <div class="p-8 md:col-span-2 flex flex-col">
                        <div class="mb-6 flex justify-between items-start gap-4">
                            <div>
                                @php
                                    $catLabels = ['traktor' => 'Traktor', 'pompa' => 'Pompa Air', 'pascapanen' => 'Pasca Panen', 'tanam' => 'Alat Tanam'];
                                    $catLabel = $catLabels[$alsintan->category] ?? ucfirst($alsintan->category ?? '-');
                                @endphp
                                <span class="inline-block px-3 py-1 bg-primary-50 text-primary-700 text-xs font-bold rounded-lg border border-primary-100 mb-3">
                                    Kategori: {{ $catLabel }}
                                </span>
                                <h3 class="text-3xl font-black text-gray-900 leading-tight mb-2">{{ $alsintan->name }}</h3>
                            </div>
                            <a href="{{ route('admin.alsintan.edit', $alsintan) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl font-bold text-sm transition-colors border border-amber-200 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Alat
                            </a>
                        </div>
                        <p class="text-gray-500 line-clamp-3 mb-6">{{ $alsintan->description ?: 'Tidak ada deskripsi tersedia untuk alat ini.' }}</p>

                        <div class="grid grid-cols-2 gap-6 mb-8 bg-gray-50 p-5 rounded-2xl border border-gray-100">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Merk / Tipe</p>
                                <p class="font-bold text-gray-900">{{ $alsintan->merk ?: '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kapasitas Mesin</p>
                                <p class="font-bold text-gray-900">{{ $alsintan->capacity ?: '-' }}</p>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <h4 class="text-sm font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Status Distribusi Inventaris</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div class="bg-white border border-gray-200 rounded-xl p-4 text-center shadow-sm">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Total Dimiliki</p>
                                    <p class="text-2xl font-black text-gray-800">{{ $alsintan->stock }}</p>
                                </div>
                                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 text-center shadow-sm">
                                    <p class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Tersedia</p>
                                    <p class="text-2xl font-black text-emerald-700">{{ $alsintan->available_stock }}</p>
                                </div>
                                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-center shadow-sm">
                                    <p class="text-[10px] font-bold text-amber-600 uppercase mb-1">Dipinjam</p>
                                    <p class="text-2xl font-black text-amber-700">{{ $alsintan->borrowed_count }}</p>
                                </div>
                                <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center shadow-sm">
                                    <p class="text-[10px] font-bold text-red-600 uppercase mb-1">Rusak</p>
                                    <p class="text-2xl font-black text-red-700">{{ $alsintan->broken_count }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>

