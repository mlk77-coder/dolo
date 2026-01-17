<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Basic user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Customer profile with order history
    Route::get('/customer/profile', [CustomerController::class, 'profile']);
    Route::put('/customer/profile', [CustomerController::class, 'updateProfile']);
    Route::post('/customer/profile', [CustomerController::class, 'updateProfile']); // Alternative for form-data
    Route::get('/customer/order-history', [CustomerController::class, 'orderHistory']);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
