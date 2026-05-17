<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;

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
