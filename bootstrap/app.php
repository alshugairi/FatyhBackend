<?php

use Illuminate\{Foundation\Application,
    Foundation\Configuration\Exceptions,
    Foundation\Configuration\Middleware,
    Support\Facades\Route};
use App\Http\Middleware\Localization;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureSessionId;
use App\Http\Middleware\ApiKeyMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
            Route::middleware('web')
                ->group(base_path('routes/account.php'));
        },
    )
    ->withProviders([
        Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'EnsureIsAdmin'           => EnsureIsAdmin::class,
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
        ]);
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            Localization::class,
            EnsureSessionId::class
        ]);
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            //ApiKeyMiddleware::class,
        ]);
        $middleware->prepend(Localization::class);
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
