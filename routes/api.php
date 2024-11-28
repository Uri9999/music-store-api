<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
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

Route::middleware('api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify-user', [AuthController::class, 'verifyUser']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('selections', [SelectionController::class, 'index']);

    // Category
    // Route::get('categories', [CategoryController::class, 'index']);
    // Route::get('categories/{id}', [CategoryController::class, 'show']);

    Route::get('tabs', [TabController::class, 'index']);
    Route::get('new-tab', [TabController::class, 'getNewTab']);
    Route::get('random-tab', [TabController::class, 'getRandomTab']);
    Route::get('tabs/{id}', [TabController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('carts/get-by-me', [CartController::class, 'getByUserId']);
        Route::get('carts/get-count-by-me', [CartController::class, 'getCountByUserId']);
        Route::delete('carts/{id}', [CartController::class, 'destroy'])->middleware('checkIsMyCart');
        Route::post('carts', [CartController::class, 'store']);

        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders/created-by-me', [OrderController::class, 'getMyOrder']);
        Route::get('orders/{id}', [OrderController::class, 'show'])->middleware('checkIsMyOrder');


        Route::get('tabs/get/by-ids', [TabController::class, 'getTabByIds']);

        Route::get('request-tabs/{id}', [RequestTabController::class, 'show']); // thêm middleware chỉ xem của chính mình
        Route::post('request-tabs', [RequestTabController::class, 'store']);
        Route::get('request-tabs/created/by-me', [RequestTabController::class, 'getCreatedByMy']);
        Route::put('request-tabs/{requestTab}', [RequestTabController::class, 'update'])->middleware('checkIsMyRequestTab');
        Route::delete('request-tabs/{id}', [RequestTabController::class, 'destroy'])->middleware('checkIsMyRequestTab');

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
            Route::get('/user/affiliate', [UserController::class, 'getAllAffiliate']);

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
        });

    });

});
