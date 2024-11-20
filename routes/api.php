<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\TabController;
use App\Http\Controllers\RequestTabController;
use App\Http\Controllers\SelectionController;

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

    // Cart
    Route::get('carts/get-by-me', [CartController::class, 'getByUserId'])->middleware('auth:sanctum');
    Route::get('carts/get-count-by-me', [CartController::class, 'getCountByUserId'])->middleware('auth:sanctum');
    Route::post('carts/checkout', [CartController::class, 'checkout'])->middleware('auth:sanctum');
    
    // need permission only delete my cart
    Route::delete('carts/{id}', [CartController::class, 'destroy']);
    Route::post('carts', [CartController::class, 'store']);

    // Tab
    Route::get('tabs', [TabController::class, 'index']);
    Route::get('new-tab', [TabController::class, 'getNewTab']);
    Route::get('random-tab', [TabController::class, 'getRandomTab']);
    Route::get('tabs/{id}', [TabController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        // Request tabs
        Route::get('request-tabs/{id}', [RequestTabController::class, 'show']);
        Route::post('request-tabs', [RequestTabController::class, 'store']);
        Route::get('request-tabs/created/by-me', [RequestTabController::class, 'getCreatedByMy']);
        // TODO: thêm permission (policy or middleware) người tạo mới được sửa và xóa, và chỉ được sửa khi status = 0
        Route::put('request-tabs/{requestTab}', [RequestTabController::class, 'update']);
        Route::delete('request-tabs/{requestTab}', [RequestTabController::class, 'destroy']);

        // Api quản lý
        Route::prefix('manage')->middleware(['role:Admin,Affiliate'])->group(function () {
            // Request tabs
            Route::get('request-tabs/by-receiver/{id}', [RequestTabController::class, 'getByReceiverId']);

            // Tab
            Route::post('tabs', action: [TabController::class, 'store']);
            Route::post('tabs/{tab}', [TabController::class, 'update']);
            Route::delete('tabs/{tab}', [TabController::class, 'destroy']);
        });

        Route::prefix('admin')->middleware(['role:Admin'])->group(function() {
            // Request tabs
            Route::get('/request-tabs', [RequestTabController::class, 'index']);

            // Category 
            Route::post('categories', [CategoryController::class, 'store']);
            Route::put('categories/{category}', [CategoryController::class, 'update']);
            Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

        });

    });

});
