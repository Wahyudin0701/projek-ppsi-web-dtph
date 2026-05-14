<x-app-layout>
    <x-slot name="header">Manajemen Alsintan</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Inventaris Alsintan</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola daftar Alat dan Mesin Pertanian yang tersedia.</p>
            </div>
            <a href="{{ route('admin.alsintan.create') }}"
               class="inline-flex items-center gap-2 bg-[#19A148] text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-green-700 transition-colors shadow-sm shadow-green-200 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Alsintan
            </a>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Stats Row --}}
        @php
            $total     = $alsintans->sum('stock');
            $tersedia  = $alsintans->sum('available_stock');
            $dipinjam  = $alsintans->sum('borrowed_count');
            $rusak     = $alsintans->sum('broken_count');
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Inventaris</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $total }}</p>
            </div>
            <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 shadow-sm">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Siap Dipinjam</p>
                <p class="text-3xl font-extrabold text-emerald-700">{{ $tersedia }}</p>
            </div>
            <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100 shadow-sm">
                <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Sedang Dipinjam</p>
                <p class="text-3xl font-extrabold text-amber-700">{{ $dipinjam }}</p>
            </div>
            <div class="bg-red-50 rounded-2xl p-5 border border-red-100 shadow-sm">
                <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Rusak / Servis</p>
                <p class="text-3xl font-extrabold text-red-700">{{ $rusak }}</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/80">
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest flex justify-center">Alsintan</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Kategori</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest w-40 text-center">Status Distribusi</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($alsintans as $alsintan)
                        <tr class="hover:bg-gray-50/60 transition-colors">

                            {{-- Name + Image --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($alsintan->image)
                                        <img src="{{ asset('storage/' . $alsintan->image) }}" alt="{{ $alsintan->name }}"
                                             class="w-12 h-12 rounded-xl object-cover border border-gray-100 flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-sm text-gray-900 leading-tight">{{ $alsintan->name }}</p>
                                        <p class="text-[11px] text-gray-500 mt-0.5">{{ $alsintan->merk ?? 'Tanpa Merk' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4 flex justify-center">
                                @php
                                    $catLabels = ['traktor' => 'Traktor', 'pompa' => 'Pompa Air', 'pascapanen' => 'Pasca Panen', 'tanam' => 'Alat Tanam'];
                                    $catLabel = $catLabels[$alsintan->category] ?? ucfirst($alsintan->category ?? '-');
                                @endphp
                                <span class="inline-block px-2.5 py-1 bg-primary-50 text-primary-700 text-[11px] font-bold rounded-lg border border-primary-100">
                                    {{ $catLabel }}
                                </span>
                            </td>

                            {{-- Combined Status --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center justify-between text-[10px] font-bold px-2 py-1 rounded bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <span class="uppercase tracking-wider">Tersedia</span>
                                        <span class="bg-white px-1.5 py-0.5 rounded shadow-sm">{{ $alsintan->available_stock }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-[10px] font-bold px-2 py-1 rounded bg-amber-50 text-amber-700 border border-amber-100 {{ $alsintan->borrowed_count == 0 ? 'opacity-50 grayscale' : '' }}">
                                        <span class="uppercase tracking-wider">Dipinjam</span>
                                        <span class="bg-white px-1.5 py-0.5 rounded shadow-sm">{{ $alsintan->borrowed_count }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-[10px] font-bold px-2 py-1 rounded bg-red-50 text-red-700 border border-red-100 {{ $alsintan->broken_count == 0 ? 'opacity-50 grayscale' : '' }}">
                                        <span class="uppercase tracking-wider">Rusak</span>
                                        <span class="bg-white px-1.5 py-0.5 rounded shadow-sm">{{ $alsintan->broken_count }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 flex justify-center">
                                <div class="flex flex-col items-end gap-1.5">
                                    <a href="{{ route('admin.alsintan.show', $alsintan) }}"
                                       class="inline-flex items-center gap-1.5 w-24 px-3 py-1.5 text-[11px] font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.alsintan.edit', $alsintan) }}"
                                       class="inline-flex items-center gap-1.5 w-24 px-3 py-1.5 text-[11px] font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.alsintan.destroy', $alsintan) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus {{ $alsintan->name }}?')" class="block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 w-24 px-3 py-1.5 text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg border border-red-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <p class="font-bold text-gray-800">Belum ada data alsintan</p>
                                    <p class="text-sm text-gray-400">Mulai tambahkan alat dan mesin pertanian pertama Anda.</p>
                                    <a href="{{ route('admin.alsintan.create') }}"
                                       class="mt-2 inline-flex items-center gap-2 bg-[#19A148] text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-green-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah Alsintan
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
