<x-layouts.public>
    <x-slot:title>Unduh Dokumen - DTPH Muaro Jambi</x-slot:title>
    <x-slot:metaDescription>Pusat unduhan dokumen resmi, pedoman teknis, dan formulir pelayanan publik Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi.</x-slot:metaDescription>

    <div class="bg-[#f8faf9] min-h-screen pb-20">
        {{-- Hero Section --}}
        <div class="bg-white pt-12 md:pt-16 pb-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Unduh Dokumen</h1>
            <div class="mt-4 w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Akses berbagai dokumen resmi, pedoman teknis, peraturan, dan formulir pelayanan publik secara transparan untuk memudahkan kebutuhan Anda.
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <div x-data="{ previewOpen: false, activeDoc: {} }">
                @forelse($dokumen as $kategori => $items)
                    <div x-data="{ open: false }" class="mb-8 bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-sm">
                        {{-- Header Category --}}
                        <button @click="open = !open" class="w-full text-left bg-gray-50/80 hover:bg-gray-100 transition-colors px-5 sm:px-8 py-5 border-b border-gray-200 flex items-center gap-4 cursor-pointer focus:outline-none">
                            <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] text-primary-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800 tracking-tight">{{ $kategori }}</h2>
                            <span class="ml-auto bg-gray-200 text-gray-600 text-xs font-bold px-3 py-1.5 rounded-full hidden sm:block">{{ count($items) }} Berkas</span>
                            
                            {{-- Chevron --}}
                            <div class="ml-2 sm:ml-4 text-gray-400 transform transition-transform duration-300" :class="{ 'rotate-180': open }">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>

                        {{-- Document Items (Table-like rows) --}}
                        <div x-show="open" x-transition.opacity.duration.300ms>
                            <div class="divide-y divide-gray-100">
                                @foreach($items as $item)
                                <div class="p-5 sm:p-8 hover:bg-primary-50/40 transition-colors flex flex-col md:flex-row md:items-center gap-6 group">
                                    {{-- Icon & Info --}}
                                    <div class="flex items-start gap-5 flex-1 min-w-0">
                                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0 group-hover:bg-white group-hover:text-primary-500 group-hover:shadow-md border border-gray-100 group-hover:border-primary-100 transition-all duration-300 group-hover:-translate-y-0.5">
                                            @if($item->file_format === 'PDF')
                                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                            @else
                                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-base sm:text-lg font-bold text-gray-900 group-hover:text-primary-700 transition-colors mb-1.5">{{ $item->title }}</h3>
                                            <p class="text-sm text-gray-500 mb-4 leading-relaxed">{{ $item->description }}</p>
                                            <div class="flex items-center gap-3 text-xs font-semibold text-gray-400">
                                                <span class="flex items-center gap-1.5 bg-gray-100/80 px-2.5 py-1 rounded-md text-gray-600">
                                                    <svg class="w-3.5 h-3.5 {{ $item->file_format === 'PDF' ? 'text-red-500' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    {{ $item->file_format }}
                                                </span>
                                                <span class="text-gray-300">•</span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                                                    {{ $item->file_size }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex flex-row md:flex-row items-center gap-3 shrink-0 mt-2 md:mt-0 ml-17 sm:ml-19 md:ml-0">
                                        @if($item->file_format === 'PDF')
                                            <a href="{{ Storage::url($item->file_path) }}" target="_blank" class="px-4 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:border-primary-300 hover:text-primary-700 hover:bg-primary-50 rounded-xl transition-all flex items-center gap-2 shadow-sm w-full md:w-auto justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                Pratinjau
                                            </a>
                                        @else
                                            <span class="px-4 py-2.5 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-100 rounded-xl cursor-not-allowed flex items-center gap-2 w-full md:w-auto justify-center" title="Format dokumen ini tidak dapat dipratinjau langsung">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                                No Preview
                                            </span>
                                        @endif
                                        <a href="{{ Storage::url($item->file_path) }}" target="_blank" download class="px-4 py-2.5 text-sm font-bold text-white bg-gray-900 hover:bg-primary-600 rounded-xl transition-all flex items-center gap-2 shadow-sm shadow-gray-900/20 hover:shadow-primary-600/30 w-full md:w-auto justify-center group/dl">
                                            <svg class="w-4 h-4 group-hover/dl:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white rounded-3xl border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <h3 class="text-xl font-bold text-gray-700">Belum Ada Dokumen Publik</h3>
                        <p class="text-gray-500 mt-2">Daftar dokumen yang tersedia untuk diunduh akan ditampilkan di sini.</p>
                    </div>
                @endforelse
            </div>

            {{-- Info Banner --}}
            <div class="mt-12 bg-primary-600 rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-xl shadow-primary-600/20">
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0 border border-white/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2 tracking-tight">Butuh Dokumen Lainnya?</h3>
                        <p class="text-white/90 text-sm md:text-base max-w-lg leading-relaxed font-medium">
                            Jika Anda tidak menemukan dokumen yang dicari, silakan hubungi kami untuk permintaan data spesifik.
                        </p>
                    </div>
                </div>
                
                <div class="relative z-10 flex-shrink-0 w-full md:w-auto">
                    <a href="{{ route('kontak') }}" class="inline-flex justify-center w-full md:w-auto items-center gap-2 px-8 py-4 bg-white text-primary-600 hover:bg-primary-50 font-bold text-sm rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-xl">
                        Hubungi Kami
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
