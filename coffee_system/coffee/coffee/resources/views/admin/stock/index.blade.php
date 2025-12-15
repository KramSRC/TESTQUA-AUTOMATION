<x-app-layout>
    <style>
        /* ===========================
           Classic Live Inventory with Gradient Highlight
        =========================== */
        body {
            font-family: 'Georgia', serif;
            background: #f3ece5; /* soft coffee tone */
            color: #4b2e15;
        }

        .bg-white {
            background: #fffdfc;
            border: 1px solid #d9c5b4;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(75,46,21,0.1);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .bg-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(75,46,21,0.15);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #f7efe7;
            font-weight: bold;
            font-size: 0.95rem;
            color: #4b2e15;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            background: #fff8f0;
            border-radius: 6px;
            transition: background 0.25s ease, transform 0.25s ease;
        }

        tbody tr:hover {
            background: #f4e6dc;
            transform: translateY(-1px);
        }

        td {
            font-size: 0.9rem;
            color: #4b2e15;
        }

        td.text-center {
            text-align: center;
        }

        td.text-right {
            text-align: right;
        }

        .stock-healthy {
            background-color: #d1fae5;
            color: #065f46;
            padding: 6px 12px;
            border-radius: 9999px;
            font-weight: bold;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .stock-critical {
            background: linear-gradient(90deg, #ff4e42, #b91c1c);
            color: #fff;
            padding: 6px 12px;
            border-radius: 9999px;
            font-weight: bold;
            font-size: 0.75rem;
            text-transform: uppercase;
            animation: pulse 1.5s infinite;
        }

        .quantity {
            font-size: 1.8rem;
            font-weight: 800;
        }

        .quantity.low-stock {
            background: linear-gradient(90deg, #ff4e42, #fca5a5);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.85; }
        }

        a {
            color: #6b21a8;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.25s ease;
        }

        a:hover {
            text-decoration: underline;
            color: #4b1c7a;
        }

        .btn-back {
            display: inline-block;
            background: #7e7e7e;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 8px;
            padding: 8px 16px;
            margin-bottom: 12px;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-back:hover {
            background: #5e5e5e;
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            thead tr {
                display: none;
            }

            tbody tr {
                margin-bottom: 15px;
                border: 1px solid #d9c5b4;
                border-radius: 6px;
                padding: 10px;
                background: #fffdfc;
            }

            td {
                display: flex;
                justify-content: space-between;
                padding: 8px 10px;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #4b2e15;
                text-transform: uppercase;
                font-size: 0.75rem;
            }

            td.text-center, td.text-right {
                justify-content: flex-start;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Live Inventory Tracking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back to Dashboard Button -->
            <a href="{{ route('admin.dashboard') }}" class="btn-back">&larr; Back to Dashboard</a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Stock Health</th>
                            <th class="text-right">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td data-label="Product">
                                    <div class="font-black">{{ $product->name }}</div>
                                </td>
                                <td data-label="Quantity" class="text-center quantity {{ $product->stock_quantity <= 5 ? 'low-stock' : '' }}">
                                    {{ $product->stock_quantity }}
                                </td>
                                <td data-label="Stock Health" class="text-center">
                                    @if($product->stock_quantity <= 5)
                                        <span class="stock-critical">Critical Restock</span>
                                    @else
                                        <span class="stock-healthy">Healthy</span>
                                    @endif
                                </td>
                                <td data-label="Quick Actions" class="text-right">
                                    <a href="{{ route('admin.stock.edit') }}">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
