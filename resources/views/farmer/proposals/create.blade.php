<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Usulan Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="mb-8 pb-6 border-b border-gray-100">
                        <span class="text-xs font-bold text-primary-600 uppercase tracking-widest">Informasi Program</span>
                        <h3 class="text-2xl font-extrabold mt-1">{{ $program->name }}</h3>
                        <p class="text-gray-500 mt-2">Tipe: <span class="font-bold text-gray-700 capitalize">{{ str_replace('_', ' ', $program->type) }}</span></p>
                    </div>

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl border-l-4 border-red-500 font-medium">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('farmer.proposals.store', $program) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="lokasi_lahan" value="Lokasi Lahan (Alamat/Koordinat)" />
                            <x-text-input id="lokasi_lahan" name="lokasi_lahan" type="text" class="mt-1 block w-full" :value="old('lokasi_lahan')" required placeholder="Contoh: Desa Makmur, RT 01/RW 02" />
                            <p class="mt-2 text-xs text-gray-500 italic">*Tuliskan lokasi lahan yang akan menjadi objek program/bantuan ini.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('lokasi_lahan')" />
                        </div>

                        <div class="p-4 bg-primary-50 rounded-xl border border-primary-100">
                            <p class="text-sm text-primary-800 leading-relaxed">
                                <strong>Catatan:</strong> Dengan menekan tombol kirim, Anda menyatakan bahwa data yang diisi adalah benar atas nama Kelompok Tani <strong>{{ auth()->user()->nama_kelompok }}</strong>.
                            </p>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="px-8 py-3">{{ __('Kirim Usulan Proposal') }}</x-primary-button>
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
