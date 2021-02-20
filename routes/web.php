<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\DashboardController;

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
URL::forceRootUrl(getenv('APP_URL'));
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [CustomerRegisterController::class, 'index'])->name('customer.register');
Route::post('/register', [CustomerRegisterController::class, 'register'])->name('customer.post_register');
Route::get('/register/verify/{id}', [CustomerRegisterController::class, 'showVerificationForm'])->name('customer.sms_verification');
Route::post('/register/verify/', [CustomerRegisterController::class, 'verify'])->name('customer.post_sms_verification');

Route::get('/login', [CustomerLoginController::class, 'index'])->name('customer.login');
Route::post('/login', [CustomerLoginController::class, 'login'])->name('customer.post_login');
Route::get('/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');

Route::get('/cities', [OrderController::class, 'getCities'])->name('cities');
Route::get('/districts', [OrderController::class, 'getDistricts'])->name('districts');

Route::post('/checkout', [OrderController::class, 'index'])->name('checkout');
Route::post('/checkout-address', [OrderController::class, 'address'])->name('checkout.address');
Route::post('/checkout-address-edit', [OrderController::class, 'updateAddress'])->name('checkout.updateAddress');
Route::post('/checkout-payment', [OrderController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout-done', [OrderController::class, 'checkoutProcess'])->name('checkout.process');
Route::get('/finish-payment/{id}', [OrderController::class, 'paymentDone'])->name('payment.done');
Route::get('/finish-payment/', [OrderController::class, 'makePayment'])->name('payment.done.process');

Route::get('/transactions/{status}', [TransactionController::class, 'index'])->name('transaction.list');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
Route::post('/profil-edit', [ProfileController::class, 'editProfile'])->name('edit.profile');
Route::get('/profil/alamat', [ProfileController::class, 'address'])->name('profile-address');
Route::get('/profil/rekening', [ProfileController::class, 'rekening'])->name('profile-rekening');
Route::post('/profil/rekening-add', [ProfileController::class, 'addBankAccount'])->name('profile-rekening.add');

Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/semi-update', [OrderController::class, 'updateCartOrder'])->name('cart.semiupdate');

// admin
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('/login', [AdminLoginController::class, 'index'])->name('administrator.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('administrator.post_login');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('administrator.logout');
    
    Route::get('/orders', [DashboardController::class, 'showOrders'])->name('administrator.orders');
    Route::get('/orders/{id}', [DashboardController::class, 'showOrder'])->name('administrator.orders.show');
    Route::post('/order/tracking-update', [DashboardController::class, 'updateTrackingInfo'])->name('administrator.order.update_tracking');
    Route::post('/order/payment-update', [DashboardController::class, 'updatePaymentStatus'])->name('administrator.order.update_payment');
    
    Route::group(['prefix' => 'products'], function() {
        Route::get('/', [DashboardController::class, 'showProducts'])->name('administrator.products');
        Route::get('/fetch/{arg}', [DashboardController::class, 'fetchProducts'])->name('administrator.fetch_products');
        Route::get('/add', [DashboardController::class, 'createProduct'])->name('administrator.add_product.show');
        Route::post('/add', [DashboardController::class, 'addProduct'])->name('administrator.add_product');
        Route::get('/edit/{id}', [DashboardController::class, 'editProduct'])->name('administrator.edit_product');
        Route::post('/edit', [DashboardController::class, 'updateProduct'])->name('administrator.update_product');
    });
    
    Route::group(['prefix' => 'tracking'], function() {
        Route::get('/{status}', [DashboardController::class, 'showTracking'])->name('administrator.tracking');
        Route::get('/{id}/{status}', [DashboardController::class, 'changeOrderStatus'])->name('administrator.tracking.update_status');
    });

    Route::post('/category/add', [DashboardController::class, 'storeCategory'])->name('administrator.add_category');
    Route::post('/subcategory/add', [DashboardController::class, 'storeSubcategory'])->name('administrator.add_subcategory');
    Route::post('/brand/add', [DashboardController::class, 'storeBrand'])->name('administrator.add_brand');
    Route::get('/subcategories-fetch', [DashboardController::class, 'getSubcategories'])->name('administrator.fetch_subcategories');
});
