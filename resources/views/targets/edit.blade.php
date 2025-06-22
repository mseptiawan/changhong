<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Edit Target Promotor
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6">
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Target</h2>

            <form action="{{ route('targets.update', $target->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama SPGM (readonly) --}}
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-1">Nama SPGM</label>
                    <input type="text" value="{{ $target->spgm->name }}"
                        class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" disabled>
                </div>

                {{-- Bulan --}}
                <div>
                    <label for="month" class="block font-medium text-sm text-gray-700 mb-1">Bulan</label>
                    <input type="month" name="month" id="month"
                        class="border-gray-300 rounded-md shadow-sm w-full"
                        value="{{ \Carbon\Carbon::parse($target->month)->format('Y-m') }}" required>
                </div>

                {{-- Target Amount --}}
                <div>
                    <label for="target_amount" class="block font-medium text-sm text-gray-700 mb-1">Target
                        Amount</label>
                    <input type="text" name="target_amount" id="target_amount"
                        class="w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ number_format($target->target_amount, 0, '', '.') }}" required>
                </div>

                {{-- Share Bigsize (%) --}}
                <div>
                    <label for="share_bigsize_percent" class="block font-medium text-sm text-gray-700 mb-1">Share
                        Bigsize (%)</label>
                    <input type="number" step="0.01" name="share_bigsize_percent" id="share_bigsize_percent"
                        class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $target->share_bigsize_percent }}"
                        required>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-start space-x-4 pt-4">
                    <button type="submit"
                        class="w-32 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow text-sm">
                        Update
                    </button>
                    <a href="{{ route('targets.index') }}"
                        class="w-32 bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200  px-4  text-center  text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>


    {{-- JS for Auto Hitung --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                function hitungBigsize() {
                    const target = parseFloat($('#target_amount').val()) || 0;
                    const persen = parseFloat($('#share_bigsize_percent').val()) || 0;
                    const hasil = (target * persen) / 100;
                    $('#target_bigsize').val(hasil.toFixed(0));
                }

                $('#target_amount, #share_bigsize_percent').on('input', hitungBigsize);
            });
        </script>
    @endpush
</x-app-layout>
