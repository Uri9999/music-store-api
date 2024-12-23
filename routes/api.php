<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Manage\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manage\CategoryController;
use App\Http\Controllers\Customer\TabController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RequestTabController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\Manage\UserController;
use App\Http\Controllers\Manage\RequestTabController as AdminRequestTabController;
use App\Http\Controllers\Manage\TabController as AdminTabController;
use App\Http\Controllers\Manage\OrderController as AdminOrderController;
use App\Http\Controllers\Manage\ArticleController as AdminArticleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Customer\ReviewTabController;
use App\Http\Controllers\Customer\UserSubscriptionController;
use App\Http\Controllers\Customer\DeviceTokenController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Manage\DashboardController;
use App\Http\Controllers\Manage\RevenueController;
use App\Http\Controllers\Manage\UserSubscriptionController as AdminUserSubscriptionController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Manage\ReviewTabController as AdminReviewTabController;
use App\Http\Controllers\Customer\UserController as CustomerUserController;

Route::middleware('api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify-user', [AuthController::class, 'verifyUser']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('selections', [SelectionController::class, 'index']);
    Route::get('policy', [AdminArticleController::class, 'getPolicy']);
    Route::get('tutorial', [AdminArticleController::class, 'getTutorial']);
    Route::get('subscriptions', [SubscriptionController::class, 'index']);
    Route::get('banners/list', [BannerController::class, 'getList']);

    Route::get('articles', [ArticleController::class, 'getArticle']);
    Route::get('articles/random', [ArticleController::class, 'getRandomArticle']);
    Route::get('articles/{id}', [ArticleController::class, 'getDetailArticle']);
    // Category
    // Route::get('categories', [CategoryController::class, 'index']);
    // Route::get('categories/{id}', [CategoryController::class, 'show']);

    Route::get('tabs', [TabController::class, 'index']);
    Route::get('new-tab', [TabController::class, 'getNewTab']);
    Route::get('random-tab', [TabController::class, 'getRandomTab']);
    Route::get('tabs/{id}', [TabController::class, 'show']);
    Route::get('tabs/by-user-id/{id}', [TabController::class, 'getTabByUserId']);
    Route::get('user/info/{id}', [CustomerUserController::class, 'show']);

    Route::get('device-tokens/send-demo', [DeviceTokenController::class, 'sendDemoToFirstToken']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('device-tokens', [DeviceTokenController::class, 'store']);

        Route::get('notifications', [NotificationController::class, 'index']);
        Route::get('notifications/my', [NotificationController::class, 'getMyNotify']);
        Route::get('notifications/read-all', [NotificationController::class, 'readAll']);
        Route::get('notifications/count-not-read', [NotificationController::class, 'countNotReadYet']);
        Route::get('notifications/{id}', [NotificationController::class, 'show']);

        Route::get('/auth/info', [AuthController::class, 'getInfo']);
        Route::post('/auth/update/info', [AuthController::class, 'updateProfile']);

        Route::get('carts/get-by-me', [CartController::class, 'getByUserId']);
        Route::get('carts/get-count-by-me', [CartController::class, 'getCountByUserId']);
        Route::delete('carts/{id}', [CartController::class, 'destroy'])->middleware('checkIsMyCart');
        Route::post('carts', [CartController::class, 'store'])->middleware('canAddToCart');

        Route::post('orders', [OrderController::class, 'store'])->middleware('DBTransaction');
        Route::get('orders/created-by-me', [OrderController::class, 'getMyOrder']);
        Route::get('orders/{id}', [OrderController::class, 'show'])->middleware('checkIsMyOrder');


        Route::get('tabs/get/by-ids', [TabController::class, 'getTabByIds']);
        
        Route::post('/tab/{id}/review', [ReviewTabController::class, 'store'])->middleware('canCreateReviewTab');

        Route::get('request-tabs/{id}', [RequestTabController::class, 'show']); // thêm middleware chỉ xem của chính mình
        Route::post('request-tabs', [RequestTabController::class, 'store']);
        Route::get('request-tabs/created/by-me', [RequestTabController::class, 'getCreatedByMy']);
        Route::put('request-tabs/{requestTab}', [RequestTabController::class, 'update'])->middleware('checkIsMyRequestTab');
        Route::delete('request-tabs/{id}', [RequestTabController::class, 'destroy'])->middleware('checkIsMyRequestTab');

        Route::post('subscription/register', [UserSubscriptionController::class, 'register'])->middleware('canRegisterSubscription');
        Route::post('subscription/{id}', [UserSubscriptionController::class, 'showSubscription']);
        Route::get('subscription/list', [UserSubscriptionController::class, 'listSubscription']);
        Route::get('user-subscriptions', [UserSubscriptionController::class, 'getMyUserSubscription']);

        Route::prefix('manage')->middleware(['role:Admin,Affiliate'])->group(function () {
            Route::get('request-tabs/by-receiver/{id}', [RequestTabController::class, 'getByReceiverId']);
        });

        Route::prefix('admin')->middleware(['role:Admin'])->group(function () {
            Route::get('/request-tabs', [RequestTabController::class, 'index']);

            Route::get('categories', [CategoryController::class, 'index']);
            Route::get('categories/{id}', [CategoryController::class, 'show']);
            Route::post('categories', [CategoryController::class, 'store']);
            Route::put('categories/{category}', [CategoryController::class, 'update']);
            Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

            Route::get('/user', [UserController::class, 'index']);
            Route::get('/user/manager', [UserController::class, 'getManager']);

            // only admin
            Route::post('/user/{id}/lock', [UserController::class, 'lock'])->middleware('canLockUser');
            Route::post('/user/{id}/unlock', [UserController::class, 'unlock']);
            Route::get('/user/{id}', [UserController::class, 'show']);
            Route::post('/user/{id}', [UserController::class, 'update']);

            Route::get('request-tabs', [AdminRequestTabController::class, 'index']);
            Route::delete('request-tabs/{id}', [AdminRequestTabController::class, 'destroy']);
            Route::post('/request-tabs/update-receiver/{requestTab}', [AdminRequestTabController::class, 'updateReceiver'])->middleware('canUpdateRequestTabReceiver');

            Route::get('tabs', [AdminTabController::class, 'index']);
            Route::post('tabs', [AdminTabController::class, 'store']);
            Route::get('tabs/{id}', [AdminTabController::class, 'show']);
            Route::post('tabs/{id}', [AdminTabController::class, 'update']);
            Route::delete('tabs/{id}', [AdminTabController::class, 'destroy']);
            Route::delete('tabs/{tabId}/images/{mediaId}', [AdminTabController::class, 'removeTabImage']);

            Route::get('banners', [BannerController::class, 'index']);
            Route::get('banners/{id}', [BannerController::class, 'show']);
            Route::post('banners', [BannerController::class, 'store']);
            Route::post('banners/{id}', [BannerController::class, 'update']);
            Route::delete('banners/{id}', [BannerController::class, 'destroy']);

            Route::get('orders', [AdminOrderController::class, 'index']);
            Route::get('orders/{id}', [AdminOrderController::class, 'show']);
            Route::post('orders/approval/{id}', [AdminOrderController::class, 'approval']);
            Route::post('orders/cancel/{id}', [AdminOrderController::class, 'cancel']);

            Route::get('articles', [AdminArticleController::class, 'index']);
            Route::get('articles/{id}', [AdminArticleController::class, 'show']);
            Route::post('articles', [AdminArticleController::class, 'store']);
            Route::post('articles/{id}', [AdminArticleController::class, 'update'])->middleware('canUpdateArticle');
            Route::delete('articles/{id}', [AdminArticleController::class, 'destroy'])->middleware('canDeleteArticle');

            Route::post('media/upload', [MediaController::class, 'upload']);

            Route::get('/user-subscriptions', [AdminUserSubscriptionController::class, 'index']);
            Route::post('/user-subscriptions/approve/{id}', [AdminUserSubscriptionController::class, 'approve']);
            Route::post('/user-subscriptions/reject/{id}', [AdminUserSubscriptionController::class, 'reject']);

            Route::get('/revenue', [RevenueController::class, 'index']);
            Route::get('/revenue/{id}', [RevenueController::class, 'show']);

            Route::get('/dashboard/count', [DashboardController::class, 'getCount']);
            Route::get('/dashboard/user-stats', [DashboardController::class, 'getUserStats']);
            Route::get('/dashboard/order-stats', [DashboardController::class, 'getOrderStats']);
            Route::get('/dashboard/tab-stats', [DashboardController::class, 'getTabStats']);

            Route::get('/review-tab', [AdminReviewTabController::class, 'index']);
            Route::get('/review-tab/disable/{id}', [AdminReviewTabController::class, 'disable']);
            Route::get('/review-tab/enable/{id}', [AdminReviewTabController::class, 'enable']);
        });

    });

});
