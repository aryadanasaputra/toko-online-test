<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                <p class="text-gray-600">{{ $product->description }}</p>
                                <p class="text-green-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-sm">Stock: {{ $product->stock }}</p>
                                @if($product->category)
                                    <p class="text-sm text-gray-500">Category: {{ $product->category->name }}</p>
                                @endif
                                <form action="{{ route('products.show', $product->id) }}" method="get"
                                    class="mt-2 inline-block">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium stroke-red-600 px-4 py-2 rounded shadow-md transition duration-200">
                                        View Details
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>