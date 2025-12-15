<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-2xl border border-gray-200">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-black text-gray-800 uppercase">Your Receipt</h1>
                    <p class="text-gray-500">Order #{{ $order->receipt_number }} confirmed.</p>
                </div>

                <div class="border-t border-b py-6 mb-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Items Purchased</h3>
                    
                    @foreach($order->items as $item)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-700">
                                {{ $item->product_name }} (x{{ $item->quantity }})
                            </span>
                            <span class="font-bold text-gray-900">
                                ₱{{ number_format($item->price_at_purchase * $item->quantity, 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="bg-gray-800 text-white p-6 rounded-xl flex justify-between items-center mt-6">
                    <span class="uppercase text-xs font-bold tracking-widest">Total Paid</span>
                    <span class="text-2xl font-black">
                        ₱{{ number_format($order->total_amount, 2) }}
                    </span>
                </div>

                <div class="mt-10 flex gap-4 no-print">
                    <button onclick="window.print()" class="flex-1 bg-purple-600 text-white py-3 rounded-xl font-bold hover:bg-purple-700 transition">
                        Print Copy
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex-1 text-center bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                        Back to Menu
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>