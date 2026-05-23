<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="mx-auto w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-[#19A148]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Verifikasi Email Anda</h2>
        <p class="text-sm text-gray-600 leading-relaxed">
            Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan ulang.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-xl">
            <p class="font-medium text-sm text-[#19A148] text-center">
                Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat registrasi.
            </p>
        </div>
    @endif

    <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-[#19A148] border border-transparent rounded-xl font-bold text-sm text-white hover:bg-[#158C3D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-all active:scale-95 shadow-md shadow-green-500/20">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto underline text-sm font-bold text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19A148] transition-colors">
                Keluar (Log Out)
            </button>
        </form>
    </div>
</x-guest-layout>
