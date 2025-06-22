<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Promotor
            </h2>

            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-3">
                {{-- Search Form --}}
                <form action="{{ route('promoters.index') }}" method="GET" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Cari promotor..." value="{{ request('search') }}"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />

                    <button type="submit" class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200  px-4  ">
                        Cari
                    </button>
                </form>

                {{-- Tambah Promotor Button --}}
                <a href="{{ route('promoters.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-md">
                    + Tambah Promotor
                </a>
            </div>
        </div>

    </x-slot>
    <div class="container mx-auto px-4 py-6">
        {{-- <h2 class="text-2xl font-bold mb-6">Daftar SPGM dan Target Bulan {{ $month }}</h2> --}}

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($spgms as $spgm)
                <div class="bg-white shadow-md rounded-lg p-5 border border-gray-200">
                    <h4 class="text-xl font-semibold text-black mb-1">{{ $spgm->name }}</h4>
                    <p class="text-gray-600 mb-1"><strong>Company:</strong> {{ $spgm->company->group_name ?? '-' }}</p>
                    <p class="text-gray-600 mb-1"><strong>Store:</strong> {{ $spgm->store->name ?? 'N/A' }}</p>

                    @php
                        $target = $spgm->targets->first();
                    @endphp

                    <div class="mt-3 bg-gray-100 p-3 rounded">
                        <p class="text-sm"><strong>Target Amount:</strong>
                            {{ $target?->target_amount ? 'Rp ' . number_format($target->target_amount, 0, ',', '.') : 'Belum ditentukan' }}
                        </p>
                        <p class="text-sm"><strong>Bigsize:</strong>
                            {{ $target?->target_bigsize ? 'Rp ' . number_format($target->target_bigsize, 0, ',', '.') : '-' }}
                        </p>
                        <p class="text-sm"><strong>Share Bigsize (%):</strong>
                            {{ $target?->share_bigsize_percent !== null ? rtrim(rtrim(number_format($target->share_bigsize_percent, 2, '.', ''), '0'), '.') : '-' }}%
                        </p>
                    </div>

                    <a href="{{ route('promoters.edit', ['promoter' => $spgm->id_spgms]) }}"
                        class="inline-block mt-4 bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 text-sm font-medium px-4 ">
                        Edit
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-600 py-10">
                    Tidak ada promotor yang ditemukan.
                </div>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $spgms->links() }}
        </div>
    </div>

</x-app-layout>
