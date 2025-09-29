<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

// Livewire Components
use App\Livewire\Admin\Customers\Index as AdminCustomersIndex;
use App\Livewire\Admin\Orders\Index as AdminOrdersIndex;
use App\Livewire\Orders\CustomerOrders;
use App\Livewire\Products;
use App\Livewire\Collections;
use App\Livewire\Cart\CartIndex;
use App\Livewire\Orders\MyOrders;
use App\Livewire\ProductDetail;

// Controllers
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes (Blade)
|--------------------------------------------------------------------------
*/

// -------------------------
// Homepage redirect
// -------------------------
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// -------------------------
// Authentication (Web)
// -------------------------
Route::view('/login', 'auth.login')->name('login');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// -------------------------
// OTP Verification (Web)
// -------------------------
Route::get('/otp-verify', fn() => view('auth.otp-verify'))->name('otp.verify');
Route::post('/otp-verify', function (Request $request) {
    $request->validate(['otp' => 'required|digits:6']);
    $user = User::find(session('pending_user_id'));

    if (!$user) {
        return back()->withErrors(['otp' => 'Session expired. Please log in again.']);
    }

    if ($user->login_otp === $request->otp && now()->lt($user->otp_expires_at)) {
        $user->update(['login_otp' => null, 'otp_expires_at' => null]);
        session()->forget(['pending_user_id', 'pending_user_email']);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['otp' => 'Invalid or expired OTP']);
})->name('otp.verify.post');

// -------------------------
// Logout (Web)
// -------------------------
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// -------------------------
// Customer Dashboard + Cart + Orders
// -------------------------
Route::middleware(['auth', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        Route::get('/dashboard', function () {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return view('dashboard');
        })->name('dashboard');

        // Cart
        Route::get('/cart', CartIndex::class)->name('cart.index');

        // Orders
        Route::get('/my-orders/{order_id?}', MyOrders::class)->name('my-orders.index');
        Route::get('/orders', CustomerOrders::class)->name('customer.orders');

        // ✅ Track Orders Page
        Route::get('/track-orders', [OrderController::class, 'trackOrders'])->name('orders.track');

        // ✅ Download Invoice PDF
        Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    });

// -------------------------
// Payments
// -------------------------
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payment-success/{order_id}', [OrderController::class, 'success'])->name('payment.success');

// -------------------------
// Admin Routes (Web)
// -------------------------
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', \App\Http\Middleware\IsAdmin::class])
    ->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        Route::get('/products', fn() => view('admin.products.index'))->name('products.index');
        Route::get('/customers', AdminCustomersIndex::class)->name('customers.index');
        Route::get('/orders', AdminOrdersIndex::class)->name('orders.index');
    });

// -------------------------
// Public Pages
// -------------------------
Route::get('/products', Products::class)->name('products.public.index');
Route::get('/collections', Collections::class)->name('collections');
Route::view('/about', 'about')->name('about');
Route::get('/product/{id}', ProductDetail::class)->name('product.show');

// -------------------------
// Fallback
// -------------------------
Route::fallback(function () {
    $path = request()->path();

    if (str_starts_with($path, 'api/')) {
        return response()->json(['message' => 'Not Found'], 404);
    }

    if (auth()->check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }

    return redirect()->route('login');
});
