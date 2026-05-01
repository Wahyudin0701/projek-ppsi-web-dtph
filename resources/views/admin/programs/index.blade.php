<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Program') }}
            </h2>
            <a href="{{ route('admin.programs.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-primary-700">
                + Tambah Program
            </a>
        </div>
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
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Nama Program</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Tipe</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Status</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Periode</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programs as $program)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 font-medium">{{ $program->name }}</td>
                                    <td class="p-4">
                                        <span class="capitalize">{{ str_replace('_', ' ', $program->type) }}</span>
                                    </td>
                                    <td class="p-4">
                                        @if($program->is_open)
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">BUKA</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">TUTUP</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm">
                                        {{ $program->open_date?->format('d M Y') ?? '-' }} s/d {{ $program->close_date?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('admin.programs.toggle', $program) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-xs font-bold {{ $program->is_open ? 'text-orange-600' : 'text-green-600' }} hover:underline">
                                                    {{ $program->is_open ? 'Tutup' : 'Buka' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.programs.edit', $program) }}" class="text-xs font-bold text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus program ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500 italic">Belum ada program yang dibuat.</td>
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
