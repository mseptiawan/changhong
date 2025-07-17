    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    </head>


    <body class="font-sans antialiased bg-gray-100">
        <div class="flex min-h-screen">
            <aside
                class="w-72 bg-[#F3F4F6] text-black flex flex-col py-8 px-6 space-y-6 shadow-lg fixed top-0 left-0 h-screen z-10">
                <div class="flex items-center space-x-3">
                    {{-- <img src="{{ asset('changhong.png') }}" alt="Logo" class="w-10 h-10 rounded-full"> --}}
                    <h2 class="text-2xl font-bold text-red-700 tracking-wide">SPG/M Komisi System</h2>
                </div>

                <nav class="flex-1 space-y-2 text-sm font-medium">
                    <a href="{{ route('dashboards.index') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg  transition-transform transform duration-200 hover:translate-x-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m2 4H5a2 2 0 00-2 2v5h18v-5a2 2 0 00-2-2z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    {{-- Rekap Insentif: untuk promotor & manager --}}
                    @if (auth()->user()->role === 'promotor' || auth()->user()->role === 'manager')
                        <a href="{{ route('incentive-recap.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg transition-transform transform duration-200 hover:translate-x-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-4h6v4m-3-6a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                            <span>Rekap Insentif Promotor</span>
                        </a>
                    @endif

                    {{-- Transaksi Penjualan: khusus manager --}}
                    @if (auth()->user()->role === 'manager')
                        <div x-data="{ openTransaksi: false }" class="space-y-1">
                            <button @click="openTransaksi = !openTransaksi"
                                class="flex justify-between items-center w-full p-2 rounded-lg transition-transform transform duration-200 hover:translate-x-1">
                                <span class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.6 8H19M7 13l2 8m6-8l-2 8" />
                                    </svg>
                                    <span>Transaksi Penjualan</span>
                                </span>
                                <svg :class="{ 'rotate-180': openTransaksi }" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="openTransaksi" x-cloak class="pl-6 space-y-1 rounded-md">
                                <a href="{{ route('transaksi.rincian') }}"
                                    class="flex items-center space-x-2 py-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 17v-2a4 4 0 014-4h4" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 11V9a4 4 0 014-4h4" />
                                    </svg>
                                    <span>Rincian Total</span>
                                </a>

                                <a href="{{ route('transaksi.summary') }}"
                                    class="flex items-center space-x-2 py-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 10h11M9 21V3m9 18v-6a3 3 0 00-3-3H9" />
                                    </svg>
                                    <span>Laporan Pendapatan</span>
                                </a>
                            </div>
                        </div>
                    @endif



                    @if (auth()->user()->role === 'marketing')
                        <a href="{{ route('data.import.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg  transition-transform transform duration-200 hover:translate-x-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 12h16M4 8h16M4 4h16" />
                            </svg>
                            <span>Upload Data</span>
                        </a>

                        <div x-data="{ openTransaksi: false }" class="space-y-1">
                            <button @click="openTransaksi = !openTransaksi"
                                class="flex justify-between items-center w-full p-2 rounded-lg transition-transform transform duration-200 hover:translate-x-1">
                                <span class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.6 8H19M7 13l2 8m6-8l-2 8" />
                                    </svg>
                                    <span>Transaksi Penjualan</span>
                                </span>
                                <svg :class="{ 'rotate-180': openTransaksi }" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="openTransaksi" x-cloak class="pl-6 space-y-1 rounded-md">
                                <a href="{{ route('transaksi.rincian') }}"
                                    class="flex items-center space-x-2 py-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 17v-2a4 4 0 014-4h4" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 11V9a4 4 0 014-4h4" />
                                    </svg>
                                    <span>Rincian Total</span>
                                </a>

                                <a href="{{ route('transaksi.summary') }}"
                                    class="flex items-center space-x-2 py-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 10h11M9 21V3m9 18v-6a3 3 0 00-3-3H9" />
                                    </svg>
                                    <span>Laporan Pendapatan</span>
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('incentive-recap.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg transition-transform transform duration-200 hover:translate-x-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-4h6v4m-3-6a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                            <span>Rekap Insentif Promotor</span>
                        </a>
                        <a href="{{ route('promoters.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg  transition-transform transform duration-200 hover:translate-x-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A4 4 0 016 16h12a4 4 0 01.879 1.804M16 11a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Kelola Promotor</span>
                        </a>
                        <!-- Kelola Produk -->
                        <div x-data="{ open: false }" class="space-y-1">
                            <button @click="open = !open"
                                class="flex justify-between items-center w-full p-2 rounded-lg  transition-transform transform duration-200 hover:translate-x-1">
                                <span class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 10h18M3 6h18M3 14h18M3 18h18" />
                                    </svg>
                                    <span>Kelola Produk</span>
                                </span>
                                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="pl-6 space-y-1  rounded-md">
                                <a href="{{ route('products.index') }}"
                                    class="flex items-center space-x-2 py-2 text-sm ">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8m-4-4v4" />
                                    </svg>
                                    <span>Daftar Produk</span>
                                </a>
                                <a href="{{ route('model-incentives.index') }}"
                                    class="flex items-center space-x-2 py-2 text-sm ">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Model Insentif</span>
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('targets.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg  transition-transform transform duration-200 hover:translate-x-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-4h6v4m-3-6a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                            <span>Kelola Target</span>
                        </a>
                        <hr class="border-t-1 border-gray-300 my-8 ">


                        <!-- Akun -->
                    @endif

                    <div x-data="{ open: false }" class="relative space-y-2">
                        <button @click="open = !open"
                            class="flex justify-between items-center w-full p-2 rounded-lg  transition-transform transform duration-200 hover:translate-x-1">
                            <span class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5.121 17.804A4 4 0 016 16h12a4 4 0 01.879 1.804M16 11a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>Akun</span>
                            </span>
                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <ul x-show="open" @click.away="open = false" x-cloak
                            class="mt-1 pl-6 space-y-2 text-sm  rounded-md ">
                            <li class="py-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 text-sm ">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5.121 17.804A4 4 0 016 16h12a4 4 0 01.879 1.804M16 11a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li class="py-2">
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="flex items-center space-x-2 text-sm ">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 12a9 9 0 0118 0" />
                                        </svg>
                                        <span>Keluar</span>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </aside>

            <!-- Content -->
            <div class="flex-1 flex flex-col pl-72">
                @isset($header)
                    <header class="bg-[#F3F4F6] shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="p-6 flex-grow">
                    {{ $slot }}
                </main>

                <footer class="text-sm text-center py-4">
                    &copy; {{ date('Y') }} Changhong SPG/M Incentive.
                    <a href="/incentive-guidelines.pdf" class="underline  ml-2" target="_blank">
                        Incentive Guidelines
                    </a>
                </footer>

            </div>
            @stack('scripts')

    </body>


    </html>
