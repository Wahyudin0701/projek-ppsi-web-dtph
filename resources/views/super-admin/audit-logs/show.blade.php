<x-app-layout>
    <x-slot name="header">Audit Trail Logs</x-slot>

    <div class="max-w-7xl mx-auto space-y-6 py-6">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Audit Trail Log</h2>
                <p class="text-gray-500 text-sm mt-1">Tinjauan lengkap rekaman log aktivitas sistem.</p>
            </div>
            <a href="{{ route('super-admin.audit-logs.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 md:p-8 border-b border-gray-50">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="inline-flex items-center justify-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md border 
                                {{ $log->event == 'created' || $log->event == 'login' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                                   ($log->event == 'updated' ? 'bg-amber-50 text-amber-700 border-amber-200' : 
                                   ($log->event == 'deleted' || $log->event == 'logout' ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-gray-50 text-gray-700 border-gray-200')) }}">
                                {{ $log->event }}
                            </span>
                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-md border border-gray-200">
                                {{ $log->log_name }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $log->description }}</h3>
                        <p class="text-sm text-gray-500 mt-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $log->created_at->format('d F Y, H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Informasi Pelaku --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Informasi Pelaku</h4>
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        @if($log->causer)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gray-200 text-gray-900 flex items-center justify-center font-bold text-lg">
                                    {{ substr($log->causer->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $log->causer->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $log->causer->email }}</p>
                                    <div class="mt-1">
                                        <span class="inline-block px-2 py-0.5 bg-white border border-gray-200 rounded text-xs text-gray-600 font-medium">ID: {{ $log->causer->id }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">Sistem</p>
                                    <p class="text-sm text-gray-500">Aktivitas dilakukan secara otomatis oleh sistem</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Informasi Target --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Informasi Target (Data)</h4>
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 h-full">
                        @if($log->subject_type)
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Model (Tabel)</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $log->subject_type }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">ID Record</p>
                                    <span class="font-mono text-sm bg-white px-2 py-1 rounded text-gray-800 border border-gray-200">
                                        #{{ $log->subject_id }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                                Tidak ada data target yang tersimpan
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Properti (Perubahan) --}}
            <div class="p-6 md:p-8 pt-0">
                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Data Properti (Perubahan)</h4>
                
                @if($log->properties && count($log->properties) > 0)
                    <div class="bg-[#1e1e1e] rounded-xl overflow-hidden shadow-inner border border-gray-800">
                        <div class="bg-[#2d2d2d] px-4 py-2 border-b border-gray-700 flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-xs text-gray-400 ml-2 font-mono">JSON Payload</span>
                        </div>
                        <div class="p-4 overflow-x-auto">
                            <pre class="text-sm text-green-400 font-mono leading-relaxed">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-8 border border-gray-100 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="text-gray-500">Tidak ada rincian properti atau perubahan data yang dicatat untuk aktivitas ini.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
