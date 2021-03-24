<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
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
Route::get('/show', [HomeController::class, 'show'])->name('search-result');
Route::get('/category/{id}', [HomeController::class, 'categoryFilter'])->name('category-result');
Route::get('/category/{id}/{name}', [HomeController::class, 'categoryFilters'])->name('category-results');
Route::get('/filter-product/', [HomeController::class, 'filterProduct'])->name('filter-product');
Route::get('/brand/{id}', [HomeController::class, 'brandFilter'])->name('brand-result');
Route::get('/brand/{id}/{name}', [HomeController::class, 'brandFilters'])->name('brand-results');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');
Route::get('/term-condition', [HomeController::class, 'termCondition'])->name('term-condition');

Route::get('/register', [CustomerRegisterController::class, 'index'])->name('customer.register');
Route::post('/register', [CustomerRegisterController::class, 'register'])->name('customer.post_register');
Route::get('/register/verify/{id}', [CustomerRegisterController::class, 'showVerificationForm'])->name('customer.sms_verification');
Route::post('/register/verify/', [CustomerRegisterController::class, 'verify'])->name('customer.post_sms_verification');

Route::get('/login', [CustomerLoginController::class, 'index'])->name('customer.login');
Route::post('/login', [CustomerLoginController::class, 'login'])->name('customer.post_login');
Route::get('/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');

