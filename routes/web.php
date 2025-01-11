<?php

use App\Http\{Controllers\Frontend\CaptchaController,
    Controllers\Frontend\CartController,
    Controllers\Frontend\CategoryController,
    Controllers\Frontend\CheckoutController,
    Controllers\Frontend\PageController,
    Controllers\Frontend\ComparisonController,
    Controllers\Frontend\Payment\MyFatoorahController,
    Controllers\Frontend\Payment\PaymentController,
    Controllers\Frontend\Payment\PayPalController,
    Controllers\Frontend\Payment\RazorpayController,
    Controllers\Frontend\Payment\KashierController,
    Controllers\Frontend\ProductController,
    Controllers\Frontend\ReviewController,
    Controllers\Frontend\WishlistController,
    Controllers\LanguageSwitcherController};
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Mail;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localize','localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function()
{
    Auth::routes();


    Route::get(uri: 'page/{slug}', action: [PageController::class, 'page'])->name(name: 'page');
    Route::get(uri: 'contact', action: [PageController::class, 'contact'])->name(name: 'contact');
    Route::post(uri: 'contact', action: [PageController::class, 'sendContact'])->name(name: 'contact.send');
    Route::get(uri: 'new-arrivals', action: [ProductController::class, 'newArrivals'])->name(name: 'products.new_arrivals');
    Route::get(uri: 'best-sellers', action: [ProductController::class, 'newArrivals'])->name(name: 'products.best_sellers');
    Route::get(uri: 'featured-products', action: [ProductController::class, 'featuredProducts'])->name(name: 'products.featured');

    Route::get(uri: 'category/{slug}', action: [CategoryController::class, 'index'])->name(name: 'category');
    Route::get(uri: 'collection/{collection}', action: [ProductController::class, 'collection'])->name(name: 'collection.index');
    Route::get(uri: 'products', action: [ProductController::class, 'index'])->name(name: 'products.index');
    Route::get(uri: 'products/{product}', action: [ProductController::class, 'show'])->name(name: 'products.show');

    Route::group(['middleware' => 'auth'], function () {
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

        Route::get(uri: 'checkout', action: [CheckoutController::class, 'index'])->name(name: 'checkout.index');
        Route::post(uri: 'checkout', action: [CheckoutController::class, 'placeOrder'])->name(name: 'checkout.placeOrder');

        Route::get(uri: 'cart', action: [CartController::class, 'index'])->name(name: 'cart.index');
        Route::post(uri: 'cart/add', action: [CartController::class, 'addToCart'])->name(name: 'cart.add');
        Route::delete(uri: 'cart/{id}', action: [CartController::class, 'removeFromCart'])->name(name: 'cart.remove');
        Route::patch(uri: 'cart/{id}', action: [CartController::class, 'updateCart'])->name(name: 'cart.update');

        Route::get(uri: 'wishlist', action: [WishlistController::class, 'index'])->name(name: 'wishlist.index');
        Route::post(uri: 'wishlist/add', action: [WishlistController::class, 'add'])->name(name: 'wishlist.add');
        Route::delete(uri: 'wishlist/remove/{id}', action: [WishlistController::class, 'remove'])->name(name: 'wishlist.remove');
        Route::get(uri: 'wishlist/check', action: [WishlistController::class, 'check'])->name(name: 'wishlist.check');
    });

    Route::middleware(['auth', 'web'])->group(function () {
        Route::post('/compare/add', [ComparisonController::class, 'add'])->name('compare.add');
        Route::delete('/compare/remove', [ComparisonController::class, 'remove'])->name('compare.remove');
        Route::get('/compare', [ComparisonController::class, 'index'])->name('compare.index');
    });

    Route::get('payment/success/{order}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('payment/cancel/{order}', [PaymentController::class, 'cancel'])->name('payment.cancel');

    Route::get('payment/paypal/success', [PayPalController::class, 'success'])->name('payment.paypal.success');
    Route::get('payment/paypal/cancel', [PayPalController::class, 'cancel'])->name('payment.paypal.cancel');

    Route::get('payment/myfatoorah/success/{order}', [MyFatoorahController::class, 'success'])->name('payment.myfatoorah.success');
    Route::get('payment/myfatoorah/cancel/{order}', [MyFatoorahController::class, 'cancel'])->name('payment.myfatoorah.cancel');

    Route::get('/payment/kashier/success/{order}', [KashierController::class, 'handleSuccess'])->name('payment.kashier.success');
    Route::get('/payment/kashier/failure/{order}', [KashierController::class, 'handleFailure'])->name('payment.kashier.failure');
    Route::post('/payment/kashier/webhook', [KashierController::class, 'handleWebhook'])->name('payment.kashier.webhook');


//    Route::post('webhook/stripe', [StripeWebhookController::class, 'handle']);
//    Route::post('webhook/paypal', [PayPalWebhookController::class, 'handle']);
});

Route::get('captcha', [CaptchaController::class, 'getCaptcha']);
Route::get('reload-captcha', [CaptchaController::class, 'reloadCaptcha']);
Route::get(uri: 'switch-language/{locale}', action: LanguageSwitcherController::class)->name(name: 'language.switch');


Route::prefix('backend')->group(function () {


Route::get(uri: '/', action: function (){
    return 4444444;
})->name(name: 'home');

    Route::get(uri: '/hello', action: function (){
        return 'Hello World!';
    });

    Route::get(uri: '/hello2', action: function (){
        return 'Hello World2!';
    });
});
