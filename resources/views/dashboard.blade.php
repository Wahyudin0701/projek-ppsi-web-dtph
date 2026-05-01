<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @if(auth()->user()->isAdmin())
    {{-- ===== ADMIN DASHBOARD ===== --}}
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 to-slate-700 p-7 text-white shadow-lg">
            <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-white/5"></div>
            <div class="relative z-10">
                <p class="mb-1 text-sm font-semibold text-slate-400">Panel Administrator</p>
                <h2 class="mb-2 text-2xl font-extrabold">Selamat Datang, {{ auth()->user()->name }}</h2>
                <p class="max-w-lg text-sm text-slate-400 leading-relaxed">
                    Kelola verifikasi akun dan program bantuan melalui menu navigasi di samping.
                </p>
            </div>
        </div>
    </div>

    @elseif(auth()->user()->status !== 'approved')
    {{-- ===== WAITING FOR VERIFICATION ===== --}}
    @include('pages.waiting-verification')

    @else
    {{-- ===== FARMER DASHBOARD ===== --}}
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- ===== WELCOME CARD ===== --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#19A148] via-[#15883c] to-[#0f6b2e] p-7 text-white shadow-lg shadow-green-900/20">

            {{-- Decorative circles --}}
            <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute -bottom-8 right-24 h-32 w-32 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute right-16 top-4 h-20 w-20 rounded-full bg-white/8"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <p class="mb-1 text-sm font-semibold text-green-200">Selamat datang kembali</p>
                    <h2 class="mb-3 text-3xl font-extrabold tracking-tight">{{ auth()->user()->name }}</h2>

                    <div class="flex flex-wrap items-center gap-2">
                        @if(auth()->user()->nama_kelompok)
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/15 px-3 py-1.5 text-xs font-semibold backdrop-blur-sm border border-white/20">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ auth()->user()->nama_kelompok }}
                        </span>
                        @endif
                        @if(auth()->user()->alamat)
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/15 px-3 py-1.5 text-xs font-semibold backdrop-blur-sm border border-white/20">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ Str::limit(auth()->user()->alamat, 40) }}
                        </span>
                        @endif
                    </div>

                    <p class="mt-4 max-w-md text-sm leading-relaxed text-green-100/90">
                        Pantau status proposal Anda dan ajukan permohonan baru kapan saja. Tim kami siap membantu proses pengajuan alat pertanian Anda.
                    </p>
                </div>

                <div class="hidden md:flex flex-col items-end gap-3 flex-shrink-0">
                    <a href="{{ route('farmer.proposals.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-[#19A148] shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Ajukan Proposal
                    </a>
                    <span class="text-xs text-green-200 font-medium">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex h-13 w-13 flex-shrink-0 items-center justify-center rounded-xl bg-green-50 text-[#19A148]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Pengajuan</p>
                    <p class="mt-0.5 text-3xl font-black text-gray-800 leading-none">{{ $stats['total'] ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex h-13 w-13 flex-shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Sedang Diproses</p>
                    <p class="mt-0.5 text-3xl font-black text-gray-800 leading-none">{{ $stats['proses'] ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex h-13 w-13 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Selesai / Disetujui</p>
                    <p class="mt-0.5 text-3xl font-black text-gray-800 leading-none">{{ $stats['selesai'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- ===== PENGAJUAN TERAKHIR (FULL WIDTH) ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-50 px-6 py-5">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Pengajuan Terakhir</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Daftar proposal terbaru yang telah Anda ajukan</p>
                </div>
                <a href="{{ route('farmer.proposals.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-bold text-[#19A148] hover:underline">
                    Lihat Semua
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-50 text-[10px] font-extrabold uppercase tracking-widest text-gray-400">
                            <th class="px-6 py-4 text-left">No. Proposal</th>
                            <th class="px-6 py-4 text-left">Program / Alat Pertanian</th>
                            <th class="px-6 py-4 text-left">Lokasi Lahan</th>
                            <th class="px-6 py-4 text-left">Tanggal Ajuan</th>
                            <th class="px-6 py-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProposals as $prop)
                        <tr class="border-b border-gray-50 last:border-0 hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-5 font-mono text-xs font-bold text-gray-500">
                                PROP-{{ date('Y') }}-{{ str_pad($prop->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-800">{{ $prop->program->name }}</div>
                                <div class="text-[10px] text-gray-400 uppercase font-bold">{{ str_replace('_', ' ', $prop->program->type) }}</div>
                            </td>
                            <td class="px-6 py-5 text-gray-600 font-medium">{{ $prop->lokasi_lahan }}</td>
                            <td class="px-6 py-5 text-gray-500">{{ $prop->submission_date->format('d M Y') }}</td>
                            <td class="px-6 py-5">
                                @if($prop->status === 'pending_verifikasi')
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-yellow-100 bg-yellow-50 px-3 py-1 text-[11px] font-bold text-yellow-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-yellow-500"></span> Menunggu
                                    </span>
                                @elseif($prop->status === 'disetujui')
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-green-100 bg-green-50 px-3 py-1 text-[11px] font-bold text-green-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-red-100 bg-red-50 px-3 py-1 text-[11px] font-bold text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="text-sm font-medium">Belum ada proposal yang diajukan.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== PROGRAM TERBUKA (GRID LAYOUT) ===== --}}
        <div>
            <div class="flex items-center justify-between mb-5 px-1">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Program Terbuka</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Pilih program bantuan yang tersedia untuk kelompok tani Anda</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($programs as $program)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="mb-4 flex items-center justify-between">
                            <span class="inline-block rounded-lg bg-green-50 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-[#19A148]">
                                {{ str_replace('_', ' ', $program->type) }}
                            </span>
                            <div class="h-8 w-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-[#19A148] group-hover:text-white transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            </div>
                        </div>
                        <h4 class="mb-2 font-black text-gray-800 text-lg leading-tight">{{ $program->name }}</h4>
                        <p class="mb-6 text-sm text-gray-500 leading-relaxed">
                            Program bantuan distribusi alsintan untuk peningkatan produktivitas pertanian daerah.
                        </p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div class="text-[11px] text-gray-400">
                            Batas Akhir: <span class="font-bold text-gray-700 block text-xs">{{ $program->close_date?->format('d M Y') ?? 'Tanpa Batas' }}</span>
                        </div>
                        <a href="{{ route('farmer.proposals.create', $program) }}"
                           class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white transition-all duration-200 hover:bg-[#19A148] hover:shadow-lg hover:shadow-green-900/20">
                            Ajukan Sekarang
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white p-12 text-center rounded-2xl border border-dashed border-gray-200">
                    <p class="text-gray-400 font-medium">Saat ini belum ada program bantuan yang dibuka.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    @endif

</x-app-layout>
