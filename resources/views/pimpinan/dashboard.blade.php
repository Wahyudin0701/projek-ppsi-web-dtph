<x-app-layout>
    <x-slot name="header">Dashboard Pimpinan</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">

        {{-- ===== WELCOME BANNER ===== --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 p-7 text-white shadow-lg shadow-indigo-900/30">
            <div class="pointer-events-none absolute -right-10 -top-10 h-56 w-56 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute -bottom-8 right-32 h-36 w-36 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute right-20 top-4 h-24 w-24 rounded-full bg-white/8"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-1 text-xs font-bold text-indigo-200 mb-3 border border-white/10">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Panel Pimpinan
                    </div>
                    <h2 class="mb-2 text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}</h2>
                    <p class="max-w-lg text-sm text-indigo-200 leading-relaxed hidden sm:block">
                        Tinjau dan berikan keputusan akhir terhadap proposal yang telah diverifikasi oleh admin.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('pimpinan.proposals.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-indigo-700 shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Tinjau Semua Proposal
                    </a>
                    <p class="text-[11px] text-indigo-300 font-medium text-right mt-2">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Total Pengajuan --}}
            <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-[11px] font-extrabold text-emerald-600 uppercase tracking-[0.1em] mb-4">TOTAL PENGAJUAN</p>
                <p class="text-4xl font-black text-slate-800 leading-none">{{ $stats['total'] }}</p>
            </div>

            {{-- Sedang Diproses --}}
            <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-[11px] font-extrabold text-blue-600 uppercase tracking-[0.1em] mb-4">SEDANG DIPROSES</p>
                <p class="text-4xl font-black text-slate-800 leading-none">{{ $stats['menunggu'] }}</p>
            </div>

            {{-- Disetujui --}}
            <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-[11px] font-extrabold text-emerald-600 uppercase tracking-[0.1em] mb-4">DISETUJUI</p>
                <p class="text-4xl font-black text-slate-800 leading-none">{{ $stats['disetujui'] }}</p>
            </div>

            {{-- Ditolak --}}
            <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-[11px] font-extrabold text-red-600 uppercase tracking-[0.1em] mb-4">DITOLAK</p>
                <p class="text-4xl font-black text-slate-800 leading-none">{{ $stats['ditolak'] }}</p>
            </div>
        </div>

        {{-- ===== PROPOSAL MENUNGGU PERSETUJUAN ===== --}}
        <div>
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
