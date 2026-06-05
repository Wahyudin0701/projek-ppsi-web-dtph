<x-app-layout>
    <x-slot:title>Detail Pesan Masuk</x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Detail Pesan</h1>
            <p class="text-sm text-gray-500 mt-1">Baca pesan dan berikan tanggapan kepada pengguna.</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Detail Pesan --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-lg">
                            {{ substr($contact->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">{{ $contact->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $contact->email }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-900">{{ $contact->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $contact->created_at->format('H:i') }} WIB</p>
                    </div>
                </div>
                
                <div class="p-6 bg-gray-50/50">
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Subjek</span>
                        <h3 class="text-md font-bold text-gray-900 mt-1">{{ ucfirst($contact->subject) }}</h3>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pesan</span>
                        <div class="mt-2 text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</div>
                    </div>
                </div>
            </div>

            {{-- Form Balasan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">Tanggapan Admin</h3>
                </div>
                
                <div class="p-6">
                    @if($contact->status == 'replied')
                        <div class="mb-4 p-4 bg-green-50 border border-green-100 rounded-xl">
                            <div class="flex items-center gap-2 mb-2 text-green-700 font-bold text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Telah ditanggapi pada {{ $contact->replied_at->format('d M Y, H:i') }} WIB
                            </div>
                            <div class="text-sm text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $contact->reply_message }}</div>
                        </div>
                        
                        <div class="mt-6 border-t border-gray-100 pt-6">
                            <h4 class="text-sm font-bold text-gray-900 mb-2">Perbarui Tanggapan</h4>
                            <p class="text-xs text-gray-500 mb-4">Anda dapat memperbarui pesan balasan ini jika diperlukan.</p>
                    @endif

                    <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                        @csrf
                        <textarea name="reply_message" rows="5" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm text-sm"
                                  placeholder="Tulis balasan pesan di sini...">{{ old('reply_message', $contact->reply_message) }}</textarea>
                        
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-md">
                                {{ $contact->status == 'pending' ? 'Kirim Balasan' : 'Update Balasan' }}
                            </button>
                        </div>
                    </form>

                    @if($contact->status == 'replied')
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Info Panel --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6">
                <h3 class="text-md font-bold text-gray-900 mb-4">Informasi Pengguna</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">ID Pengguna</span>
                        <span class="text-sm font-bold text-primary-600 mt-1 block">#{{ $contact->user_id }}</span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Status Pesan</span>
                        <div class="mt-1">
                            @if($contact->status == 'pending')
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-lg bg-amber-100 text-amber-800">Menunggu</span>
                            @else
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-lg bg-green-100 text-green-800">Dibalas</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-xs text-gray-500 leading-relaxed">Balasan yang Anda kirimkan akan masuk ke menu <strong>Pusat Pesan</strong> pada dasbor pengguna terkait.</p>
                </div>
            </div>
        </div>
        
    </div>
</x-app-layout>
