<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Akun Kelompok Tani') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Nama Kelompok</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Ketua</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Kontak</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Alamat</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingUsers as $user)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4">{{ $user->nama_kelompok }}</td>
                                    <td class="p-4">{{ $user->ketua }}</td>
                                    <td class="p-4">{{ $user->kontak }}</td>
                                    <td class="p-4">{{ $user->alamat }}</td>
                                    <td class="p-4">
                                        <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-primary-700">Setujui</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500 italic">Tidak ada antrean verifikasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
