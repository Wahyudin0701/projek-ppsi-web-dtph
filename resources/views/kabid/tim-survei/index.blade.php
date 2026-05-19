<x-app-layout>
    <x-slot name="header">Manajemen Tim Survei</x-slot>

    <div class="space-y-6">
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-4 text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Header Action --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-gray-800">Daftar Tim Survei</h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ $surveyors->count() }} akun terdaftar</p>
            </div>
            <a href="{{ route('kabid.tim-survei.create') }}"
               class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm px-5 py-2.5 rounded-2xl transition-all shadow-lg shadow-amber-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Tim Survei
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            @forelse($surveyors as $surveyor)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                <div class="w-11 h-11 rounded-full bg-teal-100 flex items-center justify-center font-extrabold text-teal-700 flex-shrink-0">
                    {{ substr($surveyor->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-sm text-gray-800">{{ $surveyor->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $surveyor->email }}</p>
                </div>
                <div class="text-xs text-gray-400 hidden sm:block">
                    Bergabung {{ $surveyor->created_at->format('d M Y') }}
                </div>
                <form action="{{ route('kabid.tim-survei.destroy', $surveyor) }}" method="POST"
                      onsubmit="return confirm('Hapus akun {{ $surveyor->name }}? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
            @empty
            <div class="py-16 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <p class="font-bold text-sm">Belum ada Tim Survei</p>
                <a href="{{ route('kabid.tim-survei.create') }}" class="text-amber-500 font-bold text-sm hover:underline mt-2 inline-block">+ Buat akun pertama</a>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
