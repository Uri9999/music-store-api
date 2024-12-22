<?php

namespace App\Providers;

use App\Events\NotificationCreated;
use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\ArticleServiceInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\AuthServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\RequestTabRepositoryInterface;
use App\Interfaces\RequestTabServiceInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Interfaces\TabServiceInterface;
use App\Listeners\PushFCM;
use App\Repositories\AuthRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\RequestTabRepository;
use App\Repositories\TabRepository;
use App\Services\AuthService;
use App\Services\CategoryService;
use App\Services\RequestTabService;
use App\Services\TabService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\CartService;
use App\Interfaces\CartServiceInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\DashboardServiceInterface;
use App\Interfaces\DeviceTokenRepositoryInterface;
use App\Interfaces\DeviceTokenServiceInterface;
use App\Interfaces\FCMServiceInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationServiceInterface;
use App\Repositories\CartRepository;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderItemServiceInterface;
use App\Interfaces\RevenueServiceInterface;
use App\Interfaces\ReviewTabRepositoryInterface;
use App\Interfaces\ReviewTabServiceInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Interfaces\SubscriptionServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Interfaces\UserSubscriptionRepositoryInterface;
use App\Interfaces\UserSubscriptionServiceInterface;
use App\Repositories\ArticleRepository;
use App\Repositories\DeviceTokenRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ReviewTabRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserSubscriptionRepository;
use App\Services\ArticleService;
use App\Services\DashboardService;
use App\Services\DeviceTokenService;
use App\Services\FCMService;
use App\Services\NotificationService;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\RevenueService;
use App\Services\ReviewTabService;
use App\Services\SubscriptionService;
use App\Services\UserService;
use App\Services\UserSubscriptionService;
use Illuminate\Support\Facades\Event;

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

        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);
        $this->app->bind(OrderItemServiceInterface::class, OrderItemService::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);

        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
        $this->app->bind(SubscriptionServiceInterface::class, SubscriptionService::class);

        $this->app->bind(RevenueServiceInterface::class, RevenueService::class);
        $this->app->bind(DashboardServiceInterface::class, DashboardService::class);

        $this->app->bind(UserSubscriptionRepositoryInterface::class, UserSubscriptionRepository::class);
        $this->app->bind(UserSubscriptionServiceInterface::class, UserSubscriptionService::class);

        $this->app->bind(ReviewTabRepositoryInterface::class, ReviewTabRepository::class);
        $this->app->bind(ReviewTabServiceInterface::class, ReviewTabService::class);

        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);

        $this->app->bind(DeviceTokenRepositoryInterface::class, DeviceTokenRepository::class);
        $this->app->bind(DeviceTokenServiceInterface::class, DeviceTokenService::class);

        $this->app->bind(FCMServiceInterface::class, FCMService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Event::listen(
        //     NotificationCreated::class,
        //     PushFCM::class,
        // );
    }
}
