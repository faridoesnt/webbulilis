<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardTransactionController;

use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductGalleryController;
use App\Http\Controllers\Admin\AdminProductQuantityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// About US
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Contact
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Category
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [CategoryController::class, 'detail'])->name('categories-detail');

// Product Detail
Route::get('/details/{id}', [DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}', [DetailController::class, 'addToCart'])->name('detail-add-to-cart');

Route::get('/register/success', [RegisterController::class, 'success'])->name('register-success');

Route::middleware('auth')->group(function() {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('update-cart');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');
    Route::get('/success', [CartController::class, 'success'])->name('success');

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // dashboard products
    Route::get('/dashboard/products', [DashboardProductController::class, 'index'])->name('dashboard-products');
    Route::get('/dashboard/products/create', [DashboardProductController::class, 'create'])->name('dashboard-product-create');
    Route::get('/dashboard/products/{id}', [DashboardProductController::class, 'details'])->name('dashboard-product-details');
    
    // dashboard transactions
    Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
    Route::get('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])->name('dashboard-transaction-details');

    // midtrans
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout-proses');

    // Route::get('/ongkir', 'CheckOngkirController@index');
    Route::post('/ongkir', [CheckoutController::class, 'check_ongkir'])->name('ongkir');
    // Route::get('/cities', [CheckoutController::class, 'getCities'])->name('cities');
    Route::get('/cities/{province_id}', [CheckoutController::class, 'getCities'])->name('cities');
});


Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('admin-dashboard');

        Route::resource('category', AdminCategoryController::class);
        Route::post('/category/status/{id}', [AdminCategoryController::class, 'status'])->name('category-status');

        Route::resource('transactions', AdminTransactionController::class);
        Route::get('export', [AdminTransactionController::class, 'export'])->name('export');
        
        Route::resource('user', AdminUserController::class);
        
        Route::resource('product', AdminProductController::class);
        Route::post('/product/status/{id}', [AdminProductController::class, 'status'])->name('product-status');

        Route::resource('product-gallery', AdminProductGalleryController::class);

        Route::resource('product-quantity', AdminProductQuantityController::class);
        Route::post('/product/quantity/status/{id}', [AdminProductQuantityController::class, 'status'])->name('product-quantity-status');
        
});

Auth::routes();
