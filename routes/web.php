<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Backend\CustomerController as BackendCustomerController;
use App\Http\Controllers\Frontend\HeaderController;
use App\Http\Controllers\StripePaymentController;
use App\Models\Order;
use GuzzleHttp\Psr7\Request;

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

// Route::get('/dashboard', function () {
//     return view('backend.pages.dashboard');
// });
// Route::get('/', function () {
//     return view('frontend.pages.home');
// });

Route::prefix('')->group(function(){
    Route::get('/', [HomeController::class, 'home'])->name('home');

/* static pages */
    Route::get('/about', [HeaderController::class, 'about'])->name('about');
    Route::get('/contact', [HeaderController::class, 'contact'])->name('contact');

    Route::get('/shop', [HomeController::class, 'shopPage'])->name('shop.page');
    Route::get('/single-product/{product_slug}', [HomeController::class, 'productDetails'])->name('productdetail.page');
    Route::get('/shopping-cart', [CartController::class, 'cartPage'])->name('cart.page');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to.cart');
    Route::get('/remove-from-cart/{cart_id}', [CartController::class, 'removeFromCart'])->name('removefrom.cart');

    /*Authentication routes for customer/guest */
    Route::get('/register', [RegisterController::class, 'registerPage'])->name('register.page');
    Route::post('/register', [RegisterController::class, 'registerStore'])->name('register.store');
    Route::get('/login', [RegisterController::class, 'loginPage'])->name('login.page');
    Route::post('/login', [RegisterController::class, 'loginStore'])->name('login.store');

    /*AJAX Call*/
    Route::get('/upzilla/ajax/{district_id}', [CheckoutController::class, 'loadUpazillaAjax'])->name('loadupazila.ajax');

    Route::prefix('customer/')->middleware('auth', 'is_customer')->group(function(){
        Route::get('dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('logout', [RegisterController::class, 'logout'])->name('customer.logout');
        Route::post('cart/apply-coupon', [CartController::class, 'couponApply'])->name('customer.couponapply');
        Route::get('cart/remove-coupon/{coupon_name}', [CartController::class, 'removeCoupon'])->name('customer.couponremove');

        /*checkout page*/
        Route::get('checkout', [CheckoutController::class, 'checkoutPage'])->name('customer.checkoutpage');
        Route::post('placeorder', [CheckoutController::class, 'placeOrder'])->name('customer.placeorder');

        Route::get('email', function(){
            $order=Order::whereId(1)->with(['billing', 'orderdetails'])->get();
            return view('frontend.mail.purchaseconfirm', [
                'order_details'=>$order
            ]);
        });
    });
});

Route::prefix('admin/')->group(function(){
    Route::get('login', [LoginController::class, 'loginPage'])->name('admin.loginpage');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

        /* Resource controller */
        Route::resource('category', CategoryController::class);
        Route::resource('testimonial', TestimonialController::class);
        Route::resource('products', ProductController::class);
        Route::resource('coupon', CouponController::class);
        Route::get('order-list', [OrderController::class, 'index'])->name('admin.orderlist');
        Route::get('customer-list', [BackendCustomerController::class, 'index'])->name('admin.customerlist');
    });


});

// Route::middleware('auth:api')->get('/user', function(Request $request){
//     return $request->user();
// });


// Route::post('stripe', [StripePaymentController::class, 'stripePost']);
Route::get('payment-form', [StripePaymentController::class, 'form'])->name('form.payment');
Route::post('make/payment', [StripePaymentController::class, 'makePayment'])->name('make.payment');
