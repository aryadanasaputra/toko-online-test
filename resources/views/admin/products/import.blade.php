ra<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Import Products
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <form action="{{ route('admin.products.import.post') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700">Upload Excel/CSV
                                File</label>
                            <input type="file" name="file" id="file" class="mt-1 block w-full" accept=".xlsx,.xls,.csv"
                                required>
                        </div>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">Import</button>
                    </form>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Import Format</h3>
                        <p class="text-sm text-gray-600">The file should have headers: sku, name, description, price,
                            stock, category_slug</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.products.index') }}"
                                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 shadow-md">Back
                                to Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>