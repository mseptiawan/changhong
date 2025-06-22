<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Set Model Insentif
            </h2>

            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-3">
                {{-- Form Search Produk --}}
                <form action="{{ route('model-incentives.index') }}" method="GET" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ old('search', $search) }}"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />

                    <button type="submit"
                        class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 px-4 text-sm ">
                        Cari
                    </button>
                </form>

                {{-- Tombol Tambah Model Insentif --}}
                <a href="{{ route('model-incentives.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-md">
                    + Tambah Model
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Form Filter Berdasarkan Bulan --}}
    <form action="{{ route('model-incentives.index') }}" method="GET"
        class="mb-6 flex flex-wrap gap-4 items-end px-2">

        <div>
            <label for="month" class="block font-semibold mb-1">Filter Bulan</label>
            <input type="month" name="month" id="month" value="{{ old('month', request('month')) }}"
                class="border border-gray-300 rounded px-3 py-2">
        </div>

        <div>
            <button type="submit" class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200  px-4 ">Filter</button>
            <a href="{{ route('model-incentives.index') }}" class="ml-2 text-gray-600 hover:underline">Reset</a>
        </div>
    </form>

    <div class="overflow-x-auto mt-6">
        <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded-md shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nama Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Base Incentive</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Additional Reward</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($incentives as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $item->product->product_name ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">Rp
                            {{ number_format($item->base_incentive, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            {{ $item->additional_reward ? 'Rp ' . number_format($item->additional_reward, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <a href="{{ route('model-incentives.edit', $item->id_model_incentives) }}"
                                class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-1 rounded-lg shadow-md transition duration-200 px-3 text-sm ">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            Tidak ada data model incentive
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $incentives->withQueryString()->links() }}
        </div>
    </div>

    {{-- Tambahkan konten di sini seperti tabel data jika diperlukan --}}
</x-app-layout>
