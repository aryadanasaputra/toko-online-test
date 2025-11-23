<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold">{{ $product->name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $product->description }}</p>
                        <p class="text-green-600 text-xl font-bold mt-4">Rp
                            {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-sm mt-2">Stock: {{ $product->stock }}</p>
                        @if($product->category)
                            <p class="text-sm text-gray-500">Category: {{ $product->category->name }}</p>
                        @endif
                    </div>

                    @auth
                        @if(!in_array(auth()->user()->role, ['admin', 'cs1', 'cs2']))
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <label for="qty" class="text-sm font-medium">Quantity:</label>
                                    <input type="number" name="qty" id="qty" value="1" min="1" max="{{ $product->stock }}"
                                        class="border border-gray-300 rounded px-3 py-2 w-20">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">Add
                                        to Cart</button>
                                </div>
                            </form>
                        @else
                            <p class="mt-6 text-red-500">You do not have permission to place orders.</p>
                        @endif
                    @endauth

                    @guest
                        <p class="mt-6 text-gray-500">Please <a href="{{ route('login') }}" class="text-blue-500">login</a>
                            to add to cart.</p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-app-layout>