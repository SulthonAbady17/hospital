<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => Authenticate::class,
            'role' => CheckRole::class,
        ]);
        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo(function () {
            switch (Auth::user()->role) {
                case 'patient':
                    return redirect()->intended(route('patient.dashboard'));
                case 'v1':
                    return redirect()->intended(route('verifier1.dashboard'));
                case 'v2':
                    return redirect()->intended(route('verifier2.dashboard'));
                case 'admin':
                    return redirect()->intended(route('admin.dashboard'));
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors(['email' => 'Peran pengguna tidak valid.']);
            }
        });
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
