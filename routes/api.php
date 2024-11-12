<?php

use App\Http\Middleware\LogApiErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [\App\Http\Controllers\Api\v1\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\v1\AuthController::class, 'register']);

    Route::group(['middleware' => ['auth:api', 'logapierrors']], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\UserController::class, 'getLoginUser']);
        });

        // Categories
        Route::apiResource('/categories', \App\Http\Controllers\Api\v1\CategoryController::class);
        Route::post('/categories/dto', [\App\Http\Controllers\Api\v1\CategoryController::class, 'storeDTO']);
        Route::put('/categories/dto/{id}', [\App\Http\Controllers\Api\v1\CategoryController::class, 'updateDTO']);

        // Products
        Route::apiResource('/products', \App\Http\Controllers\Api\v1\ProductController::class);

        // Orders
        Route::apiResource('/orders', \App\Http\Controllers\Api\v1\OrderController::class)->except(['update']);
    });
});
