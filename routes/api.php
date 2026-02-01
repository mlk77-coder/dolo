<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CarouselController;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\CategoryController;

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

// Public carousel images (no authentication required)
Route::get('/carousel', [CarouselController::class, 'index']);

// Public discount codes (no authentication required)
Route::get('/codes', [CodeController::class, 'index']);
Route::get('/codes/{code}', [CodeController::class, 'show']);

// Public categories (no authentication required)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Public deals (no authentication required)
Route::get('/deals', [\App\Http\Controllers\Api\DealController::class, 'index']);
Route::get('/deals/featured', [\App\Http\Controllers\Api\DealController::class, 'featured']);
Route::get('/deals/{id}', [\App\Http\Controllers\Api\DealController::class, 'show']);
Route::get('/deals/category/{categoryId}', [\App\Http\Controllers\Api\DealController::class, 'byCategory']);

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
