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
                                    <button class="bg-red-700 hover:bg-blue-800 text-white px-3 py-1 rounded text-sm"
                                        onclick="showDetail({{ json_encode($row) }})">
                                        See
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
                            <div id="detailContent" class="text-sm space-y-1">
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
        let content = `
            <p><strong>SPGM:</strong> ${row['SPGM']}</p>
            <p><strong>Company:</strong> ${row['Company']}</p>
            <p><strong>Target:</strong> ${row['Target (Jt)']}</p>
            <p><strong>Actual:</strong> ${row['Actual (Jt)']}</p>
            <p><strong>% Achieved:</strong> ${row['% Achieved']}%</p>
            <p><strong>Bigsize Target:</strong> ${row['Target Bigsize (Jt)']}</p>
            <p><strong>Bigsize Actual:</strong> ${row['Bigsize Actual (Jt)']}</p>
            <p><strong>% Bigsize:</strong> ${row['% Bigsize']}%</p>
            <p><strong>Paid % Achieved:</strong> ${row['Paid % Achieved']}%</p>
            <p><strong>Paid % Bigsize:</strong> ${row['Paid % Bigsize']}%</p>
            <p><strong>Total Incentive Percent:</strong> ${row['Total Incentive Percent']}%</p>
            <p><strong>Total Incentive (IDR):</strong> Rp ${Number(row['Total Incentive (IDR)']).toLocaleString('id-ID')}</p>
        `;
        document.getElementById('detailContent').innerHTML = content;
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
