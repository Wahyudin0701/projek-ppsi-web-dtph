<x-app-layout>
    <x-slot name="header">Pusat Pesan & Bantuan</x-slot>

    <div class="max-w-7xl mx-auto space-y-8" x-data="{ activeMessage: null }">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Pusat Pesan</h2>
                <p class="text-sm text-gray-500 mt-1">Pantau feedback dan jawaban dari Admin mengenai pertanyaan Anda.</p>
            </div>
            <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Kirim Pesan Baru
            </a>
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Message List --}}
            <div class="lg:col-span-4 space-y-4">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.15em] px-1">Daftar Pesan</h3>
                
                <div class="space-y-3">
                    @php
                        $mockMessages = [
                            [
                                'id' => 1,
                                'subject' => 'Informasi Program Alsintan III',
                                'date' => '02 Mei 2025',
                                'status' => 'replied',
                                'preview' => 'Halo Admin, saya ingin menanyakan syarat khusus untuk kelompok tani padi...',
                                'response' => 'Terima kasih atas pertanyaannya Bapak/Ibu. Untuk program Tahap III, syarat utamanya adalah...',
                                'admin_name' => 'Admin DTPH (Budi)',
                                'response_date' => '02 Mei 2025'
                            ],
                            [
                                'id' => 2,
                                'subject' => 'Kendala Upload Proposal',
                                'date' => '01 Mei 2025',
                                'status' => 'pending',
                                'preview' => 'Saya mengalami kendala saat mengunggah dokumen persyaratan...',
                                'response' => null,
                                'admin_name' => null,
                                'response_date' => null
                            ],
                        ];
                    @endphp

                    @foreach($mockMessages as $msg)
                    <button @click="activeMessage = {{ json_encode($msg) }}"
                        class="w-full text-left bg-white p-5 rounded-2xl border transition-all duration-300 group"
                        :class="activeMessage && activeMessage.id === {{ $msg['id'] }} ? 'border-emerald-500 ring-4 ring-emerald-500/10 shadow-md' : 'border-gray-100 hover:border-gray-300 shadow-sm'">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $msg['date'] }}</span>
                            @if($msg['status'] === 'replied')
                                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                            @else
                                <span class="flex h-2 w-2 rounded-full bg-amber-400"></span>
                            @endif
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-1 group-hover:text-emerald-600 transition-colors">{{ $msg['subject'] }}</h4>
                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ $msg['preview'] }}</p>
                        
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-[10px] font-black uppercase {{ $msg['status'] === 'replied' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $msg['status'] === 'replied' ? 'Sudah Dijawab' : 'Menunggu Jawaban' }}
                            </span>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-emerald-500 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Message Detail View --}}
            <div class="lg:col-span-8">
                <template x-if="!activeMessage">
                    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-12 flex flex-col items-center justify-center text-center h-full min-h-[450px]">
                        <div class="w-20 h-20 bg-gray-50 text-gray-200 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-800 mb-2">Pilih Pesan</h3>
                        <p class="text-sm text-gray-400 max-w-xs">Silakan pilih pesan di sebelah kiri untuk melihat feedback dan detail percakapan dari Admin.</p>
                    </div>
                </template>

                <template x-if="activeMessage">
                    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full min-h-[450px]">
                        {{-- Detail Header --}}
                        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                            <div>
                                <h3 class="font-extrabold text-gray-800 text-lg leading-tight" x-text="activeMessage.subject"></h3>
                                <p class="text-xs text-gray-400 mt-1" x-text="'Dikirim pada ' + activeMessage.date"></p>
                            </div>
                            <button @click="activeMessage = null" class="text-gray-400 hover:text-gray-600 lg:hidden">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- Conversation Bubble Area --}}
                        <div class="p-8 space-y-8 flex-1 overflow-y-auto">
                            
                            {{-- User Message --}}
                            <div class="flex items-start gap-4 max-w-[90%]">
                                <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center flex-shrink-0 text-gray-400 font-bold text-sm">
                                    Me
                                </div>
                                <div class="bg-gray-100 rounded-3xl rounded-tl-none p-5 text-gray-700 text-sm leading-relaxed">
                                    <p x-text="activeMessage.preview"></p>
                                </div>
                            </div>

                            {{-- Admin Response --}}
                            <template x-if="activeMessage.status === 'replied'">
                                <div class="flex items-start gap-4 max-w-[90%] ml-auto flex-row-reverse">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-600 flex items-center justify-center flex-shrink-0 text-white shadow-lg shadow-emerald-600/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>
                                    <div class="bg-emerald-50 border border-emerald-100 rounded-3xl rounded-tr-none p-5 text-emerald-900 text-sm leading-relaxed shadow-sm">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="font-black text-[10px] uppercase tracking-wider text-emerald-700" x-text="activeMessage.admin_name"></span>
                                            <span class="text-[9px] text-emerald-400" x-text="activeMessage.response_date"></span>
                                        </div>
                                        <p x-text="activeMessage.response"></p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="activeMessage.status === 'menunggu'">
                                <div class="flex items-center justify-center py-10 opacity-50 italic text-gray-400 text-sm">
                                    Menunggu respon dari Admin...
                                </div>
                            </template>
                        </div>

                        {{-- Action Area --}}
                        <div class="px-8 py-6 border-t border-gray-50">
                            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-[11px] text-amber-800 leading-relaxed font-medium">
                                    Untuk keamanan data, semua percakapan dipantau oleh sistem. Admin akan membalas pesan Anda maksimal 1x24 jam pada hari kerja.
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
