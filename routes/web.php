<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DealImageController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AppNotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\MobileCarouselImageController;
use App\Http\Controllers\AnalyticsDailyController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard (or login if not authenticated)
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Language switcher
Route::post('/language/switch', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

// Authentication routes (handled by Breeze)
require __DIR__.'/auth.php';

// Protected routes - E-commerce Admin Panel
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource routes
    Route::resource('categories', CategoryController::class);
    
    // Deals - specific routes BEFORE resource
    Route::get('deals/map-location', function() {
        return view('pages.deals.map-location');
    })->name('deals.map-location');
    Route::get('deals/{deal}/view-location', function(\App\Models\Deal $deal) {
        return view('pages.deals.view-location', compact('deal'));
    })->name('deals.view-location');
    
    // COMMENTED OUT - Using modal approach instead of page navigation
    // Route::post('deals/save-draft', [DealController::class, 'saveDraft'])->name('deals.save-draft');
    
    Route::post('deals/update-sort-order', [DealController::class, 'updateSortOrder'])->name('deals.update-sort-order');
    Route::get('deals/export/csv', [DealController::class, 'exportCsv'])->name('deals.export-csv');
    
    // Deals resource route
    Route::resource('deals', DealController::class);
    
    Route::resource('deal-images', DealImageController::class)->only(['store', 'destroy']);
    Route::resource('advertisements', AdvertisementController::class);
    Route::resource('mobile-carousel-images', MobileCarouselImageController::class);
    Route::resource('merchants', MerchantController::class);
    Route::get('merchants/export/csv', [MerchantController::class, 'exportCsv'])->name('merchants.export-csv');
    Route::resource('orders', OrderController::class);
    Route::get('orders/export/csv', [OrderController::class, 'exportCsv'])->name('orders.export-csv');
    Route::resource('redemptions', RedemptionController::class);
    Route::resource('ratings', RatingController::class);
    Route::resource('codes', \App\Http\Controllers\CodeController::class);
    Route::resource('notifications', AppNotificationController::class);
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    Route::get('customers/export/csv', [\App\Http\Controllers\CustomerController::class, 'exportCsv'])->name('customers.export-csv');
    Route::get('orders/abandoned-carts', [\App\Http\Controllers\AbandonedCartController::class, 'index'])->name('orders.abandoned-carts');
    Route::get('analytics-daily', [AnalyticsDailyController::class, 'index'])->name('analytics-daily.index');
    
    // Profile routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
