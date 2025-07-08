<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800 leading-tight flex items-center gap-2">
            <i data-lucide="award" class="w-6 h-6 text-yellow-500"></i>
            Dashboard - Ranking Penjualan Bigsize
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Top 1 - 10 -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2 mb-4">
                    <i data-lucide="trophy" class="w-5 h-5 text-yellow-500"></i>
                    Top 1 - 10 Penjual Bigsize
                </h3>
                <div class="bg-white shadow rounded-2xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 text-sm font-medium">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Ranking</th>
                                <th class="px-4 py-2 text-left">Nama SPGM</th>
                                <th class="px-4 py-2 text-left">Qty Bigsize</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($top10 as $index => $item)
                                <tr>
                                    <td class="px-4 py-2 font-bold text-yellow-600">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $spgms[$item->spgms_id] ?? 'Tidak Diketahui' }}</td>
                                    <td class="px-4 py-2">{{ number_format($item->total_qty) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top 11 - 20 -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2 mb-4">
                    <i data-lucide="trophy" class="w-5 h-5 text-gray-500"></i>
                    Top 11 - 20 Penjual Bigsize
                </h3>
                <div class="bg-white shadow rounded-2xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 text-sm font-medium">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Ranking</th>
                                <th class="px-4 py-2 text-left">Nama SPGM</th>
                                <th class="px-4 py-2 text-left">Qty Bigsize</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($top20 as $index => $item)
                                <tr>
                                    <td class="px-4 py-2 font-bold text-gray-600">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $spgms[$item->spgms_id] ?? 'Tidak Diketahui' }}</td>
                                    <td class="px-4 py-2">{{ number_format($item->total_qty) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
