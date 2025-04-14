<?php

use App\Http\Controllers\HouseController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;
// Public routes
Route::get('/', [HouseController::class, 'index'])->name('home');
Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');

// Authentication routes (provided by Laravel Breeze)
require __DIR__ . '/auth.php';

// Protected routes
Route::middleware('auth')->group(function () {
    // Seller routes
    Route::middleware('seller')->group(function () {
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');

        // House management routes
        Route::get('/houses/create', [HouseController::class, 'create'])->name('houses.create');
        Route::post('/houses', [HouseController::class, 'store'])->name('houses.store');
        Route::get('/houses/{house}/edit', [HouseController::class, 'edit'])->name('houses.edit');
        Route::put('/houses/{house}', [HouseController::class, 'update'])->name('houses.update');
        Route::delete('/houses/{house}', [HouseController::class, 'destroy'])->name('houses.destroy');
    });

    // Buyer routes
    Route::middleware('buyer')->group(function () {
        Route::get('/buyer/dashboard', function () {
            return view('buyer.dashboard');
        })->name('buyer.dashboard');

        Route::post('/houses/{house}/request', [RequestController::class, 'store'])->name('requests.store');
    });

    // Common routes for both buyers and sellers
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{request}', [RequestController::class, 'show'])->name('requests.show');
    Route::patch('/requests/{houseRequest}', [RequestController::class, 'update'])->name('requests.update');
});

// Public house show route (must be after create route)
Route::get('/houses/{house}', [HouseController::class, 'show'])->name('houses.show');
