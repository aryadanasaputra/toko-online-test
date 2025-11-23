<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CSController;
use App\Http\Controllers\Admin\ProductBulkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = \App\Models\Product::with('category')->get();
    return view('products.index', compact('products'));
})->name('home');

Route::get('/products', function () {
    $products = \App\Models\Product::with('category')->get();
    return view('products.index', compact('products'));
})->name('products.index');

Route::get('/products/{id}', function ($id) {
    $product = \App\Models\Product::findOrFail($id);
    return view('products.show', compact('product'));
})->name('products.show');

Route::get('/dashboard', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role == 'cs1') {
            $payments = \App\Models\Payment::where('status', 'uploaded')->with('order.user')->get();
            return view('dashboard', compact('payments', 'role'));
        } elseif ($role == 'cs2') {
            $orders = \App\Models\Order::where('status', 'confirmed')->with('items')->get();
            return view('dashboard', compact('orders', 'role'));
        } elseif ($role == 'admin') {
            return view('dashboard', compact('role'));
        }
    }
    $products = \App\Models\Product::with('category')->take(6)->get();
    return view('dashboard', compact('products'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart and Orders
    Route::middleware(['deny_role:admin,cs1,cs2'])->group(function () {
        Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/orders', [OrderController::class, 'placeOrder'])->name('orders.place');
    });
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Payments
    Route::post('/payments/{orderId}', [PaymentController::class, 'upload'])->name('payments.upload');

    // CS Routes
    Route::middleware(['role:cs1'])->group(function(){
        Route::get('/cs/payments', [CSController::class, 'listPaymentsForVerification'])->name('cs.payments');
        Route::post('/cs/payments/{id}/verify', [CSController::class, 'verifyPayment'])->name('cs.payments.verify');
        Route::post('/cs/payments/{id}/reject', [CSController::class, 'rejectPayment'])->name('cs.payments.reject');
    });
    Route::middleware(['role:cs2'])->group(function(){
        Route::get('/cs/shipments', [CSController::class, 'listForShipment'])->name('cs.shipments');
        Route::post('/cs/orders/{id}/ship', [CSController::class, 'markShipped'])->name('cs.orders.ship');
    });

    // Admin
    Route::middleware(['role:admin'])->group(function(){
        Route::get('/admin/products/import', [ProductBulkController::class, 'showImport'])->name('admin.products.import');
        Route::post('/admin/products/import', [ProductBulkController::class, 'import'])->name('admin.products.import.post');
        Route::get('/admin/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/admin/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/admin/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/admin/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('admin.products.show');
        Route::get('/admin/products/{product}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/admin/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});

require __DIR__.'/auth.php';
