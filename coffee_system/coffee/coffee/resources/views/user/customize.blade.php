<x-app-layout>
    <style>
        /* ==============================
           Coffee Shop Customize Page
        =============================== */
        body {
            font-family: 'Georgia', serif;
            background: #f3ece5 url('https://www.transparenttextures.com/patterns/cream-paper.png') repeat;
            color: #4b2e15;
        }

        /* Matches your Dashboard Header */
        .coffee-header {
            background: linear-gradient(135deg, #4b2e15, #6f4e37);
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .coffee-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .customize-card {
            background: linear-gradient(145deg, #fff8f0, #f7eee5);
            border: 1px solid #e0d6c3;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            max-width: 600px;
            margin: auto;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .customize-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .customize-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 1rem;
            border-bottom: 3px solid #e0d6c3;
        }

        h2.product-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        p.price {
            font-weight: bold;
            color: #d97706;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;
            color: #6f4e37;
        }

        select,
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 0.7rem;
            border: 2px solid #d1c4b1;
            border-radius: 10px;
            margin-bottom: 1.2rem;
            font-weight: bold;
            background-color: #fff;
            outline: none;
            transition: 0.3s;
        }

        select:focus,
        input:focus {
            border-color: #d97706;
            box-shadow: 0 0 8px rgba(217, 119, 6, 0.2);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-submit,
        .btn-back {
            flex: 1;
            text-align: center;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: bold;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .btn-submit {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-back {
            background: #a47149;
            color: #fff;
        }

        .btn-back:hover {
            background: #6b4226;
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
    </style>

    <x-slot name="header">
        <div class="coffee-header">
            <h2>Customize Your Order ☕</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="customize-card">

                @if($product->image)
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                <div style="height: 250px; background: #e0d6c3; display: flex; align-items: center; justify-content: center; border-radius: 16px; margin-bottom: 1rem; color: #7a5c44; font-weight: bold;">
                    No Image Available
                </div>
                @endif

                <h2 class="product-title">{{ $product->name }}</h2>
                <p class="price">₱{{ number_format($product->price, 2) }}</p>

                <form action="{{ route('products.add_custom_order', $product->id) }}" method="POST">
                    @csrf

                    <label for="size">Size</label>
                    <select name="size" id="size" required>
                        <option value="small">Small (Regular)</option>
                        <option value="medium">Medium (+₱20)</option>
                        <option value="large">Large (+₱40)</option>
                    </select>

                    <label for="sugar">Sugar Level</label>
                    <select name="sugar" id="sugar" required>
                        <option value="no_sugar">0% No Sugar</option>
                        <option value="less_sugar">30% Less Sugar</option>
                        <option value="half_sugar">50% Half Sugar</option>
                        <option value="full_sugar">100% Full Sugar</option>
                    </select>

                    <label for="extra">Extra Ingredients (Optional)</label>
                    <input type="text" name="extra" id="extra" placeholder="e.g., Extra shot, Caramel drizzle...">

                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" required>

                    <div class="button-group">
                        <button type="submit" class="btn-submit">Add to Cart</button>
                        <a href="{{ route('dashboard') }}" class="btn-back">← Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>