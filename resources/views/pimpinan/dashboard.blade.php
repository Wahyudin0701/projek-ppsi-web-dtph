<x-app-layout>
    <x-slot name="header">Dashboard Pimpinan</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">

        {{-- ===== STAT CARDS (Master & Operational) ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-5">
            {{-- Kelompok Tani --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-blue-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Total Kelompok Tani</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ number_format($stats['total_poktan'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- User Umum --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-indigo-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Total User Umum</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ number_format($stats['total_user'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Katalog Alsintan --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-sky-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Katalog Alsintan</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ number_format($stats['katalog_alsintan'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Program Aktif --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-emerald-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Program Aktif</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ number_format($stats['program_aktif'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Pengajuan Alsintan --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-cyan-50 text-cyan-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-cyan-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Pengajuan Alsintan</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ number_format($stats['pengajuan_alsintan'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Pengajuan Program --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-teal-50 text-teal-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-teal-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Pengajuan Program</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ number_format($stats['pengajuan_program'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- ===== CHARTS ===== --}}
        @include('components.dashboard-charts')

        {{-- ===== PROPOSAL MENUNGGU PERSETUJUAN ===== --}}
        <div class="mt-6">
            <div class="flex items-center justify-between mb-5 px-1">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Proposal Menunggu Persetujuan Anda</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Proposal yang telah diverifikasi admin dan siap untuk ditinjau</p>
                </div>
                <a href="{{ route('pimpinan.proposals.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-bold text-indigo-600 hover:underline">
                    Lihat Semua
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($pendingProposals->isEmpty())
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-16 text-center">
                    <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-gray-400 font-semibold">Tidak ada proposal yang menunggu persetujuan Anda.</p>
                    <p class="text-gray-400 text-sm mt-1">Semua proposal sudah ditangani.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">No. Registrasi</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Pengaju</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Jenis & Objek</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Tgl. Pengajuan</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($pendingProposals as $proposal)
                                    @php $isAlsintan = $proposal->alsintan_id !== null; @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="font-bold text-gray-900 text-sm">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900 text-sm">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $proposal->user->name }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md mb-1 {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                                                {{ $isAlsintan ? 'Alsintan' : 'Program Bantuan' }}
                                            </span>
                                            <p class="font-semibold text-gray-800 text-sm">
                                                {{ $isAlsintan ? $proposal->alsintan->name : $proposal->program->name }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <p class="text-sm text-gray-700">{{ $proposal->submission_date?->translatedFormat('d M Y') }}</p>
                                            <p class="text-xs text-gray-400">{{ $proposal->submission_date?->translatedFormat('H:i') }} WIB</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('pimpinan.proposals.show', $proposal) }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                                Tinjau
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
