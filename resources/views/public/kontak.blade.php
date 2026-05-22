<x-layouts.public>
    <x-slot:title>Kontak Kami - DTPH Muaro Jambi</x-slot:title>
    <x-slot:metaDescription>Hubungi Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi untuk informasi lebih lanjut mengenai program bantuan dan layanan pertanian.</x-slot:metaDescription>

    <div class="bg-[#f8faf9] min-h-screen" x-data="contactPage({{ auth()->check() ? 'true' : 'false' }})">
        
        {{-- Hero Section --}}
        <div class="bg-white py-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight pb-3">Hubungi Kami</h1>
            <div class="mt-4 w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Punya pertanyaan mengenai program bantuan atau butuh bantuan teknis? Tim kami siap melayani Anda. Hubungi kami melalui kanal di bawah ini.
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                {{-- Left Side: Contact Information --}}
                <div class="lg:col-span-5 space-y-8">
                    <div class="space-y-6">
                        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Informasi Kontak</h2>
                        <p class="text-gray-500 text-sm leading-relaxed">Silakan kunjungi kantor kami atau hubungi kami melalui telepon dan email pada jam kerja.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                        {{-- Address Card --}}
                        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-[0_6px_30px_-10px_rgba(0,0,0,0.04)] group hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.08)] transition-all duration-500">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-500 group-hover:text-white transition-all duration-500 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kantor Kami</h3>
                                    <p class="text-sm font-bold text-gray-900 leading-snug">Komplek Perkantoran Bukit Cinto Kenang, Sengeti, Kabupaten Muaro Jambi, Jambi 36381</p>
                                </div>
                            </div>
                        </div>

                        {{-- Phone Card --}}
                        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-[0_6px_30px_-10px_rgba(0,0,0,0.04)] group hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.08)] transition-all duration-500">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-500 group-hover:text-white transition-all duration-500 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Telepon & WhatsApp</h3>
                                    <p class="text-sm font-bold text-gray-900 leading-snug">+62 812-3456-7890</p>
                                    <p class="text-xs text-gray-400 mt-1 font-medium">(0741) 123456</p>
                                </div>
                            </div>
                        </div>

                        {{-- Email Card --}}
                        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-[0_6px_30px_-10px_rgba(0,0,0,0.04)] group hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.08)] transition-all duration-500">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Email Layanan</h3>
                                    <p class="text-sm font-bold text-gray-900 leading-snug">kontak@dtph-muarojambi.go.id</p>
                                    <p class="text-xs text-gray-400 mt-1 font-medium">Respon dalam 24 jam</p>
                                </div>
                            </div>
                        </div>

                        {{-- Working Hours Card --}}
                        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-[0_6px_30px_-10px_rgba(0,0,0,0.04)] group hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.08)] transition-all duration-500 sm:col-span-2 lg:col-span-1">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 text-gray-600 flex items-center justify-center flex-shrink-0 group-hover:bg-gray-800 group-hover:text-white transition-all duration-500 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Jam Operasional</h3>
                                    <p class="text-sm font-bold text-gray-900 leading-snug">Senin — Jumat</p>
                                    <p class="text-xs text-primary-600 mt-1 font-bold">08.00 - 16.00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Social Media --}}
                    <div class="bg-primary-600 rounded-[2.5rem] p-8 text-white shadow-xl overflow-hidden relative group">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl transition-all duration-700 group-hover:scale-150"></div>
                        <h3 class="text-xl font-bold mb-4 relative z-10">Ikuti Media Sosial Kami</h3>
                        <p class="text-white/80 text-sm mb-6 relative z-10 leading-relaxed font-medium">Dapatkan update terbaru mengenai program pertanian melalui kanal media sosial resmi kami.</p>
                        <div class="flex items-center gap-4 relative z-10">
                            <a href="#" class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center hover:bg-white text-white hover:text-primary-600 transition-all duration-500 hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="#" class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center hover:bg-white text-white hover:text-primary-600 transition-all duration-500 hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <a href="#" class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center hover:bg-white text-white hover:text-primary-600 transition-all duration-500 hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Contact Form --}}
                <div class="lg:col-span-7">
                    <div class="bg-white p-8 md:p-10 rounded-[3rem] border border-gray-100 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.06)] relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-bl-[100px] -z-0 opacity-50"></div>
                        
                        <div class="relative z-10">
                            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-8">Kirim Pesan</h2>
                            
                            <form @submit.prevent="submitForm" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="name" class="text-sm font-bold text-gray-700 ml-1">Nama Lengkap</label>
                                        <input type="text" id="name" name="name" required
                                            @auth value="{{ auth()->user()->name }}" @endauth
                                            placeholder="Masukkan nama Anda"
                                            class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 text-gray-800 placeholder-gray-400 focus:border-primary-400 focus:ring-4 focus:ring-primary-400/10 transition-all font-medium text-sm">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="email" class="text-sm font-bold text-gray-700 ml-1">Alamat Email</label>
                                        <input type="email" id="email" name="email" required
                                            @auth value="{{ auth()->user()->email }}" @endauth
                                            placeholder="email@anda.com"
                                            class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 text-gray-800 placeholder-gray-400 focus:border-primary-400 focus:ring-4 focus:ring-primary-400/10 transition-all font-medium text-sm">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="subject" class="text-sm font-bold text-gray-700 ml-1">Subjek</label>
                                    <select id="subject" name="subject" required
                                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 text-gray-800 focus:border-primary-400 focus:ring-4 focus:ring-primary-400/10 transition-all font-medium text-sm appearance-none cursor-pointer">
                                        <option value="" disabled selected>Pilih subjek pesan</option>
                                        <option value="pertanyaan">Pertanyaan Umum</option>
                                        <option value="program">Informasi Program Bantuan</option>
                                        <option value="teknis">Bantuan Teknis Aplikasi</option>
                                        <option value="pengaduan">Pengaduan Layanan</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="message" class="text-sm font-bold text-gray-700 ml-1">Pesan Anda</label>
                                    <textarea id="message" name="message" required rows="5"
                                        placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."
                                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 text-gray-800 placeholder-gray-400 focus:border-primary-400 focus:ring-4 focus:ring-primary-400/10 transition-all font-medium text-sm resize-none"></textarea>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" 
                                        :disabled="loading"
                                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-5 rounded-[1.5rem] transition-all duration-300 shadow-lg shadow-primary-500/25 flex items-center justify-center gap-3 active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">
                                        <template x-if="!loading">
                                            <span class="flex items-center gap-3">
                                                Kirim Pesan Sekarang
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </span>
                                        </template>
                                        <template x-if="loading">
                                            <span class="flex items-center gap-3">
                                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Mengirim...
                                            </span>
                                        </template>
                                    </button>
                                </div>
                            </form>

                            {{-- Success Message --}}
                            <div x-show="submitted" x-transition x-cloak
                                class="absolute inset-0 bg-white/95 flex flex-col items-center justify-center text-center p-8 z-20 rounded-[3rem]">
                                <div class="w-20 h-20 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mb-6 shadow-sm">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Pesan Terkirim!</h3>
                                <p class="text-gray-500 font-medium mb-8">Terima kasih telah menghubungi kami. Tim kami akan segera menanggapi pesan Anda melalui Pusat Pesan di Dashboard Anda.</p>
                                <button @click="submitted = false" class="text-primary-600 font-bold hover:underline">Kirim Pesan Baru</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Google Maps Section --}}
            <div class="mt-24 space-y-8">
                <div class="text-center">
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Lokasi Kantor</h2>
                    <p class="text-gray-500 text-sm mt-2 font-medium">Temukan kami di Komplek Perkantoran Bukit Cinto Kenang, Sengeti.</p>
                </div>
                <div class="bg-white p-3 rounded-[3rem] border border-gray-100 shadow-2xl overflow-hidden h-[450px] relative group">
                    {{-- Actual Google Maps Embed for DTPH Muaro Jambi --}}
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15951.353427506246!2d103.4883499!3d-1.2520866!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e25786f02172777%3A0xc07842c1694f4c28!2sDinas%20Tanaman%20Pangan%20Dan%20Hortikultura%20Kabupaten%20Muaro%20Jambi!5e0!3m2!1sid!2sid!4v1714570000000!5m2!1sid!2sid" 
                        class="w-full h-full rounded-[2.5rem]" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div class="absolute inset-0 pointer-events-none border-[12px] border-white rounded-[3rem]"></div>
                </div>
            </div>
        </div>

        {{-- FAQ Preview or Footer CTA --}}
        <div class="bg-white border-t border-gray-100 py-20">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Butuh Jawaban Cepat?</h2>
                <p class="text-gray-500 mb-10 leading-relaxed font-medium">Sebelum menghubungi kami, Anda mungkin ingin memeriksa halaman FAQ kami untuk jawaban atas pertanyaan yang paling sering diajukan mengenai pendaftaran E-Proposal.</p>
                <a href="{{ route('informasi.faq') }}" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:gap-3 transition-all">
                    Lihat Pertanyaan Umum (FAQ)
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>

    <script>
        function contactPage(isAuthenticated) {
            return {
                loading: false,
                submitted: false,
                isGuest: !isAuthenticated,
                submitForm() {
                    if (this.isGuest) {
                        // Redirect guest to login page
                        window.location.href = "{{ route('login') }}";
                        return;
                    }

                    this.loading = true;
                    // Simulate API Call for Authenticated User
                    setTimeout(() => {
                        this.loading = false;
                        this.submitted = true;
                    }, 2000);
                }
            }
        }
    </script>
</x-layouts.public>
