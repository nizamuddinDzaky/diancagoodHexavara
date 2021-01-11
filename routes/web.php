<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;

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

Route::get('/register', [CustomerRegisterController::class, 'index'])->name('customer.register');
Route::post('/register', [CustomerRegisterController::class, 'register'])->name('customer.post_register');
Route::get('/register/verify/{id}', [CustomerRegisterController::class, 'showVerificationForm'])->name('customer.sms_verification');
Route::post('/register/verify/', [CustomerRegisterController::class, 'verify'])->name('customer.post_sms_verification');

Route::get('/login', [CustomerLoginController::class, 'index'])->name('customer.login');
Route::post('/login', [CustomerLoginController::class, 'login'])->name('customer.post_login');
Route::get('/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');

Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
Route::get('/payment', [OrderController::class, 'payment'])->name('payment');
Route::get('/finish-payment', [OrderController::class, 'paymentDone'])->name('paymentDone');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.list');