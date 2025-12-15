<x-app-layout>
    <style>
        /* ==============================
           Stylish Premium Coffee Shop Theme
        =============================== */
        body {
            font-family: 'Georgia', serif;
            color: #4b2e15;
        }

        /* Search Bar */
        .search-container {
            max-width: 450px;
            margin: 0 auto 1.5rem auto;
        }

        .search-container input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 2px solid #d1c4b1;
            border-radius: 12px;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        .search-container input:focus {
            border-color: #b88654;
            box-shadow: 0 0 10px rgba(180, 130, 95, 0.3);
        }

        /* --- UPDATED CATEGORY FILTER STYLES --- */
        .category-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
            justify-content: center;
        }

        .category-filter button {
            background: #ffffff;
            /* White background for unselected */
            color: #d97706;
            /* Orange text */
            border: 2px solid #f59e0b;
            /* Orange border */
            font-weight: bold;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        /* Active and Hover State (Orange Gradient) */
        .category-filter button.active,
        .category-filter button:hover {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
            /* White text */
            border-color: transparent;
            /* Remove border on active */
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Product Card Styles */
        .product-card {
            background: linear-gradient(145deg, #fff8f0, #f7eee5);
            border: 1px solid #e0d6c3;
            border-radius: 20px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: 0.3s ease;
        }

        .product-card img {
            border-bottom: 2px solid #e0d6c3;
            height: 220px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 1rem;
            width: 100%;
        }

        .product-card h3 {
            color: #4b2e15;
            font-size: 1.3rem;
            margin-top: 0.5rem;
            font-weight: bold;
        }

        /* Buttons */
        .btn-primary,
        .btn-customizable {
            display: inline-flex;
            width: 100%;
            justify-content: center;
            padding: 0.6rem 1rem;
            border-radius: 12px;
            font-weight: bold;
            text-align: center;
            transition: 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            transform: scale(1.05);
        }

        .btn-customizable {
            background: linear-gradient(135deg, #10b981, #047857);
            color: #fff;
            margin-top: 0.25rem;
        }

        .btn-customizable:hover {
            background: linear-gradient(135deg, #047857, #10b981);
            transform: scale(1.05);
        }

        /* Out of Stock */
        .out-of-stock {
            background-color: #d9d3ca;
            color: #7a5c44;
            font-weight: bold;
            text-align: center;
            border-radius: 12px;
            padding: 0.6rem;
            margin-top: 1rem;
            letter-spacing: 0.5px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 1024px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .grid {
                grid-template-columns: 1fr !important;
            }

            .category-filter {
                justify-content: center;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-coffee-dark leading-tight text-center md:text-left">
            ☕ Coffee Shop
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search coffee...">
        </div>

        <div class="category-filter">
            <button type="button" class="active" onclick="filterCategory('all')">All</button>
            <button type="button" onclick="filterCategory('espresso')">Espresso</button>
            <button type="button" onclick="filterCategory('latte')">Latte</button>
            <button type="button" onclick="filterCategory('cappuccino')">Cappuccino</button>
            <button type="button" onclick="filterCategory('frappuccino')">Frappuccino</button>
            <button type="button" onclick="filterCategory('tea')">Tea</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6" id="productGrid">
            @foreach($products as $product)
            <div class="product-card"
                data-category="{{ strtolower($product->categoryData->name ?? 'uncategorized') }}"
                data-name="{{ strtolower($product->name) }}">

                <img src="{{ asset('images/' . $product->image) }}" class="rounded">

                <h3>{{ $product->name }}</h3>
                <p class="font-bold text-lg">₱{{ number_format($product->price, 2) }}</p>

                @if($product->stock_quantity > 0)
                <div class="flex flex-col gap-3 mt-2">
                    <form action="{{ route('order.store') }}" method="POST" class="flex items-center gap-2 w-full">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1"
                            class="w-20 border border-gray-300 rounded-md text-center font-bold">
                        <button type="submit" class="btn-primary">Add to Cart</button>
                    </form>
                    <a href="{{ route('user.customize', $product->id) }}" class="btn-customizable">Customize</a>
                </div>
                @else
                <div class="out-of-stock">Out of Stock</div>
                @endif

            </div>
            @endforeach
        </div>
    </div>

    <script>
        // CATEGORY FILTER
        function filterCategory(category) {
            const cards = document.querySelectorAll('.product-card');

            // Normalize the clicked category to lowercase
            const targetCategory = category.toLowerCase();

            cards.forEach(card => {
                // Get the category from data attribute (already lowercase from PHP)
                const cardCategory = card.dataset.category;

                if (targetCategory === 'all') {
                    card.style.display = 'flex';
                } else {
                    // Check if the card's category contains the target string
                    card.style.display = cardCategory.includes(targetCategory) ? 'flex' : 'none';
                }
            });

            // Active button highlight
            const buttons = document.querySelectorAll('.category-filter button');
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
        }

        // 🔍 LIVE SEARCH FILTER
        document.getElementById("searchInput").addEventListener("keyup", function() {
            const search = this.value.toLowerCase();
            const cards = document.querySelectorAll(".product-card");

            cards.forEach(card => {
                const name = card.dataset.name;
                card.style.display = name.includes(search) ? "flex" : "none";
            });
        });
    </script>

</x-app-layout>