<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Middleware\JsonHeaderMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Middleware\ValidatePostSize;
use Illuminate\Routing\Middleware\SubstituteBindings;

final class Kernel extends HttpKernel
{
    protected $middleware = [
        TrustProxies::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class
    ];

    protected $middlewareGroups = [
        'api' => [
            'throttle:3600,1',
            SubstituteBindings::class,
            JsonHeaderMiddleware::class
        ]
    ];
}
