<?php

declare(strict_types=1);

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('products', [ProductController::class, 'list']);
Route::get('products/search', [ProductController::class, 'search']);

Route::prefix('orders')->group(function() {
    Route::get('{id}', [OrderController::class, 'findById']);
    Route::post('create', [OrderController::class, 'create']);
    Route::delete('{id}', [OrderController::class, 'delete']);
});

Route::prefix('cart')->group(function() {
    Route::get('get', [CartController::class, 'getCart']);
    Route::get('items', [CartController::class, 'getItems']);
    Route::post('add-item', [CartController::class, 'addItem']);
    Route::post('remove-item/{id}', [CartController::class, 'removeItem']);
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('users/orders', [AuthController::class, 'findAllForUser']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});

//Admin routes
Route::prefix('admin')->group(function() {
    Route::post('login', [AdminController::class, 'login']);

    Route::middleware('admin:sanctum')->group(function() {
        Route::get('orders', [OrderController::class, 'list']);
        Route::post('logout', [AdminController::class, 'logout']);
    });
});


