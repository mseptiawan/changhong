<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Summary Revenue Bulanan
            </h2>

            <form action="{{ route('transaksi.summary') }}" method="GET" class="flex items-center space-x-2">
                <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}"
                    class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm shadow">
                    Filter
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-6 px-4">
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr class="text-xs text-gray-700 uppercase text-left">
                        <th class="px-4 py-2">SPGM</th>
                        <th class="px-4 py-2">Company</th>
                        <th class="px-4 py-2">Target (Jt)</th>
                        <th class="px-4 py-2">Actual (Jt)</th>
                        <th class="px-4 py-2">% Achieved</th>
                        <th class="px-4 py-2">Target Bigsize (Jt)</th>
                        <th class="px-4 py-2">Bigsize Actual (Jt)</th>
                        <th class="px-4 py-2">% Bigsize</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm capitalize">
                    @forelse ($summary as $row)
                        @if ($row->actual_sales > 0)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-2">{{ ucwords(strtolower($row->spgm_name)) }}</td>
                                <td class="px-4 py-2">{{ $row->company }}</td>
                                <td class="px-4 py-2 text-right">
                                    {{ number_format($row->target_amount / 1_000_000, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right">
                                    {{ number_format($row->actual_sales) }}</td>
                                <td class="px-4 py-2 text-right">{{ $row->percent_achieved }}%</td>
                                <td class="px-4 py-2 text-right">
                                    {{ number_format($row->target_bigsize / 1_000_000, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right">
                                    {{ number_format($row->bigsize_sales) }}</td>
                                <td class="px-4 py-2 text-right">{{ $row->percent_bigsize }}%</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="text-center px-4 py-4 text-gray-500">
                                Tidak ada data untuk bulan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
