<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Status
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold">Order #{{ $order->id }}</h4>
                                            <p class="text-sm text-gray-600">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                            <p class="text-sm text-gray-600">Items: {{ $order->items->count() }}</p>
                                            <p class="text-sm text-gray-600">Date: {{ $order->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <div class="text-right">
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
                                            <br>
                                            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <p class="text-gray-600">You haven't placed any orders yet.</p>
                        <div class="mt-4">
                            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
