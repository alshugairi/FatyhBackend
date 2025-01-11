<?php

use App\Http\{Controllers\CaptchaController, Controllers\LanguageSwitcherController};
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localize','localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function()
{
    Auth::routes();
    Route::get(uri: '/', action: function (){
        return 'Home';
    })->name(name: 'home');

});

Route::get('captcha', [CaptchaController::class, 'getCaptcha']);
Route::get('reload-captcha', [CaptchaController::class, 'reloadCaptcha']);
Route::get(uri: 'switch-language/{locale}', action: LanguageSwitcherController::class)->name(name: 'language.switch');

