@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<h3 class="text-lg font-semibold mb-2 mt-6">Data Penjualan yang Sudah Di-upload</h3>

<table class="w-full border text-sm text-left">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2">Toko</th>
            <th class="px-4 py-2">SPGM</th>
            <th class="px-4 py-2">Produk</th>
            <th class="px-4 py-2">Jumlah</th>
            <th class="px-4 py-2">Tipe</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sales as $row)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $row->transaction_date }}</td>
                <td class="px-4 py-2">{{ $row->store_name }}</td>
                <td class="px-4 py-2">{{ $row->spgm_name }}</td>
                <td class="px-4 py-2">{{ $row->product_name }}</td>
                <td class="px-4 py-2">{{ $row->quantity }}</td>
                <td class="px-4 py-2 capitalize">{{ $row->sale_type }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-2 text-center text-gray-500">Belum ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
