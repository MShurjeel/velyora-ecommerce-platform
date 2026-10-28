<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Velyora
|--------------------------------------------------------------------------
*/

// --- Public Pages ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}', [ProductController::class, 'show']); // Alias
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// --- Authentication Routes ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Cart & Wishlist Pages ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

// --- Protected User Account Routes ---
Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/my-profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.update');
    Route::put('/my-profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/my-profile/account', [ProfileController::class, 'destroyAccount'])->name('profile.deleteAccount');
    Route::get('/my-orders', [ProfileController::class, 'orders'])->name('orders.index');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    // Addresses
    Route::post('/my-profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::put('/my-profile/addresses/{id}', [ProfileController::class, 'updateAddress'])->name('profile.addresses.update');
    Route::delete('/my-profile/addresses/{id}', [ProfileController::class, 'destroyAddress'])->name('profile.addresses.destroy');
    Route::post('/my-profile/addresses/{id}/default', [ProfileController::class, 'setDefaultAddress'])->name('profile.addresses.default');

    // Payment Methods
    Route::post('/my-profile/payment-methods', [ProfileController::class, 'storePaymentMethod'])->name('profile.payments.store');
    Route::delete('/my-profile/payment-methods/{id}', [ProfileController::class, 'destroyPaymentMethod'])->name('profile.payments.destroy');
    Route::post('/my-profile/payment-methods/{id}/default', [ProfileController::class, 'setDefaultPaymentMethod'])->name('profile.payments.default');

    // Reviews
    Route::post('/my-profile/reviews', [ProfileController::class, 'storeReview'])->name('profile.reviews.store');
    Route::delete('/my-profile/reviews/{id}', [ProfileController::class, 'destroyReview'])->name('profile.reviews.destroy');
});

// --- Admin Panel Routes ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'index'])->name('login');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::put('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

// --- AJAX / Dynamic Endpoints (Supports both clean URLs & legacy paths) ---
Route::post('/ajax/cart', [CartController::class, 'handleAjax'])->name('cart.ajax');
Route::post('/ajax/cart.php', [CartController::class, 'handleAjax']);

Route::post('/ajax/wishlist', [WishlistController::class, 'handleAjax'])->name('wishlist.ajax');
Route::post('/ajax/wishlist.php', [WishlistController::class, 'handleAjax']);

Route::post('/ajax/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.store');
Route::post('/ajax/checkout.php', [CheckoutController::class, 'processCheckout']);
