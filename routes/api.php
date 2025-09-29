<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes (Token based, JSON only)
|--------------------------------------------------------------------------
*/

// -------------------------
// Authentication (API)
// -------------------------
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logoutApi'])->name('api.logout');
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('api.logoutAll');

    // ✅ Authenticated user info
    Route::get('/user', function (Request $request) {
        return response()->json([
            'id'     => $request->user()->id,
            'name'   => $request->user()->name,
            'email'  => $request->user()->email,
            'role'   => $request->user()->role,
            'status' => $request->user()->status,
        ]);
    })->name('api.user');

    // Orders tracking (customer)
    Route::get('/orders/latest-tracking', [OrderController::class, 'latestTracking'])->name('api.orders.latest');
    Route::get('/orders/{order}/tracking', [OrderController::class, 'track'])->name('api.orders.track');
});

// -------------------------
// Public Product Routes
// -------------------------
Route::get('/categories/{category}/products', [CategoryController::class, 'products'])->name('api.categories.products');
Route::get('/products', [ProductController::class, 'publicIndex'])->name('api.products.public');
Route::get('/products/{id}', [ProductController::class, 'publicShow'])->name('api.products.show');

// -------------------------
// Admin-only Routes (API)
// -------------------------
Route::middleware(['auth:sanctum', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/admin-products', [ProductController::class, 'adminIndex'])->name('api.products.admin');
    Route::get('/admin-products/{id}', [ProductController::class, 'show'])->name('api.products.showAdmin');
    Route::post('/admin-products', [ProductController::class, 'store'])->name('api.products.store');
    Route::patch('/admin-products/{id}', [ProductController::class, 'update'])->name('api.products.update');
    Route::delete('/admin-products/{id}', [ProductController::class, 'destroy'])->name('api.products.destroy');
});
