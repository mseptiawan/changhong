<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Tambah Model Insentif
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 p-6 bg-white shadow rounded">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc pl-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('model-incentives.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <!-- Input untuk pencarian -->
                <label for="product_search" class="block mb-1 font-semibold">Cari Produk</label>
                <input type="text" id="product_search" class="border rounded px-3 py-2 w-full"
                    placeholder="Ketik nama produk...">

                <!-- Hidden input untuk simpan product_id -->
                <input type="hidden" name="product_id" id="product_id">

            </div>

            <div class="mb-4">
                <label for="base_incentive" class="block text-sm font-medium text-gray-700">Base Incentive *</label>
                <input type="number" step="0.01" name="base_incentive" required
                    class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-4">
                <label for="additional_reward" class="block text-sm font-medium text-gray-700">Additional Reward</label>
                <input type="number" step="0.01" name="additional_reward" class="w-full border rounded px-3 py-2" />
            </div>
            <div class="flex justify-start space-x-2">
                <button type="submit" class="w-32 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('model-incentives.index') }}"
                    class="w-32 text-center bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200  px-4">
                    Batal
                </a>
            </div>

        </form>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#product_search").autocomplete({
                    source: "{{ route('products.autocomplete') }}",
                    minLength: 2,
                    select: function(event, ui) {
                        // Set nilai input tersembunyi
                        $('#product_id').val(ui.item.id);

                        // Set nilai yang ditampilkan di input pencarian (optional)
                        $('#product_search').val(ui.item.label);

                        // Debug untuk memastikan isinya benar
                        console.log('Selected product:', ui.item);

                        // Mencegah autocomplete menimpa input
                        return false;
                    }
                });
            });
        </script>
    @endpush



</x-app-layout>
