<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Program Baru') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.programs.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="name" value="Nama Program" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="type" value="Tipe Program" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="bantuan_permanen">Bantuan Permanen (Hibah)</option>
                                <option value="pinjam_alat">Peminjaman Alat (Alsintan)</option>
                                <option value="usulan_pendanaan">Usulan Pendanaan</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="open_date" value="Tanggal Buka" />
                                <x-text-input id="open_date" name="open_date" type="date" class="mt-1 block w-full" :value="old('open_date')" />
                                <x-input-error class="mt-2" :messages="$errors->get('open_date')" />
                            </div>
                            <div>
                                <x-input-label for="close_date" value="Tanggal Tutup" />
                                <x-text-input id="close_date" name="close_date" type="date" class="mt-1 block w-full" :value="old('close_date')" />
                                <x-input-error class="mt-2" :messages="$errors->get('close_date')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button>{{ __('Simpan Program') }}</x-primary-button>
                            <a href="{{ route('admin.programs.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
