<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Organization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('orgCheck', [
            Organization::class,
        ]);
        $middleware->appendToGroup('adminCheck', [
            Admin::class,
        ]);
        // $middleware->append([Admin::class, Organization::class]);
        // $middleware->web(append: [Admin::class]);
        // $middleware->web(append: [Organization::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
