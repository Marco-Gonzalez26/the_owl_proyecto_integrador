<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckEmployeeOrAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get("/sobre-nosotros", [AboutUsController::class, "index"])->name("about-us");

Route::middleware([CheckEmployeeOrAdmin::class, "auth"])->group(function () {
    Route::prefix('/panel')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::get('/productos', [ProductController::class, 'index'])->name('products.index');

        Route::get('/productos/crear', [ProductController::class, 'showCreate'])->name('products.create');

        Route::get('/productos/{id}/editar', [ProductController::class, 'showEdit'])->name('products.edit');

        // Categories
        Route::get('/categorias', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/categorias/crear', [CategoriesController::class, 'showCreate'])->name('categories.create');
        Route::get('/categorias/{id}/editar', [CategoriesController::class, 'showEdit'])->name('categories.edit');

        // Brands
        Route::get('/marcas', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/marcas/{id}/editar', [BrandController::class, 'showEdit'])->name('brands.edit');
        Route::get('/marcas/crear', [BrandController::class, 'showCreate'])->name('brands.create');





        // API WEB ROUTES
        // Products
        Route::post('/api/productos/crear', [ProductController::class, 'store'])->name('api.products.create');

        Route::put('/api/productos/{id}/editar', [ProductController::class, 'update'])->name('api.products.update');

        Route::delete('/api/productos/{id}/eleminar', [ProductController::class, 'destroy'])->name('api.products.destroy');

        // Categories
        Route::post('/api/categorias/crear', [CategoriesController::class, 'store'])->name('api.categories.create');
        Route::put('/api/categorias/{id}/editar', [CategoriesController::class, 'update'])->name('api.categories.update');

        Route::delete('/categorias/{id}/eliminar', [CategoriesController::class, 'destroy'])->name('api.categories.destroy');
    });
});


Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');

Route::middleware('auth')->group(function () {


    Route::get("/mis-pedidos", [OrderController::class, "showUserOrders"])->name("user.orders");

    Route::post('/pedido', [CheckoutController::class, 'createCartCheckoutSession'])->name('checkout.create');

    Route::get('/pedido/exitoso', [CheckoutController::class, "checkOutSuccess"])->name('checkout.success');
    Route::get('/pedido/error', [CheckoutController::class, "error"])->name('checkout.error');
    Route::get('/pedido/cancelado', [CheckoutController::class, "cancel"])->name('checkout.cancel');
});



Route::get('/producto/{id}', [ProductController::class, 'show'])->name('product.show');
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
