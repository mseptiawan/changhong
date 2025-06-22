<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Tambah Produk</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                {{-- Kategori --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category" id="category" class="form-select mt-1 block w-full" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_code }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" name="sell_out_price" class="form-input mt-1 block w-full" required />
                </div>

                {{-- Nama Produk --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="product_name" class="form-input mt-1 block w-full" required />
                </div>

                {{-- Variant --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Varian</label>
                    <input type="hidden" name="variant" value="">
                    <div id="variant-options">
                        <div class="variant-group" data-category="TV" style="display: none;">
                            <label><input type="radio" name="variant" value="TV ( OVER 50 )" /> TV ( OVER 50 )</label>
                        </div>
                        <div class="variant-group" data-category="AC" style="display: none;">
                            <label><input type="radio" name="variant" value="AC ( OVER 1,5P )" /> AC ( OVER 1,5P
                                )</label>
                        </div>
                        <div class="variant-group" data-category="REFF" style="display: none;">
                            <label><input type="radio" name="variant" value="NO FROST" /> NO FROST</label>
                        </div>
                        <div class="variant-group" data-category="WM" style="display: none;">
                            <label><input type="radio" name="variant" value="Front Loading" /> Front Loading</label>
                        </div>
                    </div>
                </div>

                {{-- Big Size --}}
                <input type="hidden" name="bigsize" id="bigsize" value="0" />

                {{-- Submit --}}
                <div class="flex justify-start mt-6">
                    <button type="submit"
                        class="w-32 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow text-sm">
                        Simpan
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="w-32 bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200  px-4  ml-4  text-center text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const categorySelect = document.getElementById('category');
        const variantGroups = document.querySelectorAll('.variant-group');
        const bigsizeInput = document.getElementById('bigsize');

        function updateVariantOptions() {
            const selectedCategory = categorySelect.value;

            // Sembunyikan semua group radio varian
            variantGroups.forEach(group => {
                group.style.display = 'none';

                // Hilangkan centang radio sebelumnya
                const radio = group.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });

            // Tampilkan hanya yang cocok dengan kategori
            const activeGroup = document.querySelector(`.variant-group[data-category="${selectedCategory}"]`);
            if (activeGroup) {
                activeGroup.style.display = 'block';
            }

            // Reset bigsize
            bigsizeInput.value = 0;
        }

        // Saat varian dipilih, ubah nilai bigsize
        document.getElementById('variant-options').addEventListener('change', function(e) {
            if (e.target.name === 'variant') {
                bigsizeInput.value = e.target.value ? 1 : 0;
            }
        });

        categorySelect.addEventListener('change', updateVariantOptions);

        // Jalankan saat awal load
        updateVariantOptions();
    </script>

</x-app-layout>
