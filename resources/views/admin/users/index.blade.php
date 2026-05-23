<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Akun Kelompok Tani') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        {{-- Header Stats/Title --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Verifikasi Kelompok Tani</h2>
                <p class="text-sm text-gray-500 font-medium mt-1">Tinjau permohonan pendaftaran dan berikan akses sistem.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Menunggu</p>
                    <p class="text-xl font-black text-gray-900 leading-none mt-1">{{ $pendingUsers->count() }} Antrean</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in-down">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Modern List / Data Grid --}}
        <div class="space-y-4">
            @forelse($pendingUsers as $user)
                <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-blue-200 hover:shadow-md transition-all relative overflow-hidden">
                    
                    {{-- Color Accent Bar --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $user->farmerProfile->status === 'menunggu' ? 'bg-amber-400' : 'bg-purple-500' }}"></div>

                    <div class="flex items-start gap-5 pl-2">
                        {{-- Avatar --}}
                        <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xl shrink-0 group-hover:scale-105 transition-transform">
                            {{ substr($user->farmerProfile->nama_kelompok ?? 'K', 0, 1) }}
                        </div>

                        {{-- Info --}}
                        <div>
                            <div class="flex items-center gap-3 mb-1.5">
                                <h3 class="font-extrabold text-gray-900 text-lg">{{ $user->farmerProfile->nama_kelompok }}</h3>
                                
                                @if($user->farmerProfile->status === 'menunggu')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-black tracking-widest uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Baru
                                    </span>
                                @elseif($user->farmerProfile->status === 'pengajuan_revisi')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 text-[10px] font-black tracking-widest uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                                        Ubah Data
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black tracking-widest uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Reviewed
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 mt-2">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span class="font-semibold">{{ $user->farmerProfile->ketua }}</span>
                                    <span class="text-xs text-gray-400 font-mono">({{ $user->farmerProfile->nik_ketua ?? '-' }})</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg>
                                    {{ $user->email }}
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600 md:col-span-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $user->farmerProfile->kontak }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="flex-shrink-0 pl-2 md:pl-0">
                        <a href="{{ route('admin.users.show', $user) }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-blue-50 text-blue-600 hover:bg-blue-600 hover:border-blue-600 hover:text-white rounded-xl font-extrabold text-sm transition-all group/btn shadow-sm hover:shadow-md">
                            Tinjau Akun
                            <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <p class="text-right text-[10px] text-gray-400 mt-2 font-medium">Terdaftar: {{ $user->created_at->diffForHumans() }}</p>
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-20 text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-xl mb-2">Antrean Kosong</h3>
                    <p class="text-gray-500">Semua pendaftar kelompok tani telah diverifikasi.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

