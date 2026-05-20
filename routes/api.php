<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\ProductController;

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
});

