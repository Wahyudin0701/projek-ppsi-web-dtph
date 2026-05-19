<x-app-layout>
    <x-slot name="header">Buat Akun Tim Survei</x-slot>

    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 space-y-5">
            <div>
                <h2 class="font-extrabold text-gray-800 text-xl">Akun Tim Survei Baru</h2>
                <p class="text-sm text-gray-400 mt-1">Akun ini akan digunakan petugas survei untuk login dan mengisi checklist lapangan.</p>
            </div>

            <form action="{{ route('kabid.tim-survei.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="survei@dtph.go.id"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Password *</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('password') border-red-400 @enderror">
                    @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('kabid.tim-survei.index') }}" class="flex-1 text-center py-3 rounded-2xl border border-gray-200 font-bold text-sm text-gray-600 hover:bg-gray-50 transition-all">Batal</a>
                    <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-extrabold py-3 rounded-2xl transition-all shadow-lg shadow-amber-500/30">
                        Buat Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
