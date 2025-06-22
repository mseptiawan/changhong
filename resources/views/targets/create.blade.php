<x-app-layout>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Tambah Target Promotor
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6">
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Target SPGM</h2>

            <form action="{{ route('targets.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- SPGM --}}
                <div>
                    <label for="spgms_search" class="block font-medium text-sm text-gray-700 mb-1">Cari Nama
                        SPGM</label>
                    <input type="text" id="spgms_search"
                        class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2" placeholder="Ketik nama SPGM...">
                    <input type="hidden" name="spgms_id" id="spgms_id">
                </div>

                {{-- Bulan --}}
                <div>
                    <label for="month" class="block font-medium text-sm text-gray-700 mb-1">Bulan</label>
                    <input type="month" name="month" id="month"
                        class="border-gray-300 rounded-md shadow-sm w-full" required>
                </div>

                {{-- Target Amount --}}
                <div>
                    <label for="target_amount" class="block font-medium text-sm text-gray-700 mb-1">Target
                        Amount</label>
                    <input type="number" name="target_amount" id="target_amount"
                        class="border-gray-300 rounded-md shadow-sm w-full" required>
                </div>

                {{-- Share Bigsize (%) --}}
                <div>
                    <label for="share_bigsize_percent" class="block font-medium text-sm text-gray-700 mb-1">Share
                        Bigsize (%)</label>
                    <input type="number" step="0.01" name="share_bigsize_percent" id="share_bigsize_percent"
                        class="border-gray-300 rounded-md shadow-sm w-full" required>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-start space-x-4 pt-4">
                    <button type="submit"
                        class="w-32 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow text-sm">
                        Simpan
                    </button>
                    <a href="{{ route('targets.index') }}"
                        class="w-32 bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200  px-4  text-center  text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>


    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- jQuery -->

        <!-- jQuery UI for Autocomplete -->
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <!-- Select2 (opsional jika kamu masih pakai untuk field lain) -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Autocomplete untuk SPGM
                $('#spgms_search').autocomplete({
                    source: "{{ route('spgms.autocomplete') }}",
                    minLength: 2,
                    select: function(event, ui) {
                        $('#spgms_search').val(ui.item.label);
                        $('#spgms_id').val(ui.item.id);
                        return false;
                    }
                });

                // Fungsi hitung target bigsize
                function hitungBigsize() {
                    const target = parseFloat($('#target_amount').val()) || 0;
                    const persen = parseFloat($('#share_bigsize_percent').val()) || 0;
                    const hasil = (target * persen) / 100;

                    const hasilFormatted = hasil % 1 === 0 ? hasil : parseFloat(hasil.toFixed(2)).toString().replace(
                        /\.?0+$/, '');
                    $('#target_bigsize').val(hasilFormatted);
                }

                $('#target_amount, #share_bigsize_percent').on('input', hitungBigsize);
            });
        </script>
    @endpush

</x-app-layout>
