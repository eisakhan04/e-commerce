<?php

namespace Modules\Category\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Category\Interfaces\CategoryRepositoryInterface;
use Modules\Category\Interfaces\CategoryServiceInterface;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Services\CategoryService;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
