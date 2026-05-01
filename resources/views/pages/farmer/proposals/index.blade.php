<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Usulan Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
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
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Tanggal</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Program</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500">Lokasi Lahan</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-500 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proposals as $proposal)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 text-sm">{{ $proposal->submission_date->format('d M Y') }}</td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900">{{ $proposal->program->name }}</div>
                                        <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ str_replace('_', ' ', $proposal->program->type) }}</div>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $proposal->lokasi_lahan }}</td>
                                    <td class="p-4 text-center">
                                        @php
                                            $statusColors = [
                                                'pending_verifikasi' => 'bg-yellow-100 text-yellow-700',
                                                'disetujui' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                            ];
                                            $color = $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $color }}">
                                            {{ str_replace('_', ' ', $proposal->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-gray-500 italic">Anda belum pernah mengajukan proposal usulan.</td>
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
