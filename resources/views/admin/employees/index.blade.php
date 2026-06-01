<x-app-layout>
    <x-slot name="header">Kelola Pegawai</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium mb-6">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Section 1: Pejabat Struktural --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-8">
            <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Form Pejabat Struktural</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola data pejabat struktural yang bertugas di dinas.</p>
                </div>
            </div>
            
            <div class="p-0">
                <form action="{{ route('admin.employees.update-struktur') }}" method="POST">
                    @csrf
                    
                    <div class="border-t border-gray-100">
                        <!-- Desktop Header -->
                        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50/80 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <div class="col-span-4 lg:col-span-3">Jabatan</div>
                            <div class="col-span-8 lg:col-span-9 grid grid-cols-12 gap-4">
                                <div class="col-span-5">Nama Lengkap</div>
                                <div class="col-span-4">NIP</div>
                                <div class="col-span-3">Pangkat/Gol</div>
                            </div>
                        </div>

                        <!-- Rows -->
                        <div class="divide-y divide-gray-50">
                            @foreach($structuralRolesList as $index => $role)
                            @php
                                $emp = $pejabatStruktural->get($role);
                            @endphp
                            <div class="p-6 md:px-6 md:py-4 hover:bg-blue-50/30 transition-colors group">
                                <input type="hidden" name="struktur[{{ $index }}][role]" value="{{ $role }}">
                                
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:items-start">
                                    <!-- Jabatan Label -->
                                    <div class="md:col-span-4 lg:col-span-3 md:pt-2.5">
                                        <p class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500/40 group-hover:bg-blue-500 transition-colors hidden md:block"></span>
                                            {{ $role }}
                                        </p>
                                    </div>
                                    
                                    <!-- Inputs -->
                                    <div class="md:col-span-8 lg:col-span-9 grid grid-cols-1 sm:grid-cols-12 gap-3 sm:gap-4">
                                        <div class="sm:col-span-5">
                                            <label class="block text-xs font-bold text-gray-500 mb-1 md:hidden">Nama Lengkap</label>
                                            <input type="text" name="struktur[{{ $index }}][name]" value="{{ $emp?->name !== 'Belum Diisi' ? $emp?->name : '' }}" placeholder="Nama Lengkap..." class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white transition-all">
                                        </div>
                                        
                                        <div class="sm:col-span-4">
                                            <label class="block text-xs font-bold text-gray-500 mb-1 md:hidden">NIP</label>
                                            <input type="text" name="struktur[{{ $index }}][nip]" value="{{ $emp?->nip }}" placeholder="NIP..." class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white transition-all font-mono">
                                        </div>
                                        
                                        <div class="sm:col-span-3">
                                            <label class="block text-xs font-bold text-gray-500 mb-1 md:hidden">Pangkat/Gol</label>
                                            <input type="text" name="struktur[{{ $index }}][pangkat_gol]" value="{{ $emp?->pangkat_gol }}" placeholder="Pangkat/Gol..." class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white transition-all">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="p-6 md:p-8 bg-gray-50/50 border-t border-gray-100 flex justify-end rounded-b-3xl">
                        <button type="submit" class="bg-blue-600 text-white font-bold px-6 py-2.5 rounded-xl shadow-sm hover:bg-blue-700 hover:shadow transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Section 2: Pegawai Fungsional & Lainnya --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Pegawai Fungsional & Umum</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola data pegawai fungsional dan staf pelaksana.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <form method="GET" action="{{ route('admin.employees.index') }}" class="relative w-full sm:w-auto">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP..."
                            class="w-full sm:w-60 pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </form>

                    <a href="{{ route('admin.employees.create') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 transition-colors shadow-sm self-start sm:self-auto shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Pegawai Lainnya
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nama Lengkap</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">NIP & Golongan</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Jabatan</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Bidang</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($employees as $employee)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900 text-sm">{{ $employee->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600 font-mono mb-1">{{ $employee->nip ?? '-' }}</p>
                                    @if($employee->pangkat_gol)
                                    <p class="text-[10px] uppercase font-bold text-gray-400">{{ $employee->pangkat_gol }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $employee->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($employee->bidang)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            {{ $employee->bidang }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.employees.edit', $employee) }}"
                                           class="inline-flex items-center justify-center bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-amber-600 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        {{-- Delete with modal --}}
                                        <div x-data="{ openDelete: false }" class="inline-block">
                                            <button type="button" @click="openDelete = true"
                                                    class="inline-flex items-center justify-center bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>

                                            <template x-teleport="body">
                                                <div x-show="openDelete" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm px-4">
                                                    <div @click.away="openDelete = false"
                                                         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                                         class="bg-white rounded-2xl p-6 shadow-xl w-full max-w-sm text-center">
                                                        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                        </div>
                                                        <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Data Pegawai</h3>
                                                        <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus data <span class="font-bold text-gray-900">{{ $employee->name }}</span>? Data yang dihapus tidak dapat dikembalikan.</p>
                                                        <div class="flex justify-center gap-3">
                                                            <button type="button" @click="openDelete = false" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                                            <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors text-sm">Ya, Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900">Belum Ada Pegawai Fungsional</h3>
                                    <p class="text-sm text-gray-500 mt-1">Mulai tambahkan data pegawai fungsional/umum.</p>
                                    <a href="{{ route('admin.employees.create') }}"
                                       class="mt-4 inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Pegawai Lainnya
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($employees->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $employees->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
