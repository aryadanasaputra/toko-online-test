<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    @if(isset($role) && $role == 'cs1')
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-4">Payments Awaiting Verification</h3>
                            @if($payments->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Order ID</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                User</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Proof</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($payments as $payment)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->order->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->order->user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp
                                                    {{ number_format($payment->order->total, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <img src="{{ asset('storage/' . $payment->file_path) }}" alt="Proof"
                                                        class="w-20 h-20 object-cover">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <form action="{{ route('cs.payments.verify', $payment->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-green-500 text-white px-3 py-1 rounded text-sm">Verify</button>
                                                    </form>
                                                    <form action="{{ route('cs.payments.reject', $payment->id) }}" method="POST"
                                                        class="inline ml-2">
                                                        @csrf
                                                        <input type="text" name="note" placeholder="Reason"
                                                            class="border px-2 py-1 text-sm" required>
                                                        <button type="submit"
                                                            class="bg-red-500 text-white px-3 py-1 rounded text-sm">Reject</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No payments awaiting verification.</p>
                            @endif
                        </div>
                    @elseif(isset($role) && $role == 'cs2')
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-4"> Ready for Shipment</h3>
                            @if($orders->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Order ID</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                User</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Items</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp
                                                    {{ number_format($order->total, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @foreach($order->items as $item)
                                                        {{ $item->product->name }} ({{ $item->quantity }})<br>
                                                    @endforeach
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <form action="{{ route('cs.orders.ship', $order->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Mark
                                                            Shipped</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No orders ready for shipment.</p>
                            @endif
                        </div>
                    @elseif(isset($role) && $role == 'admin')
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-4">Admin Dashboard</h3>
                            <p>Welcome, Admin. You can manage products and users here.</p>
                            <a href="{{ route('admin.products.import') }}"
                                class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-md transition duration-200">Import
                                Products</a>
                        </div>
                    @else
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-4">Available Products</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @php
                                    $products = \App\Models\Product::with('category')->take(6)->get();
                                @endphp
                                @foreach($products as $product)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h4 class="text-lg font-semibold">{{ $product->name }}</h4>
                                        <p class="text-gray-600">{{ $product->description }}</p>
                                        <p class="text-green-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm">Stock: {{ $product->stock }}</p>
                                        @if($product->category)
                                            <p class="text-sm text-gray-500">Category: {{ $product->category->name }}</p>
                                        @endif
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="mt-2 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-md transition duration-200">View Details</a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">View All
                                    Products</a>
                            </div>

                            @php
                                $cart = session()->get('cart', []);
                            @endphp
                            @if(!empty($cart))
                                <div class="mt-6">
                                    <a href="{{ route('checkout') }}"
                                        class="bg-green-500 hover:bg-green-600 text-gray-900 px-6 py-2 rounded shadow-md transition duration-200">Proceed
                                        to Checkout</a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>