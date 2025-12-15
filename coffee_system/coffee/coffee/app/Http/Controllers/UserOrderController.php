<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    // ----------------------------------------------------------------
    // DASHBOARD & MENU
    // ----------------------------------------------------------------
    public function index()
    {
        // 1. If Admin, load Admin Dashboard
        if (Auth::user()->is_admin) {
            $products = Product::all();
            $customerOrders = Order::with(['user', 'product'])
                ->where('status', 'pending')
                ->latest()
                ->get();

            return view('admin.dashboard', compact('customerOrders', 'products'));
        }

        // 2. If User, load Menu
        $products = Product::all();
        $activeProducts = Product::where('status', 1)->get();
        return view('dashboard', compact('products', 'activeProducts'));
    }

    // ----------------------------------------------------------------
    // CART SYSTEM
    // ----------------------------------------------------------------

    // Add Simple Item to Cart (from Dashboard)
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Check if item already exists in cart
        $order = Order::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->where('status', 'in_cart')
            ->first();

        if ($order) {
            $order->quantity += $request->quantity;
            $order->save();
        } else {
            Order::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'status' => 'in_cart',
            ]);
        }

        return redirect()->back()->with('success', 'Added to cart!');
    }

    // View Cart Page
    public function cart()
    {
        $cartItems = Order::with('product')
            ->where('user_id', auth()->id())
            ->where('status', 'in_cart')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.cart', compact('cartItems', 'total'));
    }

    // Remove Item from Cart
    public function removeFromCart($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'in_cart')
            ->first();

        if ($order) {
            $order->delete();
            return redirect()->back()->with('success', 'Item removed.');
        }

        return redirect()->back()->with('error', 'Item not found.');
    }

    // ----------------------------------------------------------------
    // CUSTOMIZE ORDER
    // ----------------------------------------------------------------

    // Show Customize Page
    public function customize(Product $product)
    {
        return view('user.customize', compact('product'));
    }

    // Add Custom Item to Cart (FIXED THIS)
    public function addCustomOrder(Request $request, Product $product)
    {
        // 1. Validate inputs (Matches your Blade form)
        $data = $request->validate([
            'size' => 'required|string',
            'sugar' => 'required|string', // Changed from milk to sugar to match blade
            'extra' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // 2. Create Order in 'in_cart' status
        Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'size' => $data['size'],
            'sugar' => $data['sugar'],
            'extra' => $data['extra'] ?? null,
            'quantity' => $data['quantity'],
            'status' => 'in_cart', // IMPORTANT: Marks it as a cart item
        ]);

        return redirect()->route('cart')->with('success', 'Custom coffee added to cart!');
    }


    // ----------------------------------------------------------------
    // CHECKOUT SYSTEM
    // ----------------------------------------------------------------

    // 1. Show the Checkout Page (GET)
    public function checkout()
    {
        $cartItems = Order::with('product')
            ->where('user_id', auth()->id())
            ->where('status', 'in_cart')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('dashboard');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Return the Checkout View
        return view('checkout.index', compact('cartItems', 'total'));
    }

    // 2. Process the Order (POST) - Called when user clicks "Confirm"
    public function confirmOrder(Request $request)
    {
        // 1. Validate inputs (Added Address, Removed Dining/Table)
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20',
            'address'       => 'required|string|max:500', // New Rule
            'payment_method' => 'required'
        ]);

        $cartItems = \App\Models\Order::with('product')
            ->where('user_id', auth()->id())
            ->where('status', 'in_cart')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // 2. Save Receipt with Address
        $receipt = \App\Models\Receipt::create([
            'user_id'        => auth()->id(),
            'receipt_number' => 'REC-' . strtoupper(uniqid()),
            'total_amount'   => $total,
            'customer_name'  => $request->customer_name,
            'phone_number'   => $request->phone_number,
            'address'        => $request->address,        // Save Address
            'payment_method' => $request->payment_method,
            'notes'          => $request->notes,
        ]);

        // 3. Process Items
        foreach ($cartItems as $item) {
            $item->update(['status' => 'pending']);

            \App\Models\ReceiptItem::create([
                'receipt_id' => $receipt->id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price_at_purchase' => $item->product->price,
                'custom_details' => ($item->size ? "{$item->size}, " : "") . ($item->sugar ? "{$item->sugar}" : "")
            ]);

            if ($item->product->stock_quantity >= $item->quantity) {
                $item->product->decrement('stock_quantity', $item->quantity);
            }
        }

        return redirect()->route('user.order.receipt', $receipt->id)
            ->with('success', 'Order placed successfully!');
    }
    // View Receipt
    public function viewReceipt($id)
    {
        $order = Receipt::with('items')->findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.receipt', compact('order'));
    }


    // ----------------------------------------------------------------
    // ADMIN FUNCTIONS
    // ----------------------------------------------------------------

    public function complete($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'completed']);
        return back()->with('success', 'Order marked as completed!');
    }

    public function history()
    {
        $transactions = Order::with(['user', 'product'])
            ->where('status', 'completed')
            ->latest()
            ->get();
        return view('admin.history', compact('transactions'));
    }

    // Stock Functions
    public function trackStock()
    {
        $products = Product::all();
        return view('admin.stock.index', compact('products'));
    }

    public function lowStockAlerts()
    {
        $lowStock = Product::where('stock_quantity', '<=', 5)->get();
        return view('admin.stock.alerts', compact('lowStock'));
    }

    public function editStock()
    {
        $products = Product::all();
        return view('admin.stock.edit', compact('products'));
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $inputQty = (int) $request->quantity_input;

        if ($request->action === 'add') {
            $product->stock_quantity += $inputQty;
        } else {
            $product->stock_quantity = $inputQty;
        }
        $product->save();
        return back();
    }
}
