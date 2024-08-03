<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProductListController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//user route 
Route::get('/', [UserController::class, 'index'])->name('user.home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//cart
Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('view', 'view')->name('cart.view');
    Route::post('store/{product}', 'store')->name('cart.store');
    Route::patch('store/{product}', 'update')->name('cart.update');
    Route::delete('store/{product}', 'delete')->name('cart.delete');
});

Route::prefix('checkout')->controller(CheckoutController::class)->group(function () {
    Route::post('order', 'store')->name('checkout.store');
});

//productlist and filters
Route::prefix('products')->controller(ProductListController::class)->group(function() {
    Route::get('/', 'index')->name('products.index');
});

//admin routes

Route::group(['prefix' => 'admin', 'Middleware' => 'redirectAdmin'], function() {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/image/{id}', [ProductController::class, 'deleteImage'])->name('admin.products.image.delete');
    Route::delete('/products/destroy/{id}',[ProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::put('/orders/update/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/orders/delete/{id}',[OrderController::class, 'delete'])->name('admin.orders.delete');
});

require __DIR__.'/auth.php';
