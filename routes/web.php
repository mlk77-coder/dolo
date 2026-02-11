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
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Landing Page Routes (Public)
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/privacy', [LandingController::class, 'privacy'])->name('landing.privacy');
Route::get('/download-apk', [LandingController::class, 'downloadApk'])->name('landing.download-apk');

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
    Route::post('deal-images/{dealImage}/set-primary', [DealImageController::class, 'setPrimary'])->name('deal-images.set-primary');
    Route::resource('advertisements', AdvertisementController::class);
    Route::resource('mobile-carousel-images', MobileCarouselImageController::class);
    Route::resource('merchants', MerchantController::class);
    Route::get('merchants/export/csv', [MerchantController::class, 'exportCsv'])->name('merchants.export-csv');
    Route::resource('orders', OrderController::class);
    Route::get('orders/export/csv', [OrderController::class, 'exportCsv'])->name('orders.export-csv');
    Route::resource('redemptions', RedemptionController::class);
    Route::resource('ratings', RatingController::class);
    Route::resource('codes', \App\Http\Controllers\CodeController::class);
    
    // Email Marketing Routes
    Route::get('email-marketing', [\App\Http\Controllers\EmailMarketingController::class, 'index'])->name('email-marketing.index');
    Route::get('email-marketing/create', [\App\Http\Controllers\EmailMarketingController::class, 'create'])->name('email-marketing.create');
    Route::post('email-marketing/send', [\App\Http\Controllers\EmailMarketingController::class, 'send'])->name('email-marketing.send');
    Route::post('email-marketing/preview', [\App\Http\Controllers\EmailMarketingController::class, 'preview'])->name('email-marketing.preview');
    
    // App Notifications (Mobile Push Notifications)
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
