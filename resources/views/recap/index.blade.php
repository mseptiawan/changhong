<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Recap Insentif Promotor
            </h2>
            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-3">
                <form action="" method="GET" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Cari SPGM..." value="{{ request('search') }}"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />

                    <button type="submit"
                        class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 px-4 text-sm">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <form action="" method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label for="month" class="block font-semibold mb-1">Filter Bulan</label>
                <input type="month" name="month" id="month" value="{{ request('month') }}"
                    class="border border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <button type="submit"
                    class="bg-red-700 hover:bg-red-800 focus:ring-red-500 text-white py-2 rounded-lg shadow-md transition duration-200 px-4">
                    Filter
                </button>
                <a href="{{ route('targets.index') }}" class="ml-2 text-gray-600 hover:underline">Reset</a>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-sm text-sm">
                <thead class="bg-gray-100 text-left font-semibold">
                    <tr>
                        <th class="p-2 border">SPGM</th>
                        {{-- <th class="p-2 border">Company</th>
                        <th class="p-2 border text-right">Target (Jt)</th>
                        <th class="p-2 border text-right">Actual (Jt)</th>
                        <th class="p-2 border text-right">% Achieved</th>
                        <th class="p-2 border text-right">Target Bigsize (Jt)</th>
                        <th class="p-2 border text-right">Bigsize Actual (Jt)</th>
                        <th class="p-2 border text-right">% Bigsize</th>
                        <th class="p-2 border text-right">Paid % Achieved</th>
                        <th class="p-2 border text-right">Paid % Bigsize</th> --}}
                        <th class="p-2 border text-right">Persentase Rate Payment</th>
                        <th class="p-2 border text-right ">Total Insentif</th>
                        <th class="p-2 border">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recap as $row)
                        @if ($row['Actual (Jt)'] > 0)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-2 border">{{ $row['SPGM'] }}</td>
                                {{-- <td class="p-2 border">{{ $row['Company'] }}</td>
                                <td class="p-2 border text-right">{{ number_format($row['Target (Jt)']) }}</td>
                                <td class="p-2 border text-right">{{ number_format($row['Actual (Jt)']) }}</td>
                                <td class="p-2 border text-right">{{ $row['% Achieved'] }}%</td>
                                <td class="p-2 border text-right">{{ number_format($row['Target Bigsize (Jt)']) }}</td>
                                <td class="p-2 border text-right">{{ number_format($row['Bigsize Actual (Jt)']) }}</td>
                                <td class="p-2 border text-right">{{ $row['% Bigsize'] }}%</td>
                                <td class="p-2 border text-right">{{ $row['Paid % Achieved'] }}%</td>
                                <td class="p-2 border text-right">{{ $row['Paid % Bigsize'] }}%</td> --}}
                                <td class="p-2 border text-right font-semibold ">
                                    {{ $row['Total Incentive Percent'] }}%
                                </td>
                                <td class="p-2 border text-right font-semibold">
                                    Rp {{ number_format($row['Total Incentive (IDR)'], 0, ',', '.') }}
                                </td>
                                <td class="p-2 border text-center">
                                    <button
                                        class="bg-green-400 text-white px-3 py-1 rounded text-sm flex items-center gap-1"
                                        onclick="showDetail({{ json_encode($row) }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                </td>

                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="11" class="p-4 text-center text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse


                    <div id="detailModal"
                        class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-50 flex items-center justify-center">
                        <div class="bg-white rounded shadow p-6 w-[90%] max-w-2xl">
                            <h2 class="text-lg font-bold mb-4">Detail Insentif</h2>
                            <div id="detailContent" class="text-sm space-y-1 overflow-y-auto max-h-[70vh] pr-2">
                                <!-- Konten akan diisi via JavaScript -->
                            </div>
                            <div class="mt-4 text-right">
                                <button onclick="closeDetail()"
                                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Tutup</button>
                            </div>
                        </div>
                    </div>

                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>


<script>
    function showDetail(row) {
        let bonus = parseInt(row['Bigsize Top Bonus (IDR)']) || 0;

        let content = `
            <p><strong>Nama SPG:</strong> ${row['SPGM']}</p>
            <p><strong>Perusahaan:</strong> ${row['Company']}</p>
            <p><strong>Target Penjualan:</strong> ${Number(row['Target (Jt)']) / 1_000_000} Juta</p>

            <p><strong>Penjualan Aktual:</strong> ${row['Actual (Jt)']} Juta</p>
            <p><strong>Pencapaian Penjualan:</strong> ${row['% Achieved']}%</p>
            <p><strong>Target Big Size:</strong> ${(Number(row['Target Bigsize (Jt)']) / 1_000_000).toLocaleString('id-ID')} Juta</p>

            <p><strong>Penjualan Big Size:</strong> ${row['Bigsize Actual (Jt)']} Juta</p>
            <p><strong>Pencapaian Big Size:</strong> ${row['% Bigsize']}%</p>
            <p><strong>Dibayar Penjualan:</strong> ${row['Paid % Achieved']}%</p>
            <p><strong>Dibayar Big Size:</strong> ${row['Paid % Bigsize']}%</p>

            <p><strong>Total Persentase Insentif:</strong> ${row['Total Incentive Percent']}%</p>


            <p><strong>Insentif Dasar:</strong> Rp ${Number(row['Base Incentive (IDR)']).toLocaleString('id-ID')}</p>
            <p><strong>Insentif Reward:</strong> Rp ${Number(row['Reward Incentive (IDR)']).toLocaleString('id-ID')}</p>
            <p><strong>Total Sebelum Persen:</strong> Rp ${Number(row['Gross Incentive (IDR)']).toLocaleString('id-ID')}</p>
            <p><strong>Dibayar ${row['Total Incentive Percent']}%:</strong> Rp ${Number(row['Paid Incentive (IDR)']).toLocaleString('id-ID')}</p>
            <p><strong>Bonus Top Big Size:</strong> Rp ${bonus.toLocaleString('id-ID')}</p>
            <p><strong>Total Insentif:</strong> Rp ${Number(row['Total Incentive (IDR)']).toLocaleString('id-ID')}</p>
        `;


        // Jika ada daftar produk, tampilkan tabel
        if (row['Products Sold'] && Array.isArray(row['Products Sold']) && row['Products Sold'].length > 0) {
            let productRows = '';
            row['Products Sold'].forEach((p, index) => {
                productRows += `
                <tr>
                    <td class="border px-2 py-1 text-center">${index + 1}</td>
                    <td class="border px-2 py-1">${p.product_name}</td>
                    <td class="border px-2 py-1 text-right">${p.quantity}</td>
                    <td class="border px-2 py-1 text-right">Rp ${Number(p.total_amount).toLocaleString('id-ID')}</td>
                </tr>`;
            });

            content += `
            <h3 class="mt-4 font-semibold">Daftar Produk yang Dijual</h3>
            <div class="overflow-x-auto mt-2">
                <table class="min-w-full text-sm border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">No</th>
                            <th class="border px-2 py-1">Nama Produk</th>
                            <th class="border px-2 py-1 text-right">Qty</th>
                            <th class="border px-2 py-1 text-right">Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${productRows}
                    </tbody>
                </table>
            </div>`;
        }

        document.getElementById('detailContent').innerHTML = content;
        document.getElementById('detailModal').classList.remove('hidden');
    }


    function closeDetail() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
