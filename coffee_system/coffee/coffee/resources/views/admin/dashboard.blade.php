<x-app-layout>
    <style>
        /* ==============================
           Coffee Shop Admin Dashboard
        ============================== */
        body {
            background: #f7f3ef;
            font-family: 'Poppins', sans-serif;
            color: #4b2e15;
        }

        /* Card Containers */
        .bg-white {
            background: #fffdfc;
            border-radius: 20px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top-width: 4px;
        }

        .bg-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        /* Card Headings */
        h2, h3 {
            color: #4b2e15;
        }

        h2 {
            font-weight: 800;
            font-size: 1.8rem;
        }

        h3 {
            font-weight: 700;
            font-size: 1.25rem;
        }

        /* Action Boxes */
        .group {
            background: #fff8f0;
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
            border-width: 2px;
        }

        .group:hover {
            background: #fff1e6;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(75,46,21,0.15);
        }

        .text-orange-600, .text-blue-600, .text-green-600, .text-purple-600 {
            font-weight: 700;
        }

        .text-orange-800, .text-blue-800, .text-green-800, .text-purple-800 {
            font-weight: 500;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fffdfc;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background: #f3e8e0;
            color: #4b2e15;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tbody tr:hover {
            background: #fff3e6;
            transition: background 0.3s ease;
        }

        /* Buttons */
        .btn {
            background: linear-gradient(135deg, #6f4436, #4b2e15);
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: 8px 14px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #3a2311;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 4px 12px rgba(75,46,21,0.3);
        }

        /* Responsive Grid */
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr !important;
            }

            .flex {
                flex-direction: column !important;
                gap: 12px;
            }

            .overflow-x-auto {
                overflow-x: scroll;
            }
        }

        @keyframes slideUpFade {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .bg-white {
            animation: slideUpFade 0.8s ease-out;
        }

        .group:hover {
            box-shadow: 0 8px 20px rgba(111,68,54,0.35);
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard - Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Inventory Actions -->
            <div class="bg-white p-8 rounded-lg shadow-md mb-8 border-t-4 border-blue-500">
                <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">Inventory Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('admin.products.index') }}" class="group block p-6 bg-orange-50 border-2 border-orange-200 rounded-xl hover:bg-orange-100 transition duration-300">
                        <div class="text-orange-600 font-bold text-lg mb-2">View Menu Items</div>
                        <p class="text-sm text-orange-800">Review existing coffee products and descriptions.</p>
                    </a>

                    <a href="{{ route('admin.products.create') }}" class="group block p-6 bg-blue-50 border-2 border-blue-200 rounded-xl hover:bg-blue-100 transition duration-300">
                        <div class="text-blue-600 font-bold text-lg mb-2">Add New Coffee</div>
                        <p class="text-sm text-blue-800">Create a new product with price and image.</p>
                    </a>

                    <a href="{{ route('admin.orders.history') }}" class="group block p-6 bg-green-50 border-2 border-green-200 rounded-xl hover:bg-green-100 transition duration-300">
                        <div class="text-green-600 font-bold text-lg mb-2">History</div>
                        <p class="text-sm text-green-800">View all recorded transactions and completed sales.</p>
                    </a>
                </div>
            </div>

            <!-- Live Pending Orders -->
            <div class="bg-white p-8 rounded-lg shadow-md mb-8 border-t-4 border-red-500">
                <h3 class="text-lg font-bold text-gray-900 mb-6 text-center">Live Pending Orders</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-4 font-bold text-sm text-gray-600 uppercase">Customer</th>
                                <th class="p-4 font-bold text-sm text-gray-600 uppercase">Product</th>
                                <th class="p-4 font-bold text-sm text-gray-600 uppercase text-center">Qty</th>
                                <th class="p-4 font-bold text-sm text-gray-600 uppercase">Total</th>
                                <th class="p-4 font-bold text-sm text-gray-600 uppercase text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customerOrders as $order)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-800">{{ $order->user->name }}</td>
                                    <td class="p-4 font-semibold text-gray-700">{{ $order->product->name }}</td>
                                    <td class="p-4 text-center">{{ $order->quantity }}</td>
                                    <td class="p-4 text-green-600 font-bold">
                                        ₱{{ number_format($order->product->price * $order->quantity, 2) }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn text-sm">
                                                Mark as Brewed
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-500 italic">
                                        No pending coffee orders. All caught up!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Live Stock Tracking -->
            <div class="bg-white p-8 rounded-lg shadow-md mb-8 border-t-4 border-purple-500">
                <h3 class="text-lg font-bold text-gray-900 mb-6 text-center">Live Stock Tracking</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('admin.stock.index') }}" class="group block p-6 bg-orange-50 border-2 border-orange-200 rounded-xl hover:bg-orange-100 transition">
                        <div class="text-orange-600 font-bold text-lg mb-2">Track Stock & Health</div>
                        <p class="text-sm text-orange-800">View current levels and critical stock health alerts.</p>
                    </a>

                    <a href="{{ route('admin.stock.edit') }}" class="group block p-6 bg-purple-50 border-2 border-purple-200 rounded-xl hover:bg-purple-100 transition">
                        <div class="text-purple-600 font-bold text-lg mb-2">Edit Stock</div>
                        <p class="text-sm text-purple-800">Manually update inventory quantities.</p>
                    </a>

                    <a href="{{ route('admin.stock.sales') }}" class="group block p-6 bg-green-50 border-2 border-green-200 rounded-xl hover:bg-green-100 transition">
                        <div class="text-green-600 font-bold text-lg mb-2">Sales & Revenue</div>
                        <p class="text-sm text-green-800">Track coffee shop sales performance.</p>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