Route::get('/cities', [OrderController::class, 'getCities'])->name('cities');
Route::get('/districts', [OrderController::class, 'getDistricts'])->name('districts');
Route::get('/order-detail/{id}', [OrderController::class, 'getOrderDetail'])->name('order');

Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout-address', [OrderController::class, 'address'])->name('checkout.address');
Route::post('/checkout-address-edit', [OrderController::class, 'updateAddress'])->name('checkout.updateAddress');
Route::post('/checkout-payment', [OrderController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout-done', [OrderController::class, 'checkoutProcess'])->name('checkout.process');
Route::get('/finish-payment/{id}', [OrderController::class, 'paymentDone'])->name('payment.done');
Route::post('/process-payment', [OrderController::class, 'makePayment'])->name('payment.done.process');
Route::get('/cancel-order/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');
Route::get('/delete-cart/{id}', [OrderController::class, 'deleteCart'])->name('delete.cart');
Route::post('/delete-cart', [OrderController::class, 'deleteMultipleCart'])->name('delete.multiple.cart');
Route::get('/transactions/{status}', [TransactionController::class, 'index'])->name('transaction.list');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product-variant/{id}', [ProductVariantController::class, 'getDetail'])->name('product_variant.detail');
Route::post('/product-variant/update', [ProductVariantController::class, 'update'])->name('product_variant.update');
Route::delete('/product-variant/delete/{id}', [ProductVariantController::class, 'destroy'])->name('product_variant.delete');

Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
Route::post('/profil-edit', [ProfileController::class, 'editProfile'])->name('edit.profile');
Route::get('/profil/alamat', [ProfileController::class, 'address'])->name('profile-address');
Route::get('/detail-address', [ProfileController::class, 'getDetailAddreess'])->name('address.detail');
Route::post('/profil/alamat-add', [ProfileController::class, 'addAddress'])->name('profile-address.add');
Route::post('/profil/alamat-edit/{id}', [ProfileController::class, 'updateAddress'])->name('profile-address.edit');
Route::get('/profil/alamat-delete/{id}', [ProfileController::class, 'deleteAddress'])->name('profile-address.delete');
Route::get('/profil/rekening', [ProfileController::class, 'rekening'])->name('profile-rekening');
Route::post('/profil/rekening-add', [ProfileController::class, 'addBankAccount'])->name('profile-rekening.add');
Route::delete('/profil/rekening-delete/{id}', [ProfileController::class, 'deleteBankAccount'])->name('profile-rekening.delete');

Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/quick-add/{id}', [OrderController::class, 'quickAddToCart'])->name('cart.quick_add');
Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/semi-update', [OrderController::class, 'updateCartOrder'])->name('cart.semiupdate');
Route::post('/cart/remove', [OrderController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.list');
Route::get('/reviews/done', [ReviewController::class, 'reviewDone'])->name('reviews.done');
Route::post('/reviews/add', [ReviewController::class, 'create'])->name('reviews.add');

// admin
Route::group(['prefix' => 'admin'], function() {
    Route::get('/login', [AdminLoginController::class, 'index'])->name('administrator.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('administrator.post_login');

    Route::group(['middleware' => 'auth'], function() {
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
            Route::post('/add-variant', [DashboardController::class, 'storeVariant'])->name('administrator.add_variant');
            Route::get('/edit/{id}', [DashboardController::class, 'editProduct'])->name('administrator.edit_product');
            Route::post('/edit', [DashboardController::class, 'updateProduct'])->name('administrator.update_product');
        });
        
        Route::group(['prefix' => 'tracking'], function() {
            Route::get('/{status}', [DashboardController::class, 'showTracking'])->name('administrator.tracking');
            Route::get('/{id}/{status}', [DashboardController::class, 'changeOrderStatus'])->name('administrator.tracking.update_status');
        });

        Route::get('/report/all', [DashboardController::class, 'allReport'])->name('administrator.all_report');
        Route::get('/report/product/all', [DashboardController::class, 'productReport'])->name('administrator.product_report');
        Route::get('/report/product/sold', [DashboardController::class, 'productSoldReport'])->name('administrator.product_sold_report');
        Route::get('/report/product/soldout', [DashboardController::class, 'productSoldoutReport'])->name('administrator.product_soldout_report');
        Route::get('/report/payment', [DashboardController::class, 'paymentReport'])->name('administrator.payment_report');
        Route::get('/report/sales', [DashboardController::class, 'salesReport'])->name('administrator.sales_report');

        Route::get('/report/payment/pdf', [DashboardController::class, 'paymentReportPDF'])->name('administrator.payment_report_pdf');
        Route::get('/report/all/pdf', [DashboardController::class, 'allReportPDF'])->name('administrator.all_report_pdf');
        Route::get('/report/sales/pdf', [DashboardController::class, 'salesReportPDF'])->name('administrator.sales_report_pdf');
        Route::get('/report/product/pdf', [DashboardController::class, 'productReportPDF'])->name('administrator.product_report_pdf');

        Route::get('/report/payment/excel', [DashboardController::class, 'paymentReportExcel'])->name('administrator.payment_report_excel');
        Route::get('/report/all/excel', [DashboardController::class, 'allReportExcel'])->name('administrator.all_report_excel');
        Route::get('/report/sales/excel', [DashboardController::class, 'salesReportExcel'])->name('administrator.sales_report_excel');
        Route::get('/report/product/excel', [DashboardController::class, 'productReportExcel'])->name('administrator.product_report_excel');

        Route::get('/homepage-management', [DashboardController::class, 'homepageList'])->name('administrator.homepage');
        Route::post('/homepage-management/create', [DashboardController::class, 'homepageCreate'])->name('administrator.homepage.create');
        Route::get('/homepage-management/change/{id}', [DashboardController::class, 'homepageChange'])->name('administrator.homepage.change');
        Route::post('/homepage-management/update', [DashboardController::class, 'homepageUpdate'])->name('administrator.homepage.update');
        Route::post('/homepage-management/delete', [DashboardController::class, 'homepageDelete'])->name('administrator.homepage.delete');
    
        Route::post('/category/add', [DashboardController::class, 'storeCategory'])->name('administrator.add_category');
        Route::post('/subcategory/add', [DashboardController::class, 'storeSubcategory'])->name('administrator.add_subcategory');
        Route::post('/brand/add', [DashboardController::class, 'storeBrand'])->name('administrator.add_brand');
        Route::get('/subcategories-fetch', [DashboardController::class, 'getSubcategories'])->name('administrator.fetch_subcategories');

        Route::group(['prefix' => 'promos'], function() {
            Route::get('/{type}', [PromoController::class, 'index'])->name('administrator.promo');
            Route::post('/create', [PromoController::class, 'create'])->name('administrator.promo.create');
            Route::get('/detail/{id}', [PromoController::class, 'show'])->name('administrator.promo.show');
            Route::get('/detail/{promo_id}/{variant_id}', [PromoController::class, 'getPromoValue'])->name('administrator.promo.value');
            Route::get('/change/{promo_id}', [PromoController::class, 'getPromo'])->name('administrator.promo.change');
            Route::post('/update/', [PromoController::class, 'update'])->name('administrator.promo.update');
            Route::post('/publish', [PromoController::class, 'publish'])->name('administrator.promo.publish');
            Route::post('/delete', [PromoController::class, 'destroy'])->name('administrator.promo.delete');
        });
    });
});
