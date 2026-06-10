<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-800 leading-tight">
            {{ __('Revisi Data Registrasi') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-8">
            <div class="mb-8">
                <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    {{ $profile->rejection_reason ? 'Perbaiki Data Registrasi' : 'Perbarui Data Registrasi' }}
                </h3>
                @if($profile->rejection_reason)
                    <p class="text-sm text-gray-500 mt-2">Silakan sesuaikan data Anda dengan catatan revisi dari admin. Pastikan semua informasi yang dimasukkan adalah valid dan terbaru.</p>
                @else
                    <p class="text-sm text-gray-500 mt-2">Silakan perbarui data profil Anda sesuai dengan perubahan yang diinginkan.</p>
                @endif
            </div>

            @if($profile->rejection_reason)
                <div class="mb-8 p-5 bg-amber-50 border border-amber-100 rounded-xl">
                    <h4 class="text-sm font-bold text-amber-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Catatan Revisi dari Admin
                    </h4>
                    <p class="text-sm text-amber-700 font-medium">{{ $profile->rejection_reason }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('farmer.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- NIK (readonly) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">NIK <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik', $profile->nik) }}" required
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm">
                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                    </div>

                    {{-- Nomor WhatsApp --}}
                    <div>
                        <label for="no_wa" class="block text-sm font-bold text-gray-800 mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm"
                               placeholder="08xx-xxxx-xxxx">
                        <x-input-error :messages="$errors->get('no_wa')" class="mt-2" />
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-bold text-gray-800 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3" required
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all sm:text-sm resize-none"
                                  placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $profile->alamat) }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    {{-- Foto KTP --}}
                    <div class="md:col-span-2">
                        <label for="foto_ktp" class="block text-sm font-bold text-gray-800 mb-2">
                            Foto KTP Baru <span class="text-xs text-gray-400 font-normal">(Opsional, maks 5MB, format JPG/PNG)</span>
                        </label>
                        <input type="file" name="foto_ktp" id="foto_ktp" accept=".jpg,.jpeg,.png"
                               class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#19A148]/20 focus:border-[#19A148] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#19A148]/10 file:text-[#19A148] hover:file:bg-[#19A148]/20">
                        @if($profile->foto_ktp)
                            <p class="text-xs text-gray-500 mt-2">Foto saat ini: <a href="{{ Storage::url($profile->foto_ktp) }}" target="_blank" class="text-[#19A148] hover:underline font-semibold">Lihat Foto</a></p>
                        @endif
                        <x-input-error :messages="$errors->get('foto_ktp')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-6 flex justify-end gap-4 border-t border-gray-100 mt-6">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-[#19A148] text-white rounded-xl text-sm font-bold hover:bg-[#15883c] transition-all active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan dan Kirim Ulang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
