<x-app-layout>
    <x-slot name="header">Edit Surat Tugas dan Tim Survei</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Edit Surat Tugas dan Tim Survei</h2>
                <p class="text-gray-500 text-sm mt-1">Perbarui nomor surat, masa berlaku, dan susunan anggota tim survei.</p>
            </div>
            <a href="{{ route('kabid.proposals.show', $proposal) }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        {{-- Proposal Summary --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md bg-amber-50 text-amber-600">
                {{ $proposal->alsintan_id ? 'Peminjaman Alsintan' : 'Program Bantuan' }}
            </span>
            <h3 class="text-xl font-extrabold text-gray-800 mt-2">
                {{ $proposal->program?->name ?? $proposal->alsintan?->name ?? 'Proposal' }}
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Kelompok Tani: <span class="font-bold text-gray-800">{{ $proposal->user->farmerProfile?->nama_kelompok ?? $proposal->user->name }}</span>
            </p>
        </div>

        {{-- Edit Assignment Form --}}
        @php
            $initialMembers = old('team_members', $assignment->team_members ?? [['name' => '', 'nip' => '', 'role' => '']]);
        @endphp
        <form action="{{ route('kabid.proposals.assignment.update', [$proposal, $assignment]) }}" method="POST"
              class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6"
              x-data="{ 
                employees: {{ json_encode($employees) }},
                members: {{ json_encode($initialMembers) }},
                validFrom: '{{ old('valid_from', $assignment->valid_from->format('Y-m-d')) }}'
              }">
            @csrf
            @method('PATCH')

            <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-2xl">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-blue-700 font-medium">Anda sedang mengedit surat tugas <span class="font-bold">{{ $assignment->nomor_surat }}</span> yang diterbitkan pada {{ $assignment->created_at->translatedFormat('d F Y') }}.</p>
            </div>

            <h3 class="font-extrabold text-gray-800 text-lg">Konfigurasi Penugasan</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Nomor Surat Tugas *</label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $assignment->nomor_surat) }}" required placeholder="Misal: 001/80.a/Kep-PPK/DTPH/2026"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('nomor_surat') border-red-400 @enderror">
                    @error('nomor_surat')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Berlaku Dari *</label>
                    <input type="date" name="valid_from" x-model="validFrom" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('valid_from') border-red-400 @enderror">
                    @error('valid_from')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Berlaku Sampai *</label>
                    <input type="date" name="valid_until" value="{{ old('valid_until', $assignment->valid_until->format('Y-m-d')) }}" :min="validFrom" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('valid_until') border-red-400 @enderror">
                    @error('valid_until')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="border-t border-gray-50 pt-5">
                <label class="block text-sm font-bold text-gray-700 mb-4">Susunan Anggota Tim Survei *</label>

                <div class="space-y-4">
                    <template x-for="(member, index) in members" :key="index">
                        <div class="bg-gray-50/50 p-5 rounded-2xl border border-gray-100 relative">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Pegawai *</label>
                                    <select @change="let emp = employees.find(e => e.id == $event.target.value); if(emp) { member.name = emp.name; member.nip = emp.nip; member.role = emp.role; } else { member.name = ''; member.nip = ''; member.role = ''; }"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                                        <option value="">-- Pilih Pegawai --</option>
                                        <template x-for="emp in employees" :key="emp.id">
                                            <option :value="emp.id" 
                                                    :selected="member.name === emp.name" 
                                                    :disabled="members.some((m, idx) => m.name === emp.name && idx !== index)"
                                                    x-text="emp.name + ' (' + emp.role + ')' + (members.some((m, idx) => m.name === emp.name && idx !== index) ? ' - Sudah Dipilih' : '')">
                                            </option>
                                        </template>
                                    </select>
                                    
                                    <!-- Hidden inputs for form submission -->
                                    <input type="hidden" x-model="member.name" :name="'team_members['+index+'][name]'">
                                    <input type="hidden" x-model="member.nip" :name="'team_members['+index+'][nip]'">
                                    <input type="hidden" x-model="member.role" :name="'team_members['+index+'][role]'">
                                </div>
                            </div>
                            <button type="button" @click="members.splice(index, 1)" x-show="members.length > 1"
                                    class="absolute top-3 right-3 p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors"
                                    title="Hapus Anggota">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="members.push({name: '', nip: '', role: ''})"
                        class="mt-4 text-sm font-bold text-amber-600 hover:text-amber-700 flex items-center gap-1">
                    <span>+ Tambah Anggota Tim</span>
                </button>
                @error('team_members')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('kabid.proposals.show', $proposal) }}"
                   class="flex-1 text-center py-3.5 rounded-2xl border border-gray-200 font-bold text-sm text-gray-600 hover:bg-gray-50 transition-all order-2 sm:order-1">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-extrabold py-3.5 rounded-2xl transition-all shadow-lg shadow-amber-500/30 order-1 sm:order-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
