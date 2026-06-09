<x-app-layout>
    <x-slot name="header">Manajemen Program</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Program Bantuan</h2>
                <p class="text-gray-500 text-sm mt-1">Dinas Tanaman Pangan dan Hortikultura</p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3">
                {{-- Left Info Side (Visual representation & Code) --}}
                <div class="bg-gray-50 p-6 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                    <div class="w-full aspect-square max-w-xs rounded-2xl bg-emerald-50 border border-emerald-100 flex flex-col items-center justify-center p-6 text-center">
                        <svg class="w-20 h-20 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        <span class="mt-4 block text-xs font-extrabold text-emerald-800 uppercase tracking-widest bg-emerald-100/60 px-3 py-1 rounded-full">
                            {{ $program->category ? $program->category->name : '-' }}
                        </span>
                    </div>
                    <div class="mt-6 text-center w-full">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ID PROGRAM</p>
                        <p class="font-mono text-lg font-bold text-gray-800">#PRG-{{ str_pad($program->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                {{-- Details Side --}}
                <div class="p-8 md:col-span-2 flex flex-col">
                    <div class="mb-6 flex justify-between items-start gap-4">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900 leading-tight mb-2">{{ $program->name }}</h3>
                        </div>
                        <a href="{{ route('admin.programs.edit', $program) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl font-bold text-sm transition-colors border border-amber-200 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Program
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Deskripsi</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $program->description ?: 'Tidak ada deskripsi tersedia untuk program ini.' }}</p>
                        </div>

                        @if($program->sop_description)
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Alur / SOP Program</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $program->sop_description }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-6 my-6 bg-gray-50 p-5 rounded-2xl border border-gray-100 text-sm">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sasaran Program</p>
                            <p class="font-bold text-gray-900">{{ $program->sasaran ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kuota Penerima</p>
                            <p class="font-bold text-gray-900">{{ $program->kuota ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Narahubung (Contact Person)</p>
                            @if($program->contact_person)
                                <p class="font-bold text-gray-900">
                                    {{ $program->contact_person }} 
                                    @if($program->contact_phone)
                                        <span class="text-gray-500 font-normal">({{ $program->contact_phone }})</span>
                                    @endif
                                </p>
                            @else
                                <p class="font-bold text-gray-900">-</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Dokumen Juknis / SOP</p>
                            @if($program->juknis_file)
                                <a href="{{ Storage::url($program->juknis_file) }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-bold mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Unduh Dokumen
                                </a>
                            @else
                                <p class="font-bold text-gray-900">-</p>
                            @endif
                        </div>
                    </div>

                    @if($program->requirements && (is_array($program->requirements) || is_object($program->requirements)) && count($program->requirements) > 0)
                        <div class="mb-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Persyaratan Khusus</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                @foreach($program->requirements as $req)
                                    @if(!empty(trim($req)))
                                        <li class="flex items-start gap-2.5">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>{{ $req }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-auto">
                        <h4 class="text-sm font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Status & Jadwal Pendaftaran</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-white border border-gray-200 rounded-xl p-4 text-center shadow-sm">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Jadwal Dibuka</p>
                                <p class="text-sm font-black text-gray-800">{{ $program->open_date?->format('d M Y') ?? '-' }}</p>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-xl p-4 text-center shadow-sm">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Jadwal Ditutup</p>
                                <p class="text-sm font-black text-red-600">{{ $program->close_date?->format('d M Y') ?? '-' }}</p>
                            </div>
                            <div class="rounded-xl p-4 text-center shadow-sm flex flex-col justify-center items-center {{ $program->status === 'berjalan' ? 'bg-emerald-50 border border-emerald-100 text-emerald-700' : ($program->status === 'belum_berjalan' ? 'bg-amber-50 border border-amber-100 text-amber-700' : 'bg-gray-100 border border-gray-200 text-gray-500') }}">
                                <p class="text-[10px] font-bold uppercase mb-1">Status</p>
                                <p class="text-xs font-black capitalize">
                                    @if($program->status === 'berjalan')
                                        Pendaftaran Buka
                                    @elseif($program->status === 'belum_berjalan')
                                        Belum Dibuka
                                    @else
                                        Selesai
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

