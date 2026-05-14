<?php

namespace Modules\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Interfaces\ProductRepositoryInterface;
use Modules\Product\Interfaces\ProductServiceInterface;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductService;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
