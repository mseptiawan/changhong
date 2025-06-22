<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white shadow-md rounded-xl p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Lupa Kata Sandi</h2>

        <p class="text-sm text-gray-600 mb-4">
            Masukkan email Anda, kami akan kirim tautan untuk mengatur ulang kata sandi.
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full focus:ring-red-500 focus:border-red-500"
                    type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button
                    class="w-full justify-center bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200">
                    >
                    {{ __('Kirim Link Reset') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
