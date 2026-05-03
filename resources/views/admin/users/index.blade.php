<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Akun Kelompok Tani') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
            {{-- Header Stats/Title --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Verifikasi Kelompok Tani</h2>
                    <p class="text-sm text-gray-500 font-medium mt-1">Kelola pendaftaran baru dan berikan akses ke sistem E-Proposal.</p>
                </div>
                <div class="flex items-center gap-3 bg-white px-4 py-2.5 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Antrean</p>
                        <p class="text-lg font-black text-gray-900 leading-none mt-1">{{ $pendingUsers->count() }} Akun</p>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in-down">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Data Kelompok</th>
                                <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Ketua / NIK</th>
                                <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Informasi Kontak</th>
                                <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($pendingUsers as $user)
                            <tr class="group hover:bg-gray-50/50 transition-colors {{ $user->status === 'menunggu' ? 'bg-amber-50/30' : '' }}">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        @if($user->status === 'menunggu')
                                            <span class="flex-shrink-0 w-2 h-2 rounded-full bg-amber-500 animate-pulse" title="Baru"></span>
                                        @else
                                            <span class="flex-shrink-0 w-2 h-2 rounded-full bg-slate-300" title="Sudah Dilihat"></span>
                                        @endif
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900">{{ $user->nama_kelompok }}</span>
                                            <span class="text-xs text-gray-500 mt-0.5">Terdaftar: {{ $user->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800 text-sm">{{ $user->ketua }}</span>
                                        <span class="text-xs text-gray-400 font-mono mt-1">{{ $user->nik_ketua ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2 text-xs font-bold text-gray-600">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                            {{ $user->email }}
                                        </div>
                                        <div class="flex items-center gap-2 text-xs font-bold text-gray-600">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $user->kontak }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-xs font-black transition-all shadow-sm
                                              {{ $user->status === 'menunggu' 
                                                 ? 'bg-[#19A148] text-white hover:bg-[#15883c] hover:shadow-md' 
                                                 : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <h3 class="font-extrabold text-gray-900">Semua Terverifikasi</h3>
                                        <p class="text-sm text-gray-500 mt-1">Tidak ada antrean verifikasi untuk saat ini.</p>
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
