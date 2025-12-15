<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SalesController;
use App\Models\Order;

// Redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// User Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserOrderController::class, 'index'])->name('dashboard');
});

// Profile & Orders
Route::middleware('auth')->group(function () {
    // Basic direct order (if used elsewhere)
    Route::post('/order', [UserOrderController::class, 'store'])->name('order.store');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        $customerOrders = Order::with(['user', 'product'])->get();
        return view('admin.dashboard', compact('customerOrders'));
    })->name('dashboard');

    // Product CRUD
    Route::resource('products', ProductController::class);
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    
    // Toggle Status
    Route::patch('/products/{id}/toggle', [ProductController::class, 'toggleStatus'])
        ->name('products.toggle');
        
    // Orders history
    Route::get('/history', [UserOrderController::class, 'history'])->name('orders.history');
    Route::post('/orders/{id}/complete', [UserOrderController::class, 'complete'])->name('orders.complete');

    // Stock management
    Route::get('/stock/sales', [SalesController::class, 'index'])->name('stock.sales');
    Route::get('/stock', [UserOrderController::class, 'trackStock'])->name('stock.index');
    Route::get('/stock/alerts', [UserOrderController::class, 'lowStockAlerts'])->name('stock.alerts');
    Route::get('/stock/edit', [UserOrderController::class, 'editStock'])->name('stock.edit');
    Route::patch('/stock/{id}', [UserOrderController::class, 'updateStock'])->name('stock.update');
});

// Cart + Checkout
Route::middleware('auth')->group(function () {

    Route::get('/cart', [UserOrderController::class, 'cart'])->name('cart');

    // ✅ FIXED: Changed POST to GET so the link works
    Route::get('/checkout', [UserOrderController::class, 'checkout'])->name('checkout');
    
    // Processes the form submission (Confirm Order)
    Route::post('/orders', [UserOrderController::class, 'confirmOrder'])->name('orders.store');

    // Remove from cart
    Route::delete('/cart/remove/{id}', [UserOrderController::class, 'removeFromCart'])
        ->name('cart.remove');

    Route::get('/my-orders/{id}/receipt', [UserOrderController::class, 'viewReceipt'])
        ->name('user.order.receipt');
});

// Customize product
Route::middleware('auth')->group(function () {
    Route::get('/user/customize/{product}', [UserOrderController::class, 'customize'])
        ->name('user.customize');

    Route::post('/user/customize/{product}', [UserOrderController::class, 'addCustomOrder'])
        ->name('products.add_custom_order');
});

require __DIR__ . '/auth.php';