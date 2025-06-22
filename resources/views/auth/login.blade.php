<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="items-center ">
        <div class=" p-8 rounded-2xl shadow-2xl  border-red-200">
            <!-- Judul dan Deskripsi -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center space-x-3">
                    {{-- <img src="{{ asset('changhong.png') }}" alt="Logo CHANGHONG" class="w-10 h-10 rounded-full"> --}}
                    <h1 class="text-3xl font-extrabold text-red-700 tracking-wide">SPG/M Komisi System</h1>
                </div>
                <p class="mt-3 text-gray-600 text-sm leading-relaxed">
                    Selamat datang di Sistem Insentif SPG & Merchandiser <span
                        class="font-semibold">CHANGHONG</span>.<br />
                    Kelola data komisi dengan mudah, transparan, dan otomatis.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="'Email'" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg focus:ring-red-500 focus:border-red-500" type="email"
                        name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="'Kata Sandi'" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg focus:ring-red-500 focus:border-red-500" type="password"
                        name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center text-sm text-gray-600">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                        <span class="ms-2">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs text-red-700 hover:underline" href="{{ route('password.request') }}">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <!-- Tombol -->
                <div>
                    <x-primary-button
                        class="w-full justify-center bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200">
                        Masuk
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
