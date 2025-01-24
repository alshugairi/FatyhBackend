<?php

namespace App\Routes\Admin;

use App\{Http\Controllers\Admin\Settings\CityController,
    Http\Controllers\Admin\Settings\CountryController,
    Http\Controllers\Admin\Settings\CurrencyController,
    Http\Controllers\Admin\Settings\FaqController,
    Http\Controllers\Admin\Settings\FaqCategoryController,
    Http\Controllers\Admin\Settings\LanguageController,
    Http\Controllers\Admin\Settings\PageController,
    Http\Controllers\Admin\Settings\PermissionController,
    Http\Controllers\Admin\Settings\ReturnReasonController,
    Http\Controllers\Admin\Settings\RoleController,
    Http\Controllers\Admin\Settings\SettingsController,
    Http\Controllers\Admin\Settings\SliderController,
    Http\Controllers\Admin\Settings\MenuController,
    Http\Controllers\Admin\Settings\TranslationController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class SettingsRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        self::settingsRoutes();
        self::countriesRoute();
        self::citiesRoute();
        self::currenciesRoute();
        self::rolesRoute();
        self::permissionsRoute();
        self::languagesRoute();
        self::pagesRoute();
        self::faqCategoriesRoute();
        self::faqsRoute();
        self::slidersRoute();
        self::returnReasonsRoute();
        self::menusRoute();
        self::translationsRoute();
    }

    /**
     * @return void
     */
    private static function settingsRoutes(): void
    {
        Route::get(uri: 'settings', action: [SettingsController::class, 'index'])->name(name: 'settings.index');

        Route::get(uri: 'settings/company', action: [SettingsController::class, 'company'])->name(name: 'settings.company');
        Route::post(uri: 'settings/company', action: [SettingsController::class, 'storeCompany'])->name(name: 'settings.company.store');

        Route::get(uri: 'settings/social', action: [SettingsController::class, 'social'])->name(name: 'settings.social');
        Route::post(uri: 'settings/social', action: [SettingsController::class, 'storeSocial'])->name(name: 'settings.social.store');

        Route::get(uri: 'settings/mail', action: [SettingsController::class, 'mail'])->name(name: 'settings.mail');
        Route::post(uri: 'settings/mail', action: [SettingsController::class, 'storeMail'])->name(name: 'settings.mail.store');

        Route::get(uri: 'settings/site', action: [SettingsController::class, 'site'])->name(name: 'settings.site');
        Route::post(uri: 'settings/site', action: [SettingsController::class, 'storeSite'])->name(name: 'settings.site.store');

        Route::get(uri: 'settings/theme', action: [SettingsController::class, 'theme'])->name(name: 'settings.theme');
        Route::post(uri: 'settings/theme', action: [SettingsController::class, 'storeTheme'])->name(name: 'settings.theme.store');

        Route::get(uri: 'settings/otp', action: [SettingsController::class, 'otp'])->name(name: 'settings.otp');
        Route::post(uri: 'settings/otp', action: [SettingsController::class, 'storeOtp'])->name(name: 'settings.otp.store');

        Route::get(uri: 'settings/map', action: [SettingsController::class, 'map'])->name(name: 'settings.map');
        Route::post(uri: 'settings/map', action: [SettingsController::class, 'storeMap'])->name(name: 'settings.map.store');

        Route::get(uri: 'settings/notifications', action: [SettingsController::class, 'notifications'])->name(name: 'settings.notifications');
        Route::post(uri: 'settings/notifications', action: [SettingsController::class, 'storeNotifications'])->name(name: 'settings.notifications.store');

        Route::get(uri: 'settings/sms-gateways', action: [SettingsController::class, 'smsGateways'])->name(name: 'settings.sms_gateways');
        Route::post(uri: 'settings/sms-gateways', action: [SettingsController::class, 'storeSmsGateways'])->name(name: 'settings.sms_gateways.store');

        Route::get(uri: 'settings/payment-gateways', action: [SettingsController::class, 'paymentGateways'])->name(name: 'settings.payment_gateways');
        Route::post(uri: 'settings/payment-gateways', action: [SettingsController::class, 'storePaymentGateways'])->name(name: 'settings.payment_gateways.store');
    }

    /**
     * @return void
     */
    private static function countriesRoute(): void
    {
        Route::get(uri: 'countries/list', action: [CountryController::class, 'list'])->name(name: 'countries.list');
        Route::resource(name: 'countries', controller: CountryController::class);
    }

    /**
     * @return void
     */
    private static function citiesRoute(): void
    {
        Route::get(uri: 'cities/list', action: [CityController::class, 'list'])->name(name: 'cities.list');
        Route::resource(name: 'cities', controller: CityController::class);
    }

    /**
     * @return void
     */
    private static function currenciesRoute(): void
    {
        Route::get(uri: 'currencies/list', action: [CurrencyController::class, 'list'])->name(name: 'currencies.list');
        Route::resource(name: 'currencies', controller: CurrencyController::class);
    }

    /**
     * @return void
     */
    private static function rolesRoute(): void
    {
        Route::get(uri: 'roles/list', action: [RoleController::class, 'list'])->name(name: 'roles.list');
        Route::resource(name: 'roles', controller: RoleController::class);
    }

    /**
     * @return void
     */
    private static function permissionsRoute(): void
    {
        Route::get(uri: 'permissions/list', action: [PermissionController::class, 'list'])->name(name: 'permissions.list');
        Route::resource(name: 'permissions', controller: PermissionController::class);
    }

    /**
     * @return void
     */
    private static function languagesRoute(): void
    {
        Route::get(uri: 'languages/list', action: [LanguageController::class, 'list'])->name(name: 'languages.list');
        Route::resource(name: 'languages', controller: LanguageController::class);
    }

    /**
     * @return void
     */
    private static function pagesRoute(): void
    {
        Route::get(uri: 'pages/list', action: [PageController::class, 'list'])->name(name: 'pages.list');
        Route::resource(name: 'pages', controller: PageController::class);
    }

    /**
     * @return void
     */
    private static function faqCategoriesRoute(): void
    {
        Route::get(uri: 'faq-categories/list', action: [FaqCategoryController::class, 'list'])->name(name: 'faq_categories.list');
        Route::resource(name: 'faq-categories', controller: FaqCategoryController::class)->names('faq_categories');
    }

    private static function faqsRoute(): void
    {
        Route::get(uri: 'faqs/list', action: [FaqController::class, 'list'])->name(name: 'faqs.list');
        Route::resource(name: 'faqs', controller: FaqController::class);
    }

    /**
     * @return void
     */
    private static function slidersRoute(): void
    {
        Route::get(uri: 'sliders/list', action: [SliderController::class, 'list'])->name(name: 'sliders.list');
        Route::resource(name: 'sliders', controller: SliderController::class);
    }

    /**
     * @return void
     */
    private static function returnReasonsRoute(): void
    {
        Route::get(uri: 'return-reasons/list', action: [ReturnReasonController::class, 'list'])->name(name: 'return_reasons.list');
        Route::resource(name: 'return-reasons', controller: ReturnReasonController::class)->names('return_reasons');
    }

    /**
     * @return void
     */
    private static function translationsRoute(): void
    {
        Route::get(uri: '/translations', action: [TranslationController::class, 'index'])->name(name: 'translations.index');
        Route::get('/translations/{lang}/{file}', [TranslationController::class, 'edit'])->name('translations.edit');
        Route::put('/translations/{lang}/{file}', [TranslationController::class, 'update'])->name('translations.update');
    }

    private static function menusRoute(): void
    {
        Route::get(uri: 'menus/list', action: [MenuController::class, 'list'])->name(name: 'menus.list');
        Route::resource(name: 'menus', controller: MenuController::class)->names('menus');
    }
}
