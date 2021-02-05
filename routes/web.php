<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

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

Route::post('/checkout', [OrderController::class, 'index'])->name('checkout');
Route::post('/checkout-address', [OrderController::class, 'address'])->name('checkout.address');
Route::post('/checkout-done', [OrderController::class, 'checkout_process'])->name('checkout.process');
Route::get('/payment', [OrderController::class, 'payment'])->name('payment');
Route::get('/finish-payment', [OrderController::class, 'paymentDone'])->name('payment.done');

Route::get('/transactions/{status}', [TransactionController::class, 'index'])->name('transaction.list');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
Route::get('/profil/alamat', [ProfileController::class, 'address'])->name('profile-address');
Route::get('/profil/rekening', [ProfileController::class, 'rekening'])->name('profile-rekening');

Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');