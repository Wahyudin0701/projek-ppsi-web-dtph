<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @if(auth()->user()->isUser() && (!auth()->user()->farmerProfile || auth()->user()->farmerProfile->status !== 'approved' || (auth()->user()->farmerProfile->status === 'approved' && !auth()->user()->farmerProfile->is_verified_acknowledged)))
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
                    
                    @if(auth()->user()->farmerProfile && auth()->user()->farmerProfile->alamat)
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
                    <a href="{{ route('farmer.proposals.pilih') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-[#19A148] shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span class="sm:inline">Ajukan Proposal</span>
                    </a>
                    <span class="text-[10px] sm:text-xs text-green-200 font-medium hidden sm:block">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            {{-- Card: Total --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-full bg-slate-50 text-slate-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-slate-100 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 mb-0.5">Total Pengajuan</p>
                    <p class="text-3xl font-black text-gray-900 leading-none tracking-tight">{{ $stats['total'] ?? 0 }}</p>
                </div>
            </div>

            {{-- Card: Diproses --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-blue-100 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 mb-0.5">Sedang Diproses</p>
                    <p class="text-3xl font-black text-gray-900 leading-none tracking-tight">{{ $stats['proses'] ?? 0 }}</p>
                </div>
            </div>

            {{-- Card: Disetujui --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-emerald-100 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 mb-0.5">Disetujui</p>
                    <p class="text-3xl font-black text-gray-900 leading-none tracking-tight">{{ $stats['disetujui'] ?? 0 }}</p>
                </div>
            </div>

            {{-- Card: Ditolak --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-full bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-red-100 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 mb-0.5">Ditolak</p>
                    <p class="text-3xl font-black text-gray-900 leading-none tracking-tight">{{ $stats['ditolak'] ?? 0 }}</p>
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
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">No. Registrasi</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Objek Proposal</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Lokasi Lahan</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentProposals as $proposal)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-900 text-sm">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-900">{{ $proposal->submission_date->translatedFormat('d M Y') }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $proposal->submission_date->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($proposal->alsintan)
                                        <p class="font-bold text-gray-900 text-sm">{{ $proposal->alsintan->name }}</p>
                                        <p class="text-[10px] text-primary-600 font-bold uppercase tracking-tighter">Peminjaman Alsintan</p>
                                    @elseif($proposal->program)
                                        <p class="font-bold text-gray-900 text-sm">{{ $proposal->program->name }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ str_replace('_', ' ', $proposal->program->type) }}</p>
                                    @else
                                        <p class="font-bold text-gray-900">-</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="text-sm text-gray-600 line-clamp-1">{{ $proposal->lokasi_lahan }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusColors = [
                                            'pending_verifikasi' => 'bg-yellow-100 text-yellow-700',
                                            'diteruskan_ke_pimpinan' => 'bg-indigo-100 text-indigo-700',
                                            'didisposisi_kabid' => 'bg-amber-100 text-amber-700',
                                            'surat_tugas_terbit' => 'bg-blue-100 text-blue-700',
                                            'survei_selesai' => 'bg-orange-100 text-orange-700',
                                            'menunggu_approval_ba' => 'bg-purple-100 text-purple-700',
                                            'disetujui'          => 'bg-green-100 text-green-700',
                                            'ditolak'            => 'bg-red-100 text-red-700',
                                        ];
                                        $color = $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-700';
                                        $statusLabel = match($proposal->status) {
                                            'pending_verifikasi' => 'Verifikasi',
                                            'diteruskan_ke_pimpinan'  => 'Pimpinan',
                                            'didisposisi_kabid'  => 'Di Kabid',
                                            'surat_tugas_terbit' => 'Surat Tugas',
                                            'survei_selesai' => 'Survei',
                                            'menunggu_approval_ba' => 'Finalisasi',
                                            'disetujui'          => 'Disetujui',
                                            'ditolak'            => 'Ditolak',
                                            default              => $proposal->status,
                                        };
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest {{ $color }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('farmer.proposals.show', $proposal) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center">
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
                <div onclick="window.location.href='{{ route('farmer.proposals.alsintan.show', $alsintan) }}'" class="cursor-pointer bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg hover:border-[#19A148]/30 hover:-translate-y-1 transition-all duration-300 flex flex-col group relative">

                    {{-- Image Section --}}
                    @if($alsintan->image)
                        <div class="h-48 w-full bg-gray-100 relative overflow-hidden">
                            <img src="{{ Storage::url($alsintan->image) }}" alt="{{ $alsintan->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                    @else
                        <div class="h-48 w-full bg-slate-50 flex items-center justify-center relative overflow-hidden">
                            <svg class="w-12 h-12 text-slate-300 transition-transform duration-500 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    
                    {{-- Badge overlaid on image --}}
                    <div class="absolute top-4 left-4 z-10">
                        <span class="inline-block rounded-lg bg-white/95 backdrop-blur-sm px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-sky-600 shadow-sm">
                            {{ $alsintan->category }}
                        </span>
                    </div>

                    {{-- Content Section --}}
                    <div class="p-6 flex flex-col flex-1 justify-between relative z-10 pointer-events-none">
                        <div>
                            <h4 class="mb-2 font-black text-gray-800 text-lg leading-tight group-hover:text-[#19A148] transition-colors">{{ $alsintan->name }}</h4>
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-2">
                                {{ $alsintan->description ?? 'Alat pertanian berkualitas untuk menunjang produktivitas kelompok tani.' }}
                            </p>
                        </div>
                        
                        <div class="pt-4 mt-5 border-t border-gray-50 flex items-center justify-between pointer-events-auto">
                            <div class="text-[11px] text-gray-400">
                                Stok Tersedia: <span class="font-bold text-gray-700 block text-xs">{{ $alsintan->available_stock }} Unit</span>
                            </div>
                            <a href="{{ route('farmer.proposals.alsintan.create', $alsintan) }}" onclick="event.stopPropagation()" class="inline-flex items-center justify-center rounded-xl bg-[#19A148] px-5 py-2.5 text-xs font-bold text-white transition-all duration-200 hover:bg-green-700 shadow-sm shadow-green-900/10 hover:shadow-md hover:shadow-green-900/20">
                                Ajukan Proposal
                            </a>
                        </div>
                    </div>
                </div>
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
                <div onclick="window.location.href='{{ route('farmer.proposals.bantuan.show', $program) }}'" class="cursor-pointer bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:border-primary-600/30 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
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
                        <a href="{{ route('farmer.proposals.create', $program) }}" onclick="event.stopPropagation()" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white transition-all duration-200 group-hover:bg-primary-600 group-hover:shadow-lg group-hover:shadow-primary-900/20">
                            Ajukan Proposal
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
