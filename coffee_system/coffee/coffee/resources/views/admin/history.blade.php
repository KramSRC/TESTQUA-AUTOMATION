<x-app-layout>
    <style>
        /* ================================
           Coffee Shop Classic Sales History
        ================================= */
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: #f3ece5; /* warm coffee tone */
            color: #4b2e15;
        }

        /* Card container */
        .bg-white {
            background: #fffdfc;
            border: 1px solid #d9c5b4;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(75,46,21,0.1);
            transition: box-shadow 0.25s ease, transform 0.25s ease;
        }

        .bg-white:hover {
            box-shadow: 0 10px 25px rgba(75,46,21,0.15);
            transform: translateY(-2px);
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px; /* spacing between rows */
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

        td.font-bold {
            font-weight: 700;
        }

        td.text-green-600 {
            color: #3c6e47; /* dark green for totals */
        }

        /* Go Back Button */
        button {
            background: #7e5a3c;
            color: #fff;
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background 0.25s ease, transform 0.25s ease;
        }

        button:hover {
            background: #5e402a;
            transform: translateY(-1px);
        }

        /* Header */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
                border: none;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #4b2e15;
            }

            td.text-center {
                justify-content: flex-start;
            }
        }
    </style>

    <x-slot name="header">
        <div class="header-container">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sales History</h2>
            <button onclick="window.history.back()">&larr; Go Back</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th>Total Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td data-label="Date" class="text-sm">{{ $transaction->updated_at->format('M d, Y H:i') }}</td>
                            <td data-label="Customer">{{ $transaction->user->name }}</td>
                            <td data-label="Product">{{ $transaction->product->name }}</td>
                            <td data-label="Qty" class="text-center">{{ $transaction->quantity }}</td>
                            <td data-label="Total Sale" class="font-bold text-green-600">
                                ₱ {{ number_format($transaction->product->price * $transaction->quantity, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-500">
                                No transactions recorded yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
