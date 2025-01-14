<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/restaurant/register', [App\Http\Controllers\Api\AuthController::class, 'restaurantRegister']);
Route::post('/driver/register', [App\Http\Controllers\Api\AuthController::class, 'driverRegister']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/user/update-latlong', [App\Http\Controllers\Api\AuthController::class, 'updateLatLong'])->middleware('auth:sanctum');
Route::get('/restaurant', [App\Http\Controllers\Api\AuthController::class, 'getRestaurant']);

Route::post('/products', [App\Http\Controllers\Api\ProductController::class, 'store'])->middleware('auth:sanctum');
Route::get('/products', [App\Http\Controllers\Api\ProductController::class, 'index'])->middleware('auth:sanctum');
Route::get('/products/user', [App\Http\Controllers\Api\ProductController::class, 'getProductByUserId'])->middleware('auth:sanctum');
Route::post('/products/edit', [App\Http\Controllers\Api\ProductController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/products/{id}', [App\Http\Controllers\Api\ProductController::class, 'destroy'])->middleware('auth:sanctum');


Route::post('/order', [App\Http\Controllers\Api\OrderController::class, 'createOrder'])->middleware('auth:sanctum');
Route::get('/order/user', [App\Http\Controllers\Api\OrderController::class, 'orderHistory'])->middleware('auth:sanctum');
Route::get('/order/restaurant', [App\Http\Controllers\Api\OrderController::class, 'getOrdersByStatus'])->middleware('auth:sanctum');
Route::get('/order/driver', [App\Http\Controllers\Api\OrderController::class, 'getOrdersByStatusDriver'])->middleware('auth:sanctum');
Route::put('/order/restaurant/update-status/{id}', [App\Http\Controllers\Api\OrderController::class, 'updateOrderStatus'])->middleware('auth:sanctum');
Route::put('/order/driver/update-status/{id}', [App\Http\Controllers\Api\OrderController::class, 'updateOrderStatusDriver'])->middleware('auth:sanctum');
Route::put('/order/user/update-status/{id}', [App\Http\Controllers\Api\OrderController::class, 'updatePurchaseStatus'])->middleware('auth:sanctum');
