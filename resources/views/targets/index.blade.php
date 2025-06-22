<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Setel Target Promotor
            </h2>

            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-3">
                <form action="{{ route('targets.index') }}" method="GET" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Cari SPGM..." value="{{ request('search') }}"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />

                    <button type="submit"
                        class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 px-4  text-sm">
                        Cari
                    </button>
                </form>

                <a href="{{ route('targets.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-md">
                    + Tambah Target
                </a>
            </div>
        </div>
    </x-slot>
    <div class="container mx-auto px-4 py-6">
        {{-- Form Filter --}}
        <form action="{{ route('targets.filterByDate') }}" method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label for="month" class="block font-semibold mb-1">Filter Bulan</label>
                <input type="month" name="month" id="month" value="{{ request('month') }}"
                    class="border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <button type="submit"
                    class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200  px-4">Filter</button>
                <a href="{{ route('targets.index') }}" class="ml-2 text-gray-600 hover:underline">Reset</a>
            </div>
        </form>
        {{-- Tabel daftar target --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300 rounded-lg shadow-md">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border border-gray-300">
                            Nama SPGM</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border border-gray-300">
                            Bulan</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border border-gray-300">
                            Target Amount</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border border-gray-300">
                            Target Bigsize</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border border-gray-300">
                            Share Bigsize (%)</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border border-gray-300">
                            Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($targets as $target)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                {{ $target->spgm ? $target->spgm->name : 'SPGM tidak ditemukan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                {{ \Carbon\Carbon::parse($target->month)->format('F Y') }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right border border-gray-200">
                                Rp {{ number_format($target->target_amount, 0, ',', '.') }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right border border-gray-200">
                                Rp {{ number_format($target->target_bigsize, 0, ',', '.') }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center border border-gray-200">
                                {{ rtrim(rtrim(number_format($target->share_bigsize_percent, 2, '.', ''), '0'), '.') }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center border border-gray-200">
                                <a href="{{ route('targets.edit', ['target' => $target->id]) }}"
                                    class="inline-block bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 text-xs font-semibold px-4">
                                    Edit
                                </a>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">
                                Tidak ada data target
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
    <div class="mt-4">
        {{ $targets->appends(request()->query())->links() }}
    </div>



</x-app-layout>
