<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <p><strong>Status:</strong>
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'awaiting_payment') bg-blue-100 text-blue-800
                                @elseif($order->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($order->status == 'packing') bg-purple-100 text-purple-800
                                @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </p>
                        <p><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                    <div class="mb-6">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center border-b py-2">
                                <div>
                                    <p class="font-medium">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                </div>
                                <p class="font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    @if($order->status == 'awaiting_payment')
                        <form action="{{ route('payments.upload', $order->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="file" class="block text-sm font-medium text-gray-700">Upload Payment
                                    Proof</label>
                                <input type="file" name="file" id="file" class="mt-1 block w-full" required>
                            </div>
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">Upload</button>
                        </form>

                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-200 shadow-md"
                                onclick="return confirm('Are you sure you want to cancel this order?')">Cancel
                                Order</button>
                        </form>
                    @endif

                    @if($order->payment)
                        <div class="mt-6">
                            <h4 class="text-md font-semibold">Payment Status: {{ ucfirst($order->payment->status) }}</h4>
                            @if($order->payment->file_path)
                                <img src="{{ asset('storage/' . $order->payment->file_path) }}" alt="Payment Proof"
                                    class="mt-2 max-w-xs">
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>