<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Promotor
            </h2>

            {{-- <form action="{{ route('promoters.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Cari promotor..." value="{{ request('search') }}"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />

                <button type="submit" class="bg-red-950 text-white px-4 py-2 rounded-md hover:bg-red-800 text-sm">
                    Cari
                </button>
            </form> --}}
        </div>
    </x-slot>

    <div class="container  max-w-xl mx-auto p-6 bg-white shadow-md rounded-md mt-20">
        {{-- <h2 class="text-2xl font-bold mb-6">Daftar SPGM dan Target Bulan {{ $month }}</h2> --}}

        <div class="max-w-xl mx-auto mt-4">
            <h2 class="text-2xl font-semibold mb-6">Edit Promoter</h2>

            <form action="{{ route('promoters.update', $promoter->id_spgms) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama Promotor -->
                <div>
                    <label for="name" class="block text-sm font-medium">Nama Promotor</label>
                    <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 mt-1"
                        value="{{ old('name', $promoter->name) }}" required>
                </div>

                <!-- Pilih Company -->
                <div>
                    <label for="company_id" class="block text-sm font-medium">Company</label>
                    <select name="company_id" id="company_id" class="w-full border rounded px-3 py-2 mt-1" required>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id_companies }}"
                                {{ $promoter->company_id == $company->id_companies ? 'selected' : '' }}>
                                {{ $company->group_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Store -->
                <div class="mb-4">
                    <label for="store_search" class="block text-sm font-medium text-gray-700">Cari Store</label>
                    <input type="text" id="store_search" class="w-full border border-gray-300 rounded px-3 py-2 mt-1"
                        placeholder="Ketik nama store..." value="{{ $promoter->store->name ?? '' }}">
                    <input type="hidden" name="store_id" id="store_id" value="{{ $promoter->store_id }}">

                </div>

                <div class="flex justify-start mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                        Update
                    </button>
                    <a href="{{ route('promoters.index') }}"
                        class=" bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 px-4 ml-4  text-center  text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <!-- jQuery & jQuery UI -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script>
            $(function() {
                $('#store_search').autocomplete({
                    source: '{{ route('stores.autocomplete') }}',
                    minLength: 2,
                    select: function(event, ui) {
                        $('#store_search').val(ui.item.label);
                        $('#store_id').val(ui.item.id);
                        return false;
                    }
                });
            });
        </script>
    @endpush

    <script>
        $(function() {
            // Kosongkan value saat klik
            $('#store_search').on('focus', function() {
                $(this).val('');
                $('#store_id').val('');
            });

            $('#store_search').autocomplete({
                source: '{{ route('stores.autocomplete') }}',
                minLength: 2,
                select: function(event, ui) {
                    $('#store_search').val(ui.item.label);
                    $('#store_id').val(ui.item.id);
                    return false;
                }
            });
        });
    </script>

</x-app-layout>
