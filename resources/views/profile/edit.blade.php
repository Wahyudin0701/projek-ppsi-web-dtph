<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            
            {{-- Card 1: Informasi Kelompok Tani --}}
            @if(auth()->user()->role === 'petani')
                <div class="bg-white rounded-[2rem] p-8 sm:p-10 border border-gray-100 shadow-sm relative overflow-hidden h-fit">
                    @include('profile.partials.farmer-profile-information')
                </div>
            @endif

            {{-- Card 2: Informasi Akun --}}
            <div class="bg-white rounded-[2rem] p-8 sm:p-10 border border-gray-100 shadow-sm relative overflow-hidden space-y-12 h-fit">
                
                {{-- Form Update Profil --}}
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <hr class="border-gray-100">

                {{-- Form Update Password --}}
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>

                <hr class="border-gray-100">

                {{-- Form Hapus Akun --}}
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
