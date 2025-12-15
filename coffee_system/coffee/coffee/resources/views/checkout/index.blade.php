<x-app-layout>
    <style>
        /* ==============================
           Checkout Theme
        =============================== */
        :root {
            --primary: #4b2e15;
            --accent: #d97706;
            --bg-cream: #f9f5f0;
            --white: #ffffff;
            --gray-border: #e5e7eb;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-cream);
            color: var(--primary);
        }

        .checkout-header {
            background: linear-gradient(135deg, #4b2e15, #3e2612);
            padding: 2rem 0;
            text-align: center;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .checkout-container {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 2rem;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .card {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(75, 46, 21, 0.05);
            border: 1px solid #f0e6dd;
            margin-bottom: 1.5rem;
        }

        h3.section-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0e6dd;
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid var(--gray-border);
            border-radius: 10px;
            font-family: inherit;
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
        }

        /* Radio Grid for Payments */
        .radio-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .custom-radio {
            display: block;
            position: relative;
            cursor: pointer;
        }

        .custom-radio input {
            position: absolute;
            opacity: 0;
        }

        .radio-box {
            border: 2px solid var(--gray-border);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            background: #fff;
            transition: 0.2s;
        }

        .custom-radio input:checked~.radio-box {
            border-color: var(--accent);
            background-color: #fff8f1;
            color: var(--accent);
        }

        .receipt-card {
            background: #fff;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .receipt-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--accent);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px dashed #ddd;
        }

        .btn-confirm {
            width: 100%;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
        }

        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <x-slot name="header">
        <div class="checkout-header">
            <h2>Complete Your Order</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <div class="checkout-container">

                <div class="left-section">

                    <div class="card">
                        <h3 class="section-title">1. Customer Details</h3>

                        <div class="form-group">
                            <label for="customer_name">Full Name</label>
                            <input type="text" name="customer_name" id="customer_name"
                                class="form-input"
                                value="{{ auth()->user()->name }}"
                                placeholder="Enter your full name" required>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number"
                                class="form-input"
                                placeholder="e.g. 0912 345 6789" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Delivery Address</label>
                            <textarea name="address" id="address" rows="2"
                                class="form-input"
                                placeholder="Building, Street, City..." required></textarea>
                        </div>
                    </div>

                    <div class="card">
                        <h3 class="section-title">2. Payment Methods</h3>
                        <div class="radio-grid">
                            <label class="custom-radio">
                                <input type="radio" name="payment_method" value="cash" checked>
                                <div class="radio-box">💵 Cash</div>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="payment_method" value="gcash">
                                <div class="radio-box">📱 G-Cash</div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="notes">Special Notes</label>
                            <textarea name="notes" id="notes" rows="2" class="form-input" placeholder="Optional..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card receipt-card" style="height: fit-content;">
                    <h3 class="section-title">Order Summary</h3>

                    @foreach($cartItems as $item)
                    <div class="receipt-item">
                        <div>
                            <strong>{{ $item->quantity }}x {{ $item->product->name }}</strong>
                            @if($item->size || $item->sugar)
                            <br><small style="color:#888">{{ ucfirst($item->size) }} • {{ $item->sugar }}</small>
                            @endif
                        </div>
                        <span>₱{{ number_format(($item->product->price * $item->quantity), 2) }}</span>
                    </div>
                    @endforeach

                    <div class="receipt-total">
                        <span>Total</span>
                        <span>₱{{ number_format($total, 2) }}</span>
                    </div>

                    <button type="submit" class="btn-confirm">Confirm Order ☕</button>

                    <div style="text-align: center; margin-top: 15px;">
                        <a href="{{ route('cart') }}" style="color: #999; text-decoration: none; font-size: 0.9rem;">Back to Cart</a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>