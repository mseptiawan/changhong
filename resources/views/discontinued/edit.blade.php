<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Edit Discontinue Produk
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('discontinued-products.update', $discontinuedProduct->id_discontinue) }}"
                method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Produk --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" class="form-input mt-1 block w-full bg-gray-100" readonly
                        value="{{ $discontinuedProduct->product->product_name }}">
                </div>

                {{-- Tanggal Discontinue --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Discontinue</label>
                    <input type="date" name="discontinue_date" class="form-input mt-1 block w-full"
                        value="{{ $discontinuedProduct->discontinue_date }}" required>
                </div>

                {{-- Tombol Submit --}}
                <div class="flex justify-start space-x-2 mt-6">
                    <button type="submit" class="w-32 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Simpan
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="w-32 text-center bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
