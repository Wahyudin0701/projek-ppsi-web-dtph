<x-app-layout>
    <x-slot name="header">Dashboard Super Admin</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        
        {{-- ===== WELCOME BANNER ===== --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black p-7 text-white shadow-lg shadow-gray-900/30">
            <div class="pointer-events-none absolute -right-10 -top-10 h-56 w-56 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute -bottom-8 right-32 h-36 w-36 rounded-full bg-white/5"></div>
            <div class="pointer-events-none absolute right-20 top-4 h-24 w-24 rounded-full bg-white/8"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-1 text-xs font-bold text-gray-200 mb-3 border border-white/10">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Sistem Administrator (IT)
                    </div>
                    <h2 class="mb-2 text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->display_name }}</h2>
                    <p class="max-w-xl text-sm text-gray-200 leading-relaxed hidden sm:block">
                        Anda adalah pengelola teknis dengan hak akses tertinggi. Peran utama Anda mencakup manajemen pengguna serta pengawasan aktivitas seluruh pengguna melalui fitur Jejak Aktivitas untuk menjaga keamanan dan keandalan sistem.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('super-admin.users.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-900 shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Manajemen Role
                    </a>
                    <p class="text-[11px] text-gray-300 font-medium text-right mt-2">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Total Pengguna --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-gray-100 text-gray-900 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-gray-200 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Total Pengguna</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ $stats['total_users'] }}</p>
                </div>
            </div>

            {{-- Roles --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-gray-100 text-gray-900 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-gray-200 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Roles</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ $stats['total_roles'] }}</p>
                </div>
            </div>


            {{-- Aktivitas Tercatat --}}
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 group">
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-rose-100 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase tracking-widest">Aktivitas Tercatat</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 leading-none tracking-tight">{{ $stats['recent_logs'] }}</p>
                </div>
            </div>
        </div>

        {{-- ===== RECENT LOGS ===== --}}
        <div>
            <div class="flex items-center justify-between mb-5 px-1">
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Aktivitas Terkini</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Jejak aktivitas (Audit Trail) terbaru dalam sistem</p>
                </div>
                <a href="{{ route('super-admin.audit-logs.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-bold text-gray-900 hover:underline whitespace-nowrap flex-shrink-0">
                    Lihat Semua
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-400 text-xs font-bold uppercase tracking-wider">
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">Pelaku</th>
                                <th class="px-6 py-4 text-center">Event</th>
                                <th class="px-6 py-4">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($latestLogs as $log)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 align-middle text-sm text-gray-500 whitespace-nowrap">
                                        {{ $log->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 align-middle font-bold text-gray-900 text-sm">
                                        {{ $log->causer ? $log->causer->name : 'Sistem' }}
                                    </td>
                                    <td class="px-6 py-4 align-middle text-center">
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md border 
                                            {{ $log->event == 'created' || $log->event == 'login' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                                               ($log->event == 'updated' ? 'bg-amber-50 text-amber-700 border-amber-200' : 
                                               ($log->event == 'deleted' || $log->event == 'logout' ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-gray-50 text-gray-700 border-gray-200')) }}">
                                            {{ $log->event }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-middle text-sm text-gray-600">
                                        {{ $log->description }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-medium">
                                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        Tidak ada log aktivitas ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
