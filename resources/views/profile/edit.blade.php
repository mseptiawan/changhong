<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Profil Akun') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
                {{-- Informasi Profil --}}
                <div class="flex-1 bg-white rounded-2xl shadow-md px-6 py-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">{{ __('Informasi Profil') }}</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Update Password --}}
                <div class="flex-1 bg-white rounded-2xl shadow-md px-6 py-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">{{ __('Ganti Password') }}</h3>
                    @include('profile.partials.update-password-form')
                </div>
                {{-- hapus akun --}}
            </div>
        </div>
    </div>

</x-app-layout>
