<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Tambah Discontinue Produk
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6">
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Discontinue Produk</h2>

            <form action="{{ route('discontinued-products.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id_product }}">

                {{-- Nama Produk --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text"
                        class="form-input block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm" readonly
                        value="{{ $product->product_name }}">
                </div>

                {{-- Tanggal Discontinue --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Discontinue</label>
                    <input type="date" name="discontinue_date" required
                        class="form-input block w-full rounded-md border-gray-300 shadow-sm" />
                </div>

                {{-- Tombol --}}
                <div class="flex justify-start space-x-4 mt-6">
                    <button type="submit"
                        class="w-32 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow text-sm">
                        Simpan
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="w-32 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-center shadow text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
