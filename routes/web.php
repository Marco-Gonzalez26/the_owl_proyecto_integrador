<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckEmployeeOrAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get("/about-us", [AboutUsController::class, "index"])->name("about-us");

Route::middleware([CheckEmployeeOrAdmin::class, "auth"])->group(function () {
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');

        Route::get('/products/create', [ProductController::class, 'showCreate'])->name('products.create');

        Route::get('/products/{id}/edit', [ProductController::class, 'showEdit'])->name('products.edit');

        // Categories
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoriesController::class, 'showCreate'])->name('categories.create');
        Route::get('/categories/{id}/edit', [CategoriesController::class, 'showEdit'])->name('categories.edit');

        // Brands
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/{id}/edit', [BrandController::class, 'showEdit'])->name('brands.edit');
        Route::get('/brands/create', [BrandController::class, 'showCreate'])->name('brands.create');





        // API WEB ROUTES
        // Products
        Route::post('/api/products/create', [ProductController::class, 'store'])->name('api.products.create');

        Route::put('/api/products/{id}/edit', [ProductController::class, 'update'])->name('api.products.update');

        Route::delete('/api/products/{id}/delete', [ProductController::class, 'destroy'])->name('api.products.destroy');

        // Categories
        Route::post('/api/categories/create', [CategoriesController::class, 'store'])->name('api.categories.create');
        Route::put('/api/categories/{id}/edit', [CategoriesController::class, 'update'])->name('api.categories.update');

        Route::delete('/categories/{id}/delete', [CategoriesController::class, 'destroy'])->name('api.categories.destroy');
    });
});


Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');


Route::get('/checkout', function (Request $request) {


    $quantity = 5;

    return Inertia::resolveUrlUsing();
})->name('checkout');

Route::view('/checkout/success', 'checkout.success')->name('checkout.success');
Route::view('/checkout/cancel', 'checkout.cancel')->name('checkout.cancel');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');


Route::prefix('test')->name('test.')->group(function () {
    // Test cart page with sample data
    Route::get('/cart', [CheckoutController::class, 'testCart'])->name('cart');

    // Test checkout with predefined items
    Route::post('/checkout', [CheckoutController::class, 'testCheckout'])->name('checkout');

    // Test Stripe API connection
    Route::get('/stripe-connection', [CheckoutController::class, 'testStripeConnection'])->name('stripe.connection');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
