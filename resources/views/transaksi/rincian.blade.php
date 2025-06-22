<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Rincian Transaksi Penjualan
            </h2>

            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-3">
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 border border-green-400 px-4 py-2 rounded-md text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('data.import.index') }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-md">
                    + Tambah Transaksi
                </a>
            </div>
        </div>
    </x-slot>


    <div class="py-6 px-4">
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
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded-md shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Nama Toko</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">SPGM</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Produk</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Kategori</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 uppercase">Qty</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-700 uppercase">Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Tipe</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse ($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ ucwords(strtolower($trx->store_name)) }}</td>
                            <td class="px-4 py-2">{{ ucwords(strtolower($trx->spgm_name)) }}</td>
                            <td class="px-4 py-2">
                                {{ ucwords(strtolower($trx->product_name)) }}<br>
                                <span class="text-xs text-gray-500 capitalize">{{ $trx->variant ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-2">{{ $trx->category_code }}</td>
                            <td class="px-4 py-2 text-center">{{ $trx->quantity }}</td>
                            <td class="px-4 py-2 text-right">{{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ ucfirst($trx->sale_type) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center px-4 py-6 text-gray-500">
                                Tidak ada data transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
