<?php

use App\Http\Middleware\AdminImpersonation;
use App\Http\Middleware\CheckProfileComplete;
use App\Http\Middleware\CheckUserIsActive;
use App\Http\Middleware\EnsureBrand;
use App\Http\Middleware\EnsureEmailVerified;
use App\Http\Middleware\EnsureKol;
use App\Http\Middleware\ForceJson;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'auth', 'user.active', 'verified'])
                ->group(base_path('routes/brand.php'));

            Route::middleware(['web', 'auth', 'user.active', 'verified'])
                ->group(base_path('routes/kol.php'));

            Route::middleware(['web', 'auth', 'user.active'])
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'user.active' => CheckUserIsActive::class,
            'verified' => EnsureEmailVerified::class,
            'brand' => EnsureBrand::class,
            'kol' => EnsureKol::class,
            'profile.complete' => CheckProfileComplete::class,
            'role' => RoleMiddleware::class,
            'force.json' => ForceJson::class,
            'impersonate' => AdminImpersonation::class,
        ]);

        $middleware->web(append: [
            AdminImpersonation::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
