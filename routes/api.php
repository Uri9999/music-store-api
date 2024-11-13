<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TabController;

Route::middleware('api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Category
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // Tab
    Route::get('tabs', [TabController::class, 'index']);
    Route::get('tabs/{id}', [TabController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

});
Route::middleware(['auth:sanctum', 'role:Admin,Affiliate'])->group(function () {

    // Tab
    Route::post('tabs', action: [TabController::class, 'store']);
    Route::post('tabs/{tab}', [TabController::class, 'update']);
    Route::delete('tabs/{tab}', [TabController::class, 'destroy']);
});
