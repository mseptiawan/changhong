<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0 ">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Produk - Active, Discontinue
            </h2>

            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-3">
                {{-- Form Search --}}
                <form action="{{ route('products.index') }}" method="GET" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />

                    <button type="submit" class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 px-4   text-sm">
                        Cari
                    </button>
                </form>

                {{-- Tombol Tambah Produk --}}
                <a href="{{ route('products.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-md">
                    + Tambah Produk
                </a>
            </div>
        </div>

    </x-slot>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded-md shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                        Kategori</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                        Harga</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                        Nama Produk</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                        Varian</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                        Big Size</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                        Discontinue</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                        Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->category->name }}
                        </td>


                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $product->sell_out_price ? 'Rp ' . number_format($product->sell_out_price, 0, ',', '.') : '-' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->product_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $product->variant ?? 'Tidak Ada' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $product->bigsize ? 'Iya' : 'Tidak' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $product->isDiscontinued() ? 'Iya' : 'Tidak' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2 text-sm">
                            <a href="{{ route('products.edit', ['product' => $product->id_product]) }}"
                                class="inline-block bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 text-xs font-semibold px-4 ">
                                Edit
                            </a>

                            @php
                                $discontinued = $product->discontinuedProduct;
                            @endphp

                            @if ($discontinued)
                                {{-- Sudah discontinue → Edit --}}
                                <a href="{{ route('discontinued-products.edit', $discontinued->id_discontinue) }}"
                                    class="inline-block bg-yellow-600 hover:bg-yellow-500 text-white text-xs font-semibold px-4 py-2 rounded transition">
                                    Edit Discontinue
                                </a>
                            @else
                                {{-- Belum discontinue → Tambah --}}
                                <a href="{{ route('discontinued-products.create', ['product_id' => $product->id_product]) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-400 text-white text-xs font-semibold px-4 py-2 rounded transition">
                                    Discontinue
                                </a>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>

</x-app-layout>
