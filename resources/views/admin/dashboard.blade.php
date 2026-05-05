<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @if(auth()->user()->isAdmin())
    {{-- ===== ADMIN DASHBOARD ===== --}}
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 to-slate-700 p-7 text-white shadow-lg">
            <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-white/5"></div>
            <div class="relative z-10">
                <p class="mb-1 text-sm font-semibold text-slate-400">Panel Administrator</p>
                <h2 class="mb-2 text-2xl font-extrabold">Selamat Datang, {{ auth()->user()->name }}</h2>
                <p class="max-w-lg text-sm text-slate-400 leading-relaxed">
                    Kelola verifikasi akun dan program bantuan melalui menu navigasi di samping.
                </p>
            </div>
        </div>
    </div>

    @endif
</x-app-layout>
