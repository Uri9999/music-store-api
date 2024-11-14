<?php

namespace App\Providers;

use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\AuthServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\RequestTabRepositoryInterface;
use App\Interfaces\RequestTabServiceInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Interfaces\TabServiceInterface;
use App\Repositories\AuthRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\RequestTabRepository;
use App\Repositories\TabRepository;
use App\Services\AuthService;
use App\Services\CategoryService;
use App\Services\RequestTabService;
use App\Services\TabService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);

        $this->app->bind(TabRepositoryInterface::class, TabRepository::class);
        $this->app->bind(TabServiceInterface::class, TabService::class);

        $this->app->bind(RequestTabRepositoryInterface::class, RequestTabRepository::class);
        $this->app->bind(RequestTabServiceInterface::class, RequestTabService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
