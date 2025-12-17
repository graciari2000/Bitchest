<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PriceHistoryController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Market data (public)
Route::get('/market', [MarketController::class, 'index']);
Route::get('/market/top', [MarketController::class, 'top']);
Route::get('/market/{symbol}', [MarketController::class, 'show']);

// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Profile routes (both admin and client)
    Route::put('/profile', [ProfileController::class, 'update']);

    // Portfolio routes (legacy, can be removed if using wallet)
    Route::get('/portfolio', [PortfolioController::class, 'index']);
    Route::get('/portfolio/summary', [PortfolioController::class, 'summary']);

    // Wallet routes (client)
    Route::get('/wallet', [WalletController::class, 'index']);
    Route::get('/wallet/balance', [WalletController::class, 'balance']);
    Route::post('/wallet/sell', [WalletController::class, 'sell']);

    // Transaction routes
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/statistics', [TransactionController::class, 'statistics']);

    // Price history routes
    Route::get('/price-history', [PriceHistoryController::class, 'index']);
    Route::get('/price-history/{symbol}', [PriceHistoryController::class, 'show']);

    // Admin routes
    Route::prefix('admin')->group(function () {
        // Client management
        Route::get('/clients', [AdminController::class, 'clients']);
        Route::get('/clients/{clientId}', [AdminController::class, 'clientDetails']);
        Route::post('/clients', [AdminController::class, 'createClient']);
        Route::put('/clients/{clientId}', [AdminController::class, 'updateClient']);
        Route::delete('/clients/{clientId}', [AdminController::class, 'deleteClient']);
        Route::post('/clients/{clientId}/generate-password', [AdminController::class, 'generateTempPassword']);

        // Admin profile
        //admin settings
        Route::get('/settings', [AdminController::class, 'getSettings']);
        Route::put('/settings', [AdminController::class, 'updateSettings']);
        Route::put('/profile', [AdminController::class, 'updateProfile']);

        // Cryptocurrencies
        Route::get('/cryptocurrencies', [AdminController::class, 'cryptocurrencies']);

        // Statistics
        Route::get('/statistics', [AdminController::class, 'statistics']);
        Route::get('/transactions', [AdminController::class, 'transactions']);
    });

    // Market price update (admin only, but can be called by scheduled job)
    Route::post('/market/update-prices', [MarketController::class, 'updatePrices']);
});
