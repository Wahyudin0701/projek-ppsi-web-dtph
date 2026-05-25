<x-app-layout>
    <x-slot name="header">Dashboard Admin</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">

        {{-- ===== WELCOME BANNER ===== --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-900 via-blue-800 to-sky-900 p-7 text-white shadow-lg shadow-blue-900/30">
            <div class="pointer-events-none absolute -right-10 -top-10 h-56 w-56 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute -bottom-8 right-32 h-36 w-36 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute right-20 top-4 h-24 w-24 rounded-full bg-white/8"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-1 text-xs font-bold text-blue-200 mb-3 border border-white/10">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Panel Administrator
                    </div>
                    <h2 class="mb-2 text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}</h2>
                    <p class="max-w-lg text-sm text-blue-200 leading-relaxed hidden sm:block">
                        Kelola verifikasi akun Kelompok Tani dan periksa proposal pengajuan bantuan baru yang masuk.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.proposals.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-blue-700 shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Kelola Proposal
                    </a>
                    <p class="text-[11px] text-blue-300 font-medium text-right mt-2">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- User Pending --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-blue-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Verifikasi User</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ $stats['pending_users'] }}</p>
                </div>
            </div>

            {{-- Proposal Pending --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-amber-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Verifikasi Proposal</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ $stats['pending_proposals'] }}</p>
                </div>
            </div>

            {{-- Program Berjalan --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-emerald-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Program Berjalan</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ $stats['active_programs'] }}</p>
                </div>
            </div>

            {{-- Total Proposal --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-indigo-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Total Proposal</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ $stats['total_proposals'] }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- ===== DAFTAR USER MENUNGGU ===== --}}
            <div>
                <div class="flex items-center justify-between mb-5 px-1">
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-lg">Pendaftaran Kelompok Tani</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Menunggu verifikasi Anda</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center gap-1 text-sm font-bold text-blue-600 hover:underline">
                        Lihat Semua
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($latestPendingUsers->isEmpty())
                    <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
                        <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <p class="text-gray-400 font-semibold">Tidak ada user menunggu verifikasi.</p>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($latestPendingUsers as $userPending)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                                        {{ substr($userPending->farmerProfile->nama_kelompok ?? $userPending->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-gray-900 text-sm">{{ $userPending->farmerProfile->nama_kelompok ?? $userPending->name }}</p>
                                                        <p class="text-xs text-gray-400 mt-0.5">{{ $userPending->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('admin.users.show', $userPending) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-lg transition-colors">
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

            {{-- ===== PROPOSAL BARU MENUNGGU ===== --}}
            <div>
                <div class="flex items-center justify-between mb-5 px-1">
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-lg">Proposal Baru</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Pengajuan yang perlu diverifikasi administratif</p>
                    </div>
                    <a href="{{ route('admin.proposals.index') }}"
                       class="inline-flex items-center gap-1 text-sm font-bold text-blue-600 hover:underline">
                        Lihat Semua
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($latestPendingProposals->isEmpty())
                    <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
                        <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="text-gray-400 font-semibold">Tidak ada proposal baru yang menunggu.</p>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($latestPendingProposals as $proposal)
                                        @php $isAlsintan = $proposal->alsintan_id !== null; @endphp
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="font-bold text-gray-900 text-sm">#PRP-{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</p>
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md mb-1 {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                                                    {{ $isAlsintan ? 'Alsintan' : 'Bantuan' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('admin.proposals.show', $proposal) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-lg transition-colors">
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

        {{-- ===== PROPOSAL DISPOSISI KABID ===== --}}
        <div>
            <div class="flex items-center justify-between mb-5 px-1">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Disposisi Kabid & Tindak Lanjut Survei</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Proposal yang siap diterbitkan surat tugas dan diinput hasil verifikasi CPCL</p>
                </div>
                <a href="{{ route('admin.proposals.index', ['status' => 'surat_tugas_terbit']) }}"
                   class="inline-flex items-center gap-1 text-sm font-bold text-blue-600 hover:underline">
                    Lihat Semua
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($dispositionedProposals->isEmpty())
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
                    <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <p class="text-gray-400 font-semibold">Tidak ada proposal dalam tahap tindak lanjut survei.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-400 text-xs font-bold uppercase tracking-wider">
                                    <th class="px-6 py-4">No. Proposal</th>
                                    <th class="px-6 py-4">Kelompok Tani</th>
                                    <th class="px-6 py-4">Bantuan / Program</th>
                                    <th class="px-6 py-4">Masa Berlaku Survei</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($dispositionedProposals as $prop)
                                    @php 
                                        $isAlsintan = $prop->alsintan_id !== null; 
                                        $assignment = $prop->surveyAssignments->last();
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900 text-sm align-middle">
                                            #PRP-{{ str_pad($prop->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <p class="font-bold text-gray-900 text-sm leading-tight">{{ $prop->user->farmerProfile->nama_kelompok ?? $prop->user->name }}</p>
                                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $prop->user->farmerProfile->desa ?? 'N/A' }}, {{ $prop->user->farmerProfile->kecamatan ?? 'N/A' }}</p>
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <div class="flex flex-col items-start gap-1">
                                                <span class="inline-block text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded-md {{ $isAlsintan ? 'bg-sky-50 text-sky-600' : 'bg-violet-50 text-violet-600' }}">
                                                    {{ $isAlsintan ? 'Alsintan' : 'Bantuan' }}
                                                </span>
                                                <span class="text-xs text-gray-700 font-medium max-w-[200px] truncate">
                                                    {{ $isAlsintan ? $prop->alsintan->name : $prop->program->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 align-middle text-xs text-gray-600 font-medium">
                                            @if($assignment)
                                                <span class="block text-gray-800 font-semibold">{{ $assignment->valid_from->translatedFormat('d M Y') }}</span>
                                                <span class="text-[10px] text-gray-400">s/d {{ $assignment->valid_until->translatedFormat('d M Y') }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right align-middle">
                                            <div class="inline-flex items-center gap-2">
                                                <a href="{{ route('admin.proposals.cetak-surat-tugas', $prop) }}"
                                                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-sky-50 hover:bg-sky-100 text-sky-700 text-xs font-bold rounded-xl transition-colors border border-sky-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    Cetak Surat Tugas
                                                </a>
                                                <a href="{{ route('admin.proposals.cpcl.create', $prop) }}"
                                                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl transition-colors border border-emerald-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                                    Input CPCL
                                                </a>
                                                <a href="{{ route('admin.proposals.show', $prop) }}"
                                                   class="inline-flex items-center px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-bold rounded-xl transition-colors border border-gray-100">
                                                    Detail
                                                </a>
                                            </div>
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

