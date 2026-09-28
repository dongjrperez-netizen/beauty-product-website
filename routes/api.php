<?php

use App\Http\Controllers\Admin\CatalogDashboardController;
use App\Http\Controllers\Admin\CatalogEntityController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/products', [StorefrontProductController::class, 'index']);
Route::get('/products/{slug}', [StorefrontProductController::class, 'show']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', CatalogDashboardController::class);
    Route::apiResource('products', ProductController::class);

    Route::get('/catalog/{resource}', [CatalogEntityController::class, 'index']);
    Route::post('/catalog/{resource}', [CatalogEntityController::class, 'store']);
    Route::put('/catalog/{resource}/{id}', [CatalogEntityController::class, 'update']);
    Route::delete('/catalog/{resource}/{id}', [CatalogEntityController::class, 'destroy']);
});
