<x-app-layout>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="text-sm list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Tambah Promotor</h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
        <form action="{{ route('promoters.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">ID SPGM</label>
                <input type="text" name="id_spgms" value="{{ $nextId }}" readonly
                    class="w-full border-gray-300 rounded-md shadow-sm text-sm" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" required
                    class="w-full border-gray-300 rounded-md shadow-sm text-sm" />
            </div>

            <!-- Company select -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Perusahaan</label>
                <select name="company_id" required class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">-- Pilih Company --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id_companies }}">{{ $company->group_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Store select -->
            <div class="mb-4">
                <label for="store_search" class="block text-sm font-medium text-gray-700">Cari Store</label>
                <input type="text" id="store_search" class="border rounded px-3 py-2 w-full"
                    placeholder="Ketik nama store...">
                <input type="hidden" name="store_id" id="store_id">
            </div>


            <div class="flex justify-start mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                    Simpan
                </button>
                <a href="{{ route('products.index') }}"
                    class=" bg-red-600 text-white px-4 py-2 ml-4 rounded-md text-center hover:bg-red-700 shadow text-sm">
                    Batal
                </a>
            </div>



        </form>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script>
            $(document).ready(function() {
                $('#store_search').autocomplete({
                    source: "{{ route('stores.autocomplete') }}",
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

</x-app-layout>
