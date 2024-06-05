<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Provider;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

final class NewsRouteServiceProvider extends RouteServiceProvider
{
    public function map(): void
    {
        Route::middleware('api')
            ->namespace('Module\News\Infrastructure\Controller')
            ->group(base_path('Module/News/Infrastructure/Route/api.php'))
        ;
    }

}
