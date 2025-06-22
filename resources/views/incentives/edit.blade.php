<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Edit Model Insentif
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('model-incentives.update', $modelIncentive->id_model_incentives) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                <input type="text" value="{{ $modelIncentive->product->product_name ?? '-' }}" disabled
                    class="w-full border-gray-300 rounded px-3 py-2 bg-gray-100" />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Base Incentive</label>
                <input type="number" name="base_incentive" step="0.01"
                    value="{{ old('base_incentive', $modelIncentive->base_incentive) }}"
                    class="w-full border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Additional Reward</label>
                <input type="number" name="additional_reward" step="0.01"
                    value="{{ old('additional_reward', $modelIncentive->additional_reward) }}"
                    class="w-full border-gray-300 rounded px-3 py-2">
            </div>

            <div class="flex justify-start space-x-2">
                <button type="submit"
                    class="w-32 text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('model-incentives.index') }}"
                    class="w-32 text-center bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200  px-4 ">
                    Batal
                </a>
            </div>

        </form>
    </div>
</x-app-layout>
