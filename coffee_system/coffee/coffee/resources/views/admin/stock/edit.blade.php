<x-app-layout>
    <style>
        /* ================================
           Classic Coffee Stock Inventory
           + Low Stock Highlight
        ================================= */
        body {
            font-family: 'Georgia', serif;
            background: #f3ece5; /* warm coffee tone */
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

        td.text-purple-700 {
            font-weight: 700;
        }

        input[type="number"] {
            border: 1px solid #d9c5b4;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 0.9rem;
            width: 5rem;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #6b4b3b;
            box-shadow: 0 0 5px rgba(107,75,59,0.3);
        }

        button {
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-weight: bold;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(75,46,21,0.2);
        }

        .bg-blue-600:hover {
            background-color: #4a3a6b;
        }

        .bg-green-600:hover {
            background-color: #356b3c;
        }

        .bg-gray-500:hover {
            background-color: #5e5e5e;
        }

        /* Low Stock Highlight */
        .low-stock {
            background: linear-gradient(90deg, #fcd34d, #f87171); /* orange to red gradient */
            color: #fff;
            font-weight: bold;
        }

        /* Back to Dashboard Button */
        .btn-dashboard {
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

        .btn-dashboard:hover {
            background: #5e5e5e;
            transform: translateY(-1px);
        }

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
            }

            td.text-center {
                justify-content: flex-start;
            }

            .flex {
                flex-direction: column;
                gap: 8px;
            }

            input[type="number"] {
                width: 100%;
            }

            .flex.justify-end {
                justify-content: flex-start;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Manage Stock Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Back to Dashboard Button -->
                <a href="{{ route('admin.dashboard') }}" class="btn-dashboard">&larr; Back to Dashboard</a>

                <table>
                    <thead>
                        <tr>
                            <th>Product</th> 
                            <th>Current Stock</th>
                            <th>Edit Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td data-label="Product">{{ $product->name }}</td>
                                <td data-label="Current Stock" class="text-purple-700 text-2xl font-black 
                                    @if($product->stock_quantity <= 5) low-stock @endif">
                                    {{ $product->stock_quantity }}
                                </td>
                                <td data-label="Edit Quantity">
                                    <form action="{{ route('admin.stock.update', $product->id) }}" method="POST" class="flex items-center gap-3">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <input type="number" name="quantity_input" placeholder="Qty" required>
                                        
                                        <button type="submit" name="action" value="overwrite" class="bg-blue-600 text-white">
                                            Set as Total
                                        </button>

                                        <button type="submit" name="action" value="add" class="bg-green-600 text-white">
                                            Add Stock
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-10 flex justify-end">
                    <a href="{{ route('admin.stock.index') }}" 
                       class="bg-gray-500 text-white px-5 py-2 text-sm rounded-lg shadow font-bold">
                        &larr; Go to Tracking
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
