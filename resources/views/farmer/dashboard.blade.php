<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @if(!auth()->user()->farmerProfile || auth()->user()->farmerProfile->status !== 'approved' || (auth()->user()->farmerProfile->status === 'approved' && !auth()->user()->farmerProfile->is_verified_acknowledged))
        {{-- ===== WAITING FOR VERIFICATION / SUCCESS NOTICE ===== --}}
        @include('farmer.waiting-verification')
    @else
        {{-- ===== FARMER DASHBOARD CONTENT ===== --}}
    <div class="max-w-7xl mx-auto space-y-8">
        {{-- ===== WELCOME CARD ===== --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#19A148] via-[#15883c] to-[#0f6b2e] p-7 text-white shadow-lg shadow-green-900/20">

            {{-- Decorative circles --}}
            <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute -bottom-8 right-24 h-32 w-32 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute right-16 top-4 h-20 w-20 rounded-full bg-white/8"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6">
                <div>
                    <p class="mb-1 text-[11px] sm:text-sm font-semibold text-green-200 opacity-80 hidden sm:block">Selamat datang kembali</p>
                    <h2 class="mb-2 sm:mb-3 text-2xl sm:text-3xl font-extrabold tracking-tight">{{ auth()->user()->name }}</h2>
                    
                    @if(auth()->user()->farmerProfile->alamat)
                    <div class="flex items-center gap-2">
                        <div class="inline-flex items-start gap-2 rounded-xl bg-white/10 p-3 sm:px-3 sm:py-1.5 text-[11px] sm:text-xs font-semibold backdrop-blur-md border border-white/10 text-white/90">
                            <svg class="h-3.5 w-3.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="leading-relaxed">{{ auth()->user()->farmerProfile->alamat }}</span>
                        </div>
                    </div>
                    @endif

                    <p class="mt-4 max-w-md text-sm leading-relaxed text-green-100/90 hidden sm:block">
                        Pantau status proposal Anda dan ajukan permohonan baru kapan saja. Tim kami siap membantu proses pengajuan alat pertanian Anda.
                    </p>
                </div>

                <div class="flex md:flex-col items-start md:items-end gap-3 flex-shrink-0 mt-2 md:mt-0">
                    <a href="{{ route('farmer.proposals.programs') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-[#19A148] shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span class="sm:inline">Ajukan Proposal</span>
                    </a>
                    <span class="text-[10px] sm:text-xs text-green-200 font-medium hidden sm:block">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-[11px] font-extrabold text-emerald-600 uppercase tracking-[0.1em] mb-4">Total Pengajuan</p>
                <p class="text-4xl font-black text-slate-800 leading-none">{{ $stats['total'] ?? 0 }}</p>
            </div>

            <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-[11px] font-extrabold text-blue-600 uppercase tracking-[0.1em] mb-4">Sedang Diproses</p>
                <p class="text-4xl font-black text-slate-800 leading-none">{{ $stats['proses'] ?? 0 }}</p>
            </div>

            <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-[11px] font-extrabold text-emerald-600 uppercase tracking-[0.1em] mb-4">Disetujui</p>
                <p class="text-4xl font-black text-slate-800 leading-none">{{ $stats['disetujui'] ?? 0 }}</p>
            </div>

            <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-[11px] font-extrabold text-red-600 uppercase tracking-[0.1em] mb-4">Ditolak</p>
                <p class="text-4xl font-black text-slate-800 leading-none">{{ $stats['ditolak'] ?? 0 }}</p>
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
                                @if($prop->alsintan)
                                    <div class="font-bold text-gray-800">{{ $prop->alsintan->name }}</div>
                                    <div class="text-[10px] text-[#19A148] uppercase font-bold tracking-tight">Peminjaman Alsintan</div>
                                @elseif($prop->program)
                                    <div class="font-bold text-gray-800">{{ $prop->program->name }}</div>
                                    <div class="text-[10px] text-gray-400 uppercase font-bold">{{ str_replace('_', ' ', $prop->program->type) }}</div>
                                @else
                                    <div class="font-bold text-gray-800">-</div>
                                @endif
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
                                @elseif($prop->status === 'ditolak')
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-red-100 bg-red-50 px-3 py-1 text-[11px] font-bold text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-gray-100 bg-gray-50 px-3 py-1 text-[11px] font-bold text-gray-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> {{ ucfirst(str_replace('_', ' ', $prop->status)) }}
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

        {{-- ===== KATALOG ALSINTAN (GRID LAYOUT) ===== --}}
        <div>
            <div class="flex items-center justify-between mb-5 px-1">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Katalog Alsintan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Pilih alat dan mesin pertanian yang ingin Anda pinjam</p>
                </div>
                <a href="{{ route('farmer.proposals.alsintan') }}"
                   class="inline-flex items-center gap-1 text-sm font-bold text-[#19A148] hover:underline">
                    Lihat Semua Alat
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($alsintans as $alsintan)
                <a href="{{ route('farmer.proposals.alsintan.create', $alsintan) }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:border-[#19A148]/30 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="mb-4 flex items-center justify-between">
                            <span class="inline-block rounded-lg bg-sky-50 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-sky-600">
                                {{ $alsintan->category }}
                            </span>
                        </div>
                        <h4 class="mb-2 font-black text-gray-800 text-lg leading-tight group-hover:text-[#19A148] transition-colors">{{ $alsintan->name }}</h4>
                        <p class="mb-6 text-sm text-gray-500 leading-relaxed line-clamp-2">
                            {{ $alsintan->description ?? 'Alat pertanian berkualitas untuk menunjang produktivitas kelompok tani.' }}
                        </p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div class="text-[11px] text-gray-400">
                            Stok Tersedia: <span class="font-bold text-gray-700 block text-xs">{{ $alsintan->available_stock }} Unit</span>
                        </div>
                        <div class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white transition-all duration-200 group-hover:bg-[#19A148] group-hover:shadow-lg group-hover:shadow-green-900/20">
                            Ajukan Proposal
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full bg-white p-12 text-center rounded-2xl border border-dashed border-gray-200">
                    <p class="text-gray-400 font-medium">Saat ini belum ada alat pertanian yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ===== PROGRAM TERBUKA (GRID LAYOUT) ===== --}}
        <div>
            <div class="flex items-center justify-between mb-5 px-1">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Program Terbuka</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Pilih program bantuan yang tersedia untuk kelompok tani Anda</p>
                </div>
                <a href="{{ route('farmer.proposals.bantuan') }}"
                   class="inline-flex items-center gap-1 text-sm font-bold text-[#19A148] hover:underline">
                    Lihat Semua Program
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($programs as $program)
                <a href="{{ route('farmer.proposals.create', $program) }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:border-primary-600/30 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="mb-4 flex items-center justify-between">
                            <span class="inline-block rounded-lg bg-primary-50 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-primary-600">
                                {{ str_replace('_', ' ', $program->type) }}
                            </span>
                        </div>
                        <h4 class="mb-2 font-black text-gray-800 text-lg leading-tight group-hover:text-primary-600 transition-colors">{{ $program->name }}</h4>
                        <p class="mb-6 text-sm text-gray-500 leading-relaxed">
                            Program bantuan distribusi alsintan untuk peningkatan produktivitas pertanian daerah.
                        </p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div class="text-[11px] text-gray-400">
                            Batas Akhir: <span class="font-bold text-gray-700 block text-xs">{{ $program->close_date?->format('d M Y') ?? 'Tanpa Batas' }}</span>
                        </div>
                        <div class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white transition-all duration-200 group-hover:bg-primary-600 group-hover:shadow-lg group-hover:shadow-primary-900/20">
                            Ajukan Proposal
                        </div>
                    </div>
                </a>
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
