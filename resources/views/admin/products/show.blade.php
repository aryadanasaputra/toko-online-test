<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product Details: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Product Information</h3>
                        <div class="space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-200 shadow-md">Edit</a>
                            <a href="{{ route('admin.products.index') }}"
                                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 shadow-md">Back
                                to List</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">SKU</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->sku }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->name }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->description ?: 'No description' }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Price</label>
                                <p class="mt-1 text-sm text-gray-900">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Stock</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->stock }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->category->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div>
                            @if($product->image)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-white">Image</label>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="mt-2 max-w-full h-auto rounded-lg shadow-md">
                                </div>
                            @else
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-white">Image</label>
                                    <p class="mt-1 text-sm text-gray-500">No image uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>