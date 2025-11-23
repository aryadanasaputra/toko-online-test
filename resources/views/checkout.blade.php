<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(empty($cart))
                        <p>Your cart is empty.</p>
                    @else
                        <h3 class="text-lg font-semibold mb-4">Your Cart</h3>
                        <div class="mb-6">
                            @foreach($cart as $item)
                                <div class="flex justify-between items-center border-b py-2">
                                    <div>
                                        <p class="font-medium">{{ $item['name'] }}</p>
                                        <p class="text-sm text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="font-bold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <form action="{{ route('orders.place') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Shipping
                                    Address</label>
                                <textarea name="address" id="address" rows="4"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                            </div>
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200 shadow-md">Place
                                Order</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>