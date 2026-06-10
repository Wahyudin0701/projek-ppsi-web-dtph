<x-app-layout>
    <x-slot name="header">Kelola Kontak & Pesan Masuk</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Kontak</h1>
            <p class="text-sm text-gray-500 mt-1">Atur informasi kontak publik dan kelola pesan masuk dari pengguna.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ====== FORM PENGATURAN INFORMASI KONTAK ====== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-8 overflow-hidden" x-data="{ open: false }">
        <button type="button" @click="open = !open"
            class="w-full px-6 py-5 flex items-center gap-3 hover:bg-gray-50/70 transition-colors text-left">
            <div class="w-9 h-9 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="flex-1">
                <h2 class="text-base font-bold text-gray-900">Informasi Kontak Publik</h2>
                <p class="text-xs text-gray-500 mt-0.5">Klik untuk mengatur alamat, telepon, email, dan jam operasional yang tampil di situs publik.</p>
            </div>
            <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>

        <div x-show="open" x-collapse>
        <div class="border-t border-gray-100">
        <form action="{{ route('admin.contacts.settings.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label for="contact_address" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Alamat Kantor
                    </label>
                    <input type="text" id="contact_address" name="contact_address"
                        value="{{ old('contact_address', $settings['contact_address']) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                        placeholder="Komplek Perkantoran...">
                    @error('contact_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>


                {{-- Ext --}}
                <div>
                    <label for="contact_phone_ext" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Telepon Kantor (Opsional)
                    </label>
                    <input type="text" id="contact_phone_ext" name="contact_phone_ext"
                        value="{{ old('contact_phone_ext', $settings['contact_phone_ext']) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                        placeholder="(0741) xxxxxx">
                    @error('contact_phone_ext')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="contact_email" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Email Layanan
                    </label>
                    <input type="email" id="contact_email" name="contact_email"
                        value="{{ old('contact_email', $settings['contact_email']) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                        placeholder="email@dtph-muarojambi.go.id">
                    @error('contact_email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Jam Operasional --}}
                <div>
                    <label for="contact_hours" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Hari Operasional
                    </label>
                    <input type="text" id="contact_hours" name="contact_hours"
                        value="{{ old('contact_hours', $settings['contact_hours']) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                        placeholder="Senin — Jumat">
                    @error('contact_hours')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="contact_hours_time" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Jam Operasional
                    </label>
                    <input type="text" id="contact_hours_time" name="contact_hours_time"
                        value="{{ old('contact_hours_time', $settings['contact_hours_time']) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                        placeholder="08.00 - 16.00 WIB">
                    @error('contact_hours_time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

            </div>

            {{-- Divider --}}
            <div class="mt-6 border-t border-gray-100 pt-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Media Sosial</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- WhatsApp --}}
                    <div>
                        <label for="social_whatsapp" class="block text-sm font-bold text-gray-700 mb-1.5">
                            WhatsApp
                        </label>
                        <input type="text" id="social_whatsapp" name="social_whatsapp"
                            value="{{ old('social_whatsapp', $settings['social_whatsapp'] ?? '') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                            placeholder="+62 812-xxxx-xxxx">
                        @error('social_whatsapp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Facebook --}}
                    <div>
                        <label for="social_facebook" class="block text-sm font-bold text-gray-700 mb-1.5">
                            Facebook
                        </label>
                        <input type="url" id="social_facebook" name="social_facebook"
                            value="{{ old('social_facebook', $settings['social_facebook']) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                            placeholder="https://facebook.com/...">
                        @error('social_facebook')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Instagram --}}
                    <div>
                        <label for="social_instagram" class="block text-sm font-bold text-gray-700 mb-1.5">
                            Instagram
                        </label>
                        <input type="url" id="social_instagram" name="social_instagram"
                            value="{{ old('social_instagram', $settings['social_instagram']) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                            placeholder="https://instagram.com/...">
                        @error('social_instagram')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Twitter/X --}}
                    <div>
                        <label for="social_twitter" class="block text-sm font-bold text-gray-700 mb-1.5">
                            Twitter / X
                        </label>
                        <input type="url" id="social_twitter" name="social_twitter"
                            value="{{ old('social_twitter', $settings['social_twitter']) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                            placeholder="https://x.com/...">
                        @error('social_twitter')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Maps Embed --}}
            <div class="mt-6 border-t border-gray-100 pt-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Peta Lokasi (Google Maps Embed)</p>
                <p class="text-xs text-gray-400 mb-4">Salin URL <code class="bg-gray-100 px-1 rounded">src</code> dari kode embed Google Maps (buka Google Maps → Bagikan → Sematkan peta → salin URL dari atribut src).</p>
                <div>
                    <label for="maps_embed_url" class="block text-sm font-bold text-gray-700 mb-1.5">
                        URL Embed Google Maps
                    </label>
                    <input type="url" id="maps_embed_url" name="maps_embed_url"
                        value="{{ old('maps_embed_url', $settings['maps_embed_url']) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm shadow-sm transition-colors"
                        placeholder="https://www.google.com/maps/embed?pb=...">
                    @error('maps_embed_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>


            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-md text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Informasi Kontak
                </button>
            </div>
        </form>
        </div>
        </div>
    </div>

    {{-- ====== TABEL PESAN MASUK ====== --}}
    <div class="mb-4">
        <h2 class="text-lg font-bold text-gray-800">Pesan Masuk</h2>
        <p class="text-sm text-gray-500">Daftar pesan dan pertanyaan yang masuk dari pengguna.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengirim</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Subjek</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50/50 transition-colors {{ $contact->status == 'pending' ? 'bg-amber-50/30' : '' }}">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $contact->name }}</div>
                            <div class="text-xs text-gray-500">{{ $contact->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-semibold">{{ ucfirst($contact->subject) }}</div>
                            <div class="text-sm text-gray-500 line-clamp-1 mt-1">{{ $contact->message }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($contact->status == 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                    Menunggu Balasan
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Sudah Dibalas
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $contact->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $contact->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg font-bold transition-colors">
                                Lihat / Balas
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                <p class="text-base font-medium text-gray-500">Belum ada pesan masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contacts->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
