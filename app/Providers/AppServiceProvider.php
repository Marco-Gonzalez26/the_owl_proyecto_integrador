<?php

namespace App\Providers;

use App\Interfaces\BrandRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CloudinaryServiceInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\RolesRepositoryInterface;


use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RolesRepository;


use App\Services\CloudinaryService;

use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);

        $this->app->bind(RolesRepositoryInterface::class, RolesRepository::class);

        $this->app->bind(CloudinaryServiceInterface::class, CloudinaryService::class);
        $this->app->singleton(StripeClient::class, function ($app) {
            return new StripeClient(["api_key" => env('STRIPE_SECRET')]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
