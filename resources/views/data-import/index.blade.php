<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Upload Data Penjualan Promotor
        </h2>
    </x-slot>
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex justify-center items-center min-h-[70vh]">

        <form action="{{ route('data.import.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 w-full max-w-md">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="excel_file">
                    Pilih file Excel
                </label>
                <input type="file" name="excel_file" id="excel_file" accept=".xls,.xlsx"
                    class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
                @error('excel_file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-400 text-white px-6 py-2 rounded ">
                    Upload
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
