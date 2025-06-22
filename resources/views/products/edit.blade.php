<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Edit Produk</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('products.update', $product->id_product) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Kategori --}}
                @php
                    $categoryCode = is_object($product->category)
                        ? $product->category->category_code
                        : $product->category;
                    $categoryName = is_object($product->category) ? $product->category->name : '-';
                @endphp

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input type="text" class="form-input mt-1 block w-full bg-gray-100 cursor-not-allowed"
                        value="{{ $categoryName }}" readonly />
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" name="sell_out_price" class="form-input mt-1 block w-full"
                        value="{{ $product->sell_out_price }}" required />
                </div>

                {{-- Nama Produk --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="product_name" class="form-input mt-1 block w-full"
                        value="{{ $product->product_name }}" required />
                </div>

                {{-- Varian --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Varian</label>
                    <input type="hidden" name="variant" value="">
                    <div id="variant-options" class="mt-2">
                        @php
                            $currentVariant = $product->variant;
                            $variantOptions = [
                                'TV' => 'TV ( OVER 50 )',
                                'AC' => 'AC ( OVER 1,5P )',
                                'REFF' => 'NO FROST',
                                'WM' => 'Front Loading',
                            ];
                        @endphp

                        @if (array_key_exists($categoryCode, $variantOptions))
                            <label class="inline-flex items-center space-x-2">
                                <input type="radio" name="variant" value="{{ $variantOptions[$categoryCode] }}"
                                    {{ $currentVariant === $variantOptions[$categoryCode] ? 'checked' : '' }} />
                                <span>{{ $variantOptions[$categoryCode] }}</span>
                            </label>
                        @else
                            <span class="text-gray-500 text-sm">Tidak ada varian untuk kategori ini</span>
                        @endif
                    </div>
                </div>

                {{-- Big Size --}}
                <input type="hidden" name="bigsize" id="bigsize" value="{{ $product->bigsize }}" />

                {{-- Submit --}}
                <div class="flex justify-start space-x-2 mt-6">
                    <button type="submit" class="w-32 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Simpan
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="w-32 bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 px-4 text-center ">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Perbarui nilai bigsize berdasarkan pilihan varian
        document.querySelectorAll('input[name="variant"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('bigsize').value = this.value ? 1 : 0;
            });
        });
    </script>
</x-app-layout>
