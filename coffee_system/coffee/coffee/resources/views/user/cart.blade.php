<x-app-layout>
    <style>
    /* ==============================
       Aesthetic Coffee Cart Theme
    =============================== */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fef8f5;
        color: #4b2e15;
    }

    /* Cart container */
    .bg-white {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        padding: 1.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .bg-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }
    th {
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: #7a5c44;
    }
    td {
        background: #fff7f0;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        color: #4b2e15;
        font-weight: 500;
    }
    td:last-child, th:last-child {
        text-align: right;
    }

    /* Remove Button */
    .remove-btn {
        background: #ffded4;
        color: #b3392b;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: 0.3s;
        border: none;
        cursor: pointer;
    }
    .remove-btn:hover {
        background: #ffb8a8;
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    /* Total Amount section */
    .total-box {
        background: #fff3e6;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-size: 1.125rem;
        font-weight: 700;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    }
    .text-2xl {
        color: #f59e0b;
    }

    /* Buttons */
    a, button {
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s;
        padding: 0.8rem 1.5rem; /* Increased padding for better click area */
        display: inline-block;
        text-decoration: none;
    }

    /* Continue Shopping Button */
    .bg-gray-200 {
        background: #ffeeda;
        color: #7a5c44;
    }
    .bg-gray-200:hover {
        background: #ffd9b3;
        transform: translateY(-2px);
    }

    /* Checkout Button (Green/Orange) */
    .bg-green-600 {
        background: #f59e0b;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    .bg-green-600:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Responsive */
    @media (max-width: 640px) {
        table th, table td {
            font-size: 0.875rem;
        }

        .flex.justify-end.gap-4 {
            flex-direction: column;
            align-items: stretch;
        }

        .flex.justify-end.gap-4 a, 
        .flex.justify-end.gap-4 button {
            width: 100%;
            text-align: center;
        }
    }
    </style>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-center md:text-left text-coffee-dark leading-tight">
            ☕ Your Coffee Cart
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($cartItems->isEmpty())
                    <p class="text-center text-gray-500 py-8">
                        Your cart is empty. 
                        <a href="{{ route('dashboard') }}" style="color: #f59e0b; text-decoration: underline;">Go get some coffee!</a>
                    </p>
                @else

                    <table class="mb-6">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    {{ $item->product->name }}
                                    @if($item->size || $item->sugar)
                                        <div style="font-size: 0.8rem; color: #888;">
                                            {{ ucfirst($item->size) }} | {{ $item->sugar }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td>₱{{ number_format(($item->product->price * $item->quantity), 2) }}</td>

                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="remove-btn">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-between items-center total-box mb-6">
                        <span>Total Amount:</span>
                        <span class="text-2xl">₱{{ number_format($total, 2) }}</span>
                    </div>

                    <div class="flex justify-end gap-4 flex-wrap">
                        <a href="{{ route('dashboard') }}" class="bg-gray-200">
                            Continue Shopping
                        </a>
                        
                        <a href="{{ route('checkout') }}" class="bg-green-600">
                            Place Order (Checkout)
                        </a>
                    </div>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>