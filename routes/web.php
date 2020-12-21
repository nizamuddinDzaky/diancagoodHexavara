<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\CustomerLoginController;

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

Route::get('/register', [CustomerRegisterController::class, 'index'])->name('show.register');

Route::get('/login', [CustomerLoginController::class, 'index'])->name('show.login');
Route::get('/verifikasi', [CustomerLoginController::class, 'showVerificationForm'])->name('show.verification');
