<x-app-layout>
    <x-slot name="header">Audit Trail Logs</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Header & Filter --}}
            <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col gap-5">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Jejak Aktivitas Sistem</h3>
                    <p class="text-sm text-gray-500 mt-1">Lacak semua aktivitas pengguna, penambahan, perubahan, dan penghapusan data di dalam sistem.</p>
                </div>
                
                <form id="filterForm" action="{{ route('super-admin.audit-logs.index') }}" method="GET" x-data x-ref="filterForm" class="flex flex-wrap gap-4 items-end pt-2">
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tipe Log</label>
                        <select name="log_name" x-on:change="$refs.filterForm.submit()" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-all bg-white appearance-none" style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                            <option value="" {{ !request()->filled('log_name') ? 'selected' : '' }}>Semua</option>
                            @foreach($logNames as $name)
                                <option value="{{ $name }}" {{ request('log_name') === $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Event</label>
                        <select name="event" x-on:change="$refs.filterForm.submit()" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-all bg-white appearance-none" style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                            <option value="" {{ !request()->filled('event') ? 'selected' : '' }}>Semua</option>
                            @foreach($events as $ev)
                                <option value="{{ $ev }}" {{ request('event') === $ev ? 'selected' : '' }}>{{ strtoupper($ev) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">User (Pelaku)</label>
                        <select name="causer_id" x-on:change="$refs.filterForm.submit()" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-all bg-white appearance-none" style="-webkit-appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                            <option value="" {{ !request()->filled('causer_id') ? 'selected' : '' }}>Semua</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ request('causer_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[140px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Dari Tgl</label>
                        <input type="date" name="date_from" x-on:change="$refs.filterForm.submit()" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-all bg-white">
                    </div>
                    <div class="flex-1 min-w-[140px]">
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Sampai Tgl</label>
                            @if(request()->anyFilled(['log_name', 'event', 'causer_id', 'date_from', 'date_to']))
                                <a href="{{ route('super-admin.audit-logs.index') }}" class="text-[10px] font-bold text-gray-900 hover:text-black uppercase tracking-wider">Reset</a>
                            @endif
                        </div>
                        <input type="date" name="date_to" x-on:change="$refs.filterForm.submit()" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-all bg-white">
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap">Waktu</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Tipe</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Event</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Pelaku</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Deskripsi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Target ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-bold text-gray-900 text-sm">{{ $log->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $log->created_at->format('H:i:s') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-md border border-gray-200">
                                        {{ $log->log_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md border 
                                        {{ $log->event == 'created' || $log->event == 'login' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                                           ($log->event == 'updated' ? 'bg-amber-50 text-amber-700 border-amber-200' : 
                                           ($log->event == 'deleted' || $log->event == 'logout' ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-gray-50 text-gray-700 border-gray-200')) }}">
                                        {{ $log->event }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900 text-sm">{{ $log->causer ? $log->causer->name : 'Sistem' }}</p>
                                    @if($log->causer)
                                        <p class="text-[11px] text-gray-500">{{ $log->causer->email }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $log->description }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    @if($log->subject_type)
                                        <span class="font-mono text-[10px] bg-gray-100 px-1.5 py-1 rounded text-gray-700 border border-gray-200">
                                            {{ class_basename($log->subject_type) }}#{{ $log->subject_id }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('super-admin.audit-logs.show', $log->id) }}" class="inline-flex items-center justify-center bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm" title="Detail">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900">Tidak Ada Log Aktivitas</h3>
                                    <p class="text-gray-500 mt-1 text-sm">Sistem belum mencatat jejak aktivitas yang sesuai dengan kriteria filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Footer Controls & Pagination --}}
            <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30 flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tampilkan:</span>
                    <select name="per_page" form="filterForm" onchange="document.getElementById('filterForm').submit()" class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs text-gray-700 font-bold focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-all bg-white cursor-pointer hover:border-gray-300 shadow-sm">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 baris</option>
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20 baris</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 baris</option>
                    </select>
                </div>
                
                @if(method_exists($logs, 'links') && $logs->hasPages())
                    <div class="w-full">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
