<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\BxssUser;
use App\Http\Middleware\HRGroup;
use App\Http\Middleware\MediaGroup;
use App\Http\Middleware\Organization;
use App\Http\Middleware\Media;
use App\Http\Middleware\Depo;
use App\Http\Middleware\DepoGroup;
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
        $middleware->appendToGroup('hrCheck', [
            HRGroup::class,
        ]);
        $middleware->appendToGroup('mediaCheck', [
            MediaGroup::class,
        ]);
        $middleware->appendToGroup('adminCheck', [
            Admin::class,
        ]);
        $middleware->appendToGroup('mediaUserCheck', [
            Media::class,
        ]);
        $middleware->appendToGroup('depoUserCheck', [
            Depo::class,
        ]);
        $middleware->appendToGroup('depoCheck', [
            DepoGroup::class,
        ]);
        $middleware->appendToGroup('bxssCheck', [
            BxssUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
