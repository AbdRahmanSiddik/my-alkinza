<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__ . '/../routes/web.php', api: __DIR__.'/../routes/api.php', commands: __DIR__ . '/../routes/console.php', health: '/up')
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, $request) {
            if ($e instanceof \Spatie\Permission\Exceptions\UnauthorizedException || $e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                $user = auth()->user();

                if ($user && $user->hasRole('kasir')) {
                    return redirect()->route('kasir')->with('error', 'Kamu tidak punya akses ke halaman itu.');
                }else if ($user && $user->hasRole('user')) {
                    return redirect()->route('shop.index');
                }

                return response()->view('errors.403', [], 403);
            }

            return null; // continue default render
        });
    })
    ->create();
