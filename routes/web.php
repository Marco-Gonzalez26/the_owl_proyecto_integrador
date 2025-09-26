<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrandSizeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Mail\OrderConfirmationEmail;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckEmployeeOrAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
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

        // Users
        Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
        Route::get('/usuarios/crear', [UserController::class, 'showCreate'])->name('users.create');
        Route::get('/usuarios/{id}/editar', [UserController::class, 'showEdit'])->name('users.edit');

        // Brands
        Route::get('/marcas', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/marcas/{id}/editar', [BrandController::class, 'showEdit'])->name('brands.edit');
        Route::get('/marcas/crear', [BrandController::class, 'showCreate'])->name('brands.create');

        // Sizes
        Route::get('/tamaños', [SizeController::class, 'index'])->name('sizes.index');
        Route::get('/tamaños/crear', [SizeController::class, 'showCreate'])->name('sizes.create');
        Route::get('/tamaños/{id}/editar', [SizeController::class, 'showEdit'])->name('sizes.edit');

        //Orders
        Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
        Route::get("/pedidos/{id}", [OrderController::class, 'show'])->name('orders.show');
        Route::get('/pedidos/{id}', [OrderController::class, 'showEdit'])->name('orders.showEdit');
        Route::put('/pedidos/{id}/edit', [OrderController::class, 'update'])->name('orders.update');



        // API WEB ROUTES
        // Products
        Route::post('/api/productos/crear', [ProductController::class, 'store'])->name('api.products.create');

        Route::put('/api/productos/{id}/editar', [ProductController::class, 'update'])->name('api.products.update');

        Route::delete('/api/productos/{id}/eleminar', [ProductController::class, 'destroy'])->name('api.products.destroy');

        // Categories
        Route::post('/api/categorias/crear', [CategoriesController::class, 'store'])->name('api.categories.create');
        Route::put('/api/categorias/{id}/editar', [CategoriesController::class, 'update'])->name('api.categories.update');

        Route::delete('/categorias/{id}/eliminar', [CategoriesController::class, 'destroy'])->name('api.categories.destroy');

        // Sizes
        Route::post('/api/tamaños/crear', [SizeController::class, 'store'])->name('api.sizes.create');
        Route::put('/api/tamaños/{id}/editar', [SizeController::class, 'update'])->name('api.sizes.update');
        Route::delete('/tamaños/{id}/eliminar', [SizeController::class, 'destroy'])->name('api.sizes.destroy');

        // Brands

        Route::post('/api/marcas/crear', [BrandController::class, 'store'])->name('api.brands.create');
        Route::put('/api/marcas/{id}/editar', [BrandController::class, 'update'])->name('api.brands.update');
        Route::delete("/api/marcas/{id}/eliminar", [BrandController::class, 'destroy'])->name('api.brands.destroy');

        // BrandSize
        Route::get('/marcas/{brandId}/tamaños', [BrandSizeController::class, 'getSizesByBrandId'])
            ->name('api.brands.sizes.by-brand');

        Route::post('/api/marca_tamaño/crear', [BrandSizeController::class, 'store'])->name('api.brand_sizes.create');
        Route::delete('/api/marca_tamaño/eliminar', [BrandSizeController::class, 'destroy'])->name('api.brand_sizes.destroy');

        // Orders
        Route::put('/pedidos/{id}/edit', [OrderController::class, 'update'])->name('api.orders.update');

        // Users
        Route::post('/api/usuarios/crear', [UserController::class, 'store'])->name('api.users.store');
        Route::put('/api/usuarios/{id}/editar', [UserController::class, 'update'])->name('api.users.update');
        Route::delete('/api/usuarios/{id}/eliminar', [UserController::class, 'destroy'])->name('api.users.destroy');
    });
});



Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');

Route::get('/producto/{id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware('auth')->group(function () {


    Route::get("/mis-pedidos", [OrderController::class, "showUserOrders"])->name("user.orders");

    Route::post('/pedido', [CheckoutController::class, 'createCartCheckoutSession'])->name('checkout.create');

    Route::get('/pedido/exitoso', [CheckoutController::class, "checkOutSuccess"])->name('checkout.success');
    Route::get('/pedido/error', [CheckoutController::class, "error"])->name('checkout.error');
    Route::get('/pedido/cancelado', [CheckoutController::class, "cancel"])->name('checkout.cancel');
});




require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
