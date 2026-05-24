<x-app-layout>
    <x-slot name="header">Detail Program</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">{{ $program->name }}</h2>
                <p class="text-gray-500 text-sm mt-1">Detail informasi, syarat, dan jadwal program bantuan</p>
            </div>
            <a href="{{ route('farmer.proposals.bantuan') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            {{-- Left Column: Summary & CTA --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Info Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden relative p-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-primary-50 rounded-3xl border border-primary-100 flex items-center justify-center text-primary-600 mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <span class="inline-block rounded-xl bg-gray-100 px-4 py-2 text-xs font-extrabold uppercase tracking-widest text-gray-600 shadow-sm mb-4">
                            {{ str_replace('_', ' ', $program->type) }}
                        </span>
                        @if($program->is_open)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-primary-50 text-primary-700 text-xs font-bold border border-primary-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                                Pendaftaran Buka
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 text-gray-500 text-xs font-bold border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Pendaftaran Ditutup
                            </span>
                        @endif
                    </div>
                </div>

                {{-- CTA Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6 sm:p-8 text-center">
                    <h3 class="font-bold text-gray-900 mb-2">Tertarik dengan Program Ini?</h3>
                    <p class="text-sm text-gray-500 mb-6">Ajukan proposal bantuan sekarang dengan melengkapi form yang tersedia sebelum batas waktu.</p>
                    @if($program->is_open)
                        <a href="{{ route('farmer.proposals.create', $program->id) }}"
                           class="group w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary-600 text-white font-bold text-base rounded-2xl hover:bg-primary-700 hover:shadow-xl hover:shadow-primary-900/20 hover:-translate-y-1 transition-all duration-300">
                            Ajukan Proposal
                            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @else
                        <button disabled class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-gray-100 text-gray-400 font-bold text-base rounded-2xl cursor-not-allowed">
                            Pendaftaran Ditutup
                        </button>
                    @endif
                </div>
            </div>

            {{-- Right Column: Details --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Detail Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 sm:p-10">
                    <h3 class="font-black text-2xl text-gray-900 mb-6">Informasi Program</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Sasaran</p>
                            <p class="font-bold text-gray-800 break-words">{{ $program->sasaran ?? 'Umum / Kelompok Tani' }}</p>
                        </div>
                        <div class="bg-emerald-50 rounded-2xl p-4 border border-emerald-100 text-center">
                            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-1.5">Kuota</p>
                            <p class="font-bold text-emerald-700 text-lg">{{ $program->kuota ?? '-' }}</p>
                        </div>
                        <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 text-center">
                            <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mb-1.5">Terdaftar</p>
                            <p class="font-bold text-amber-700 text-lg">{{ $program->proposals_count ?? '0' }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 text-center">
                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-1.5">Batas Akhir</p>
                            <p class="font-bold text-blue-700">{{ $program->close_date?->format('d M Y') ?? 'Tanpa Batas' }}</p>
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-gray-900 mb-3 border-t border-gray-100 pt-8">Deskripsi</h3>
                    <p class="text-gray-600 leading-relaxed text-justify mb-8">
                        {{ $program->description ?? 'Belum ada deskripsi lengkap untuk program bantuan ini.' }}
                    </p>

                    @if($program->requirements && (is_array($program->requirements) || is_object($program->requirements)) && count($program->requirements) > 0)
                        <h3 class="font-bold text-lg text-gray-900 mb-3 border-t border-gray-100 pt-8">Persyaratan Khusus</h3>
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-8">
                            <ul class="space-y-3">
                                @foreach($program->requirements as $req)
                                    <li class="flex items-start gap-3 text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-primary-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $req }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($program->sop_description)
                        <h3 class="font-bold text-lg text-gray-900 mb-3 border-t border-gray-100 pt-8">Alur / SOP Pengajuan</h3>
                        <div class="bg-blue-50/50 rounded-2xl p-6 border border-blue-100">
                            <div class="text-sm text-blue-800/80 leading-relaxed space-y-2 whitespace-pre-line">
                                {{ $program->sop_description }}
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
