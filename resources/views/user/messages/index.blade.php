<x-app-layout>
    <x-slot:title>Pusat Pesan</x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Pusat Pesan</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar pesan Anda ke Admin dan balasannya.</p>
        </div>
        <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-md">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tulis Pesan Baru
        </a>
    </div>

    <div class="space-y-6">
        @forelse($messages as $msg)
            <div class="bg-white rounded-2xl shadow-sm border {{ $msg->status == 'replied' ? 'border-primary-100' : 'border-gray-200' }} overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">{{ ucfirst($msg->subject) }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Dikirim pada {{ $msg->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        @if($msg->status == 'pending')
                            <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-bold rounded-lg bg-amber-50 text-amber-600 border border-amber-200">
                                <svg class="w-4 h-4 animate-spin-slow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Menunggu Balasan
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-bold rounded-lg bg-green-50 text-green-600 border border-green-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Dibalas Admin
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Pesan Anda --}}
                <div class="p-6 bg-gray-50/50">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-gray-900 mb-2">Pesan Anda:</h3>
                            <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap bg-white p-4 rounded-xl border border-gray-100">{{ $msg->message }}</div>
                        </div>
                    </div>
                </div>

                {{-- Balasan Admin --}}
                @if($msg->status == 'replied')
                <div class="p-6 border-t border-primary-50 bg-primary-50/30">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-bold text-primary-900">Balasan Admin:</h3>
                                <span class="text-xs text-primary-600 font-medium">{{ $msg->replied_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <div class="text-sm text-gray-800 leading-relaxed whitespace-pre-wrap bg-white p-4 rounded-xl border border-primary-100 shadow-sm">{{ $msg->reply_message }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Belum ada pesan</h2>
                <p class="text-gray-500 max-w-md mx-auto mb-8">Anda belum pernah mengirimkan pesan apapun melalui form Kontak Kami. Silakan kirim pesan jika Anda membutuhkan bantuan.</p>
                <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-md">
                    Mulai Tulis Pesan
                </a>
            </div>
        @endforelse

        @if($messages->hasPages())
            <div class="mt-6">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
