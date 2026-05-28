<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Register & Login (public)
| Logout & Profile (auth:sanctum)
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Password reset routes (public)
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp',     [AuthController::class, 'verifyOtp']);
Route::post('/reset-password',  [AuthController::class, 'resetPassword']);

// Public product routes (for Flutter frontend)
Route::get('/products',            [ProductController::class, 'index']);
Route::get('/products/search',     [ProductController::class, 'search']);
Route::get('/products/categories', [ProductController::class, 'categories']);
Route::get('/products/{product}',  [ProductController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/profile',  [AuthController::class, 'profile']);
    Route::put('/profile',  [AuthController::class, 'updateProfile']);
    Route::get('/user',     fn (Request $request) => $request->user());

    // Addresses
    Route::get('/addresses',              [AddressController::class, 'index']);
    Route::post('/addresses',             [AddressController::class, 'store']);
    Route::put('/addresses/{address}',    [AddressController::class, 'update']);
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);

    // Wishlist
    Route::get('/wishlist',              [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle',      [WishlistController::class, 'toggle']);
    Route::get('/wishlist/check/{id}',   [WishlistController::class, 'check']);
    Route::post('/wishlist/check',       [WishlistController::class, 'checkMultiple']);

    // Orders
    Route::get('/orders',                [OrderController::class, 'index']);
    Route::post('/orders',               [OrderController::class, 'store']);
    Route::get('/orders/{order}',        [OrderController::class, 'show']);
});


