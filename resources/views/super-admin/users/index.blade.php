<x-app-layout>
    <x-slot name="header">Manajemen Role</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="mb-4">
            <h3 class="text-xl font-bold text-gray-900">Role Sistem Inti</h3>
            <p class="text-sm text-gray-500 mt-1">Akun pejabat struktural dan administrator. Role tidak dapat dihapus atau diubah jabatannya.</p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Top Actions: Filter --}}
        <div class="flex flex-col sm:flex-row justify-end items-end sm:items-center gap-3">
            <form method="GET" action="{{ route('super-admin.users.index') }}" class="relative w-full sm:w-auto">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, role..."
                    class="w-full sm:w-72 pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-1000/20 focus:border-gray-900 transition-all shadow-sm">
            </form>
        </div>

        @php
        $fixedUsers = $users->filter(function($u) use ($fixedRoles) {
        return in_array($u->role, $fixedRoles) || $u->roles->whereIn('name', $fixedRoles)->isNotEmpty();
        });
        $dynamicUsers = $users->reject(function($u) use ($fixedRoles) {
        return in_array($u->role, $fixedRoles) || $u->roles->whereIn('name', $fixedRoles)->isNotEmpty();
        });
        @endphp

        {{-- Section 1: Role Tetap (Cards) --}}
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fixedUsers as $user)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition-shadow relative overflow-hidden flex flex-col h-full">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gray-800"></div>

                    <div class="flex-grow">
                        <div class="flex items-start mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $user->name }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="mb-4 flex flex-wrap gap-2 items-center">
                            @forelse($user->roles as $r)
                            <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg border border-gray-200">
                                {{ $r->name }}
                            </span>
                            @empty
                            <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg border border-gray-200">
                                {{ $user->role }}
                            </span>
                            @endforelse
                            <span class="text-[10px] font-bold text-red-500 uppercase tracking-widest bg-red-50 px-2 py-0.5 rounded border border-red-100">Tetap</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-50 flex justify-end mt-auto">
                        <a href="{{ route('super-admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-bold text-sm transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Section 2: Role Dinamis (Table) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-8">
            <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <h3 class="text-xl font-bold text-gray-900">Daftar Pengguna Umum</h3>
                
                <a href="{{ route('super-admin.users.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-black transition-colors shadow-sm w-full sm:w-auto shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pengguna
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nama</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Email</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Role Aktif</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($dynamicUsers as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 text-sm">{{ $user->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center flex-wrap gap-1">
                                    @forelse($user->roles as $r)
                                    <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg border border-gray-200">
                                        {{ $r->name }}
                                    </span>
                                    @empty
                                    <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg border border-gray-200">
                                        {{ $user->role }}
                                    </span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('super-admin.users.edit', $user) }}"
                                        class="inline-flex items-center justify-center bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    @if($user->id !== auth()->id())
                                    <div x-data="{ openDelete: false }" class="inline-block">
                                        <button type="button" @click="openDelete = true"
                                            class="inline-flex items-center justify-center bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        {{-- Delete Modal --}}
                                        <template x-teleport="body">
                                            <div x-show="openDelete" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm px-4">
                                                <div @click.away="openDelete = false"
                                                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                                    class="bg-white rounded-2xl p-6 shadow-xl w-full max-w-sm text-center">
                                                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Pengguna</h3>
                                                    <p class="text-sm text-gray-500 mb-6">Anda yakin ingin menghapus pengguna <span class="font-bold text-gray-900">"{{ $user->name }}"</span>? Data tidak dapat dikembalikan.</p>

                                                    <div class="flex justify-center gap-3">
                                                        <button type="button" @click="openDelete = false" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">Batal</button>
                                                        <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors text-sm">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">Belum Ada Pengguna Dinamis</h3>
                                <p class="text-sm text-gray-500 mt-1">Sistem belum memiliki pengguna dengan hak akses dinamis.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>