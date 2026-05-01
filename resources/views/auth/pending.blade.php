<x-public-layout>
    <x-slot:title>Akun Menunggu Verifikasi - E-Proposal</x-slot:title>

    <div class="max-w-2xl mx-auto py-20 px-4">
        <div class="bg-white p-8 rounded-2xl shadow-sm border text-center">
            <div class="mb-6 flex justify-center">
                <div class="bg-yellow-100 p-4 rounded-full">
                    <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            
            <h2 class="text-2xl font-bold mb-4">Pendaftaran Berhasil!</h2>
            <p class="text-gray-600 mb-6">
                Terima kasih telah mendaftar, <strong>{{ auth()->user()->nama_kelompok }}</strong>. 
                Akun Anda saat ini sedang dalam proses verifikasi oleh Admin Dinas Pertanian.
            </p>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 text-left mb-8">
                <p class="text-sm text-blue-700 font-semibold">Catatan:</p>
                <p class="text-sm text-blue-600">Pendaftaran akun Kelompok Tani memerlukan verifikasi manual oleh Admin Dinas sebelum dapat mengajukan usulan.</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-primary-600 font-bold hover:underline">Keluar Sesi</button>
            </form>
        </div>
    </div>
</x-public-layout>
