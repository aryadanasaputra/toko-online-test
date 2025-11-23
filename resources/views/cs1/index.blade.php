<x-app-layout>
    @php
        $hasPendingPayments = isset($hasPendingPayments) ? $hasPendingPayments : false;
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Verification (CS Layer 1)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
                                        {{ number_format($payment->order->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ asset('storage/' . $payment->file_path) }}" alt="Proof"
                                            class="w-20 h-20 object-cover">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('cs.payments.verify', $payment->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-700 transition duration-200 shadow-md">Verify</button>
                                        </form>
                                        <form action="{{ route('cs.payments.reject', $payment->id) }}" method="POST"
                                            class="inline ml-2">
                                            @csrf
                                            <input type="text" name="note" placeholder="Reason"
                                                class="border px-2 py-1 text-sm" required>
                                            <button type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700 transition duration-200 shadow-md">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>