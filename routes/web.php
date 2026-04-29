<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Operator\OrderController;
use App\Http\Controllers\Admin\PastryController; // Tambahkan ini jika sudah dibuat

// ==========================================
// RUTE PELANGGAN (GUEST / TANPA LOGIN)
// ==========================================
Route::post('/midtrans/webhook', [\App\Http\Controllers\MidtransController::class, 'webhook'])->name('midtrans.webhook');

Route::get('/', function () {
    return view('customer.home');
})->name('home');

Route::get('/catalog', [FrontController::class, 'catalog'])->name('catalog');

// Keranjang (Cart)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Cart AJAX endpoints (tanpa reload halaman)
Route::post('/cart/ajax-add',    [CartController::class, 'ajaxAdd'])->name('cart.ajax.add');
Route::post('/cart/ajax-update', [CartController::class, 'ajaxUpdate'])->name('cart.ajax.update');
Route::post('/cart/ajax-remove', [CartController::class, 'ajaxRemove'])->name('cart.ajax.remove');
Route::get('/cart/count',        [CartController::class, 'cartCount'])->name('cart.count');

// Checkout & Resi
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/receipt/{id}', [CheckoutController::class, 'receipt'])->name('receipt');
Route::get('/checkout/member-info', [CheckoutController::class, 'memberInfo'])->name('checkout.member.info');


// ==========================================
// RUTE AUTENTIKASI (LOGIN & REGISTER)
// ==========================================
// Menampilkan Halaman Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/register-process', [AuthController::class, 'registerProcess'])->name('register.process');
Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// RUTE OPERATOR (KASIR)
// ==========================================
// Gunakan middleware 'auth' untuk melindungi rute ini
Route::middleware('auth')->prefix('operator')->group(function () {
    Route::get('/dashboard', function () {
        return view('operator.dasboard'); // Perhatikan penulisan nama file di tree Anda ('dasboard.blade.php')
    })->name('operator.dashboard');

    Route::get('/orders', [OrderController::class, 'index'])->name('operator.orders');
    Route::post('/orders/{id}/pay', [OrderController::class, 'pay'])->name('operator.orders.pay');
    
    // Riwayat Pemesanan & Ajax
    Route::get('/orders/history', [OrderController::class, 'history'])->name('operator.history');
    Route::post('/orders/history/filter', [OrderController::class, 'historyFilter'])->name('operator.history.filter');
    Route::post('/orders/history/update-status', [OrderController::class, 'updateOrderStatusAjax'])->name('operator.history.update.status');
    Route::post('/orders/history/update-payment', [OrderController::class, 'updatePaymentStatusAjax'])->name('operator.history.update.payment');
    Route::post('/orders/history/delete', [OrderController::class, 'deleteOrderAjax'])->name('operator.history.delete');
    Route::post('/orders/history/process-payment', [OrderController::class, 'processPaymentAjax'])->name('operator.history.process.payment');
    Route::post('/orders/history/generate-snap-token', [OrderController::class, 'generateSnapToken'])->name('operator.history.generate.snap');
    Route::post('/orders/midtrans-success-local', [OrderController::class, 'handleMidtransCallbackLocal'])->name('operator.orders.midtrans.success');
});


// ==========================================
// RUTE ADMIN
// ==========================================
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dasboard'); // Typo sesuai dengan tree Anda
    })->name('admin.dashboard');

    // Rute CRUD Staff & Member HANYA UNTUK ADMIN
    Route::middleware([\App\Http\Middleware\EnsureIsAdmin::class])->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
        Route::resource('members', \App\Http\Controllers\Admin\MemberController::class)->names('admin.members');
    });

    // Rute CRUD Otomatis untuk Pastry, Drink, Promo
    Route::resource('pastries', PastryController::class)->names('admin.pastries');
    Route::resource('drinks', \App\Http\Controllers\Admin\DrinkController::class)->names('admin.drinks');
    Route::resource('promos', \App\Http\Controllers\Admin\PromoController::class)->names('admin.promos');

    // Rute CRUD Rewards (Hadiah Tukar Poin)
    Route::resource('rewards', \App\Http\Controllers\Admin\RewardController::class)->names('admin.rewards');

    // Pindah kategori produk & reorder (product_number)
    Route::post('/products/change-category', [\App\Http\Controllers\Admin\ProductController::class, 'changeCategory'])->name('admin.products.change-category');
    Route::post('/products/reorder',         [\App\Http\Controllers\Admin\ProductController::class, 'reorder'])->name('admin.products.reorder');
});